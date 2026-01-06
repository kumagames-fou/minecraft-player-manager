<?php

namespace KumaGames\GamePlayerManager\Filament\Server\Resources;

use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use KumaGames\GamePlayerManager\Filament\Server\Resources\PlayerResource\Pages;
use KumaGames\GamePlayerManager\Services\MinecraftPlayerProvider;
use Filament\Actions\Action;
use Filament\Actions\ViewAction;
use Filament\Facades\Filament;

class PlayerResource extends Resource
{
    protected static ?string $model = \KumaGames\GamePlayerManager\Models\Player::class;
    protected static string | \BackedEnum | null $navigationIcon = 'tabler-users-group';
    
    public static function getNavigationSort(): ?int
    {
        return (int) env('MC_PLAYER_MANAGER_NAV_SORT', 2);
    }

    protected static ?string $navigationLabel = null; 

    public static function getNavigationLabel(): string
    {
        return __('minecraft-player-manager::messages.navigation_label');
    }

    public static function canAccess(): bool
    {
        $server = \Filament\Facades\Filament::getTenant();
        // Check if the server has the 'minecraft' tag
        $tags = $server->egg->tags ?? [];
        return parent::canAccess() && in_array('minecraft', $tags);
    }

    public static function shouldRegisterNavigation(): bool
    {
        return static::canAccess();
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('avatar')
                    ->label('')
                    ->state(function ($record) {
                        $name = $record['name'];
                        // Generic Java Edition Username Regex (approx)
                        // If it contains anything other than a-z, 0-9, or _, it's likely Bedrock or invalid for Minotar
                        if (!preg_match('/^[a-zA-Z0-9_]+$/', $name)) {
                            return "https://minotar.net/avatar/MHF_Steve/32";
                        }
                        return "https://minotar.net/avatar/{$name}/32";
                    })
                    ->circular(),

                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->label(__('minecraft-player-manager::messages.columns.name')),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->state(function ($record) {
                        if ($record['is_banned']) return 'Banned';
                        return $record['online'] ? 'Online' : 'Offline';
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'Online' => 'success',
                        'Banned' => 'danger',
                        'Offline' => 'gray',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'Online' => __('minecraft-player-manager::messages.columns.online'),
                        'Banned' => __('minecraft-player-manager::messages.filters.banned'),
                        'Offline' => __('minecraft-player-manager::messages.columns.offline'),
                        default => $state,
                    })
                    ->label(__('minecraft-player-manager::messages.columns.status')),

                Tables\Columns\IconColumn::make('is_op')
                     ->boolean()
                     ->label(__('minecraft-player-manager::messages.columns.op')),
            ])
            ->actions([
                 Action::make('view_details')
                    ->label(__('minecraft-player-manager::messages.actions.view'))
                    ->icon('heroicon-m-eye')
                    ->color('gray')
                    ->url(fn ($record) => PlayerResource::getUrl('view', ['record' => $record->id])),
                    
                 Action::make('op')
                    ->label(fn ($record) => $record->is_op ? __('minecraft-player-manager::messages.actions.op.label_deop') : __('minecraft-player-manager::messages.actions.op.label_op'))
                    ->color(fn ($record) => $record->is_op ? 'warning' : 'primary')
                    ->icon(fn ($record) => $record->is_op ? 'heroicon-m-shield-exclamation' : 'heroicon-m-shield-check')
                    ->button()
                    ->action(function ($record) {
                        if (!$record) return;
                        
                        $server = \Filament\Facades\Filament::getTenant();
                        if (!$server) return; // Context check

                        $command = $record->is_op ? "deop {$record->name}" : "op {$record->name}";
                        
                        $provider = app(MinecraftPlayerProvider::class);
                        $provider->sendRconCommand($server->uuid, $command);
                        
                        \Filament\Notifications\Notification::make()
                            ->title($record->is_op ? __('minecraft-player-manager::messages.actions.op.notify_deop') : __('minecraft-player-manager::messages.actions.op.notify_op'))
                            ->success()
                            ->send();
                    })
                    ->requiresConfirmation(),

                Action::make('kick')
                    ->color('danger')
                    ->icon('heroicon-m-arrow-right-on-rectangle')
                    ->button()
                    ->action(function ($record) {
                        if (!$record) return;
                        $server = \Filament\Facades\Filament::getTenant();
                        if (!$server) return;

                        $provider = app(MinecraftPlayerProvider::class);
                        $provider->sendRconCommand($server->uuid, "kick {$record->name}");
                        \Filament\Notifications\Notification::make()->title(__('minecraft-player-manager::messages.actions.kick.notify'))->success()->send();
                    })
                    ->requiresConfirmation(),

                Action::make('ban')
                    ->color('danger')
                    ->icon('heroicon-m-no-symbol')
                    ->button()
                    ->action(function ($record) {
                        if (!$record) return;
                        $server = \Filament\Facades\Filament::getTenant();
                        if (!$server) return;

                        $provider = app(MinecraftPlayerProvider::class);
                        $provider->sendRconCommand($server->uuid, "ban {$record->name}");
                        \Filament\Notifications\Notification::make()->title(__('minecraft-player-manager::messages.actions.ban.notify'))->success()->send();
                    })
                    ->requiresConfirmation(),
            ]);
    }

    public static function form(\Filament\Schemas\Schema $schema): \Filament\Schemas\Schema
    {
        return $schema
            ->schema([
                // 1. General Info
                \Filament\Schemas\Components\Section::make(__('minecraft-player-manager::messages.sections.identity'))
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('name')->label(__('minecraft-player-manager::messages.fields.username'))->disabled(),
                        \Filament\Forms\Components\TextInput::make('status')
                            ->label(__('minecraft-player-manager::messages.fields.current_status'))
                            ->disabled()
                            ->formatStateUsing(fn ($state) => match (strtolower($state ?? '')) {
                                'online' => __('minecraft-player-manager::messages.values.online'),
                                'offline' => __('minecraft-player-manager::messages.values.offline'),
                                default => $state,
                            }),
                        \Filament\Forms\Components\TextInput::make('uuid')->label(__('minecraft-player-manager::messages.fields.uuid'))->disabled(),
                    ])->columns(3),

                // 2. Historical Stats (Grid)
                \Filament\Schemas\Components\Section::make(__('minecraft-player-manager::messages.sections.statistics'))
                    ->description(__('minecraft-player-manager::messages.sections.statistics_desc'))
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('play_time')->label(__('minecraft-player-manager::messages.fields.play_time'))->disabled(),
                        \Filament\Forms\Components\TextInput::make('walk_distance')->label(__('minecraft-player-manager::messages.fields.distance_walked'))->disabled(),
                        \Filament\Forms\Components\TextInput::make('mobs_killed')->label(__('minecraft-player-manager::messages.fields.mobs_killed'))->disabled(),
                        \Filament\Forms\Components\TextInput::make('deaths')->label(__('minecraft-player-manager::messages.fields.deaths'))->disabled(),
                    ])->columns(4),

                \Filament\Schemas\Components\Section::make(__('minecraft-player-manager::messages.sections.live_status'))
                    ->description(fn ($record) => match($record?->raw_stats) {
                        'Offline (Data from Save File)' => __('minecraft-player-manager::messages.sections.offline_status_desc'),
                        'RconDisabled' => __('minecraft-player-manager::messages.sections.rcon_disabled_status_desc'),
                        default => __('minecraft-player-manager::messages.sections.live_status_desc'),
                    })
                    ->schema([

                        \Filament\Forms\Components\ViewField::make('visual_stats')
                            ->label(__('minecraft-player-manager::messages.fields.status'))
                            ->view('minecraft-player-manager::filament.server.resources.player-resource.widgets.visual-stats-view')
                            ->columnSpanFull(),
                        \Filament\Forms\Components\TextInput::make('level')
                            ->label(__('minecraft-player-manager::messages.fields.xp_level'))
                            ->disabled()
                            ->columnSpan(2),
                        \Filament\Forms\Components\TextInput::make('gamemode')
                            ->label(__('minecraft-player-manager::messages.fields.gamemode'))
                            ->disabled()
                            ->formatStateUsing(fn ($state) => match (strtolower($state ?? '')) {
                                'survival' => __('minecraft-player-manager::messages.values.survival'),
                                'creative' => __('minecraft-player-manager::messages.values.creative'),
                                'adventure' => __('minecraft-player-manager::messages.values.adventure'),
                                'spectator' => __('minecraft-player-manager::messages.values.spectator'),
                                default => $state,
                            })
                            ->columnSpan(2),
                    ])->columns(4)->collapsible(),

                // Inventory Section
                \Filament\Schemas\Components\Section::make(__('minecraft-player-manager::messages.sections.inventory'))
                    ->schema([
                         \Filament\Forms\Components\ViewField::make('inventory_data')
                            ->label(__('minecraft-player-manager::messages.fields.visual_inventory'))
                            ->view('minecraft-player-manager::filament.server.resources.player-resource.widgets.inventory-view')
                            ->columnSpanFull(),
                    ])->collapsible(),

                // Management Section (Actions)
                 \Filament\Schemas\Components\Section::make(__('minecraft-player-manager::messages.sections.management'))
                    ->description(__('minecraft-player-manager::messages.sections.management_desc'))
                    ->schema([
                        \Filament\Forms\Components\ViewField::make('management_actions')
                            ->view('minecraft-player-manager::filament.server.resources.player-resource.widgets.management-actions')
                            ->columnSpanFull(),
                    ])->collapsible(),
                



            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPlayers::route('/'),
            'view' => Pages\ViewPlayer::route('/{record}'),
        ];
    }
}
