<!-- Spacer to keep the main content from jumping -->
<div class="w-[88px] shrink-0 hidden md:block"></div>

<!-- The actual sidebar -->
<aside class="fixed top-0 left-0 h-screen group w-[88px] hover:w-64 bg-[#fbfcfd] border-r border-slate-200/60 flex flex-col transition-all duration-300 ease-in-out z-50 overflow-hidden">
    <!-- Branding -->
    <div class="h-24 flex items-center justify-center group-hover:justify-start group-hover:px-8 transition-all duration-300 shrink-0">
        <a href="{{ route('home') }}" class="block shrink-0">
            <!-- Show just the left part of the logo when collapsed, full when expanded -->
            <div class="w-10 group-hover:w-[120px] h-10 overflow-hidden transition-all duration-300 flex items-center">
                <img src="/Global_Mobile_Association_Logo__1_-removebg-preview.png" alt="GMA Logo" class="h-10 w-auto max-w-none object-contain object-left shrink-0">
            </div>
        </a>
    </div>

    <!-- Nav Links -->
    <nav class="flex-1 px-4 space-y-2 overflow-y-auto mt-2 custom-scroll">
        @if (!isset($active) || $active === 'dashboard')
            <a href="{{ route('dashboard') }}" class="flex items-center h-12 px-0 group-hover:px-4 rounded-full group-hover:rounded-2xl transition-all duration-300 w-12 group-hover:w-full mx-auto group-hover:mx-0 bg-white group-hover:bg-[#1a1a1a] text-slate-900 group-hover:text-white shadow-sm">
                <div class="w-12 h-12 flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-[22px]">grid_view</span>
                </div>
                <span class="text-[14px] font-medium tracking-wide whitespace-nowrap overflow-hidden transition-all duration-300 opacity-0 w-0 group-hover:opacity-100 group-hover:w-auto">Dashboard</span>
            </a>
        @else
            <a href="{{ route('dashboard') }}" class="flex items-center h-12 px-0 group-hover:px-4 rounded-2xl text-slate-500 hover:text-slate-900 hover:bg-slate-100/60 transition-all duration-300 w-12 group-hover:w-full mx-auto group-hover:mx-0">
                <div class="w-12 h-12 flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-[22px]">grid_view</span>
                </div>
                <span class="text-[14px] font-medium tracking-wide whitespace-nowrap overflow-hidden transition-all duration-300 opacity-0 w-0 group-hover:opacity-100 group-hover:w-auto">Dashboard</span>
            </a>
        @endif

        @if (isset($active) && $active === 'members')
            <a href="{{ route('members') }}" class="flex items-center h-12 px-0 group-hover:px-4 rounded-full group-hover:rounded-2xl transition-all duration-300 w-12 group-hover:w-full mx-auto group-hover:mx-0 bg-white group-hover:bg-[#1a1a1a] text-slate-900 group-hover:text-white shadow-sm">
                <div class="w-12 h-12 flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-[22px]">group</span>
                </div>
                <span class="text-[14px] font-medium tracking-wide whitespace-nowrap overflow-hidden transition-all duration-300 opacity-0 w-0 group-hover:opacity-100 group-hover:w-auto">Members</span>
            </a>
        @else
            <a href="{{ route('members') }}" class="flex items-center h-12 px-0 group-hover:px-4 rounded-2xl text-slate-500 hover:text-slate-900 hover:bg-slate-100/60 transition-all duration-300 w-12 group-hover:w-full mx-auto group-hover:mx-0">
                <div class="w-12 h-12 flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-[22px]">group</span>
                </div>
                <span class="text-[14px] font-medium tracking-wide whitespace-nowrap overflow-hidden transition-all duration-300 opacity-0 w-0 group-hover:opacity-100 group-hover:w-auto">Members</span>
            </a>
        @endif

        @if (isset($active) && $active === 'events')
<<<<<<< Updated upstream
            <a href="{{ route('admin.events') }}" class="flex items-center h-12 px-0 group-hover:px-4 rounded-full group-hover:rounded-2xl transition-all duration-300 w-12 group-hover:w-full mx-auto group-hover:mx-0 bg-white group-hover:bg-[#1a1a1a] text-slate-900 group-hover:text-white shadow-sm">
=======
            <a href="{{ route('admin.events.index') }}" class="flex items-center h-12 px-0 group-hover:px-4 rounded-full group-hover:rounded-2xl transition-all duration-300 w-12 group-hover:w-full mx-auto group-hover:mx-0 bg-white group-hover:bg-[#1a1a1a] text-slate-900 group-hover:text-white shadow-sm">
>>>>>>> Stashed changes
                <div class="w-12 h-12 flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-[22px]">calendar_month</span>
                </div>
                <span class="text-[14px] font-medium tracking-wide whitespace-nowrap overflow-hidden transition-all duration-300 opacity-0 w-0 group-hover:opacity-100 group-hover:w-auto">Events</span>
            </a>
        @else
<<<<<<< Updated upstream
            <a href="{{ route('admin.events') }}" class="flex items-center h-12 px-0 group-hover:px-4 rounded-2xl text-slate-500 hover:text-slate-900 hover:bg-slate-100/60 transition-all duration-300 w-12 group-hover:w-full mx-auto group-hover:mx-0">
=======
            <a href="{{ route('admin.events.index') }}" class="flex items-center h-12 px-0 group-hover:px-4 rounded-2xl text-slate-500 hover:text-slate-900 hover:bg-slate-100/60 transition-all duration-300 w-12 group-hover:w-full mx-auto group-hover:mx-0">
>>>>>>> Stashed changes
                <div class="w-12 h-12 flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-[22px]">calendar_month</span>
                </div>
                <span class="text-[14px] font-medium tracking-wide whitespace-nowrap overflow-hidden transition-all duration-300 opacity-0 w-0 group-hover:opacity-100 group-hover:w-auto">Events</span>
            </a>
        @endif

        @if (isset($active) && $active === 'reports')
            <div class="flex flex-col gap-1 w-12 group-hover:w-full mx-auto group-hover:mx-0 transition-all duration-300">
                <a href="#" class="flex items-center h-12 px-0 group-hover:px-4 rounded-full group-hover:rounded-2xl transition-all duration-300 bg-white group-hover:bg-[#1a1a1a] text-slate-900 group-hover:text-white shadow-sm justify-between">
                    <div class="flex items-center">
                        <div class="w-12 h-12 flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-[22px]">summarize</span>
                        </div>
                        <span class="text-[14px] font-medium tracking-wide whitespace-nowrap overflow-hidden transition-all duration-300 opacity-0 w-0 group-hover:opacity-100 group-hover:w-auto">Reports</span>
                    </div>
                    <span class="material-symbols-outlined text-[18px] opacity-0 group-hover:opacity-100 transition-opacity duration-300 hidden group-hover:block">remove</span>
                </a>
                <!-- Submenu only visible when expanded -->
                <div class="pl-12 pr-4 py-2 space-y-3 relative overflow-hidden transition-all duration-300 opacity-0 max-h-0 group-hover:opacity-100 group-hover:max-h-40 hidden group-hover:block">
                    <div class="absolute left-7 top-0 bottom-4 w-px bg-slate-200"></div>
                    <a href="#" class="flex items-center gap-3 text-slate-600 hover:text-slate-900 relative">
                        <div class="absolute -left-[21px] top-1/2 -translate-y-1/2 w-[5px] h-[5px] rounded-full bg-slate-400"></div>
                        <span class="material-symbols-outlined text-[18px]">trending_up</span>
                        <span class="text-[13px] font-medium tracking-wide whitespace-nowrap">Market Report</span>
                    </a>
                    <a href="#" class="flex items-center gap-3 text-slate-600 hover:text-slate-900 relative">
                        <span class="material-symbols-outlined text-[18px]">domain</span>
                        <span class="text-[13px] font-medium tracking-wide whitespace-nowrap">Stock Reports</span>
                    </a>
                </div>
            </div>
        @else
            <a href="#" class="flex items-center h-12 px-0 group-hover:px-4 rounded-2xl text-slate-500 hover:text-slate-900 hover:bg-slate-100/60 transition-all duration-300 w-12 group-hover:w-full mx-auto group-hover:mx-0">
                <div class="w-12 h-12 flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-[22px]">summarize</span>
                </div>
                <span class="text-[14px] font-medium tracking-wide whitespace-nowrap overflow-hidden transition-all duration-300 opacity-0 w-0 group-hover:opacity-100 group-hover:w-auto">Reports</span>
            </a>
        @endif
        
        <a onclick="openSettingsModal()" class="cursor-pointer flex items-center h-12 px-0 group-hover:px-4 rounded-2xl text-slate-500 hover:text-slate-900 hover:bg-slate-100/60 transition-all duration-300 w-12 group-hover:w-full mx-auto group-hover:mx-0 mt-2">
            <div class="w-12 h-12 flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-[22px]">settings</span>
            </div>
            <span class="text-[14px] font-medium tracking-wide whitespace-nowrap overflow-hidden transition-all duration-300 opacity-0 w-0 group-hover:opacity-100 group-hover:w-auto">Settings</span>
        </a>
    </nav>

    <!-- Bottom Links -->
    <div class="p-4 mt-auto border-t border-transparent group-hover:border-slate-200/50 transition-colors duration-300">
        <form method="POST" action="{{ route('logout') }}" class="flex justify-center group-hover:block w-full">
            @csrf
            <button type="submit" class="flex items-center h-12 px-0 group-hover:px-4 rounded-2xl text-slate-500 hover:text-slate-900 hover:bg-slate-100/60 transition-all duration-300 w-12 group-hover:w-full mx-auto group-hover:mx-0">
                <div class="w-12 h-12 flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-[22px]">logout</span>
                </div>
                <span class="text-[14px] font-medium tracking-wide whitespace-nowrap overflow-hidden transition-all duration-300 opacity-0 w-0 group-hover:opacity-100 group-hover:w-auto">Sign Out</span>
            </button>
        </form>
    </div>
</aside>
