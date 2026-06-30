<aside class="w-64 bg-[#f8f9fc] border-r border-slate-200 flex flex-col flex-shrink-0">
    <div class="pt-6 pb-6 px-6 flex flex-col gap-1.5 border-b border-slate-200/50 mb-4">
        <a href="{{ route('home') }}" class="block">
            <img src="/Global_Mobile_Association_Logo__1_-removebg-preview.png" alt="GMA Logo" class="h-14 w-auto object-contain object-left">
        </a>
        <p class="text-[11px] font-bold text-slate-600 tracking-wide pl-1 mt-1">Member Portal</p>
    </div>

    <nav class="flex-1 px-3 space-y-1.5 overflow-y-auto">
        @if (!isset($active) || $active === 'home')
            <div class="relative">
                <div class="absolute left-0 top-0 bottom-0 w-[3px] bg-[#3525cd] rounded-r-md"></div>
                <a href="{{ route('member.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 text-[#3525cd] bg-indigo-50/50 rounded-lg transition-colors ml-1">
                    <span class="material-symbols-outlined text-[22px]">home</span>
                    <span class="text-[13px] font-bold">Home</span>
                </a>
            </div>
        @else
            <a href="{{ route('member.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 text-slate-600 hover:bg-slate-100 rounded-lg transition-colors ml-1">
                <span class="material-symbols-outlined text-[22px]">home</span>
                <span class="text-[13px] font-semibold">Home</span>
            </a>
        @endif

        @if (isset($active) && $active === 'events')
            <div class="relative">
                <div class="absolute left-0 top-0 bottom-0 w-[3px] bg-[#3525cd] rounded-r-md"></div>
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-[#3525cd] bg-indigo-50/50 rounded-lg transition-colors ml-1">
                    <span class="material-symbols-outlined text-[22px]">event</span>
                    <span class="text-[13px] font-bold">Events</span>
                </a>
            </div>
        @else
            <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-slate-600 hover:bg-slate-100 rounded-lg transition-colors ml-1">
                <span class="material-symbols-outlined text-[22px]">event</span>
                <span class="text-[13px] font-semibold">Events</span>
            </a>
        @endif

        @if (isset($active) && $active === 'payments')
            <div class="relative">
                <div class="absolute left-0 top-0 bottom-0 w-[3px] bg-[#3525cd] rounded-r-md"></div>
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-[#3525cd] bg-indigo-50/50 rounded-lg transition-colors ml-1">
                    <span class="material-symbols-outlined text-[22px]">payments</span>
                    <span class="text-[13px] font-bold">Payments</span>
                </a>
            </div>
        @else
            <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-slate-600 hover:bg-slate-100 rounded-lg transition-colors ml-1">
                <span class="material-symbols-outlined text-[22px]">payments</span>
                <span class="text-[13px] font-semibold">Payments</span>
            </a>
        @endif

        @if (isset($active) && $active === 'manage-team')
            <div class="relative">
                <div class="absolute left-0 top-0 bottom-0 w-[3px] bg-[#3525cd] rounded-r-md"></div>
                <a href="{{ route('teams.index') }}" class="flex items-center gap-3 px-3 py-2.5 text-[#3525cd] bg-indigo-50/50 rounded-lg transition-colors ml-1">
                    <span class="material-symbols-outlined text-[22px]">group</span>
                    <span class="text-[13px] font-bold">Manage Team</span>
                </a>
            </div>
        @else
            <a href="{{ route('teams.index') }}" class="flex items-center gap-3 px-3 py-2.5 text-slate-600 hover:bg-slate-100 rounded-lg transition-colors ml-1">
                <span class="material-symbols-outlined text-[22px]">group</span>
                <span class="text-[13px] font-semibold">Manage Team</span>
            </a>
        @endif
    </nav>

    <div class="p-4 border-t border-slate-200">

        <form method="POST" action="{{ route('logout') }}" class="mt-1 ml-1">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 px-3 py-2 text-slate-600 hover:bg-slate-100 rounded-lg transition-colors">
                <span class="material-symbols-outlined text-[22px]">logout</span>
                <span class="text-[13px] font-semibold">Sign Out</span>
            </button>
        </form>
    </div>
</aside>
