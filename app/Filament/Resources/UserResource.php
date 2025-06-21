<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DateTimePicker;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    // دوال لعرض الترجمة
    public static function getLabel(): string
    {
        return __('user.resource.label');
    }

    public static function getPluralLabel(): string
    {
        return __('user.resource.plural_label');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                 TextInput::make('name')
                    ->label(__('user.fields.name'))
                    ->required()
                    ->maxLength(150),

                TextInput::make('email')
                    ->label(__('user.fields.email'))
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true),

                TextInput::make('password')
                    ->label(__('user.fields.password'))
                    ->password()
                    ->required()
                    ->maxLength(255)
                    ->dehydrateStateUsing(fn ($state) => bcrypt($state))
                    ->hiddenOn('edit'),

                Select::make('type')
                    ->label(__('user.fields.type'))
                    ->required()
                    ->options([
                        'Admin' => __('user.type.admin'),
                        'Client' => __('user.type.client'),
                        'Owner' => __('user.type.owner')
                    ]),

                DateTimePicker::make('email_verified_at')
                    ->label(__('user.fields.email_verified_at'))
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('user.fields.name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label(__('user.fields.email'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('type')
                    ->label(__('user.fields.type'))
                    ->badge(),
                TextColumn::make('created_at')
                    ->label(__('user.fields.created_at'))
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function canAccess(): bool
    {
        return auth()->user()?->hasRole('Owner');
    }
    public static function canViewAny(): bool
    {
        return auth()->user()?->hasRole(['Owner']);
    }
}
