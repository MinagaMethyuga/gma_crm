@props(['active' => 'home'])

<!-- Header -->
<header id="gma-header" class="fixed top-4 left-1/2 -translate-x-1/2 w-[92%] max-w-[1240px] z-50 bg-white/80 backdrop-blur-md border border-white/40 rounded-full px-6 py-3 shadow-[0_20px_50px_rgba(0,0,0,0.15)] transition-all duration-500">
    <div class="flex justify-between items-center max-w-full mx-auto">
        <!-- Brand / Logo -->
        <a href="{{ route('home') }}" class="flex items-center gap-2 group transition-transform duration-300 hover:scale-[1.02]">
            <img src="/Global_Mobile_Association_Logo__1_-removebg-preview.png" alt="Global Mobile Association Logo" class="h-12 md:h-16 w-auto object-contain">
        </a>

        <!-- Navigation Links (Desktop) -->
        <nav class="hidden xl:flex items-center space-x-1 relative">
            <!-- Navigation Hover Pill Tracker -->
            <div id="nav-hover-pill" class="absolute h-9 bg-[#006a6a]/5 rounded-full transition-all duration-300 ease-out opacity-0 pointer-events-none z-0"></div>
            
            <a href="{{ route('home') }}" class="nav-item font-label-md text-xs uppercase tracking-wider {{ $active === 'home' ? 'text-[#001e40]' : 'text-[#001e40]/80 hover:text-[#006a6a]' }} px-4 py-2 rounded-full relative z-10 font-bold transition-colors duration-300">Home</a>
            
            <a href="{{ route('about') }}" class="nav-item font-label-md text-xs uppercase tracking-wider {{ $active === 'about' ? 'text-[#001e40]' : 'text-[#001e40]/80 hover:text-[#006a6a]' }} px-4 py-2 rounded-full relative z-10 font-bold transition-colors duration-300">About GMA</a>

            <a href="{{ route('who-we-serve') }}" class="nav-item font-label-md text-xs uppercase tracking-wider {{ $active === 'who-we-serve' ? 'text-[#001e40]' : 'text-[#001e40]/80 hover:text-[#006a6a]' }} px-4 py-2 rounded-full relative z-10 font-bold transition-colors duration-300">Who We Serve</a>

            <a href="{{ route('committees') }}" class="nav-item font-label-md text-xs uppercase tracking-wider {{ $active === 'committees' ? 'text-[#001e40]' : 'text-[#001e40]/80 hover:text-[#006a6a]' }} px-4 py-2 rounded-full relative z-10 font-bold transition-colors duration-300">Committees</a>
            <a href="{{ route('research-insights') }}" class="nav-item font-label-md text-xs uppercase tracking-wider {{ $active === 'research-insights' ? 'text-[#001e40]' : 'text-[#001e40]/80 hover:text-[#006a6a]' }} px-4 py-2 rounded-full relative z-10 font-bold transition-colors duration-300">Research & Insights</a>
            <a href="{{ route('events') }}" class="nav-item font-label-md text-xs uppercase tracking-wider {{ $active === 'events' ? 'text-[#001e40]' : 'text-[#001e40]/80 hover:text-[#006a6a]' }} px-4 py-2 rounded-full relative z-10 font-bold transition-colors duration-300">Events</a>
        </nav>

        <!-- Authentication and Action Button -->
        <div class="flex items-center gap-4">
            <div class="hidden md:flex items-center gap-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ route('dashboard') }}" class="group relative inline-flex h-10 items-center justify-center overflow-hidden rounded-full bg-white px-6 text-xs font-bold uppercase tracking-wider text-[#001e40] shadow-[0_4px_14px_0_rgba(0,30,64,0.1)] transition-all duration-300 hover:text-white hover:shadow-[0_4px_14px_0_rgba(0,106,106,0.39)]"><span class="absolute left-0 bottom-0 h-0 w-0 -translate-x-1/2 translate-y-1/2 rounded-full bg-[#006a6a] transition-all duration-500 ease-out group-hover:h-[300px] group-hover:w-[300px]"></span><span class="relative z-10 flex items-center gap-2">Dashboard <span class="material-symbols-outlined text-[16px] transition-transform duration-300 group-hover:translate-x-1">arrow_forward</span></span></a>
                    @else
                        <a href="{{ route('login') }}" class="font-label-md text-xs uppercase tracking-wider text-[#001e40]/80 hover:text-[#006a6a] font-bold transition-colors duration-300">Log in</a>
                    @endauth
                @endif
            </div>
            <a href="{{ route('register') }}" class="hidden sm:inline-block relative overflow-hidden bg-gradient-to-r from-[#006a6a] to-[#009090] text-white font-label-md text-xs uppercase tracking-widest px-6 py-3 rounded-full shadow-lg transition-all duration-300 hover:scale-103 hover:shadow-[0_0_20px_rgba(0,106,106,0.2)] active:scale-98 font-bold border border-[#006a6a]/20">
                Join GMA
            </a>
            
            <!-- Burger Menu (Mobile) -->
            <button id="mobile-menu-btn" class="xl:hidden flex flex-col justify-center items-center w-10 h-10 rounded-full bg-[#001e40]/5 border border-[#001e40]/10 text-[#001e40] hover:bg-[#001e40]/10 transition-colors z-50">
                <span class="material-symbols-outlined text-lg">menu</span>
            </button>
        </div>
    </div>
    
    <!-- Mobile Dropdown Drawer -->
    <div id="mobile-drawer" class="absolute top-20 left-0 right-0 bg-white border border-[#e0e0e0]/40 rounded-3xl p-6 shadow-2xl backdrop-blur-md invisible opacity-0 -translate-y-4 transition-all duration-300 z-40 flex flex-col gap-4">
        <a href="{{ route('home') }}" class="text-sm font-semibold {{ $active === 'home' ? 'text-[#001e40]' : 'text-[#001e40]/80 hover:text-[#006a6a]' }} py-2 border-b border-[#001e40]/5">Home</a>
        
        <a href="{{ route('about') }}" class="text-sm font-semibold {{ $active === 'about' ? 'text-[#001e40]' : 'text-[#001e40]/80 hover:text-[#006a6a]' }} py-2 border-b border-[#001e40]/5">About GMA</a>

        <a href="{{ route('who-we-serve') }}" class="text-sm font-semibold {{ $active === 'who-we-serve' ? 'text-[#001e40]' : 'text-[#001e40]/80 hover:text-[#006a6a]' }} py-2 border-b border-[#001e40]/5">Who We Serve</a>

        <a href="{{ route('committees') }}" class="text-sm font-semibold {{ $active === 'committees' ? 'text-[#001e40]' : 'text-[#001e40]/80 hover:text-[#006a6a]' }} py-2 border-b border-[#001e40]/5">Committees</a>
        <a href="{{ route('research-insights') }}" class="text-sm font-semibold {{ $active === 'research-insights' ? 'text-[#001e40]' : 'text-[#001e40]/80 hover:text-[#006a6a]' }} py-2 border-b border-[#001e40]/5">Research & Insights</a>
        <a href="{{ route('events') }}" class="text-sm font-semibold {{ $active === 'events' ? 'text-[#001e40]' : 'text-[#001e40]/80 hover:text-[#006a6a]' }} py-2 border-b border-[#001e40]/5">Events</a>
        <div class="flex flex-col gap-3 mt-4">
            @if (Route::has('login'))
                @auth
                    <div class="flex justify-center"><a href="{{ route('dashboard') }}" class="group relative inline-flex h-10 items-center justify-center overflow-hidden rounded-full bg-white px-6 text-xs font-bold uppercase tracking-wider text-[#001e40] shadow-[0_4px_14px_0_rgba(0,30,64,0.1)] transition-all duration-300 hover:text-white hover:shadow-[0_4px_14px_0_rgba(0,106,106,0.39)]"><span class="absolute left-0 bottom-0 h-0 w-0 -translate-x-1/2 translate-y-1/2 rounded-full bg-[#006a6a] transition-all duration-500 ease-out group-hover:h-[300px] group-hover:w-[300px]"></span><span class="relative z-10 flex items-center gap-2">Dashboard <span class="material-symbols-outlined text-[16px] transition-transform duration-300 group-hover:translate-x-1">arrow_forward</span></span></a></div>
                @else
                    <a href="{{ route('login') }}" class="text-center text-xs uppercase tracking-wider text-[#001e40]/80 hover:text-[#006a6a] py-3 border border-[#001e40]/10 rounded-full font-semibold">Log in</a>
                @endauth
            @endif
            <a href="{{ route('register') }}" class="w-full bg-gradient-to-r from-[#006a6a] to-[#009090] text-white font-label-md text-xs uppercase tracking-widest py-3.5 rounded-full shadow-md font-bold text-center border border-[#006a6a]/20">
                Join GMA
            </a>
        </div>
    </div>
</header>
