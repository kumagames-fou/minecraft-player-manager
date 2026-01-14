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
        'live_status' => 'ステータス',
        'live_status_desc' => 'サーバーからのリアルタイムデータ',
        'offline_status_desc' => 'オフラインのためセーブデータを参照しています',
        'rcon_disabled_status_desc' => 'RCONが無効のためセーブデータを参照しています',
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
            'label_ban' => 'BAN',
            'label_unban' => 'BAN解除',
            'reason' => '理由',
            'default_reason' => '管理者によるBAN',
            'notify_ban' => 'BANコマンドを送信しました',
            'notify_unban' => 'BAN解除コマンドを送信しました',
        ],
    ],

    'widget' => [
        'online_players' => 'オンライン人数',
        'motd' => 'MOTD',
        'map' => 'マップ名',
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
        'offline_data_source' => 'オフライン (最終セーブデータ)',
    ],

    'units' => [
        'mins' => '分',
    ],
    'settings' => [
        'rcon_enabled' => 'RCON / ライブステータスを有効にする',
        'rcon_enabled_helper' => 'RCONを使用してリアルタイムデータ（インベントリ、体力など）を取得・表示します。server.propertiesでRCONが有効になっている必要があります。',
        'nav_sort' => 'メニュー表示順序',
        'nav_sort_helper' => 'サイドメニュー内の表示順序を設定します。数字が小さいほど上に表示されます。（デフォルト: 2）',
        'saved' => '設定を保存しました。',
    ],
];
