<?php

namespace App\Filament\Resources\ServiceCategories;

use App\Filament\Resources\ServiceCategories\Pages;
use App\Models\ServiceCategory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Hidden; 
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Enums\RecordActionsPosition;

class ServiceCategoryResource extends Resource
{
    protected static ?string $model = ServiceCategory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedFolder;
    protected static string|\UnitEnum|null $navigationGroup = 'Master Data';

    protected static ?string $navigationLabel = 'Kategori Layanan';

    protected static ?string $modelLabel = 'Kategori Layanan';

    protected static ?string $pluralModelLabel = 'Kategori Layanan';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Kategori')
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Layanan')
                            ->required()
                            ->placeholder('Cicilan'),

                        Textarea::make('description')
                            ->label('Deskripsi')
                            ->placeholder('Pembayaran cicilan gadai')
                            ->rows(2),

                        Hidden::make('estimated_time')
                            ->default(5),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->contentGrid([
                'md' => 2,
                'xl' => 3,
            ])
            ->extraAttributes(['class' => 'service-category-cards'])
            ->recordActionsPosition(RecordActionsPosition::BeforeColumns)
            ->columns([
                Stack::make([
                    TextColumn::make('name')
                        ->label('Nama Layanan')
                        ->weight('bold')
                        ->size('md'),

                    TextColumn::make('description')
                        ->label('Deskripsi')
                        ->color('gray')
                        ->size('sm')
                        ->limit(60),

                    Split::make([
                        TextColumn::make('waiting_today_label')
                            ->label('')
                            ->state('Total Antrean')
                            ->color('gray')
                            ->size('sm'),

                        TextColumn::make('waiting_today')
                            ->label('')
                            ->state(fn (ServiceCategory $record) => $record->waitingToday())
                            ->weight('bold')
                            ->size('lg')
                            ->alignEnd(),
                    ])->extraAttributes(['class' => 'border-t border-gray-200 dark:border-white/10 !mt-2 !pt-3']),
                    ])->space(2),
            ])
            ->filters([])
            ->recordActions([
                EditAction::make()
                    ->label('')
                    ->iconButton()
                    ->color('success'),
                DeleteAction::make()
                    ->label('')
                    ->iconButton()
                    ->color('danger'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Hapus Terpilih'),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListServiceCategories::route('/'),
            'create' => Pages\CreateServiceCategory::route('/create'),
            'edit'   => Pages\EditServiceCategory::route('/{record}/edit'),
        ];
    }
}