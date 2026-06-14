<div style="margin-top: auto; padding: 1rem;">
    <form method="POST" action="{{ filament()->getLogoutUrl() }}">
        @csrf
        <button type="submit" style="display: flex; align-items: center; gap: 0.75rem; color: #ffffff; background: none; border: none; cursor: pointer; width: 100%; padding: 0.5rem 0.75rem; border-radius: 0.5rem; transition: background 0.2s;">
            <x-heroicon-o-arrow-right-start-on-rectangle style="width: 1.25rem; height: 1.25rem;" />
            <span style="font-weight: 500; font-size: 0.875rem;">Keluar</span>
        </button>
    </form>
</div>