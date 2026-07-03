@props(['active' => 'home'])

<!-- Header -->
<header id="gma-header" class="fixed top-0 left-0 right-0 w-full z-50 bg-[#f4f5ee]/90 backdrop-blur-md border-b border-[#e2e3db] px-6 md:px-12 py-4 transition-all duration-500">
    <div class="flex justify-between items-center max-w-7xl mx-auto">
        <!-- Brand / Logo -->
        <a href="{{ route('home') }}" class="flex items-center gap-2 group transition-transform duration-300 hover:scale-[1.01]">
            <img src="/Global_Mobile_Association_Logo__1_-removebg-preview.png" alt="Global Mobile Association Logo" class="h-20 md:h-28 w-auto object-contain drop-shadow-[0_2px_10px_rgba(0,0,0,0.05)] transition-all duration-500">
        </a>

        <!-- Navigation Links (Desktop) -->
        <nav class="hidden xl:flex items-center space-x-8 relative">
            @php
                $links = [
                    ['route' => 'home', 'label' => 'Home', 'key' => 'home'],
                    ['route' => 'about', 'label' => 'About GMA', 'key' => 'about'],
                    ['route' => 'who-we-serve', 'label' => 'Who We Serve', 'key' => 'who-we-serve'],
                    ['route' => 'committees', 'label' => 'Committees', 'key' => 'committees'],
                    ['route' => 'research-insights', 'label' => 'Research & Insights', 'key' => 'research-insights'],
                    ['route' => 'events', 'label' => 'Events', 'key' => 'events'],
                ];
            @endphp

            @foreach ($links as $link)
                @php
                    $isCurrent = $active === $link['key'];
                @endphp
                <a href="{{ route($link['route']) }}" class="group relative py-2 text-[15px] font-semibold tracking-tight transition-colors duration-300 {{ $isCurrent ? 'text-[#006a6a]' : 'text-neutral-600 hover:text-black' }}">
                    <span>{{ $link['label'] }}</span>
                    <span class="absolute bottom-0 left-0 w-full h-[2px] bg-[#006a6a] transition-all duration-300 origin-left {{ $isCurrent ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}"></span>
                </a>
            @endforeach
        </nav>

        <!-- Authentication and Action Button -->
        <div class="flex items-center gap-6">
            <div class="hidden md:flex items-center gap-6">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ route('dashboard') }}" class="group relative inline-flex items-center gap-2 overflow-hidden bg-gradient-to-r from-[#006a6a] to-[#008b8b] text-white font-semibold text-[14px] px-6 py-2.5 rounded-full shadow-[0_4px_15px_rgba(0,106,106,0.2)] hover:shadow-[0_6px_25px_rgba(0,106,106,0.35)] hover:-translate-y-0.5 active:translate-y-0 transition-all duration-300">
                            <span>Dashboard</span>
                            <span class="material-symbols-outlined text-[16px] transition-transform duration-300 group-hover:translate-x-1">arrow_forward</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-[15px] font-semibold text-neutral-600 hover:text-black transition-colors duration-300">Log in</a>
                        
                        <a href="{{ route('register') }}" class="group relative inline-flex items-center gap-2 overflow-hidden bg-gradient-to-r from-[#006a6a] to-[#008b8b] text-white font-semibold text-[14px] px-6 py-2.5 rounded-full shadow-[0_4px_15px_rgba(0,106,106,0.2)] hover:shadow-[0_6px_25px_rgba(0,106,106,0.35)] hover:-translate-y-0.5 active:translate-y-0 transition-all duration-300">
                            <span>Join GMA</span>
                            <span class="material-symbols-outlined text-[16px] transition-transform duration-300 group-hover:translate-x-1">arrow_forward</span>
                        </a>
                    @endauth
                @endif
            </div>
            
            <!-- Burger Menu (Mobile) -->
            <button id="mobile-menu-btn" class="xl:hidden flex flex-col justify-center items-center w-10 h-10 rounded-lg bg-neutral-200/50 border border-neutral-300 text-neutral-800 hover:bg-neutral-200/80 transition-colors z-50">
                <span class="material-symbols-outlined text-lg">menu</span>
            </button>
        </div>
    </div>
    
    <!-- Mobile Dropdown Drawer -->
    <div id="mobile-drawer" class="absolute top-20 left-0 right-0 bg-[#f4f5ee]/95 backdrop-blur-md border-b border-[#e2e3db] p-6 shadow-xl invisible opacity-0 -translate-y-4 transition-all duration-300 z-40 flex flex-col gap-4">
        @foreach ($links as $link)
            @php
                $isCurrent = $active === $link['key'];
            @endphp
            <a href="{{ route($link['route']) }}" class="text-sm font-semibold {{ $isCurrent ? 'text-[#006a6a]' : 'text-neutral-600 hover:text-black' }} py-2 border-b border-neutral-200/60 transition-colors duration-300">{{ $link['label'] }}</a>
        @endforeach
        
        <div class="flex flex-col gap-3 mt-4">
            @if (Route::has('login'))
                @auth
                    <a href="{{ route('dashboard') }}" class="w-full text-center bg-gradient-to-r from-[#006a6a] to-[#008b8b] text-white font-semibold text-[14px] py-2.5 rounded-full shadow-md transition-all duration-300">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-center text-sm font-semibold text-neutral-600 hover:text-black py-2.5 border border-neutral-300 rounded-lg">Log in</a>
                    
                    <a href="{{ route('register') }}" class="w-full text-center bg-gradient-to-r from-[#006a6a] to-[#008b8b] text-white font-semibold text-[14px] py-2.5 rounded-full shadow-md transition-all duration-300">
                        Join GMA
                    </a>
                @endauth
            @endif
        </div>
    </div>
</header>
