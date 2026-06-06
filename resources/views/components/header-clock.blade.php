<div 
    x-data="{
        waktu: '',
        tanggal: '',
        updateWaktu() {
            const sekarang = new Date();
            this.waktu = sekarang.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
            this.tanggal = sekarang.toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });
        }
    }"
    x-init="updateWaktu(); setInterval(() => updateWaktu(), 1000)"
    class="hidden md:flex items-center"
    style="gap: 0.5rem; border-right: 1px solid #e5e7eb; padding-right: 1.25rem; margin-right: 0.25rem;"
>
     <x-heroicon-o-clock style="width: 20px; height: 20px; stroke: #6b7280;" />

    <span x-text="tanggal" style="font-size: 0.875rem; font-weight: 500; color: #4b5563;"></span>

    <span style="color: #d1d5db; margin: 0 0.25rem;">|</span>

    <span x-text="waktu" style="font-size: 0.875rem; font-weight: 700; color: #374151;"></span>
</div>