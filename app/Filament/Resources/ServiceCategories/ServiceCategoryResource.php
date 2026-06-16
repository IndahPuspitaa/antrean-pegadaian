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
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;


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
                    TextColumn::make('name')
                        ->weight('bold')
                        ->size(TextColumn\TextColumnSize::Large)
                        ->searchable()
                        ->sortable(),

                    TextColumn::make('description')
                        ->color('gray')
                        ->lineClamp(2),

                    Split::make([
                        TextColumn::make('label_total')
                            ->default('Total Antrean')
                            ->color('gray')
                            ->size(TextColumn\TextColumnSize::Small),
                        
                        TextColumn::make('queues_count')
                            ->default('0') 
                            ->weight('bold')
                            ->color('success')
                            ->size(TextColumn\TextColumnSize::Large)
                            ->alignRight(),
                    ])->extraAttributes(['class' => 'mt-6 border-t pt-4']),
                    
                ])->space(2), 
            ])
            ->filters([])
            ->actions([
            EditAction::make()
                ->label('Ubah'),
                
            DeleteAction::make()
                ->label('Hapus'),
            ])
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