<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IncomeResource\Pages;
use App\Filament\Resources\IncomeResource\RelationManagers;
use App\Models\Income;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\NumberInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\NumberColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\CurrencyColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class IncomeResource extends Resource
{
    protected static ?string $model = Income::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

     public static function getLabel(): ?string
    {
        return __('income.resource.label'); // سيتم تحميله من ملف الترجمة
    }

    // التسمية في اللغة الإنجليزية
    public   static function getPluralLabel(): ?string
    {
        return __('income.resource.plural_label'); // سيتم تحميله من ملف الترجمة
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                 Forms\Components\Select::make('client_id')
                ->label('Client')
                ->relationship('client', 'company_name')
                ->searchable()
                ->required(),

            TextInput::make('amount')
            ->numeric()
            ->required()
            ->label('Amount'),

            DatePicker::make('date')
                ->required()
                ->default(now())
                ->label('Date'),

            Textarea::make('description')
                ->nullable()
                ->label('Description'),

            TextInput::make('source')
                ->nullable()
                ->maxLength(255)
                ->label('Source'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('client.company_name')->label('Client')->searchable()->sortable(),
                TextColumn::make('amount')
                ->label('Amount')
                ->sortable()
                ->formatStateUsing(fn ($state) => number_format($state, 2) . ' $'),
                TextColumn::make('date')->date()->sortable(),
                TextColumn::make('description')->limit(50),
                TextColumn::make('source')->limit(50),
                TextColumn::make('created_at')->dateTime()->sortable(),
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
            'index'  => Pages\IncomeComingSoon::route('/'),
            'create' => Pages\CreateIncome::route('/create'),
            'edit' => Pages\EditIncome::route('/{record}/edit'),
        ];
    }
    public static function canViewAny(): bool
    {
        return auth()->user()?->hasRole(['Owner']);
    }
}
