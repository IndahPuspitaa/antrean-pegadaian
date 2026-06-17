<style>
    /* 1. Sembunyikan logo bawaan Filament */
    .fi-sidebar-header .fi-logo,
    .fi-topbar .fi-logo {
        display: none !important;
    }

    /* 2. INI KUNCINYA: Paksa kotak luar (parent) milik Filament jadi hijau gradasi */
    .fi-sidebar-header, 
    .fi-topbar-start {
        background: linear-gradient(180deg, rgba(0, 130, 54, 1) 0%, rgba(1, 102, 48, 1) 100%) !important;
        margin: 0 !important;
        /* Hapus border bawah jika ada */
        border-bottom: none !important; 
    }

    /* 3. Pengaturan wadah logo kamu */
    .custom-logo-container {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1.25rem 1rem;
        width: 100%;
        background-color: transparent;
    }

    /* 4. Paksa teks judul jadi PUTIH */
    .custom-logo-text h1 {
        font-size: 0.95rem;
        font-weight: 700;
        color: #ffffff !important; 
        margin: 0;
        line-height: 1.2;
    }

    /* 5. Paksa teks Admin Panel jadi HIJAU MUDA */
    .custom-logo-text span {
        font-size: 0.72rem;
        color: #d1fae5 !important; 
        margin: 0;
        line-height: 1.2;
    }

    /* 6. Responsif untuk HP */
    @media (max-width: 768px) {
        .custom-logo-container {
            padding: 0.8rem 1rem;
        }
    }
</style>

<div class="custom-logo-container">
    <img src="{{ asset('images/logo-pegadaian.png') }}" alt="Logo" style="height: 35px; width: auto; flex-shrink: 0;">
    <div class="custom-logo-text" style="display: flex; flex-direction: column;">
        <h1>Sistem Antrean</h1>
        <span>Admin Panel</span>
    </div>
</div>