<?php

return [
    'navigation_label' => 'Játékosok',
    
    'columns' => [
        'avatar' => 'Avatár',
        'name' => 'Felhasználónév',
        'status' => 'Státusz',
        'world' => 'Világ',
        'online' => 'Elérhető',
        'offline' => 'Nem Elérhető',
        'op' => 'Operátor',
    ],

    'filters' => [
        'all' => 'Összes',
        'online' => 'Elérhető',
        'offline' => 'Nem Elérhető',
        'op' => 'OP',
        'banned' => 'Kitiltva',
    ],

    'sections' => [
        'identity' => 'Identitás',
        'statistics' => 'Statisztikák',
        'statistics_desc' => 'Történelmi adatok a világ statisztikáiból',
        'live_status' => 'Élő állapot',
        'live_status_desc' => 'Valós idejű adatok (csak online játékosoknál)',
        'offline_status_desc' => 'Nem elérhető - Az utolsó mentési fájl adatainak megjelenítése',
        'rcon_disabled_status_desc' => 'RCON letiltva - A mentési fájl adatainak megjelenítése',
        'inventory' => 'Leltár',
        'management' => 'Kezelés',
        'management_desc' => 'Műveletek végrehajtása ezen a játékoson',
    ],

    'fields' => [
        'username' => 'Felhasználónév',
        'current_status' => 'Jelenlegi állapot',
        'uuid' => 'UUID',
        'play_time' => 'Játékidő',
        'distance_walked' => 'Megtett távolság',
        'mobs_killed' => 'Megölt mobok',
        'deaths' => 'Halálok',
        'status' => 'Státusz',
        'xp_level' => 'XP szint',
        'gamemode' => 'Játékmód',
        'visual_inventory' => 'Vizuális leltár',
    ],

    'stats' => [
        'health' => 'Életerő',
        'food' => 'Éhség',
    ],

    'actions' => [
        'view' => 'Megtekintés',
        'op' => [
            'label_op' => 'OP',
            'label_deop' => 'DEOP',
            'heading_op' => 'Operátor jog adása',
            'heading_deop' => 'Operátor jog elvétele',
            'desc_op' => 'Biztosan operátorrá szeretnéd tenni ezt a játékost (OP)?',
            'desc_deop' => 'Biztosan el szeretnéd venni az OP jogokat ettől a játékostól?',
            'notify_op' => 'OP parancs elküldve',
            'notify_deop' => 'DEOP parancs elküldve',
        ],
        'clear_inventory' => [
            'label' => 'Leltár törlése',
            'desc' => 'Biztosan törölni szeretnéd a játékos teljes leltárát? Ez nem visszavonható.',
            'notify' => 'Leltár törlése parancs elküldve',
        ],
        'kick' => [
            'label' => 'Kirúgás',
            'reason' => 'Indok',
            'default_reason' => 'Operátor által kirúgva',
            'notify' => 'Kick parancs elküldve',
        ],
        'ban' => [
            'label_ban' => 'Kitiltás',
            'label_unban' => 'Kitiltás feloldása',
            'reason' => 'Indok',
            'default_reason' => 'Operátor által kitiltva',
            'notify_ban' => 'Ban parancs elküldve',
            'notify_unban' => 'Kizárás feloldására vonatkozó parancs elküldve',
        ],
    ],

    'widget' => [
        'online_players' => 'Elérhető játékosok',
        'motd' => 'MOTD',
        'map' => 'Térkép neve',
        'units' => [
            'mins' => 'perc',
        ],
    ],

    'pages' => [
        'list' => 'Játékos lista',
        'view' => 'Játékos megtekintése',
    ],

    'values' => [
        'survival' => 'Túlélő',
        'creative' => 'Kreatív',
        'adventure' => 'Kaland',
        'spectator' => 'Néző',
        'online' => 'Elérhető',
        'offline' => 'Nem elérhető',
        'offline_data_source' => 'Nem elérhető (Utolsó mentett adat)',
    ],

    'units' => [
        'mins' => 'perc',
    ],
    'settings' => [
        'rcon_enabled' => 'RCON / Élő állapot engedélyezése',
        'rcon_enabled_helper' => 'Valós idejű adatlekérést tesz lehetővé (Leltár, Életerő stb.) RCON-on keresztül. Ehhez engedélyezni kell az RCON-t a server.properties-ben.',
        'nav_sort' => 'Navigációs sorrend',
        'nav_sort_helper' => 'Rendezési sorrend az oldalsó menüben. Az alacsonyabb számok magasabban jelennek meg. (Alapértelmezett: 2)',
        'saved' => 'Beállítások sikeresen elmentve.',
    ],
];
