<div style="padding: 1.25rem 1.5rem; border-top: 1px solid rgba(255, 255, 255, 0.15); margin-top: auto;">
    <form method="POST" action="{{ filament()->getLogoutUrl() }}">
        @csrf
        <button type="submit" style="display: flex; align-items: center; gap: 1rem; color: #ffffff; background: none; border: none; cursor: pointer; width: 100%; font-family: inherit; font-size: 0.95rem; font-weight: 500;">
            <x-heroicon-o-arrow-right-start-on-rectangle style="width: 1.5rem; height: 1.5rem;" />
            <span>Keluar</span>
        </button>
    </form>
</div>
