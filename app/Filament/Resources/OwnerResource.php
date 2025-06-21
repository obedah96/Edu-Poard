<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OwnerResource\Pages;
use App\Filament\Resources\OwnerResource\RelationManagers;
use App\Models\Owner;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;

class OwnerResource extends Resource
{
    protected static ?string $model = Owner::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function getLabel(): string
    {
        return __('filament.owner.label');
    }

    public static function getPluralLabel(): string
    {
        return __('filament.owner.plural_label');
    }

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Select::make('user_id')
                ->label(__('filament.owner.fields.user'))
                ->relationship('user', 'name')
                ->searchable()
                ->required(),

            FileUpload::make('avatar')
                ->label(__('filament.owner.fields.avatar'))
                ->image()
                ->directory('avatars')
                ->imageEditor(),

            Textarea::make('notes')
                ->label(__('filament.owner.fields.notes'))
                ->rows(4),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table->columns([
            ImageColumn::make('avatar')
                ->label(__('filament.owner.fields.avatar'))
                ->circular(),

            TextColumn::make('user.name')
                ->label(__('filament.owner.fields.user')),

            TextColumn::make('notes')
                ->label(__('filament.owner.fields.notes'))
                ->limit(30),
        ])
        ->filters([])
        ->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),
        ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOwners::route('/'),
            'create' => Pages\CreateOwner::route('/create'),
            'edit' => Pages\EditOwner::route('/{record}/edit'),
        ];
    }
    public static function canViewAny(): bool
    {
        return auth()->user()?->hasRole(['Owner']);
    }
}
