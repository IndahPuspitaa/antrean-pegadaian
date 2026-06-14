<x-filament-panels::page>
    {{-- Info Speaker --}}
    <div style="background:#eff6ff;border:1px solid #bfdbfe;border-radius:12px;padding:16px;display:flex;align-items:flex-start;gap:12px;margin-bottom:8px">
        <x-heroicon-o-speaker-wave style="width:24px;height:24px;stroke:#3b82f6;flex-shrink:0;margin-top:2px" />
        <div>
            <p style="font-weight:600;color:#1d4ed8;margin:0 0 4px 0">Panggilan Suara melalui Speaker</p>
            <p style="font-size:14px;color:#3b82f6;margin:0">Nomor antrean akan dipanggil melalui pengeras suara/speaker di ruang tunggu. Pastikan sistem audio aktif.</p>
        </div>
    </div>

    {{-- Pilih Loket --}}
    <div style="background:white;border:1px solid #e5e7eb;border-radius:12px;padding:16px;margin-bottom:8px">
        <p style="font-size:14px;color:#6b7280;margin:0 0 12px 0">Pilih Loket Anda</p>
        <div style="display:grid;grid-template-columns:repeat({{ $this->counters->count() }},1fr);gap:12px">
            @foreach($this->counters as $counter)
                <button
                    wire:click="selectCounter({{ $counter->id }})"
                    style="padding:12px 16px;border-radius:12px;font-weight:600;cursor:pointer;transition:all 0.2s;
                        {{ $selectedCounter === $counter->id
                            ? 'border:2px solid #16a34a;background:#f0fdf4;color:#15803d;'
                            : 'border:2px solid #e5e7eb;background:white;color:#4b5563;' }}"
                >
                    {{ $counter->name }}
                </button>
            @endforeach
        </div>
    </div>

    {{-- Main Content --}}
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px">

        {{-- Antrean Menunggu --}}
        <div style="background:white;border:1px solid #e5e7eb;border-radius:12px;padding:20px">
            <h2 style="font-size:18px;font-weight:700;color:#1f2937;margin:0 0 16px 0">Antrean Menunggu</h2>

            @forelse($this->waitingQueues as $queue)
                <div style="margin-bottom:16px;background:#f9fafb;border:1px solid #f3f4f6;border-radius:12px;padding:16px">
                    <div style="display:flex;align-items:center;gap:8px;margin-bottom:4px">
                        <span style="font-size:20px;font-weight:700;color:#15803d">{{ $queue->ticket_number }}</span>
                        <span style="font-size:12px;background:#fef9c3;color:#a16207;padding:2px 8px;border-radius:999px;font-weight:500">Menunggu</span>
                    </div>
                    <p style="font-weight:500;color:#1f2937;margin:0 0 2px 0">{{ $queue->customer_name ?? 'Nasabah Umum' }}</p>
                    <p style="font-size:14px;color:#6b7280;margin:0 0 12px 0">{{ $queue->serviceCategory?->name }}</p>
                    <button
                        wire:click="panggilAntrean({{ $queue->id }})"
                        style="width:100%;background:#16a34a;color:white;font-weight:600;padding:10px;border-radius:12px;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px"
                        onmouseover="this.style.background='#15803d'" onmouseout="this.style.background='#16a34a'"
                    >
                        <x-heroicon-o-phone style="width:16px;height:16px;stroke:white" />
                        Panggil ke Loket {{ $selectedCounter }}
                    </button>
                </div>
            @empty
                <div style="text-align:center;padding:40px 0;color:#9ca3af">
                    <x-heroicon-o-check-circle style="width:48px;height:48px;stroke:#d1fae5;margin:0 auto 8px" />
                    <p style="margin:0">Tidak ada antrean menunggu</p>
                </div>
            @endforelse
        </div>

        {{-- Sedang Dilayani --}}
        <div style="background:white;border:1px solid #e5e7eb;border-radius:12px;padding:20px">
            <h2 style="font-size:18px;font-weight:700;color:#1f2937;margin:0 0 16px 0">Sedang Dilayani</h2>

            @forelse($this->calledQueues as $queue)
                <div style="margin-bottom:16px;background:#fff7ed;border:1px solid #fed7aa;border-radius:12px;padding:16px">
                    <div style="display:flex;align-items:center;gap:8px;margin-bottom:4px">
                        <span style="font-size:20px;font-weight:700;color:#ea580c">{{ $queue->ticket_number }}</span>
                        <span style="font-size:12px;background:#ffedd5;color:#c2410c;padding:2px 8px;border-radius:999px;font-weight:500">
                            Dipanggil - {{ $queue->counter?->name ?? 'Loket '.$selectedCounter }}
                        </span>
                    </div>
                    <p style="font-weight:500;color:#1f2937;margin:0 0 2px 0">{{ $queue->customer_name ?? 'Nasabah Umum' }}</p>
                    <p style="font-size:14px;color:#6b7280;margin:0 0 12px 0">{{ $queue->serviceCategory?->name }}</p>

                    <div style="display:flex;gap:8px">
                        <button
                            wire:click="ulangi({{ $queue->id }})"
                            style="flex:1;background:#3b82f6;color:white;font-weight:600;padding:8px;border-radius:12px;border:none;cursor:pointer;font-size:14px;display:flex;align-items:center;justify-content:center;gap:6px"
                            onmouseover="this.style.background='#2563eb'" onmouseout="this.style.background='#3b82f6'"
                        >
                            <x-heroicon-o-arrow-path style="width:16px;height:16px;stroke:white" />
                            Ulangi
                        </button>
                        <button
                            wire:click="selesai({{ $queue->id }})"
                            style="flex:1;background:#22c55e;color:white;font-weight:600;padding:8px;border-radius:12px;border:none;cursor:pointer;font-size:14px;display:flex;align-items:center;justify-content:center;gap:6px"
                            onmouseover="this.style.background='#16a34a'" onmouseout="this.style.background='#22c55e'"
                        >
                            <x-heroicon-o-check-circle style="width:16px;height:16px;stroke:white" />
                            Selesai
                        </button>
                        <button
                            wire:click="lewati({{ $queue->id }})"
                            style="flex:1;background:#4b5563;color:white;font-weight:600;padding:8px;border-radius:12px;border:none;cursor:pointer;font-size:14px;display:flex;align-items:center;justify-content:center;gap:6px"
                            onmouseover="this.style.background='#374151'" onmouseout="this.style.background='#4b5563'"
                        >
                            <x-heroicon-o-forward style="width:16px;height:16px;stroke:white" />
                            Lewati
                        </button>
                    </div>
                </div>
            @empty
                <div style="text-align:center;padding:40px 0;color:#9ca3af">
                    <x-heroicon-o-phone style="width:48px;height:48px;stroke:#e5e7eb;margin:0 auto 8px" />
                    <p style="margin:0">Belum ada antrean dipanggil</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Text to Speech --}}
    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('queue-called', ({ ticketNumber, counterName }) => {
                const text = `Nomor antrean ${ticketNumber.split('').join(' ')}, silakan menuju ${counterName}`;
                const utterance = new SpeechSynthesisUtterance(text);
                utterance.lang = 'id-ID';
                utterance.rate = 0.9;
                utterance.volume = 1;
                window.speechSynthesis.speak(utterance);
            });
        });
    </script>
</x-filament-panels::page>