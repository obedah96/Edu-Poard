<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdminResource\Pages;
use App\Filament\Resources\AdminResource\RelationManagers;
use App\Models\Admin;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Model;


class AdminResource extends Resource
{
    protected static ?string $model = Admin::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';

     public static function getLabel(): ?string
    {
        return __('admin.resource.label'); // ملف الترجمة
    }

    public static function getPluralLabel(): ?string
    {
        return __('admin.resource.plural_label'); // ملف الترجمة
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('user_id')
                ->label(__('admin.fields.user'))
                ->relationship('user', 'name')
                ->searchable()
                ->required(),
                Forms\Components\Select::make('departments')
                ->label(__('admin.fields.department'))
                ->relationship('departments', 'service_type'),

            Forms\Components\FileUpload::make('avatar')
                ->label(__('admin.fields.avatar'))
                ->image()
                ->directory('admin-avatars'),

            Forms\Components\Select::make('status')
                ->label(__('admin.fields.status'))
                ->options([
                    'active' => __('admin.status.active'),
                    'inactive' => __('admin.status.inactive'),
                ])
                ->default('active')
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('user.name')
                ->label(__('admin.fields.user'))
                ->searchable()
                ->sortable(),

            Tables\Columns\TextColumn::make('departments')
            ->label(__('admin.fields.department'))
            ->getStateUsing(fn ($record) => $record->departments->pluck('service_type')->join(', '))
            ->limit(20)
            ->toggleable(),

            Tables\Columns\ImageColumn::make('avatar')
                ->label(__('admin.fields.avatar')),

            Tables\Columns\TextColumn::make('status')
                ->label(__('admin.fields.status'))
                ->formatStateUsing(fn ($state) =>
                    $state === 'active'
                        ? __('admin.status.active')
                        : __('admin.status.inactive')
                )
                ->badge()
                ->color(fn ($state) => $state === 'active' ? 'success' : 'danger'),
        ])
        ->filters([
            Tables\Filters\SelectFilter::make('status')
                ->label(__('admin.fields.status'))
                ->options([
                    'active' => __('admin.status.active'),
                    'inactive' => __('admin.status.inactive'),
                ]),
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

    // ... باقي الدوال كما هي (canEdit, getEloquentQuery, canDelete, ...)


    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAdmins::route('/'),
            'create' => Pages\CreateAdmin::route('/create'),
            'edit' => Pages\EditAdmin::route('/{record}/edit'),
        ];
    }
    public static function canViewAny(): bool
    {
        return auth()->user()?->hasRole(['Owner','Admin']);
    }


public static function canEdit(Model $record): bool
{
    $user = auth()->user();

    if ($user->hasRole('Owner')) {
        return true;
    }

    if ($user->hasRole('Admin')) {
        return $record->user_id === $user->id;
    }

    return false;
}

public static function getEloquentQuery(): Builder
{
    $query = parent::getEloquentQuery();

    $user = auth()->user();

    if ($user->hasRole('Owner')) {
        return $query; // عرض الكل
    }

    if ($user->hasRole('Admin')) {
        return $query->where('user_id', $user->id); // فقط السجل المرتبط بالمستخدم الحالي
    }

    return $query->whereNull('id'); // إخفاء كل شيء عن غير المصرح لهم
}
    public static function canDelete(Model $record): bool
    {
        return auth()->user()?->hasRole('Owner');
    }
}
