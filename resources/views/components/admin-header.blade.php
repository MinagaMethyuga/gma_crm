<header class="h-20 border-b border-slate-200 flex items-center justify-between px-8 bg-white shrink-0">
    <div class="relative w-96">
        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
            <span class="material-symbols-outlined text-slate-400 text-xl">search</span>
        </div>
        <input type="text" class="block w-full pl-11 pr-3 py-2.5 border border-slate-200 rounded-xl leading-5 bg-slate-50/50 text-slate-900 placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-1 focus:ring-[#4338ca] focus:border-[#4338ca] sm:text-sm transition-colors shadow-inner" placeholder="Search...">
    </div>

    <div class="flex items-center gap-8 ml-auto mr-10 h-full">
        <a href="#" class="text-[13px] font-bold text-[#4338ca] border-b-2 border-[#4338ca] h-full flex items-center">Directory</a>
        <a href="#" class="text-[13px] font-semibold text-slate-500 hover:text-slate-800 transition-colors h-full flex items-center">Invoices</a>
        <a href="#" class="text-[13px] font-semibold text-slate-500 hover:text-slate-800 transition-colors h-full flex items-center">Support</a>
    </div>
    
    <div class="flex items-center gap-4 pl-6 border-l border-slate-200 h-full">
        <button class="text-slate-400 hover:text-slate-600 transition-colors">
            <span class="material-symbols-outlined">notifications</span>
        </button>
        <button class="text-slate-400 hover:text-slate-600 transition-colors">
            <span class="material-symbols-outlined">apps</span>
        </button>
        
        <button class="bg-indigo-100/50 hover:bg-indigo-100 text-[#4338ca] text-sm font-semibold px-4 py-2 rounded-lg transition-colors ml-2 tracking-wide hidden md:block border border-indigo-200/50">
            Create Event
        </button>
        <div class="w-8 h-8 rounded-full bg-slate-200 overflow-hidden shadow-sm ml-2 shrink-0 border border-slate-200">
            <img src="https://ui-avatars.com/api/?name=Admin&background=103C68&color=fff" alt="User" class="w-full h-full object-cover">
        </div>
    </div>
</header>