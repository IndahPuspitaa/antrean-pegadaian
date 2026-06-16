<?php

namespace App\Filament\Resources\Counters\Pages;

use App\Filament\Resources\Counters\CounterResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCounter extends EditRecord
{
    protected static string $resource = CounterResource::class;

    public function getHeading(): string
    {
        return 'Ubah Loket';
    }

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\DeleteAction::make()->label('Hapus'),
        ];
    }

    protected function getSaveFormAction(): \Filament\Actions\Action
    {
        return parent::getSaveFormAction()->label('Simpan Perubahan');
    }

    protected function getCancelFormAction(): \Filament\Actions\Action
    {
        return parent::getCancelFormAction()->label('Batal');
    }
}
