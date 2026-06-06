<?php

namespace App\Filament\Resources\Queues\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;

class QueueForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Antrean')
                    ->columnSpanFull()
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('ticket_number')
                                    ->label('Nomor Antrean')
                                    ->disabled(),

                                Select::make('service_category_id')
                                    ->label('Layanan')
                                    ->relationship('serviceCategory', 'name')
                                    ->required(),
                            ]),

                        Grid::make(2)
                            ->schema([
                                TextInput::make('customer_name')
                                    ->label('Nama Nasabah')
                                    ->placeholder('Opsional'),

                                TextInput::make('counter_id')
                                    ->label('Loket')
                                    ->numeric(),
                            ]),

                        Grid::make(2)
                            ->schema([
                                Select::make('status')
                                    ->label('Status')
                                    ->options([
                                        'Menunggu'  => 'Menunggu',
                                        'Dipanggil' => 'Dipanggil',
                                        'Selesai'   => 'Selesai',
                                        'Dilewati'  => 'Dilewati',
                                    ])
                                    ->required(),

                                DatePicker::make('queue_date')
                                    ->label('Tanggal')
                                    ->default(today()),
                            ]),
                    ]),
            ]);
    }
}