<?php

namespace KumaGames\GamePlayerManager\Filament\Server\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use App\Filament\Server\Components\SmallStatBlock;
use KumaGames\GamePlayerManager\Services\MinecraftPlayerProvider;
use Filament\Facades\Filament;

class PlayerCountWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $server = Filament::getTenant();

        if (
            ! $server ||
            ! in_array('minecraft', $server->egg->tags ?? [])
        ) {
            return [];
        }

        $serverId = $server->uuid ?? 'server-1';
        
        $provider = new MinecraftPlayerProvider();
        $players = $provider->getPlayers($serverId);
        
        $onlineCount = count(array_filter($players, fn($p) => $p['online'] ?? false));
        // We can get max players if we had query details, but for now hardcode or omit
        
        return [
            SmallStatBlock::make(__('minecraft-player-manager::messages.widget.online_players'), (string) $onlineCount), 
        ];
    }
}
