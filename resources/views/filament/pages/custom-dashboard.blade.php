<x-filament-panels::page>
<style>
.db-wrap { font-family: 'Inter', sans-serif; display: flex; flex-direction: column; gap: 20px; width: 100%; }
.db-stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; }
.db-card { background: white; border-radius: 14px; border: 1px solid #e5e7eb; padding: 20px; }
.db-card-icon { width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 12px; font-size: 22px; }
.db-card-num { font-size: 30px; font-weight: 700; color: #1f2937; margin-bottom: 2px; }
.db-card-label { font-size: 13px; color: #6b7280; }
.db-section { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.db-box { background: white; border-radius: 14px; border: 1px solid #e5e7eb; padding: 20px; }
.db-box-title { font-size: 17px; font-weight: 700; color: #1f2937; margin-bottom: 16px; }
.cat-row { margin-bottom: 16px; }
.cat-top { display: flex; justify-content: space-between; margin-bottom: 6px; }
.cat-name { font-size: 13px; color: #374151; font-weight: 500; }
.cat-count { font-size: 13px; font-weight: 700; color: #1f2937; }
.cat-bar-bg { width: 100%; height: 8px; background: #f3f4f6; border-radius: 999px; overflow: hidden; }
.cat-bar { height: 100%; border-radius: 999px; }
.act-row { display: flex; align-items: center; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #f3f4f6; }
.act-row:last-child { border-bottom: none; }
.act-left { display: flex; align-items: center; gap: 10px; }
.act-badge { width: 38px; height: 38px; background: #ebfaef; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #008236; font-weight: 700; font-size: 11px; flex-shrink: 0; }
.act-name { font-size: 13px; font-weight: 500; color: #1f2937; }
.act-sub { font-size: 11px; color: #6b7280; margin-top: 1px; }
.act-status { font-size: 11px; font-weight: 600; padding: 3px 10px; border-radius: 999px; white-space: nowrap; }
.status-selesai { background: #ebfaef; color: #008236; }
.status-dipanggil { background: #fff5eb; color: #ca3500; }
.status-menunggu { background: #f3f4f6; color: #6b7280; }
.db-cta { background: linear-gradient(to right, #00a63e, #008236); border-radius: 14px; padding: 20px; display: flex; align-items: center; justify-content: space-between; gap: 12px; }
.db-cta-title { font-size: 16px; font-weight: 700; color: white; margin-bottom: 4px; }
.db-cta-sub { font-size: 13px; color: #b9f8cf; }
.db-cta-btn { background: white; color: #008236; font-weight: 700; font-size: 13px; padding: 10px 18px; border-radius: 10px; text-decoration: none; white-space: nowrap; }

/* Mobile responsive */
@media (max-width: 768px) {
    .db-stats { grid-template-columns: repeat(2, 1fr); }
    .db-section { grid-template-columns: 1fr; }
    .db-cta { flex-direction: column; align-items: flex-start; }
}
</style>

<div class="db-wrap">
    {{-- Stats --}}
<div class="db-stats">
    <div class="db-card">
        <div class="db-card-icon" style="background:#f0f5ff">
            <x-heroicon-o-users style="width:24px;height:24px;stroke:#3b82f6" />
        </div>
        <div class="db-card-num">{{ $totalToday }}</div>
        <div class="db-card-label">Total Antrean Hari Ini</div>
    </div>
    <div class="db-card">
        <div class="db-card-icon" style="background:#fff5eb">
            <x-heroicon-o-phone style="width:24px;height:24px;stroke:#f97316" />
        </div>
        <div class="db-card-num">{{ $callingToday }}</div>
        <div class="db-card-label">Sedang Dipanggil</div>
    </div>
    <div class="db-card">
        <div class="db-card-icon" style="background:#ebfaef">
            <x-heroicon-o-check-circle style="width:24px;height:24px;stroke:#008236" />
        </div>
        <div class="db-card-num">{{ $completedToday }}</div>
        <div class="db-card-label">Selesai Dilayani</div>
    </div>
    <div class="db-card">
        <div class="db-card-icon" style="background:#fffbeb">
            <x-heroicon-o-clock style="width:24px;height:24px;stroke:#f59e0b" />
        </div>
        <div class="db-card-num">{{ $waitingToday }}</div>
        <div class="db-card-label">Sedang Menunggu</div>
    </div>
</div>

    {{-- Kategori & Aktivitas --}}
    <div class="db-section">
        <div class="db-box">
            <div class="db-box-title">Antrean per Kategori Layanan</div>
            @php
                $barColors = [
                    'Cicilan'          => '#00c950',
                    'Perpanjang'       => '#2b7fff',
                    'Tabungan'         => '#ad46ff',
                    'Pelunasan'        => '#ff6900',
                    'Tebusan Non Cash' => '#ff6900',
                    'Lainnya'          => '#6a7282',
                ];
                $maxWaiting = $categories->max('waiting_count') ?: 1;
            @endphp
            @foreach($categories as $cat)
            @php
                $pct   = ($cat->waiting_count / $maxWaiting) * 100;
                $color = $barColors[$cat->name] ?? '#6a7282';
            @endphp     
            <div class="cat-row">
                <div class="cat-top">
                    <span class="cat-name">{{ $cat->name }}</span>
                    <span class="cat-count">{{ $cat->waiting_count }} menunggu</span>
                </div>
                <div class="cat-bar-bg">
                    <div class="cat-bar" style="width:{{ max(($cat->waiting_count / $maxWaiting) * 100, 2) }}%; background:{{ $color }}"></div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="db-box">
            <div class="db-box-title">Aktivitas Terkini</div>
            @forelse($recentActivities as $activity)
            <div class="act-row">
                <div class="act-left">
                    <div class="act-badge">{{ $activity->ticket_number }}</div>
                    <div>
                        <div class="act-name">{{ $activity->customer_name ?? 'Nasabah' }}</div>
                        <div class="act-sub">
                            {{ $activity->serviceCategory?->name }} - {{ $activity->counter?->name ?? 'Loket' }}
                        </div>
                    </div>
                </div>
                @php $s = strtolower($activity->status); @endphp
                <span class="act-status {{ $s === 'selesai' ? 'status-selesai' : ($s === 'dipanggil' ? 'status-dipanggil' : 'status-menunggu') }}">
                    {{ $activity->status }}
                </span>
            </div>
            @empty
            <div style="text-align:center; padding:30px; color:#9ca3af; font-size:13px">
                Belum ada aktivitas hari ini
            </div>
            @endforelse
        </div>
    </div>

    {{-- CTA --}}
    <div class="db-cta">
        <div>
            <div class="db-cta-title">Siap melayani nasabah?</div>
            <div class="db-cta-sub">Panggil antrean berikutnya dari halaman Panggil Antrean</div>
        </div>
        <a href="/admin/panggil-antrean" class="db-cta-btn">Mulai Panggil</a>
    </div>
</div>
</x-filament-panels::page>