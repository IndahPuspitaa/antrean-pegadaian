<?php

namespace App\Filament\Resources\Counters\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class CounterForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Loket')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Contoh: Loket 1'),
                    
                Select::make('status')
                    ->label('Status Loket')
                    ->options([
                        'Aktif' => 'Aktif',
                        'Nonaktif' => 'Nonaktif',
                    ])
                    ->default('Aktif')
                    ->required(),
            ]);
    }
}