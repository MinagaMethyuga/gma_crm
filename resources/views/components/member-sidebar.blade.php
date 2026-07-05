<!-- Spacer to keep the main content from jumping -->
<div class="w-[88px] shrink-0 hidden md:block"></div>

<!-- The actual sidebar -->
<aside id="member-sidebar" class="fixed top-0 left-0 h-screen group w-64 md:w-[88px] hover:w-64 -translate-x-full md:translate-x-0 bg-[#fbfcfd] border-r border-slate-200/60 flex flex-col transition-all duration-300 ease-in-out z-50 overflow-hidden shadow-2xl md:shadow-none sidebar-open:translate-x-0">
    <div class="h-16 md:h-24 flex items-center justify-between md:justify-center group-hover:justify-start px-4 md:px-0 group-hover:px-8 transition-all duration-300 shrink-0">
        <a href="{{ route('home') }}" class="block shrink-0">
            <div class="w-[120px] md:w-10 group-hover:w-[120px] h-10 overflow-hidden transition-all duration-300 flex items-center">
                <img src="/Global_Mobile_Association_Logo__1_-removebg-preview.png" alt="GMA Logo" class="h-8 md:h-10 w-auto max-w-none object-contain object-left shrink-0">
            </div>
        </a>
        <!-- Close button for mobile -->
        <button id="close-member-sidebar" class="md:hidden text-slate-400 hover:text-slate-800 focus:outline-none">
            <span class="material-symbols-outlined text-2xl">close</span>
        </button>
    </div>

    <nav class="flex-1 px-4 space-y-2 overflow-y-auto mt-2 custom-scroll">
        @if (!isset($active) || $active === 'home')
            <a href="{{ route('member.dashboard') }}" class="flex items-center h-12 px-0 group-hover:px-4 rounded-full group-hover:rounded-2xl transition-all duration-300 w-12 group-hover:w-full mx-auto group-hover:mx-0 bg-white group-hover:bg-[#1a1a1a] text-slate-900 group-hover:text-white shadow-sm">
                <div class="w-12 h-12 flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-[22px]">home</span>
                </div>
                <span class="text-[14px] font-medium tracking-wide whitespace-nowrap overflow-hidden transition-all duration-300 opacity-0 w-0 group-hover:opacity-100 group-hover:w-auto">Home</span>
            </a>
        @else
            <a href="{{ route('member.dashboard') }}" class="flex items-center h-12 px-0 group-hover:px-4 rounded-2xl text-slate-500 hover:text-slate-900 hover:bg-slate-100/60 transition-all duration-300 w-12 group-hover:w-full mx-auto group-hover:mx-0">
                <div class="w-12 h-12 flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-[22px]">home</span>
                </div>
                <span class="text-[14px] font-medium tracking-wide whitespace-nowrap overflow-hidden transition-all duration-300 opacity-0 w-0 group-hover:opacity-100 group-hover:w-auto">Home</span>
            </a>
        @endif

        @if (isset($active) && $active === 'events')
            <a href="{{ route('member.events') }}" class="flex items-center h-12 px-0 group-hover:px-4 rounded-full group-hover:rounded-2xl transition-all duration-300 w-12 group-hover:w-full mx-auto group-hover:mx-0 bg-white group-hover:bg-[#1a1a1a] text-slate-900 group-hover:text-white shadow-sm">
                <div class="w-12 h-12 flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-[22px]">event</span>
                </div>
                <span class="text-[14px] font-medium tracking-wide whitespace-nowrap overflow-hidden transition-all duration-300 opacity-0 w-0 group-hover:opacity-100 group-hover:w-auto">Events</span>
            </a>
        @else
            <a href="{{ route('member.events') }}" class="flex items-center h-12 px-0 group-hover:px-4 rounded-2xl text-slate-500 hover:text-slate-900 hover:bg-slate-100/60 transition-all duration-300 w-12 group-hover:w-full mx-auto group-hover:mx-0">
                <div class="w-12 h-12 flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-[22px]">event</span>
                </div>
                <span class="text-[14px] font-medium tracking-wide whitespace-nowrap overflow-hidden transition-all duration-300 opacity-0 w-0 group-hover:opacity-100 group-hover:w-auto">Events</span>
            </a>
        @endif

        @php
            $userPlanSlug = auth()->user()?->plan?->slug;
            $userPlanName = strtolower(auth()->user()?->plan?->name ?? '');
            $isProfessional = $userPlanSlug === 'professional' || str_contains($userPlanName, 'professional');
        @endphp

        @if (!$isProfessional)
            @if (isset($active) && $active === 'manage-team')
                <a href="{{ route('teams.index') }}" class="flex items-center h-12 px-0 group-hover:px-4 rounded-full group-hover:rounded-2xl transition-all duration-300 w-12 group-hover:w-full mx-auto group-hover:mx-0 bg-white group-hover:bg-[#1a1a1a] text-slate-900 group-hover:text-white shadow-sm">
                    <div class="w-12 h-12 flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-[22px]">group</span>
                    </div>
                    <span class="text-[14px] font-medium tracking-wide whitespace-nowrap overflow-hidden transition-all duration-300 opacity-0 w-0 group-hover:opacity-100 group-hover:w-auto">Manage Team</span>
                </a>
            @else
                <a href="{{ route('teams.index') }}" class="flex items-center h-12 px-0 group-hover:px-4 rounded-2xl text-slate-500 hover:text-slate-900 hover:bg-slate-100/60 transition-all duration-300 w-12 group-hover:w-full mx-auto group-hover:mx-0">
                    <div class="w-12 h-12 flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-[22px]">group</span>
                    </div>
                    <span class="text-[14px] font-medium tracking-wide whitespace-nowrap overflow-hidden transition-all duration-300 opacity-0 w-0 group-hover:opacity-100 group-hover:w-auto">Manage Team</span>
                </a>
            @endif
        @endif
        
        @if (isset($active) && $active === 'documents')
            <a href="{{ route('member.documents') }}" class="flex items-center h-12 px-0 group-hover:px-4 rounded-full group-hover:rounded-2xl transition-all duration-300 w-12 group-hover:w-full mx-auto group-hover:mx-0 bg-white group-hover:bg-[#1a1a1a] text-slate-900 group-hover:text-white shadow-sm">
                <div class="w-12 h-12 flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-[22px]">description</span>
                </div>
                <span class="text-[14px] font-medium tracking-wide whitespace-nowrap overflow-hidden transition-all duration-300 opacity-0 w-0 group-hover:opacity-100 group-hover:w-auto">Documents</span>
            </a>
        @else
            <a href="{{ route('member.documents') }}" class="flex items-center h-12 px-0 group-hover:px-4 rounded-2xl text-slate-500 hover:text-slate-900 hover:bg-slate-100/60 transition-all duration-300 w-12 group-hover:w-full mx-auto group-hover:mx-0">
                <div class="w-12 h-12 flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-[22px]">description</span>
                </div>
                <span class="text-[14px] font-medium tracking-wide whitespace-nowrap overflow-hidden transition-all duration-300 opacity-0 w-0 group-hover:opacity-100 group-hover:w-auto">Documents</span>
            </a>
        @endif

        <a onclick="openSettingsModal()" class="cursor-pointer flex items-center h-12 px-0 group-hover:px-4 rounded-2xl text-slate-500 hover:text-slate-900 hover:bg-slate-100/60 transition-all duration-300 w-12 group-hover:w-full mx-auto group-hover:mx-0 mt-2">
            <div class="w-12 h-12 flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-[22px]">settings</span>
            </div>
            <span class="text-[14px] font-medium tracking-wide whitespace-nowrap overflow-hidden transition-all duration-300 opacity-0 w-0 group-hover:opacity-100 group-hover:w-auto">Settings</span>
        </a>
    </nav>

    <div class="p-4 mt-auto border-t border-transparent group-hover:border-slate-200/50 transition-colors duration-300">
        <form method="POST" action="{{ route('logout') }}" class="flex justify-center group-hover:block w-full">
            @csrf
            <button type="submit" class="flex items-center h-12 px-0 group-hover:px-4 rounded-2xl text-slate-500 hover:text-slate-900 hover:bg-slate-100/60 transition-all duration-300 w-12 group-hover:w-full mx-auto group-hover:mx-0 md:w-12 md:mx-auto">
                <div class="w-12 h-12 flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-[22px]">logout</span>
                </div>
                <span class="text-[14px] font-medium tracking-wide whitespace-nowrap overflow-hidden transition-all duration-300 opacity-100 md:opacity-0 w-auto md:w-0 group-hover:opacity-100 group-hover:w-auto">Sign Out</span>
            </button>
        </form>
    </div>
</aside>

<!-- Mobile Overlay -->
<div id="member-sidebar-overlay" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-40 hidden md:hidden opacity-0 transition-opacity duration-300"></div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('member-sidebar');
        const overlay = document.getElementById('member-sidebar-overlay');
        const openBtn = document.getElementById('admin-mobile-menu-btn'); // reusing the same ID from header if applicable, but if not we should ensure there's a button.
        const closeBtn = document.getElementById('close-member-sidebar');

        function toggleSidebar() {
            if (!sidebar) return;
            const isOpen = sidebar.classList.contains('translate-x-0') && !sidebar.classList.contains('md:translate-x-0');
            
            if (isOpen) {
                sidebar.classList.remove('translate-x-0');
                sidebar.classList.add('-translate-x-full');
                overlay.classList.remove('opacity-100');
                overlay.classList.add('opacity-0');
                setTimeout(() => {
                    overlay.classList.add('hidden');
                }, 300);
            } else {
                sidebar.classList.remove('-translate-x-full');
                sidebar.classList.add('translate-x-0');
                overlay.classList.remove('hidden');
                setTimeout(() => {
                    overlay.classList.remove('opacity-0');
                    overlay.classList.add('opacity-100');
                }, 10);
            }
        }

        if (openBtn) openBtn.addEventListener('click', toggleSidebar);
        if (closeBtn) closeBtn.addEventListener('click', toggleSidebar);
        if (overlay) overlay.addEventListener('click', toggleSidebar);
    });
</script>
