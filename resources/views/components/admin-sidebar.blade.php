<aside class="w-64 bg-[#f8f9fc] border-r border-slate-200 flex flex-col flex-shrink-0">
    <!-- Branding -->
    <div class="pt-8 pb-4 px-6 flex flex-col gap-2">
        <a href="{{ route('home') }}" class="block">
            <img src="/Global_Mobile_Association_Logo__1_-removebg-preview.png" alt="GMA Logo" class="h-14 w-auto object-contain object-left">
        </a>
        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-[0.15em] pl-1">Admin Console</p>
    </div>

    <div class="mx-5 mb-5 h-px bg-slate-200/70"></div>

    <!-- Nav Links -->
    <nav class="flex-1 px-4 space-y-1 overflow-y-auto">
        @if (!isset($active) || $active === 'dashboard')
            <div class="relative">
                <div class="absolute left-0 top-1 bottom-1 w-1 bg-[#4338ca] rounded-r-md"></div>
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3.5 px-3.5 py-2.5 text-[#4338ca] bg-indigo-50/70 rounded-lg transition-colors ml-1">
                    <span class="material-symbols-outlined text-xl fill">grid_view</span>
                    <span class="text-[13px] font-bold">Dashboard</span>
                </a>
            </div>
        @else
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3.5 px-3.5 py-2.5 text-slate-500 hover:text-slate-700 hover:bg-slate-100/80 rounded-lg transition-colors">
                <span class="material-symbols-outlined text-xl">grid_view</span>
                <span class="text-[13px] font-semibold">Dashboard</span>
            </a>
        @endif

        @if (isset($active) && $active === 'members')
            <div class="relative">
                <div class="absolute left-0 top-1 bottom-1 w-1 bg-[#4338ca] rounded-r-md"></div>
                <a href="{{ route('members') }}" class="flex items-center gap-3.5 px-3.5 py-2.5 text-[#4338ca] bg-indigo-50/70 rounded-lg transition-colors ml-1">
                    <span class="material-symbols-outlined text-xl fill">group</span>
                    <span class="text-[13px] font-bold">Members</span>
                </a>
            </div>
        @else
            <a href="{{ route('members') }}" class="flex items-center gap-3.5 px-3.5 py-2.5 text-slate-500 hover:text-slate-700 hover:bg-slate-100/80 rounded-lg transition-colors">
                <span class="material-symbols-outlined text-xl">group</span>
                <span class="text-[13px] font-semibold">Members</span>
            </a>
        @endif

        @if (isset($active) && $active === 'events')
            <div class="relative">
                <div class="absolute left-0 top-1 bottom-1 w-1 bg-[#4338ca] rounded-r-md"></div>
                <a href="{{ route('events') }}" class="flex items-center gap-3.5 px-3.5 py-2.5 text-[#4338ca] bg-indigo-50/70 rounded-lg transition-colors ml-1">
                    <span class="material-symbols-outlined text-xl fill">calendar_month</span>
                    <span class="text-[13px] font-bold">Events</span>
                </a>
            </div>
        @else
            <a href="{{ route('events') }}" class="flex items-center gap-3.5 px-3.5 py-2.5 text-slate-500 hover:text-slate-700 hover:bg-slate-100/80 rounded-lg transition-colors">
                <span class="material-symbols-outlined text-xl">calendar_month</span>
                <span class="text-[13px] font-semibold">Events</span>
            </a>
        @endif
    </nav>

    <!-- Bottom Links -->
    <div class="p-5 border-t border-slate-200/70">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3.5 px-3.5 py-2.5 text-red-500 hover:text-red-700 hover:bg-red-50/80 rounded-lg transition-colors">
                <span class="material-symbols-outlined text-xl">logout</span>
                <span class="text-[13px] font-semibold">Sign Out</span>
            </button>
        </form>
    </div>
</aside>
