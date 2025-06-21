<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DocumentResource\Pages;
use App\Filament\Resources\DocumentResource\RelationManagers;
use App\Models\Document;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Storage;


class DocumentResource extends Resource
{
    protected static ?string $model = Document::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getLabel(): ?string
    {
        return __('document.resource.label');
    }

    public static function getPluralLabel(): ?string
    {
        return __('document.resource.plural_label');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('client_id')
                    ->label(__('document.fields.client')) // الترجمة
                    ->options(function () {
                        return \App\Models\Client::with('user')
                            ->get()
                            ->pluck('user.name', 'id');
                    })
                    ->searchable()
                    ->required(),

                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label(__('document.fields.name')),

                DatePicker::make('document_date')
                    ->required()
                    ->default(now())
                    ->label(__('document.fields.document_date')),

                TextInput::make('version')
                    ->maxLength(10)
                    ->required()
                    ->label(__('document.fields.version')),

                Select::make('type')
                    ->options([
                        'proposal' => __('document.types.proposal'),
                        'contract' => __('document.types.contract'),
                        'invoice' => __('document.types.invoice'),
                        'report' => __('document.types.report'),
                        'presentation' => __('document.types.presentation'),
                        'certificate' => __('document.types.certificate'),
                        'other' => __('document.types.other'),
                    ])
                    ->required()
                    ->label(__('document.fields.type')),

                Select::make('service_type')
                    ->label(__('document.fields.service_type'))
                    ->options([
                        'Software' => __('document.service_types.software'),
                        'Design' => __('document.service_types.design'),
                        'Marketing' => __('document.service_types.marketing'),
                        'Business' => __('document.service_types.business'),
                    ]),

                FileUpload::make('file_path')
                    ->image()
                    ->required()
                    ->directory('documents')
                    ->helperText(__('document.fields.file_upload_helper'))
                    ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/zip']),

                Select::make('uploaded_by')
                    ->label(__('document.fields.uploaded_by'))
                    ->relationship('uploadedBy', 'name')
                    ->nullable()
                    ->searchable(),

                Forms\Components\Toggle::make('is_active')
                    ->label(__('document.fields.is_active'))
                    ->default(true),

                Textarea::make('notes')
                    ->nullable()
                    ->label(__('document.fields.notes')),
            ]);
    }

    // جدول العرض
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label(__('document.fields.name')),

                TextColumn::make('client.user.name')
                    ->label(__('document.fields.client'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('document_date')
                    ->date()
                    ->sortable()
                    ->label(__('document.fields.document_date')),

                TextColumn::make('version')
                    ->sortable()
                    ->label(__('document.fields.version')),

                BadgeColumn::make('type')
                    ->sortable()
                    ->label(__('document.fields.type')),

                TextColumn::make('service_type')
                    ->sortable()
                    ->label(__('document.fields.service_type')),

                TextColumn::make('file_path')
                    ->label(__('document.fields.file_path'))
                    ->limit(50),

                TextColumn::make('uploadedBy.name')
                    ->label(__('document.fields.uploaded_by'))
                    ->sortable()
                    ->searchable(),

                BadgeColumn::make('is_active')
                    ->colors(['success' => true, 'secondary' => false])
                    ->sortable()
                    ->label(__('document.fields.is_active')),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label(__('document.fields.created_at')),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Action::make('download')
                    ->label(__('document.actions.download'))
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn ($record) => Storage::url($record->file_path))
                    ->openUrlInNewTab()
                    ->color('success'),
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
        $pages = [
            'index' => Pages\ListDocuments::route('/'),
            $pages['create'] = Pages\CreateDocument::route('/create'),
            $pages['edit'] = Pages\EditDocument::route('/{record}/edit')
        ];

        return $pages;
    }

     public static function getEloquentQuery(): Builder
    {
        $user = auth()->user();

        if ($user->hasRole('Owner')) {
            return parent::getEloquentQuery();
        }

        if ($user->hasRole('Admin')) {
            return parent::getEloquentQuery()
                ->whereHas('client', fn ($q) => $q->where('admin_id', $user->id));
        }

        if ($user->hasRole('Client')) {
            return parent::getEloquentQuery()
                ->where('client_id', $user->client->id ?? 0);
        }

        return parent::getEloquentQuery()->whereRaw('1 = 0'); // غير مصرح له بشيء
    }

        public static function canCreate(): bool
    {
        return auth()->user()?->hasRole('Owner');
    }

    public static function canEdit(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return auth()->user()?->hasRole('Owner');
    }

}
