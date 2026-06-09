<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('username')
                    ->label('Username')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),

                TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),

                TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $context): bool => $context === 'create')
                    ->maxLength(255),

                Select::make('role')
                    ->label('Role Akses')
                    ->options([
                        'admin' => 'Admin',
                        'kasir' => 'Kasir',
                        'kiosk' => 'Kiosk',
                    ])
                    ->required(),
                Select::make('counter_id')
                    ->label('Tugas di Loket')
                    ->relationship('counter', 'name')
                    ->placeholder('Pilih Loket (Hanya untuk Kasir)')
                    ->helperText('Loket 1 untuk Kasir Utama, Loket 2 untuk bantuan magang.'),
            ]);
    }
}