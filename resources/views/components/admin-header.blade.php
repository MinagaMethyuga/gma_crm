<header class="h-16 md:h-20 border-b border-slate-200 flex items-center justify-between px-4 md:px-8 bg-white shrink-0 w-full z-40 relative">
    
    <div class="flex items-center gap-2 md:hidden">
        <button id="admin-mobile-menu-btn" class="text-slate-500 hover:text-slate-800 focus:outline-none p-2 -ml-2 rounded-lg">
            <span class="material-symbols-outlined text-2xl">menu</span>
        </button>
        <img src="/Global_Mobile_Association_Logo__1_-removebg-preview.png" alt="GMA Logo" class="h-8 w-auto object-contain">
    </div>

    <div class="flex items-center gap-2 md:gap-4 h-full ml-auto">
        <button class="text-slate-400 hover:text-slate-600 transition-colors">
            <span class="material-symbols-outlined">notifications</span>
        </button>
        
        @if(isset($showCreateEvent) && $showCreateEvent)
        <button onclick="window.showCreateForm ? showCreateForm() : null" class="bg-indigo-100/50 hover:bg-indigo-100 text-[#4338ca] text-xs md:text-sm font-semibold px-3 md:px-4 py-1.5 md:py-2 rounded-lg transition-colors ml-1 md:ml-2 tracking-wide hidden sm:block border border-indigo-200/50">
            Create Event
        </button>
        @endif
        <div class="w-8 h-8 rounded-full bg-slate-200 overflow-hidden shadow-sm ml-2 shrink-0 border border-slate-200">
            @auth
            <img src="{{ auth()->user()->avatarUrl() }}" alt="User" class="w-full h-full object-cover">
            @else
            <span class="material-symbols-outlined text-slate-400 p-0.5 text-xl">person</span>
            @endauth
        </div>
    </div>
</header>