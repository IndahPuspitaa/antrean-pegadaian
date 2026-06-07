<?php

namespace App\Filament\Pages;

use App\Models\Counter;
use App\Models\Queue;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Livewire\Attributes\Computed;

class PanggilAntrean extends Page
{
    protected string $view = 'filament.pages.panggil-antrean';

    protected static ?string $navigationLabel = 'Panggil Antrean';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhone;
    protected static ?int $navigationSort = 3;
    protected static ?string $title = 'Panggil Antrean';

    public int $selectedCounter = 1;

    public function getSubheading(): ?string
    {
        return 'Kelola dan panggil antrean nasabah dengan mudah';
    }

    public function mount(): void
    {
        $this->selectedCounter = 1;
    }

    public function selectCounter(int $counterId): void
    {
        $this->selectedCounter = $counterId;
    }

    public function panggilAntrean(int $queueId): void
    {
        $queue = Queue::findOrFail($queueId);

        $queue->update([
            'status'     => 'Dipanggil',
            'counter_id' => $this->selectedCounter,
            'called_at'  => now(),
        ]);

        $this->dispatch('queue-called',
            ticketNumber: $queue->ticket_number,
            counterName: 'Loket ' . $this->selectedCounter
        );
    }

    public function selesai(int $queueId): void
    {
        Queue::findOrFail($queueId)->update([
            'status'       => 'Selesai',
            'completed_at' => now(),
        ]);
    }

    public function lewati(int $queueId): void
    {
        Queue::findOrFail($queueId)->update([
            'status'     => 'Dilewati',
            'skipped_at' => now(),
        ]);
    }

    public function ulangi(int $queueId): void
    {
        $queue = Queue::findOrFail($queueId);
        $queue->update([
            'status'     => 'Dipanggil',
            'counter_id' => $this->selectedCounter,
            'called_at'  => now(),
        ]);

        $this->dispatch('queue-called',
            ticketNumber: $queue->ticket_number,
            counterName: 'Loket ' . $this->selectedCounter
        );
    }

     #[Computed]
     public function counters(): \Illuminate\Database\Eloquent\Collection
    {
        return Counter::where('is_active', true)->orderBy('id')->get();
    }

    #[Computed]
    public function waitingQueues(): \Illuminate\Database\Eloquent\Collection
    {
        return Queue::with(['serviceCategory'])
            ->whereDate('queue_date', today())
            ->where('status', 'Menunggu')
            ->orderBy('ticket_number')
            ->get();
    }

    #[Computed]
     public function calledQueues(): \Illuminate\Database\Eloquent\Collection
    {

        return Queue::with(['serviceCategory', 'counter'])
            ->whereDate('queue_date', today())
            ->where('status', 'Dipanggil')
            ->orderBy('called_at', 'desc')
            ->get();
    }
}