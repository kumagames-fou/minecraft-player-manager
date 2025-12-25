<?php

return [
    'navigation_label' => 'ゲームプレイヤー',
    
    'columns' => [
        'avatar' => 'アバター',
        'name' => 'ユーザー名',
        'status' => 'ステータス',
        'world' => 'ワールド',
        'online' => 'オンライン',
        'offline' => 'オフライン',
        'op' => '管理者',
    ],

    'filters' => [
        'all' => 'すべて',
        'online' => 'オンライン',
        'offline' => 'オフライン',
        'op' => '管理者 (OP)',
        'banned' => 'BAN済み',
    ],

    'sections' => [
        'identity' => 'ID情報',
        'statistics' => '統計データ',
        'statistics_desc' => 'ワールド内の履歴データ',
        'live_status' => 'ライブステータス',
        'live_status_desc' => 'リアルタイムデータ（オンライン時のみ有効）',
        'inventory' => 'インベントリ',
        'management' => '管理',
        'management_desc' => 'このプレイヤーに対するアクションを実行',
    ],

    'fields' => [
        'username' => 'ユーザー名',
        'current_status' => '現在のステータス',
        'uuid' => 'UUID',
        'play_time' => 'プレイ時間',
        'distance_walked' => '移動距離',
        'mobs_killed' => 'モブ討伐数',
        'deaths' => '死亡回数',
        'status' => 'ステータス',
        'xp_level' => 'XPレベル',
        'gamemode' => 'ゲームモード',
        'visual_inventory' => 'ビジュアルインベントリ',
    ],

    'stats' => [
        'health' => '体力',
        'food' => '満腹度',
    ],

    'actions' => [
        'view' => '詳細',
        'op' => [
            'label_op' => '管理者権限付与',
            'label_deop' => '管理者権限剥奪',
            'heading_op' => '管理者権限を付与',
            'heading_deop' => '管理者権限を剥奪',
            'desc_op' => 'このプレイヤーにOP（管理者）権限を付与してもよろしいですか？',
            'desc_deop' => 'このプレイヤーからOP（管理者）権限を剥奪してもよろしいですか？',
            'notify_op' => 'OP権限を付与しました',
            'notify_deop' => 'OP権限を剥奪しました',
        ],
        'clear_inventory' => [
            'label' => 'インベントリ消去',
            'desc' => '本当にこのプレイヤーのインベントリを空にしますか？この操作は取り消せません。',
            'notify' => 'インベントリとエンダーチェストを消去しました',
        ],
        'kick' => [
            'label' => 'キック (Kick)',
            'reason' => '理由',
            'default_reason' => '管理者によりキックされました',
            'notify' => 'キックコマンドを送信しました',
        ],
        'ban' => [
            'label' => 'BAN',
            'reason' => '理由',
            'default_reason' => '管理者によりBANされました',
            'notify' => 'BANコマンドを送信しました',
        ],
    ],

    'widget' => [
        'online_players' => 'オンライン人数',
    ],

    'pages' => [
        'list' => 'プレイヤー一覧',
        'view' => 'プレイヤー詳細',
    ],

    'values' => [
        'survival' => 'サバイバル',
        'creative' => 'クリエイティブ',
        'adventure' => 'アドベンチャー',
        'spectator' => 'スペクテイター',
        'online' => 'オンライン',
        'offline' => 'オフライン',
    ],

    'units' => [
        'mins' => '分',
    ],
    'settings' => [
        'rcon_enabled' => 'RCON / ライブステータスを有効にする',
        'rcon_enabled_helper' => 'RCONを使用してリアルタイムデータ（インベントリ、体力など）を取得・表示します。server.propertiesでRCONが有効になっている必要があります。',
        'saved' => '設定を保存しました。',
    ],
];
