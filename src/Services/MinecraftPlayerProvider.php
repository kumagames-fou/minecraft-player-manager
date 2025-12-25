<?php


namespace KumaGames\GamePlayerManager\Services;

use App\Models\Server;
use Illuminate\Support\Facades\Log;
use App\Repositories\Wings\DaemonCommandRepository;

class MinecraftPlayerProvider implements GamePlayerService
{
    public function sendRconCommand(string $serverId, string $command): ?string
    {
        $server = Server::where('uuid', $serverId)->first();
        if (!$server) {
            Log::error("Server not found for UUID: $serverId");
            return null;
        }

        try {
            $server->send($command);
            Log::info("Sent command to $serverId: $command");
            return "Command sent"; 
        } catch (\Exception $e) {
            Log::error("Failed to send command to $serverId: " . $e->getMessage());
            return null;
        }
    }

    public function getPlayers(string $serverId): array
    {
        // Use 'where' for UUID lookup and eager load allocation
        $server = Server::where('uuid', $serverId)->with('allocation')->first();
        if (!$server) {
            return [];
        }

        $allPlayers = [];

        /** @var \App\Repositories\Daemon\DaemonFileRepository $fileRepository */
        $fileRepository = app(\App\Repositories\Daemon\DaemonFileRepository::class);
        $fileRepository->setServer($server);

        // 1. Get List of OPs from ops.json
        $opNames = [];
        try {
            $opsContent = $fileRepository->getContent('ops.json');
            $ops = json_decode($opsContent, true);
            if (is_array($ops)) {
                foreach ($ops as $op) {
                    $name = $op['name'] ?? null;
                    if ($name) {
                        $lowerName = strtolower($name);
                        $opNames[$lowerName] = true;
                        // Add to all players list
                        if (!isset($allPlayers[$lowerName])) {
                            $allPlayers[$lowerName] = [
                                'id' => $name,
                                'name' => $name,
                                'online' => false,
                                'is_op' => true,
                                'is_banned' => false,
                            ];
                        } else {
                            $allPlayers[$lowerName]['is_op'] = true;
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            // Ignore file read errors
        }

        // 2. Get List of Banned Players from banned-players.json
        try {
            $bannedContent = $fileRepository->getContent('banned-players.json');
            $banned = json_decode($bannedContent, true);
            if (is_array($banned)) {
                foreach ($banned as $ban) {
                    $name = $ban['name'] ?? null;
                    if ($name) {
                        $lowerName = strtolower($name);
                        // Add to all players list
                        if (!isset($allPlayers[$lowerName])) {
                            $allPlayers[$lowerName] = [
                                'id' => $name,
                                'name' => $name,
                                'online' => false,
                                'is_op' => isset($opNames[$lowerName]),
                                'is_banned' => true,
                            ];
                        } else {
                            $allPlayers[$lowerName]['is_banned'] = true;
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            // Ignore file read errors
        }

        // 3. Get List of Known Players from usercache.json (Historical/Offline)
        try {
            $cacheContent = $fileRepository->getContent('usercache.json');
            // DEBUG: Check server.properties for RCON
            try {
                $props = $fileRepository->getContent('server.properties');
                Log::info("DEBUG_SERVER_PROPS: " . substr($props, 0, 500));
            } catch (\Exception $e) {
                Log::error("DEBUG_SERVER_PROPS_ERROR: " . $e->getMessage());
            }

            $cachedPlayers = json_decode($cacheContent, true);
            if (is_array($cachedPlayers)) {
                foreach ($cachedPlayers as $player) {
                    $name = $player['name'] ?? null;
                    if ($name) {
                        $lowerName = strtolower($name);
                        // Add to all players list if not exists
                        // If exists, it means they are OP or Banned already, so we just skip updating status
                        if (!isset($allPlayers[$lowerName])) {
                            $allPlayers[$lowerName] = [
                                'id' => $name,
                                'name' => $name,
                                'online' => false,
                                'is_op' => isset($opNames[$lowerName]),
                                'is_banned' => false,
                            ];
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            // usercache.json might not exist on new servers
        }

        // 4. Online Players via Query
        $onlinePlayers = $this->getOnlinePlayersViaQuery($server);
        foreach ($onlinePlayers as $playerName) {
            $lowerName = strtolower($playerName);
            if (isset($allPlayers[$lowerName])) {
                $allPlayers[$lowerName]['online'] = true;
            } else {
                $allPlayers[$lowerName] = [
                    'id' => $playerName,
                    'name' => $playerName,
                    'online' => true,
                    'is_op' => isset($opNames[$lowerName]),
                    'is_banned' => false,
                ];
            }
        }

        return array_values($allPlayers);
    }

    private function getOnlinePlayersViaQuery(Server $server): array
    {
        $players = [];
        try {
            $ip = $server->allocation->alias ?? $server->allocation->ip;
            $port = $server->allocation->port;

             $socket = fsockopen("udp://$ip", $port, $errno, $errstr, 2);
             if ($socket) {
                 stream_set_timeout($socket, 2);
                 
                 // Request Challenge
                 $sessionId = rand(1, 99999999) & 0x0F0F0F0F;
                 $payload = pack('c', 0xFE) . pack('c', 0xFD) . pack('c', 0x09) . pack('N', $sessionId);
                 fwrite($socket, $payload);
                 
                 $response = fread($socket, 4096);
                 if ($response) {
                     $challengeStr = substr($response, 5);
                     $challengeStr = trim($challengeStr); 
                     $challenge = (int) $challengeStr;

                     // Full Stat Request
                     $payload2 = pack('c', 0xFE) . pack('c', 0xFD) . pack('c', 0x00) . 
                                 pack('N', $sessionId) . 
                                 pack('N', $challenge) . 
                                 pack('N', 0x00); 
                     
                     fwrite($socket, $payload2);
                     $fullResponse = fread($socket, 4096);
                     
                     if ($fullResponse) {
                         $body = substr($fullResponse, 16);
                         $split = explode("\x00\x01player_\x00\x00", $body);
                         
                         if (count($split) > 1) {
                            $playerSection = $split[1];
                            $rawPlayers = explode("\x00", $playerSection);

                            foreach ($rawPlayers as $playerName) {
                                if (!empty($playerName)) {
                                    $players[] = $playerName;
                                }
                            }
                        }
                     }
                 }
                 fclose($socket);
             }
        } catch (\Exception $e) {
            // Query failed
        }
        return $players;
    }

    public function getPlayerDetails(string $serverId, string $playerId): array
    {
        $server = Server::where('uuid', $serverId)->orWhere('uuid_short', $serverId)->first();
        if (!$server) return [];
        
        // Resolve UUID from Username early (Need UUID for stats file and UI)
        $uuid = null;
        /** @var \App\Repositories\Daemon\DaemonFileRepository $fileRepository */
        $fileRepository = app(\App\Repositories\Daemon\DaemonFileRepository::class);
        $fileRepository->setServer($server);
        
        try {
            $cacheContent = $fileRepository->getContent('usercache.json');
            $cache = json_decode($cacheContent, true);
            if (is_array($cache)) {
                foreach ($cache as $entry) {
                    if (strtolower($entry['name']) === strtolower($playerId)) {
                        $uuid = $entry['uuid'];
                        break;
                    }
                }
            }
        } catch (\Exception $e) { /* Ignore */ }

        $details = [
            'name' => $playerId,
            'uuid' => $uuid ?? 'Unknown',
            'status' => 'Offline', // Default
            'is_op' => false,
            'raw_stats' => 'RCON disabled or unavailable.',
            'health' => null,
            'food' => null,
            'level' => null,
            'gamemode' => null,
            'inventory_summary' => null,
            'play_time' => null,
            'walk_distance' => null,
            'mobs_killed' => null,
            'deaths' => null,
        ];

        // Check OP status
        try {
            $opsContent = $fileRepository->getContent('ops.json');
            $ops = json_decode($opsContent, true);
            if (is_array($ops)) {
                foreach ($ops as $op) {
                    if (strtolower($op['name'] ?? '') === strtolower($playerId)) {
                        $details['is_op'] = true;
                        break;
                    }
                }
            }
        } catch (\Exception $e) { /* Ignore */ }
        
        
        // 1. Get RCON Credentials
        $rconPort = null;
        $rconPassword = null;
        $enableRcon = false;

        try {
            $propsContent = $fileRepository->getContent('server.properties');
            
            // Regex Parsing for robustness
            if (preg_match('/^\s*enable-rcon\s*=\s*(true|false)/m', $propsContent, $m)) {
                $enableRcon = $m[1] === 'true';
            }
            if (preg_match('/^\s*rcon\.port\s*=\s*(\d+)/m', $propsContent, $m)) {
                $rconPort = (int)$m[1];
            }
            if (preg_match('/^\s*rcon\.password\s*=\s*(.*)$/m', $propsContent, $m)) {
                $rconPassword = trim($m[1]);
            } else {
                 // Debug why regex failed
                 $lines = explode("\n", $propsContent);
                 $passLine = array_values(array_filter($lines, fn($l) => str_contains($l, 'rcon.password')));
                 \Illuminate\Support\Facades\Log::info("DEBUG RCON PASSWORD LINE: " . json_encode($passLine));
            }
            
        } catch (\Exception $e) {
            // Failed to read properties
        }

        $primaryHost = $server->allocation->alias ?? $server->allocation->ip;
        $hasPass = !empty($rconPassword);

        $primaryHost = $server->allocation->alias ?? $server->allocation->ip;
        $hasPass = !empty($rconPassword);
        
        // Check setting
        $rconEnabled = env('MC_PLAYER_MANAGER_RCON_ENABLED', false);

        if (!$rconEnabled) {
             // Try to get status via Query even if RCON is disabled
             $onlinePlayers = $this->getOnlinePlayersViaQuery($server);
             $isOnline = false;
             foreach ($onlinePlayers as $p) {
                 if (strtolower($p) === strtolower($playerId)) {
                     $isOnline = true;
                     break;
                 }
             }
             
             $details['status'] = $isOnline ? 'Online' : 'Offline';
             $details['raw_stats'] = $isOnline 
                ? 'Player is Online (RCON stats disabled)' 
                : 'Player is Offline';
        } elseif (!$enableRcon || !$rconPort || !$hasPass) {
            $details['raw_stats'] = 'RCON is not enabled in server.properties.';
            $details['status'] = 'Config Error';
        } else {
             // 2. Connect RCON
            $hostsToTry = array_unique([$primaryHost, '127.0.0.1', 'localhost']);
            
            $connected = false;
            $lastError = '';
            $rcon = null; // Initialize $rcon outside the loop

            foreach ($hostsToTry as $host) {
                if (empty($host)) continue;
                
                \Illuminate\Support\Facades\Log::info("RCON Attempt: Host={$host}, Port={$rconPort}");
                
                $rcon = new RconService($host, $rconPort, $rconPassword, 3); // Changed timeout to 3
                if ($rcon->connect()) {
                    $connected = true;
                    \Illuminate\Support\Facades\Log::info("RCON Connected successfully to {$host}");
                    break;
                }
                // Log failure only if all fail, or rely on RconService logs
            }
            
                if ($rcon->connect()) {
                    $connected = true;
                    // Check if online first by checking root
                    // But actually, asking for a specific path directly is fine. If entity not found, it returns "No entity..."
                    
                    // 3. Fetch Data Individually for robustness
                    $details['status'] = 'Online'; // Assume online if connected and commands work, will verify below
                    
                    // Helper to fetch and parse simpler numbers
                    $fetchInt = function($path) use ($rcon, $playerId) {
                        $res = $rcon->sendCommand("data get entity $playerId $path");
                        // Response: "<uuid> has the following entity data: 123" or just "123" depending on server
                        // Regex to grab the last number in the string
                        if (preg_match('/(-?\d+)[bfsdL]?$/', trim($res), $m)) return (int)$m[1];
                        return null;
                    };
                    $fetchFloat = function($path) use ($rcon, $playerId) {
                        $res = $rcon->sendCommand("data get entity $playerId $path");
                        if (preg_match('/([\d\.]+)[bfsdL]?$/', trim($res), $m)) return (float)$m[1];
                        return null;
                    };

                    // Health
                    // Try "Health" first, then "HealF"
                    $h = $fetchFloat('Health');
                    if ($h === null) $h = $fetchFloat('HealF'); // fallback
                    if ($h !== null) $details['health'] = $h;
                    
                    // Food
                    // Try "foodLevel" (camel), then "FoodLevel" (Pascal)
                    $f = $fetchInt('foodLevel');
                    if ($f === null) $f = $fetchInt('FoodLevel');
                    if ($f !== null) $details['food'] = $f;

                    // XP Level
                    $xl = $fetchInt('XpLevel'); 
                    if ($xl === null) $xl = $fetchInt('xpLevel');
                    if ($xl === null) {
                         // Fallback to XpTotal if level missing? No, that's different.
                         // Maybe "lev" (unlikely)
                    }
                    if ($xl !== null) $details['level'] = $xl;

                    // Gamemode
                    $gmVal = $fetchInt('playerGameType');
                    if ($gmVal !== null) {
                        $gmById = [0 => 'Survival', 1 => 'Creative', 2 => 'Adventure', 3 => 'Spectator'];
                        $details['gamemode'] = $gmById[$gmVal] ?? 'Unknown';
                    } else {
                        // Try "gamemode" just in case? Usually playerGameType
                    }

                    // Inventory
                    // Inventory
                    // Fetch items iteratively to handle RCON truncation limits (4KB)
                    // Large inventories with NBT tags often exceed the limit, causing data loss.
                    // We loop through Inventory[0], Inventory[1]... until we get an error or empty result.
                    
                    $inventory = [];
                    $maxItems = 50; // Safety limit (Players typically have max 41 items: 36 main + 4 armor + 1 offhand)
                    
                    for ($i = 0; $i < $maxItems; $i++) {
                        $itemRes = $rcon->sendCommand("data get entity $playerId Inventory[$i]");
                        
                        // Break if index doesn't exist (e.g. "No such element", "Found no elements")
                        if (!$itemRes || str_contains($itemRes, 'No such element') || str_contains($itemRes, 'Found no elements') || str_contains($itemRes, 'No entity was found')) {
                            break;
                        }

                        // Response format: "<player> has the following entity data: {id:..., Count:...}"
                        // extract the part after "data: "
                        $dataPos = strpos($itemRes, 'data: ');
                        $itemStr = ($dataPos !== false) ? substr($itemRes, $dataPos + 6) : $itemRes;
                        
                        $item = [];
                        
                        // ID
                        if (preg_match('/id:\s*"?(?:minecraft:)?([^",\}\s]+)"?/i', $itemStr, $kv)) {
                            $item['id'] = trim($kv[1]);
                        }
                        
                        // Count
                        if (preg_match('/Count:\s*(\d+)b?/i', $itemStr, $kv)) {
                            $item['count'] = (int)$kv[1];
                        } else {
                            $item['count'] = 1;
                        }
                        
                        // Slot
                        if (preg_match('/Slot:\s*(\d+)b?/i', $itemStr, $kv)) {
                            $item['slot'] = (int)$kv[1];
                        }

                        if (isset($item['id']) && isset($item['slot'])) {
                            $inventory[] = $item;
                            // Debug log for checking correct parsing
                             if ($i < 3) \Illuminate\Support\Facades\Log::info("DEBUG INV Correctly Parsed Index $i: {$item['id']} (Slot {$item['slot']})");
                        }
                    }

                    $details['inventory_data'] = $inventory;
                    \Illuminate\Support\Facades\Log::info("PARSED INVENTORY ITEMS (Iterative): " . count($inventory));
                    
                    // Verify if we actually got data, otherwise might be offline (entity not found)
                    // If all values are null/empty, likely offline or bad UUID
                    if ($h === null && $f === null && $gmVal === null) {
                         // Check raw response of one command to see if "No entity"
                         $check = $rcon->sendCommand("data get entity $playerId Health");
                         if (str_contains($check, 'No entity') || str_contains($check, 'No player')) {
                             $details['status'] = 'Offline'; 
                             $details['raw_stats'] = "Player is Offline";
                         }
                    }

                    $rcon->disconnect();
                } else {
                     // Connect failed (logged in loop)
                     $details['status'] = 'RCON Error';
                }
             }

        // 4. Fetch JSON Stats
        if ($uuid) {
            try {
                $levelName = 'world';
                if (isset($propsContent) && preg_match('/level-name=(.*)/', $propsContent, $lm)) {
                    $levelName = trim($lm[1]);
                }
                
                $statsPath = "$levelName/stats/$uuid.json";
                $statsContent = $fileRepository->getContent($statsPath);
                $statsJson = json_decode($statsContent, true);
                
                if ($statsJson && isset($statsJson['stats'])) {
                    $s = $statsJson['stats'];
                    $ticks = $s['minecraft:custom']['minecraft:play_time'] ?? 0;
                    $details['play_time'] = floor($ticks / 20 / 60) . ' ' . __('minecraft-player-manager::messages.units.mins');
                    $details['mobs_killed'] = $s['minecraft:custom']['minecraft:mob_kills'] ?? 0;
                    $details['deaths'] = $s['minecraft:custom']['minecraft:deaths'] ?? 0;
                    $cm = $s['minecraft:custom']['minecraft:walk_one_cm'] ?? 0;
                    $details['walk_distance'] = floor($cm / 100) . ' m';
                }
            } catch (\Exception $e) { /* Stat file parse error */ }
        }

        return $details;
    }

    public function kick(string $serverId, string $playerId, string $reason = ''): bool
    {
        $cmd = trim("kick $playerId $reason");
        return $this->sendRconCommand($serverId, $cmd) !== null;
    }

    public function ban(string $serverId, string $playerId, string $reason = ''): bool
    {
        $cmd = trim("ban $playerId $reason");
        return $this->sendRconCommand($serverId, $cmd) !== null;
    }

    public function op(string $serverId, string $playerId): bool
    {
        $cmd = trim("op $playerId");
        return $this->sendRconCommand($serverId, $cmd) !== null;
    }

    public function deop(string $serverId, string $playerId): bool
    {
        $cmd = trim("deop $playerId");
        return $this->sendRconCommand($serverId, $cmd) !== null;
    }

    public function clearInventory(string $serverId, string $playerId): bool
    {
        $cmd = trim("clear $playerId");
        // returns "Cleared the inventory of <player>" on success, or "No items to clear", or "No player found"
        return $this->sendRconCommand($serverId, $cmd) !== null;
    }
}
