<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable()->label('Nama'),
                TextColumn::make('username')->searchable()->label('Username'),
                TextColumn::make('email')->searchable()->label('Email'),
                TextColumn::make('role')->badge()->label('Role'),
                TextColumn::make('counter.name')
                    ->label('Loket')
                    ->default('N/A'),
            ])
            ->actions([
                \Filament\Actions\EditAction::make()
                    ->label('')            
                    ->iconButton()         
                    ->color('success'),
                \Filament\Actions\DeleteAction::make()
                    ->label('')            
                    ->iconButton()         
                    ->color('danger'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}