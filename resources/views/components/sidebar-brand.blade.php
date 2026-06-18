<style>
    /* 1. Matikan elemen logo kosong bawaan Filament agar tidak menumpuk */
    .fi-logo { display: none !important; }

    /* 2. KUNCI UTAMA: Warnai area Topbar Start secara paksa agar menyatu dengan Sidebar */
    .fi-topbar-start {
        background-color: #008236 !important; /* Hijau solid, sama persis dengan atas gradasi */
        
        /* Trik untuk membanjiri sisa padding putih di pojok layar */
        margin-top: -2rem !important;
        margin-bottom: -2rem !important;
        margin-left: -2rem !important;
        padding-top: 2rem !important;
        padding-bottom: 2rem !important;
        padding-left: 2rem !important;
        
        /* Lebar disesuaikan agar lurus/sejajar dengan sidebar */
        width: 256px !important; 
        display: flex;
        align-items: center;
    }

    /* 3. Pengaturan Teks (Paksa putih & hijau muda di Desktop) */
    .custom-logo-text h1 {
        font-size: 0.95rem !important;
        font-weight: 700 !important;
        color: #ffffff !important; 
        margin: 0 !important;
        line-height: 1.2 !important;
    }

    .custom-logo-text span {
        font-size: 0.72rem !important;
        color: #d1fae5 !important; 
        margin: 0 !important;
        line-height: 1.2 !important;
    }

    .custom-logo-container {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    /* 4. Pengaturan HP (Kembalikan ke warna asli agar tidak berantakan di layar kecil) */
    @media (max-width: 1024px) {
        .fi-topbar-start {
            background-color: transparent !important;
            margin: 0 !important;
            padding: 0 !important;
            width: auto !important;
        }
        .custom-logo-text h1 { color: #008236 !important; }
        .custom-logo-text span { color: #16a34a !important; }
    }
</style>

<div class="custom-logo-container">
    <img src="{{ asset('images/logo-pegadaian.png') }}" alt="Logo" style="height: 35px; width: auto; flex-shrink: 0;">
    <div class="custom-logo-text">
        <h1>Sistem Antrean</h1>
        <span>Admin Panel</span>
    </div>
</div>