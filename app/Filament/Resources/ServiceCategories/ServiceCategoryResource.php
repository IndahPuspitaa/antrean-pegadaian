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
            ->columns([
                Stack::make([
                    Split::make([
                        TextColumn::make('name')
                            ->label('Nama Layanan')
                            ->weight('bold')
                            ->size('lg')
                            ->searchable(),

                        Split::make([
                            EditAction::make()
                                ->label('')
                                ->iconButton()
                                ->color('success'),
                            DeleteAction::make()
                                ->label('')
                                ->iconButton()
                                ->color('danger'),
                        ])->grow(false),
                    ]),

                    TextColumn::make('description')
                        ->label('Deskripsi')
                        ->color('gray')
                        ->limit(60)
                        ->searchable(),

                    Split::make([
                        TextColumn::make('waiting_today')
                            ->label('Total Antrean')
                            ->state(fn (ServiceCategory $record) => $record->waitingToday())
                            ->color('gray')
                            ->size('sm'),

                        TextColumn::make('waiting_today_value')
                            ->label('')
                            ->state(fn (ServiceCategory $record) => $record->waitingToday())
                            ->weight('bold')
                            ->size('xl')
                            ->extraAttributes(['class' => 'text-right']),
                    ]),
                ])->space(3),
            ])
            ->filters([])
            ->actions([])
            ->bulkActions([
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