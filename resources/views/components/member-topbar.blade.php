<header class="h-16 border-b border-slate-200 flex items-center justify-between md:justify-end px-4 md:px-8 bg-white shrink-0 animate-header-spring">
    <button id="admin-mobile-menu-btn" class="md:hidden text-slate-400 hover:text-slate-800 emil-btn p-2 -ml-2 focus:outline-none">
        <span class="material-symbols-outlined text-[26px]">menu</span>
    </button>
    <div class="flex items-center gap-4 md:gap-5 h-full stagger-children animate-on-scroll is-visible" style="transition-delay: 100ms;">
        <button class="text-slate-400 hover:text-slate-600 emil-btn">
            <span class="material-symbols-outlined text-[22px]">notifications</span>
        </button>
        <button class="text-slate-400 hover:text-slate-600 emil-btn">
            <span class="material-symbols-outlined text-[22px]">apps</span>
        </button>
        
        <div class="w-8 h-8 rounded-full overflow-hidden shadow-sm shrink-0 border border-slate-200 emil-btn cursor-pointer">
            <img src="{{ auth()->user()->avatarUrl() }}" alt="User" class="w-full h-full object-cover">
        </div>
    </div>
</header>
