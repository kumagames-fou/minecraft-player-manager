<?php

return [
    'navigation_label' => 'Spieler-Manager',

    'columns' => [
        'avatar' => 'Avatar',
        'name' => 'Benutzername',
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
        'statistics_desc' => 'Historische Daten aus den Welt-Stats',
        'live_status' => 'Status',
        'live_status_desc' => 'Echtzeitdaten vom Server',
        'offline_status_desc' => 'Offline - Zeigt Daten aus der letzten Speicherdatei',
        'rcon_disabled_status_desc' => 'RCON deaktiviert - Zeigt Daten aus der Speicherdatei',
        'inventory' => 'Inventar',
        'management' => 'Verwaltung',
        'management_desc' => 'Aktionen für diesen Spieler ausführen',
    ],

    'fields' => [
        'username' => 'Benutzername',
        'current_status' => 'Aktueller Status',
        'uuid' => 'UUID',
        'play_time' => 'Spielzeit',
        'distance_walked' => 'Zurückgelegte Distanz',
        'mobs_killed' => 'Mobs getötet',
        'deaths' => 'Tode',
        'status' => 'Status',
        'xp_level' => 'XP-Level',
        'gamemode' => 'Spielmodus',
        'visual_inventory' => 'Visuelles Inventar',
    ],

    'stats' => [
        'health' => 'Gesundheit',
        'food' => 'Hunger',
    ],

    'actions' => [
        'view' => 'Ansehen',
        'op' => [
            'label_op' => 'OP',
            'label_deop' => 'DEOP',
            'heading_op' => 'Operator-Status gewähren',
            'heading_deop' => 'Operator-Status entziehen',
            'desc_op' => 'Möchten Sie diesen Spieler wirklich zum Operator (OP) machen?',
            'desc_deop' => 'Möchten Sie diesem Spieler wirklich die OP-Rechte entziehen?',
            'notify_op' => 'OP-Befehl gesendet',
            'notify_deop' => 'DEOP-Befehl gesendet',
        ],
        'clear_inventory' => [
            'label' => 'Inv leeren',
            'desc' => 'Möchten Sie das Inventar dieses Spielers wirklich leeren? Dies kann nicht rückgängig gemacht werden.',
            'notify' => 'Inventar leeren Befehl gesendet',
        ],
        'kick' => [
            'label' => 'Kicken',
            'reason' => 'Grund',
            'default_reason' => 'Vom Operator gekickt',
            'notify' => 'Kick-Befehl gesendet',
        ],
        'ban' => [
            'label' => 'Bannen',
            'reason' => 'Grund',
            'default_reason' => 'Vom Operator gebannt',
            'notify' => 'Ban-Befehl gesendet',
        ],
    ],

    'widget' => [
        'online_players' => 'Online Spieler',
    ],

    'pages' => [
        'list' => 'Spielerliste',
        'view' => 'Spieler ansehen',
    ],

    'values' => [
        'survival' => 'Überleben',
        'creative' => 'Kreativ',
        'adventure' => 'Abenteuer',
        'spectator' => 'Zuschauer',
        'online' => 'Online',
        'offline' => 'Offline',
        'offline_data_source' => 'Offline (Letzte Speicherdaten)',
    ],

    'units' => [
        'mins' => 'Min',
    ],

    'settings' => [
        'rcon_enabled' => 'RCON / Live-Status aktivieren',
        'rcon_enabled_helper' => 'Ermöglicht das Abrufen von Echtzeitdaten (Inventar, Gesundheit usw.) über RCON. Erfordert, dass RCON in den server.properties aktiviert ist.',
        'nav_sort' => 'Navigationsreihenfolge',
        'nav_sort_helper' => 'Sortierreihenfolge im Seitenmenü. Niedrigere Zahlen erscheinen weiter oben. (Standard: 2)',
        'saved' => 'Einstellungen erfolgreich gespeichert.',
    ],
];
