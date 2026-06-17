<style>
    .fi-sidebar-header .fi-logo {
        display: none !important;
    }

    .custom-logo-container {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1.25rem 1rem;
        width: 100%;
        background-color: transparent;
    }

    .custom-logo-text h1 {
        font-size: 0.95rem;
        font-weight: 700;
        color: #ffffff;
        margin: 0;
        line-height: 1.2;
    }

    .custom-logo-text span {
        font-size: 0.72rem;
        color: #d1fae5 ; 
        margin: 0;
        line-height: 1.2;
    }

    @media (max-width: 768px) {
        .custom-logo-container {
            padding: 0.8rem 0;
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