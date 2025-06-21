<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientResource\Pages;
use App\Filament\Resources\ClientResource\RelationManagers;
use App\Models\Client;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\models\Admin;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Support\Facades\Auth;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ClientResource extends Resource
{
    protected static ?string $model = Client::class;
    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function getLabel(): ?string
    {
        return __('client.resource.label');
    }

    public static function getPluralLabel(): ?string
    {
        return __('client.resource.plural_label');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->label(__('client.fields.user'))
                    ->relationship('user', 'name')
                    ->searchable()
                    ->required(),

                Select::make('admin_id')
                    ->label(__('client.fields.admin'))
                    ->options(function () {
                        return Admin::with('user')
                            ->get()
                            ->mapWithKeys(fn ($admin) => [$admin->id => $admin->user->name ?? '—']);
                    })
                    ->getOptionLabelFromRecordUsing(fn (Admin $record) => $record->user->name ?? '—')
                    ->required(),

                TextInput::make('company_name')
                    ->label(__('client.fields.company_name'))
                    ->required()
                    ->maxLength(255),

                Select::make('service_type')
                    ->label(__('client.fields.service_type'))
                    ->options([
                        'Software' => __('client.service_types.software'),
                        'Design' => __('client.service_types.design'),
                        'Marketing' => __('client.service_types.marketing'),
                        'Business' => __('client.service_types.business'),
                    ]),

                FileUpload::make('logo')
                    ->label(__('client.fields.logo'))
                    ->image()
                    ->nullable()
                    ->directory('client-logos'),

                Select::make('status')
                    ->label(__('client.fields.status'))
                    ->required()
                    ->options([
                        'active' => __('client.status.active'),
                        'inactive' => __('client.status.inactive'),
                    ])
                    ->default('active'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo')
                    ->label(__('client.fields.logo'))
                    ->circular()
                    ->height(40),

                TextColumn::make('user.name')
                    ->label(__('client.fields.user'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('company_name')
                    ->label(__('client.fields.company_name'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('user.email')
                    ->label(__('client.fields.email'))
                    ->sortable(),

                BadgeColumn::make('status')
                    ->label(__('client.fields.status'))
                    ->colors([
                        'success' => 'active',
                        'secondary' => 'inactive',
                    ])
                    ->sortable(),

                TextColumn::make('admin.user.name')
                    ->label(__('client.fields.admin'))
                    ->searchable()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    // باقي الدوال كما هي بدون تغيير...

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClients::route('/'),
            'create' => Pages\CreateClient::route('/create'),
            'edit' => Pages\EditClient::route('/{record}/edit'),
        ];
    }
    public static function canCreate(): bool
    {
        return auth()->user()->hasAnyRole([ 'Owner']);
    }

    public static function getEloquentQuery(): Builder
{
    $user = Auth::user();
    $query = parent::getEloquentQuery();

    if ($user->hasRole('Owner')) {
        return $query; // كل شيء
    }

    if ($user->hasRole('Admin')) {
        $adminId = $user->admin?->id;
        return $query->where('admin_id', $adminId ?? 0);
    }

    if ($user->hasRole('Client')) {
        return $query->where('user_id', $user->id);
    }

    return $query->whereNull('id');
}
    public static function canDelete(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return auth()->user()?->hasRole('Owner');
    }
}

