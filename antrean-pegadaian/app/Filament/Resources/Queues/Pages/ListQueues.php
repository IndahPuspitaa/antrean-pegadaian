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
            Action::make('export')
                ->label('Export Data')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->action(function (): StreamedResponse {
                    $queues = Queue::with('serviceCategory', 'counter')
                        ->whereDate('queue_date', today())
                        ->orderBy('ticket_number')
                        ->get();

                    return response()->streamDownload(function () use ($queues) {
                        $handle = fopen('php://output', 'w');

                        // Header CSV
                        fputcsv($handle, [
                            'No. Antrean',
                            'Nama/Kode',
                            'Layanan',
                            'Waktu Daftar',
                            'Loket',
                            'Status',
                        ]);

                        // Data
                        foreach ($queues as $queue) {
                            fputcsv($handle, [
                                $queue->ticket_number,
                                $queue->customer_name ?? '—',
                                $queue->serviceCategory?->name ?? '—',
                                $queue->created_at?->format('H:i') ?? '—',
                                $queue->counter?->name ?? '—',
                                $queue->status,
                            ]);
                        }

                        fclose($handle);
                    }, 'data-antrean-' . today()->format('Y-m-d') . '.csv');
                }),
        ];
    }
}