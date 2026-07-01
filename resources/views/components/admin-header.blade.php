<header class="h-20 border-b border-slate-200 flex items-center justify-between px-8 bg-white shrink-0">



    
    <div class="flex items-center gap-4 h-full ml-auto">
        <button class="text-slate-400 hover:text-slate-600 transition-colors">
            <span class="material-symbols-outlined">notifications</span>
        </button>
        
        <button class="bg-indigo-100/50 hover:bg-indigo-100 text-[#4338ca] text-sm font-semibold px-4 py-2 rounded-lg transition-colors ml-2 tracking-wide hidden md:block border border-indigo-200/50">
            Create Event
        </button>
        <div class="w-8 h-8 rounded-full bg-slate-200 overflow-hidden shadow-sm ml-2 shrink-0 border border-slate-200">
            <img src="{{ auth()->user()->avatarUrl() }}" alt="User" class="w-full h-full object-cover">
        </div>
    </div>
</header>