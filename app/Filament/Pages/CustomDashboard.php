<?php

namespace App\Filament\Pages;

use App\Models\Queue;
use App\Models\ServiceCategory;
use Filament\Pages\Dashboard as BaseDashboard;
use Illuminate\Contracts\Support\Htmlable;
use Carbon\Carbon;

class CustomDashboard extends BaseDashboard
{
    protected static ?string $navigationLabel = 'Dashboard';
    protected ?string $heading = 'Dashboard';
    
    protected string $view = 'filament.pages.custom-dashboard';

    public function getSubheading(): string | Htmlable | null
    {
        return 'Ringkasan antrean kasir hari ini';
    }

    protected function getViewData(): array
    {
        $today = Carbon::today();
         
        return [
            'totalToday'     => Queue::whereDate('queue_date', $today)->count(),
            'callingToday'   => Queue::whereDate('queue_date', $today)->where('status', 'Dipanggil')->count(),
            'completedToday' => Queue::whereDate('queue_date', $today)->where('status', 'Selesai')->count(),
            'waitingToday'   => Queue::whereDate('queue_date', $today)->where('status', 'Menunggu')->count(),
            'categories' => ServiceCategory::withCount([
                'queues as waiting_count' => fn ($q) => $q
                    ->whereDate('queue_date', $today)
                    ->where('status', 'Menunggu'),
            ])->orderBy('sort_order')->get(),

            'recentActivities' => Queue::with(['serviceCategory', 'counter'])
                 ->whereDate('queue_date', $today)
                ->latest()
                ->take(5)
                ->get(),
        ];
    }
}