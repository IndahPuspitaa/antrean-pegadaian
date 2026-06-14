<div style="margin-top: auto; padding: 1rem 1.5rem; border-top: 1px solid rgba(255, 255, 255, 0.2);">
    <form method="POST" action="{{ filament()->getLogoutUrl() }}">
        @csrf
        <button type="submit" style="
            display: flex; 
            align-items: center; 
            justify-content: flex-start; 
            gap: 1rem; 
            color: #ffffff; 
            background: none; 
            border: none; 
            cursor: pointer; 
            width: 100%; 
            padding: 0.5rem 0; 
            font-family: inherit; 
            font-size: 0.95rem; 
            font-weight: 500;
        ">
            <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
            </svg>
            <span>Keluar</span>
        </button>
    </form>
</div>