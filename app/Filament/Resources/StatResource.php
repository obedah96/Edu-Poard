<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StatResource\Pages;
use App\Filament\Resources\StatResource\RelationManagers;
use App\Models\Client;
use App\Models\Stat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\NumberInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use App\Models\Customer;
use App\Models\TeamMember;
use App\Models\Task;
use App\Models\Document;
use Filament\Tables\Columns\NumberColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StatResource extends Resource
{
    protected static ?string $model = Stat::class;
    protected static ?string $navigationIcon = 'heroicon-o-chart-pie';

    public static function getLabel(): ?string
    {
        return __('stat.resource.label');
    }

    public static function getPluralLabel(): ?string
    {
        return __('stat.resource.plural_label');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('total_customers')
                ->required()
                ->numeric()
                ->minValue(0)
                ->label(__('stat.fields.total_customers')),

            TextInput::make('team_members')
                ->required()
                ->numeric()
                ->minValue(0)
                ->label(__('stat.fields.team_members')),

            TextInput::make('active_tasks')
                ->required()
                ->numeric()
                ->minValue(0)
                ->label(__('stat.fields.active_tasks')),

            TextInput::make('total_documents')
                ->required()
                ->numeric()
                ->minValue(0)
                ->label(__('stat.fields.total_documents')),

            TextInput::make('uploads_this_month')
                ->required()
                ->numeric()
                ->minValue(0)
                ->label(__('stat.fields.uploads_this_month')),

            DatePicker::make('record_date')
                ->required()
                ->unique()
                ->default(now())
                ->label(__('stat.fields.record_date')),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('total_clients')
                ->label(__('stat.fields.total_customers'))
                ->getStateUsing(fn () => Client::count())
                ->sortable(false),

            TextColumn::make('active_tasks')
                ->label(__('stat.fields.active_tasks'))
                ->getStateUsing(fn () => Task::where('status', '!=', 'completed')->count())
                ->sortable(false),

            TextColumn::make('total_documents')
                ->label(__('stat.fields.total_documents'))
                ->getStateUsing(fn () => Document::count())
                ->sortable(false),

            TextColumn::make('uploads_this_month')
                ->label(__('stat.fields.uploads_this_month'))
                ->getStateUsing(function () {
                    $start = now()->startOfMonth();
                    $end   = now()->endOfMonth();

                    return Document::whereBetween('created_at', [$start, $end])->count();
                })
                ->sortable(false),
        ])
        ->filters([])
        ->defaultSort('record_date', 'desc')
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
            'index'  => Pages\StatOverview::route('/'),
            'create' => Pages\CreateStat::route('/create'),
            'edit' => Pages\EditStat::route('/{record}/edit'),
        ];
    }
    public static function canViewAny(): bool
    {
        return auth()->user()?->hasRole(['Owner']);
    }
}
