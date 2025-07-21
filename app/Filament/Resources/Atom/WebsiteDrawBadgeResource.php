<?php

namespace App\Filament\Resources\Atom;

use App\Models\WebsiteDrawBadge;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use App\Filament\Resources\Atom\WebsiteDrawBadgeResource\Pages;

class WebsiteDrawBadgeResource extends Resource
{
    protected static ?string $model = WebsiteDrawBadge::class;

    protected static ?string $navigationIcon = 'heroicon-o-trophy';

    protected static ?string $navigationGroup = 'Website';

    protected static ?string $slug = 'draw-badges';

    protected static ?string $pluralModelLabel = 'draw badges';

    protected static ?string $navigationLabel = 'Draw Badges';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Toggle::make('published')
                    ->label(__('Published'))
                    ->default(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('id', 'desc')
            ->columns([
                TextColumn::make('id')
                    ->label(__('ID'))
                    ->sortable(),
                TextColumn::make('user_id')
                    ->label(__('User ID')),
                TextColumn::make('created_at')
                    ->label(__('Created At'))
                    ->dateTime(),
                ImageColumn::make('badge_url')
                    ->label(__('Badge'))
                    ->getStateUsing(fn ($record) => config('app.url') . $record->badge_url)
                    ->extraAttributes(['style' => 'image-rendering: pixelated'])
                    ->size(40),
                ToggleColumn::make('published')
                    ->label(__('Published')),
            ])
            ->actions([
                DeleteAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWebsiteDrawBadge::route('/'),
            'edit' => Pages\EditWebsiteDrawBadge::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}