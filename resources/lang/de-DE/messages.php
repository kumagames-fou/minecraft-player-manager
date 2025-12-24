<?php

return [
    'navigation_label' => 'Spieler',
    
    'columns' => [
        'avatar' => 'Avatar',
        'name' => 'Nutzername',
        'status' => 'Status',
        'world' => 'Welt',
        'online' => 'Online',
        'offline' => 'Offline',
        'op' => 'Operator',
    ],

    'filters' => [
        'all' => 'Alle',
        'online' => 'Online',
        'offline' => 'Offline',
        'op' => 'OP',
        'banned' => 'Gebannt',
    ],

    'sections' => [
        'identity' => 'Identität',
        'statistics' => 'Statistiken',
        'statistics_desc' => 'Historische Daten aus dem Welt Ordner',
        'live_status' => 'Live Status',
        'live_status_desc' => 'Echtzeitdaten (Nur verfügbar wenn Online)',
        'inventory' => 'Inventar',
    ],

    'fields' => [
        'username' => 'Nutzername',
        'current_status' => 'Aktueller Status',
        'uuid' => 'UUID',
        'play_time' => 'Spielzeit',
        'distance_walked' => 'Distanz gelaufen',
        'mobs_killed' => 'Mobs getötet',
        'deaths' => 'Tode',
        'status' => 'Status',
        'xp_level' => 'XP Level',
        'gamemode' => 'Spielmodus',
        'visual_inventory' => 'Visual Inventar',
    ],

    'stats' => [
        'health' => 'Herzen',
        'food' => 'Hunger',
    ],

    'actions' => [
        'view' => 'Ansehen',
        'op' => [
            'label_op' => 'OP',
            'label_deop' => 'DEOP',
            'heading_op' => 'OP Status geben',
            'heading_deop' => 'OP Status entfernen',
            'desc_op' => 'Bist du sicher, das du diesen Spieler zum Operator machen möchtest?',
            'desc_deop' => 'Bist du sicher, das du diesen Spieler den Operatore Status entfernen möchtest?',
            'notify_op' => 'OP Command gesendet',
            'notify_deop' => 'DEOP Command gesendet',
        ],
        'clear_inventory' => [
            'label' => 'Inventar leeren',
            'desc' => 'Bist du sicher das du das Inventar dieses Spielers löschen willst?',
            'notify' => 'Inventar Clear Command wurde gesendet',
        ],
        'kick' => [
            'label' => 'Kick',
            'reason' => 'Grund',
            'default_reason' => 'Gekickt von einem Operator',
            'notify' => 'Kick Command gesendet',
        ],
        'ban' => [
            'label' => 'Ban',
            'reason' => 'Grund',
            'default_reason' => 'Gebannt von einem Operator',
            'notify' => 'Ban Command gesendet',
        ],
    ],

    'widget' => [
        'online_players' => 'Online Spieler',
    ],

    'pages' => [
        'list' => 'Spieler Liste',
        'view' => 'Spieler anschauen',
    ],

    'values' => [
        'survival' => 'Überleben',
        'creative' => 'Kreativ',
        'adventure' => 'Abenteuer',
        'spectator' => 'Zuschauer',
        'online' => 'Online',
        'offline' => 'Offline',
    ],

    'units' => [
        'mins' => 'min',
    ],
];

