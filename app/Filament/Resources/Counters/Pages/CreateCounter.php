<?php

namespace App\Filament\Resources\Counters\Pages;

use App\Filament\Resources\Counters\CounterResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCounter extends CreateRecord
{
    protected static string $resource = CounterResource::class;

    public function getHeading(): string
    {
        return 'Tambah Loket';
    }

    protected function getCreateFormAction(): \Filament\Actions\Action
    {
        return parent::getCreateFormAction()->label('Simpan');
    }

    protected function getCreateAnotherFormAction(): \Filament\Actions\Action
    {
        return parent::getCreateAnotherFormAction()->label('Simpan & Buat Baru');
    }

    protected function getCancelFormAction(): \Filament\Actions\Action
    {
        return parent::getCancelFormAction()->label('Batal');
    }
}
