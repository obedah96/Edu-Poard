<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DepartmentResource\Pages;
use App\Models\Department;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class DepartmentResource extends Resource
{
    protected static ?string $model = Department::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    public static function getLabel(): string
    {
        return __('department.resource.label');
    }

    public static function getPluralLabel(): string
    {
        return __('department.resource.plural_label');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('service_type')
                ->label(__('department.fields.service_type'))
                ->options([
                    'Software' => __('department.service_types.Software'),
                    'Design' => __('department.service_types.Design'),
                    'Marketing' => __('department.service_types.Marketing'),
                    'Business' => __('department.service_types.Business'),
                ])
                ->required()
                ->searchable(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('service_type')
                ->label(__('department.fields.service_type'))
                ->formatStateUsing(fn ($state) => __("department.service_types.$state")),
        ])
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDepartments::route('/'),
            'create' => Pages\CreateDepartment::route('/create'),
            'edit' => Pages\EditDepartment::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return auth()->user()?->hasRole(['Owner']);
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()?->hasRole('Owner');
    }
}
