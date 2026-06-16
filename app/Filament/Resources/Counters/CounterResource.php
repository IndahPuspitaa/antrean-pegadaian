<?php

namespace App\Filament\Resources\Counters;

use App\Filament\Resources\Counters\Pages\CreateCounter;
use App\Filament\Resources\Counters\Pages\EditCounter;
use App\Filament\Resources\Counters\Pages\ListCounters;
use App\Filament\Resources\Counters\Schemas\CounterForm;
use App\Models\Counter;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Table;
use Filament\Tables\Columns\ToggleColumn;

class CounterResource extends Resource
{
    protected static ?string $model = Counter::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedComputerDesktop;
    protected static string|\UnitEnum|null $navigationGroup = 'Master Data';
    protected static ?string $navigationLabel = 'Loket';

    protected static ?string $modelLabel = 'Loket';

    protected static ?string $pluralModelLabel = 'Loket';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return CounterForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Loket')
                    ->weight('bold')
                    ->searchable()
                    ->sortable(),

                ToggleColumn::make('is_active') 
                    ->label('Status Aktif')
                    ->onIcon('heroicon-m-check')    
                    ->offIcon('heroicon-m-x-mark')  
                    ->sortable(),
            ])
            ->filters([])
            ->actions([
                EditAction::make()
                    ->label('')            
                    ->iconButton()         
                    ->color('success'),
                DeleteAction::make()
                    ->label('')            
                    ->iconButton()         
                    ->color('danger'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
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
            'index'  => ListCounters::route('/'),
            'create' => CreateCounter::route('/create'),
            'edit'   => EditCounter::route('/{record}/edit'),
        ];
    }
}