<?php

namespace App\Filament\Resources\Queues\Pages;

use App\Filament\Resources\Queues\QueueResource;
use App\Models\Queue;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ListQueues extends ListRecords
{
    protected static string $resource = QueueResource::class;

    protected function getHeaderActions(): array
    {
        return [
    
        ];
    }
}