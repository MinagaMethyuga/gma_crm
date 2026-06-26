<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GMA</title>
    <link rel="icon" href="/Global_Mobile_Association_Logo__1_-removebg-preview.png" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0,1&display=swap" rel="stylesheet">
    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="overflow-x-hidden bg-[#f8fafd] text-[#1b1b18]">

    <!-- Header -->
    <header id="gma-header" class="fixed top-4 left-1/2 -translate-x-1/2 w-[92%] max-w-[1240px] z-50 bg-white/80 backdrop-blur-md border border-white/40 rounded-full px-6 py-3 shadow-[0_20px_50px_rgba(0,0,0,0.15)] transition-all duration-500">
        <div class="flex justify-between items-center max-w-full mx-auto">
            <!-- Brand / Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-2 group transition-transform duration-300 hover:scale-[1.02]">
                <img src="/Global_Mobile_Association_Logo__1_-removebg-preview.png" alt="Global Mobile Association Logo" class="h-11 md:h-14 w-auto object-contain">
            </a>

            <!-- Navigation Links (Desktop) -->
            <nav class="hidden xl:flex items-center space-x-1 relative">
                <!-- Navigation Hover Pill Tracker -->
                <div id="nav-hover-pill" class="absolute h-9 bg-[#006a6a]/5 rounded-full transition-all duration-300 ease-out opacity-0 pointer-events-none z-0"></div>
                
                <a href="{{ route('home') }}" class="nav-item font-label-md text-xs uppercase tracking-wider text-[#001e40]/80 hover:text-[#006a6a] px-4 py-2 rounded-full relative z-10 font-bold transition-colors duration-300">Home</a>
                
                <a href="{{ route('about') }}" class="nav-item font-label-md text-xs uppercase tracking-wider text-[#001e40] px-4 py-2 rounded-full relative z-10 font-bold transition-colors duration-300">About GMA</a>

                <a href="{{ route('who-we-serve') }}" class="nav-item font-label-md text-xs uppercase tracking-wider text-[#001e40]/80 hover:text-[#006a6a] px-4 py-2 rounded-full relative z-10 font-bold transition-colors duration-300">Who We Serve</a>

                <a href="{{ route('committees') }}" class="nav-item font-label-md text-xs uppercase tracking-wider text-[#001e40]/80 hover:text-[#006a6a] px-4 py-2 rounded-full relative z-10 font-bold transition-colors duration-300">Committees</a>
                <a href="{{ route('research-insights') }}" class="nav-item font-label-md text-xs uppercase tracking-wider text-[#001e40]/80 hover:text-[#006a6a] px-4 py-2 rounded-full relative z-10 font-bold transition-colors duration-300">Research & Insights</a>
                <a href="{{ route('events') }}" class="nav-item font-label-md text-xs uppercase tracking-wider text-[#001e40]/80 hover:text-[#006a6a] px-4 py-2 rounded-full relative z-10 font-bold transition-colors duration-300">Events</a>
            </nav>

            <!-- Authentication and Action Button -->
            <div class="flex items-center gap-4">
                <div class="hidden md:flex items-center gap-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ route('dashboard') }}" class="font-label-md text-xs uppercase tracking-wider text-[#001e40]/80 hover:text-[#006a6a] font-bold transition-colors duration-300">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="font-label-md text-xs uppercase tracking-wider text-[#001e40]/80 hover:text-[#006a6a] font-bold transition-colors duration-300">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="font-label-md text-xs uppercase tracking-wider text-[#001e40]/80 hover:text-[#006a6a] font-bold transition-colors duration-300">Register</a>
                            @endif
                        @endauth
                    @endif
                </div>
                <button class="hidden sm:inline-block relative overflow-hidden bg-gradient-to-r from-[#006a6a] to-[#009090] text-white font-label-md text-xs uppercase tracking-widest px-6 py-3 rounded-full shadow-lg transition-all duration-300 hover:scale-103 hover:shadow-[0_0_20px_rgba(0,106,106,0.2)] active:scale-98 font-bold border border-[#006a6a]/20">
                    Join GMA
                </button>
                
                <!-- Burger Menu (Mobile) -->
                <button id="mobile-menu-btn" class="xl:hidden flex flex-col justify-center items-center w-10 h-10 rounded-full bg-[#001e40]/5 border border-[#001e40]/10 text-[#001e40] hover:bg-[#001e40]/10 transition-colors z-50">
                    <span class="material-symbols-outlined text-lg">menu</span>
                </button>
            </div>
        </div>
        
        <!-- Mobile Dropdown Drawer -->
        <div id="mobile-drawer" class="absolute top-20 left-0 right-0 bg-white border border-[#e0e0e0]/40 rounded-3xl p-6 shadow-2xl backdrop-blur-md invisible opacity-0 -translate-y-4 transition-all duration-300 z-40 flex flex-col gap-4">
            <a href="{{ route('home') }}" class="text-sm font-semibold text-[#001e40]/80 hover:text-[#006a6a] py-2 border-b border-[#001e40]/5">Home</a>
            <a href="{{ route('about') }}" class="text-sm font-semibold text-[#001e40]/80 hover:text-[#006a6a] py-2 border-b border-[#001e40]/5">About GMA</a>
            
            <a href="{{ route('who-we-serve') }}" class="text-sm font-semibold text-[#001e40]/80 hover:text-[#006a6a] py-2 border-b border-[#001e40]/5">Who We Serve</a>

            <a href="{{ route('committees') }}" class="text-sm font-semibold text-[#001e40]/80 hover:text-[#006a6a] py-2 border-b border-[#001e40]/5">Committees</a>
            <a href="{{ route('research-insights') }}" class="text-sm font-semibold text-[#001e40]/80 hover:text-[#006a6a] py-2 border-b border-[#001e40]/5">Research & Insights</a>
            <a href="{{ route('events') }}" class="text-sm font-semibold text-[#001e40]/80 hover:text-[#006a6a] py-2 border-b border-[#001e40]/5">Events</a>
            <div class="flex flex-col gap-3 mt-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-center text-xs uppercase tracking-wider text-[#001e40]/80 hover:text-[#006a6a] py-3 border border-[#001e40]/10 rounded-full font-semibold">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-center text-xs uppercase tracking-wider text-[#001e40]/80 hover:text-[#006a6a] py-3 border border-[#001e40]/10 rounded-full font-semibold">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="text-center text-xs uppercase tracking-wider text-[#001e40]/80 hover:text-[#006a6a] py-3 border border-[#001e40]/10 rounded-full font-semibold">Register</a>
                        @endif
                    @endauth
                @endif
                <button class="w-full bg-gradient-to-r from-[#006a6a] to-[#009090] text-white font-label-md text-xs uppercase tracking-widest py-3.5 rounded-full shadow-md font-bold text-center border border-[#006a6a]/20">
                    Join GMA
                </button>
            </div>
        </div>
    </header>

    <main class="pt-0 relative overflow-hidden bg-[#f8fafd]">

        <!-- Ambient floating glow circles -->
        <div class="absolute top-[-10%] left-[-10%] w-[500px] h-[500px] rounded-full bg-[#006a6a]/8 blur-[120px] pointer-events-none animate-float-slow"></div>
        <div class="absolute top-[20%] right-[-10%] w-[600px] h-[600px] rounded-full bg-[#009090]/20 blur-[150px] pointer-events-none animate-float-slow-reverse"></div>
        <div class="absolute top-[50%] left-[20%] w-[450px] h-[450px] rounded-full bg-[#40e0d0]/15 blur-[130px] pointer-events-none animate-float-slow"></div>

        <!-- Hero Section -->
        <section id="hero-section" class="relative min-h-[550px] flex items-center overflow-hidden bg-mesh-glow pt-32 pb-24">
            <div class="absolute inset-0 z-0 bg-[#00142d]/95">
                <div class="absolute inset-0 bg-gradient-to-br from-[#000d1e] via-[#001633]/90 to-[#003c3c]/40"></div>
            </div>
            
            <div class="relative z-10 max-w-[1280px] mx-auto px-4 md:px-10 w-full text-center mt-12">
                <span class="text-[#40e0d0] font-semibold text-[13px] uppercase tracking-[0.2em] mb-4 inline-block relative after:content-[''] after:absolute after:bottom-[-8px] after:left-1/2 after:-translate-x-1/2 after:w-16 after:h-[2px] after:bg-[#40e0d0]">
                    Who We Are
                </span>
                <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-[4.5rem] font-black mt-6 mb-6 leading-tight text-transparent bg-clip-text bg-gradient-to-br from-white via-[#e0f2f1] to-[#40e0d0] drop-shadow-sm">
                    About GMA
                </h1>
                <p class="text-lg md:text-2xl text-white/80 max-w-3xl mx-auto leading-relaxed font-light">
                    Serving the global used mobile ecosystem by bringing members together year-round to build stronger businesses and connections.
                </p>
            </div>
            
            <!-- Smooth arc divider into Mission section -->
            <div class="absolute bottom-0 left-0 right-0 w-full overflow-hidden leading-[0] z-20">
                <svg viewBox="0 0 1440 92" preserveAspectRatio="none" class="w-full h-[57px] md:h-[92px] block">
                    <path d="M0,90 C360,0 1080,0 1440,90 L1440,92 L0,92 Z" fill="#f0fdfa"/>
                </svg>
            </div>
        </section>

        <!-- Mission & Vision Section -->
        <section class="py-20 bg-[#f0fdfa] bg-gradient-to-b from-[#f0fdfa] to-[#eff6ff] relative -mt-[2px] pb-[100px]">
            <div class="max-w-[1280px] mx-auto px-4 sm:px-6 md:px-10">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12 relative z-10 -mt-24">
                    
                    <!-- Mission Card -->
                    <div class="bg-white p-8 md:p-12 rounded-3xl shadow-[0_25px_50px_-12px_rgba(0,106,106,0.15)] border border-[#006a6a]/10 hover:border-[#006a6a]/40 hover:shadow-[0_30px_60px_-15px_rgba(0,106,106,0.25)] transition-all duration-500 hover:-translate-y-2 group">
                        <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-[#006a6a] to-[#009a9a] text-white flex items-center justify-center mb-8 shadow-lg group-hover:scale-110 transition-transform duration-500">
                            <span class="material-symbols-outlined text-4xl">flag</span>
                        </div>
                        <h2 class="text-3xl md:text-4xl font-black text-[#001e40] mb-6">Mission</h2>
                        <p class="text-lg text-[#555] leading-relaxed">
                            The Global Mobile Association exists to serve the global used mobile ecosystem by bringing members together year-round through education, resources, leadership development, advocacy, business support, and meaningful industry connection.
                        </p>
                    </div>
                    
                    <!-- Vision Card -->
                    <div class="bg-white p-8 md:p-12 rounded-3xl shadow-[0_25px_50px_-12px_rgba(0,106,106,0.15)] border border-[#006a6a]/10 hover:border-[#006a6a]/40 hover:shadow-[0_30px_60px_-15px_rgba(0,106,106,0.25)] transition-all duration-500 hover:-translate-y-2 group">
                        <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-[#001e40] to-[#003c70] text-white flex items-center justify-center mb-8 shadow-lg group-hover:scale-110 transition-transform duration-500">
                            <span class="material-symbols-outlined text-4xl">visibility</span>
                        </div>
                        <h2 class="text-3xl md:text-4xl font-black text-[#001e40] mb-6">Vision</h2>
                        <p class="text-lg text-[#555] leading-relaxed">
                            Our vision is to become the trusted global association for the used mobile ecosystem, helping members build stronger businesses, develop stronger leaders, create stronger connections, and give the industry the voice and support it deserves.
                        </p>
                    </div>

                </div>
            </div>
            <!-- Smooth arc divider into The Gap section -->
            <div class="absolute bottom-0 left-0 right-0 w-full overflow-hidden leading-[0] z-20">
                <svg viewBox="0 0 1440 92" preserveAspectRatio="none" class="w-full h-[57px] md:h-[92px] block">
                    <path d="M0,0 C360,90 1080,90 1440,0 L1440,92 L0,92 Z" fill="#003c3c"/>
                </svg>
            </div>
        </section>

        <!-- Why the Used Mobile Ecosystem Needs GMA -->
        <section class="py-24 bg-[#003c3c] text-white relative pb-[120px] -mt-[2px] overflow-hidden">
            <div class="absolute inset-0 z-0 pointer-events-none">
                <img src="/gma_mission.png" alt="Professionals collaborating" class="w-full h-full object-cover opacity-15 mix-blend-overlay saturate-50">
                <div class="absolute inset-0 bg-gradient-to-br from-[#003c3c]/90 via-[#005a5a]/85 to-[#007a7a]/90"></div>
            </div>
            <div class="absolute inset-0 bg-mesh-glow opacity-30 pointer-events-none z-0"></div>
            
            <div class="max-w-[1280px] mx-auto px-4 sm:px-6 md:px-10 relative z-10">
                
                <div class="animate-on-scroll text-center max-w-4xl mx-auto mb-20">
                    <span class="text-[#40e0d0] font-semibold text-[13px] uppercase tracking-[0.2em] mb-4 inline-block relative after:content-[''] after:absolute after:bottom-[-6px] after:left-1/2 after:-translate-x-1/2 after:w-16 after:h-[2px] after:bg-[#40e0d0]">
                        Why GMA
                    </span>
                    <h2 class="text-3xl md:text-5xl font-bold text-white mb-6 leading-tight drop-shadow-md">Why the Used Mobile Ecosystem Needs GMA</h2>
                    <p class="text-lg md:text-xl text-white/90 leading-relaxed font-light">
                        The used mobile ecosystem has grown into a global industry, but many companies and leaders still lack a consistent year-round platform for education, collaboration, and business growth.
                    </p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-stretch">
                    
                    <!-- The Problem Card (Left) -->
                    <div class="animate-on-scroll bg-[#00142d]/60 backdrop-blur-md p-6 sm:p-8 md:p-10 rounded-3xl border border-red-500/20 shadow-2xl relative overflow-hidden group hover:border-red-500/40 transition-all duration-500 flex flex-col hover:shadow-[0_30px_60px_-15px_rgba(220,38,38,0.15)]">
                        <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-red-500/5 rounded-full blur-[60px] group-hover:bg-red-500/10 group-hover:scale-110 transition-all duration-700 pointer-events-none"></div>
                        
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-red-500/10 border border-red-500/30 text-red-400 text-xs font-bold uppercase tracking-widest w-max mb-6 sm:mb-8 relative z-10">
                            <span class="material-symbols-outlined text-sm">warning</span> The Problem
                        </div>
                        
                        <h3 class="text-xl sm:text-2xl font-bold mb-6 sm:mb-8 text-white relative z-10">The industry moves fast, and isolation is expensive.</h3>
                        
                        <div class="space-y-3 sm:space-y-4 relative z-10 flex-1 stagger-children">
                            <div class="flex gap-3 sm:gap-4 items-start bg-white/5 p-4 sm:p-5 rounded-2xl border border-white/5 hover:bg-white/10 hover:translate-x-1 transition-all duration-300">
                                <div class="mt-1 w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-red-500/20 border border-red-500/30 flex items-center justify-center shrink-0 text-red-400">
                                    <span class="material-symbols-outlined text-lg sm:text-xl">speed</span>
                                </div>
                                <div class="min-w-0">
                                    <h4 class="text-base sm:text-lg font-semibold mb-1 text-white">Rapid Market Shifts</h4>
                                    <p class="text-white/70 text-xs sm:text-sm leading-relaxed">Technology continues to change, customer expectations keep rising, and global trade evolves daily.</p>
                                </div>
                            </div>
                            <div class="flex gap-3 sm:gap-4 items-start bg-white/5 p-4 sm:p-5 rounded-2xl border border-white/5 hover:bg-white/10 hover:translate-x-1 transition-all duration-300">
                                <div class="mt-1 w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-red-500/20 border border-red-500/30 flex items-center justify-center shrink-0 text-red-400">
                                    <span class="material-symbols-outlined text-lg sm:text-xl">rule</span>
                                </div>
                                <div class="min-w-0">
                                    <h4 class="text-base sm:text-lg font-semibold mb-1 text-white">Complex Compliance</h4>
                                    <p class="text-white/70 text-xs sm:text-sm leading-relaxed">Requirements are becoming more complex, putting pressure on companies to grow profitably while developing stronger teams.</p>
                                </div>
                            </div>
                            <div class="flex gap-3 sm:gap-4 items-start bg-white/5 p-4 sm:p-5 rounded-2xl border border-white/5 hover:bg-white/10 hover:translate-x-1 transition-all duration-300">
                                <div class="mt-1 w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-red-500/20 border border-red-500/30 flex items-center justify-center shrink-0 text-red-400">
                                    <span class="material-symbols-outlined text-lg sm:text-xl">person_off</span>
                                </div>
                                <div class="min-w-0">
                                    <h4 class="text-base sm:text-lg font-semibold mb-1 text-white">Working in Silos</h4>
                                    <p class="text-white/70 text-xs sm:text-sm leading-relaxed">Too often, businesses in this space are working through similar challenges on their own, without access to shared insight or peer connection.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- The Solution Card (Right) -->
                    <div class="animate-on-scroll bg-gradient-to-br from-[#004e66]/80 to-[#001e40]/90 backdrop-blur-md p-6 sm:p-8 md:p-10 rounded-3xl border border-[#40e0d0]/30 shadow-2xl relative overflow-hidden group hover:border-[#40e0d0]/60 transition-all duration-500 flex flex-col hover:shadow-[0_30px_60px_-15px_rgba(64,224,208,0.12)]">
                        <div class="absolute -top-24 -right-24 w-64 h-64 bg-[#40e0d0]/10 rounded-full blur-[60px] group-hover:bg-[#40e0d0]/20 group-hover:scale-110 transition-all duration-700 pointer-events-none"></div>
                        
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-[#40e0d0]/20 border border-[#40e0d0]/40 text-[#40e0d0] text-xs font-bold uppercase tracking-widest w-max mb-6 sm:mb-8 relative z-10">
                            <span class="material-symbols-outlined text-sm">check_circle</span> The Solution
                        </div>

                        <h3 class="text-xl sm:text-2xl font-bold mb-3 sm:mb-4 relative z-10 text-white">GMA was created to fill the gap.</h3>
                        
                        <p class="text-white/80 mb-6 sm:mb-8 font-light leading-relaxed relative z-10 text-sm sm:text-base">
                            The used mobile industry does not need more noise. It needs practical resources, better leadership development, and a year-round voice.
                        </p>

                        <div class="grid grid-cols-2 gap-3 sm:gap-4 relative z-10 flex-1 content-start stagger-children">
                            <div class="bg-white/10 border border-white/20 p-4 sm:p-5 rounded-2xl hover:-translate-y-1.5 hover:bg-white/20 transition-all duration-300 shadow-lg">
                                <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-[#40e0d0]/20 flex items-center justify-center mb-2 sm:mb-3">
                                    <span class="material-symbols-outlined text-[#40e0d0] text-lg sm:text-xl">school</span>
                                </div>
                                <h5 class="font-bold text-white text-sm sm:text-base mb-0.5">Education</h5>
                                <p class="text-[10px] sm:text-xs text-white/70 leading-relaxed">Consistent webinars &amp; resources</p>
                            </div>
                            <div class="bg-white/10 border border-white/20 p-4 sm:p-5 rounded-2xl hover:-translate-y-1.5 hover:bg-white/20 transition-all duration-300 shadow-lg">
                                <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-[#40e0d0]/20 flex items-center justify-center mb-2 sm:mb-3">
                                    <span class="material-symbols-outlined text-[#40e0d0] text-lg sm:text-xl">groups</span>
                                </div>
                                <h5 class="font-bold text-white text-sm sm:text-base mb-0.5">Committees</h5>
                                <p class="text-[10px] sm:text-xs text-white/70 leading-relaxed">Meaningful industry collaboration</p>
                            </div>
                            <div class="bg-white/10 border border-white/20 p-4 sm:p-5 rounded-2xl hover:-translate-y-1.5 hover:bg-white/20 transition-all duration-300 shadow-lg">
                                <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-[#40e0d0]/20 flex items-center justify-center mb-2 sm:mb-3">
                                    <span class="material-symbols-outlined text-[#40e0d0] text-lg sm:text-xl">military_tech</span>
                                </div>
                                <h5 class="font-bold text-white text-sm sm:text-base mb-0.5">Leadership</h5>
                                <p class="text-[10px] sm:text-xs text-white/70 leading-relaxed">Developing talent year-round</p>
                            </div>
                            <div class="bg-white/10 border border-white/20 p-4 sm:p-5 rounded-2xl hover:-translate-y-1.5 hover:bg-white/20 transition-all duration-300 shadow-lg">
                                <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-[#40e0d0]/20 flex items-center justify-center mb-2 sm:mb-3">
                                    <span class="material-symbols-outlined text-[#40e0d0] text-lg sm:text-xl">forum</span>
                                </div>
                                <h5 class="font-bold text-white text-sm sm:text-base mb-0.5">Connection</h5>
                                <p class="text-[10px] sm:text-xs text-white/70 leading-relaxed">Bridging segments between events</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            
            <!-- Smooth arc divider into The Gap section -->
            <div class="absolute bottom-0 left-0 right-0 w-full overflow-hidden leading-[0] z-20">
                <svg viewBox="0 0 1440 90" preserveAspectRatio="none" class="w-full h-[55px] md:h-[90px] block">
                    <path d="M0,90 L1440,90 L1440,0 L0,0 Z" fill="#002b4d"/>
                </svg>
            </div>
        </section>

        <!-- The Gap GMA Fills -->
        <section class="py-24 bg-[#001e40] text-white relative pb-[120px] -mt-[2px] overflow-hidden">
            <div class="absolute inset-0 z-0 pointer-events-none">
                <img src="/gma_network.png" alt="Global Network" class="w-full h-full object-cover opacity-20 mix-blend-screen">
                <div class="absolute inset-0 bg-gradient-to-br from-[#002b4d]/90 via-[#003c5e]/80 to-[#001e40]/95"></div>
            </div>
            <div class="absolute inset-0 bg-mesh-glow opacity-20 pointer-events-none z-0"></div>
            
            <div class="max-w-[1280px] mx-auto px-4 sm:px-6 md:px-10 relative z-10">
                
                <div class="animate-on-scroll text-center max-w-4xl mx-auto mb-16">
                    <span class="text-[#40e0d0] font-semibold text-[13px] uppercase tracking-[0.2em] mb-4 inline-block relative after:content-[''] after:absolute after:bottom-[-6px] after:left-1/2 after:-translate-x-1/2 after:w-16 after:h-[2px] after:bg-[#40e0d0]">
                        The Opportunity
                    </span>
                    <h2 class="text-3xl md:text-5xl font-bold text-white mb-6 leading-tight drop-shadow-md">The Gap GMA Fills</h2>
                </div>

                <div class="max-w-5xl mx-auto space-y-6 stagger-children">
                    <div class="bg-white/10 backdrop-blur-sm border border-white/20 p-6 sm:p-8 md:p-10 rounded-3xl shadow-xl hover:bg-white/20 hover:shadow-2xl transition-all duration-500">
                        <p class="text-base sm:text-lg text-white/85 leading-relaxed font-light">
                            The used mobile industry has strong events, experienced operators, respected service providers, and companies doing important work across the global market. What has been missing is a consistent year-round association focused on bringing these segments together, supporting their growth, and helping the industry stay connected between major events.
                        </p>
                    </div>

                    <div class="bg-[#00142d]/60 backdrop-blur-sm border border-white/10 p-6 sm:p-8 md:p-10 rounded-3xl shadow-xl hover:shadow-2xl hover:border-[#40e0d0]/30 transition-all duration-500">
                        <div class="flex items-start gap-4">
                            <span class="material-symbols-outlined text-[#40e0d0] text-2xl sm:text-3xl mt-0.5 shrink-0">handshake</span>
                            <div>
                                <p class="text-base sm:text-lg text-white/85 leading-relaxed">
                                    GMA fills that gap by creating a dedicated platform for education, resources, collaboration, leadership development, business growth, and industry connection. The association is designed to support the companies, leaders, vendors, and professionals working across the used mobile ecosystem with practical value they can use throughout the year.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-r from-[#40e0d0]/20 to-transparent border-l-4 border-[#40e0d0] p-6 sm:p-8 md:p-10 rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-500">
                        <p class="text-base sm:text-lg text-white/85 leading-relaxed">
                            Instead of only gathering periodically, GMA gives the industry a place to continue important conversations, address shared challenges, develop talent, support innovation, create business opportunities, and build stronger relationships across the ecosystem.
                        </p>
                    </div>

                    <div class="bg-white/10 backdrop-blur-sm border border-white/20 p-6 sm:p-8 md:p-10 rounded-3xl shadow-xl hover:bg-white/20 hover:shadow-2xl transition-all duration-500">
                        <div class="flex items-start gap-4">
                            <span class="material-symbols-outlined text-[#40e0d0] text-2xl sm:text-3xl mt-0.5 shrink-0">track_changes</span>
                            <div>
                                <p class="text-base sm:text-lg text-white/85 leading-relaxed font-medium">
                                    The goal is not to duplicate what already exists. The goal is to provide the missing year-round structure that helps the used mobile industry become more connected, better supported, and more prepared for the opportunities ahead.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Smooth arc divider into Founder section -->
            <div class="absolute bottom-0 left-0 right-0 w-full overflow-hidden leading-[0] z-20">
                <svg viewBox="0 0 1440 90" preserveAspectRatio="none" class="w-full h-[55px] md:h-[90px] block">
                    <path d="M0,90 C360,0 1080,0 1440,90 L1440,90 L0,90 Z" fill="#f8fafd"/>
                </svg>
            </div>
        </section>

        <!-- Founder Story (Timeline Redesign) -->
        <section class="py-24 bg-gradient-to-b from-[#f8fafd] via-white to-[#edf7f7] relative pb-[120px] -mt-[2px]">
            <div class="max-w-[1000px] mx-auto px-4 sm:px-6 md:px-10">
                
                <div class="text-center mb-20">
                    <span class="text-[#006a6a] font-semibold text-[13px] uppercase tracking-[0.2em] mb-4 inline-block relative after:content-[''] after:absolute after:bottom-[-6px] after:left-1/2 after:-translate-x-1/2 after:w-16 after:h-[2px] after:bg-[#006a6a]">
                        Our Origins
                    </span>
                    <h2 class="text-4xl md:text-5xl font-black text-[#001e40] mt-4 leading-tight">Founder Story</h2>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
                    <div class="lg:col-span-4 relative h-full">
                        <div id="founder-parallax" class="text-center lg:text-left bg-white p-8 rounded-3xl shadow-sm border border-gray-100 hover:shadow-xl transition-all duration-300 will-change-transform">
                            <img src="/Bob-updated-profile-photo-2025.jpg" alt="Bob Lafon" class="w-48 h-48 sm:w-56 sm:h-56 rounded-2xl object-cover shadow-lg mx-auto lg:mx-0 border-4 border-white mb-6">
                            <h3 class="text-2xl font-bold text-[#001e40] mb-2">Bob Lafon</h3>
                            <p class="text-[#006a6a] font-semibold uppercase tracking-wider text-sm mb-4">Founder & CEO</p>
                        </div>
                    </div>
                    <div class="lg:col-span-8">
                        <!-- Vertical Timeline Container -->
                        <div class="relative border-l-2 border-[#006a6a]/20 pl-8 sm:pl-12 ml-4 sm:ml-6 md:ml-0 space-y-16">
                    
                    <!-- Timeline Node 1 -->
                    <div class="relative group">
                        <!-- Node Marker -->
                        <div class="absolute -left-[43px] sm:-left-[59px] top-1 w-6 h-6 rounded-full bg-[#40e0d0] border-4 border-white shadow-md group-hover:scale-125 transition-transform duration-300"></div>
                        
                        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-sm border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                            <span class="text-sm font-bold text-[#006a6a] mb-2 block tracking-wider">2021</span>
                            <h3 class="text-2xl font-bold text-[#001e40] mb-4">Recognizing an Underserved Market</h3>
                            <p class="text-[#555] text-lg leading-relaxed mb-4">
                                In 2021, Bob Lafon saw an underserved segment of the wireless mobile ecosystem that needed its own platform.
                            </p>
                            <p class="text-[#555] text-lg leading-relaxed">
                                After moderating a panel discussion at an industry trade show, Bob spoke with the event promoter about the opportunity he saw. Larger industry events served important purposes, but the secondary mobile ecosystem did not have a dedicated gathering built around its unique needs, challenges, companies, and opportunities.
                            </p>
                        </div>
                    </div>

                    <!-- Timeline Node 2 -->
                    <div class="relative group">
                        <div class="absolute -left-[43px] sm:-left-[59px] top-1 w-6 h-6 rounded-full bg-[#006a6a] border-4 border-white shadow-md group-hover:scale-125 transition-transform duration-300"></div>
                        
                        <div class="bg-gradient-to-br from-[#001e40] to-[#003c70] text-white p-6 sm:p-8 rounded-3xl shadow-lg border border-[#001e40]/10 hover:shadow-2xl transition-shadow duration-300">
                            <span class="material-symbols-outlined text-[#40e0d0] text-4xl mb-4 opacity-50 block">format_quote</span>
                            <p class="text-xl md:text-2xl font-light italic leading-snug mb-6 text-white/90">
                                "The used mobile ecosystem was not a small side category. It was a growing, global industry made up of operators, innovators, service providers, technology companies, and leaders who needed a place of their own."
                            </p>
                            <p class="text-white/70 text-base leading-relaxed">
                                That conversation quickly turned into action. Within minutes, a camera was rolling as Bob recorded a short announcement. Ten months later, Mobile Disrupt was born. Not everyone believed it would work, but it quickly gained momentum and established itself as the premier event serving the secondary mobile ecosystem.
                            </p>
                        </div>
                    </div>

                    <!-- Timeline Node 3 -->
                    <div class="relative group">
                        <div class="absolute -left-[43px] sm:-left-[59px] top-1 w-6 h-6 rounded-full bg-[#009090] border-4 border-white shadow-md group-hover:scale-125 transition-transform duration-300"></div>
                        
                        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-sm border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                            <span class="text-sm font-bold text-[#006a6a] mb-2 block tracking-wider">TODAY</span>
                            <h3 class="text-2xl font-bold text-[#001e40] mb-4">The Creation of GMA</h3>
                            <p class="text-[#555] text-lg leading-relaxed mb-4">
                                The creation of the Global Mobile Association follows that same pattern. Bob once again looked across the industry and saw an important gap.
                            </p>
                            <p class="text-[#555] text-lg leading-relaxed mb-4">
                                While major events bring the ecosystem together at key moments, the used mobile industry also needs year-round support, education, leadership development, business resources, advocacy, and meaningful connection between those events. GMA was founded to serve that need.
                            </p>
                            <p class="text-[#555] text-lg leading-relaxed">
                                Through his work with Lafon & Associates, Mobile Disrupt, the Mobile Mavericks Podcast, and now GMA, Bob remains focused on giving the ecosystem a platform to help members learn, connect, lead, grow, and move the industry forward together.
                            </p>
                        </div>
                    </div>

                </div>
                </div> <!-- /lg:col-span-8 -->
                </div> <!-- /grid -->
            </div>
            
            <!-- Arc divider into Final CTA section -->
            <div class="absolute bottom-0 left-0 right-0 w-full overflow-hidden leading-[0] z-20">
                <svg viewBox="0 0 1440 92" preserveAspectRatio="none" class="w-full h-[57px] md:h-[92px] block">
                    <path d="M0,0 C360,90 1080,90 1440,0 L1440,92 L0,92 Z" fill="#eff6ff"/>
                </svg>
            </div>
        </section>

        <!-- Final CTA -->
        <section class="py-24 bg-gradient-to-r from-[#f0fdfa]/60 via-[#eff6ff]/70 to-[#eef2ff]/60 relative overflow-hidden -mt-[2px]">
            <div class="absolute inset-0 bg-mesh-glow opacity-70 pointer-events-none"></div>
            <div class="absolute bottom-[-10%] left-[-10%] w-[400px] h-[400px] rounded-full bg-[#006a6a]/5 blur-[120px] pointer-events-none animate-float-slow"></div>
            
            <div class="max-w-[1280px] mx-auto px-4 sm:px-6 md:px-10 text-center relative z-10">
                <div class="max-w-4xl mx-auto bg-white/40 backdrop-blur-sm border border-white p-8 md:p-16 rounded-[3rem] shadow-2xl">
                    <h2 class="text-3xl sm:text-4xl md:text-5xl lg:text-[4rem] font-black text-transparent bg-clip-text bg-gradient-to-br from-[#001e40] via-[#00385e] to-[#006a6a] mb-8 leading-tight">
                        Be Part of Building a Stronger Industry
                    </h2>
                    
                    <p class="text-lg md:text-xl text-[#555] mb-12 leading-relaxed max-w-3xl mx-auto font-medium">
                        The used mobile ecosystem is growing, and the companies shaping its future deserve a stronger platform. GMA gives you a place to stay engaged, access resources, and build relationships year-round.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row justify-center gap-6 items-center">
                        <button class="w-full sm:w-auto bg-gradient-to-r from-[#001e40] to-[#009090] text-white font-label-md text-sm uppercase tracking-widest px-12 py-5 rounded-full shadow-lg transition-all duration-300 hover:scale-103 hover:shadow-[0_20px_40px_-10px_rgba(0,106,106,0.4)] active:scale-98 font-bold">
                            Join GMA
                        </button>
                        <button class="w-full sm:w-auto bg-white text-[#001e40] border-2 border-[#001e40] font-label-md text-sm uppercase tracking-widest px-12 py-5 rounded-full transition-all duration-300 shadow-sm hover:scale-103 hover:bg-[#001e40]/5 active:scale-98 font-bold">
                            Request Info
                        </button>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-gradient-to-br from-[#001025] to-[#002b4d] text-white border-t border-[#e0e0e0]/10 relative overflow-hidden">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12 px-4 md:px-10 py-24 max-w-[1280px] mx-auto relative z-10">
            <div class="col-span-1">
                <div class="text-xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-white to-[#40e0d0] mb-6">GMA</div>
                <p class="text-base text-white/70 mb-6 leading-relaxed">The Global Mobile Association is the definitive body for the used mobile ecosystem, fostering leadership, standards, and global trade.</p>
                <div class="flex gap-4">
                    <a href="#" class="w-11 h-11 border border-white/20 rounded-xl flex items-center justify-center transition-all duration-300 shadow-sm hover:scale-110 hover:border-[#006a6a] hover:bg-[#006a6a]/10">
                        <span class="material-symbols-outlined text-white">share</span>
                    </a>
                    <a href="#" class="w-11 h-11 border border-white/20 rounded-xl flex items-center justify-center transition-all duration-300 shadow-sm hover:scale-110 hover:border-[#006a6a] hover:bg-[#006a6a]/10">
                        <span class="material-symbols-outlined text-white">alternate_email</span>
                    </a>
                </div>
            </div>
            <div>
                <h4 class="text-[13px] uppercase tracking-widest text-white mb-8 relative after:content-[''] after:absolute after:bottom-[-8px] after:left-0 after:w-8 after:h-[2px] after:bg-[#006a6a] font-semibold">Navigation</h4>
                <ul class="space-y-4">
                    @foreach(['About GMA', 'Who We Serve', 'Committees', 'Events', 'Research & Insights'] as $link)
                    <li class="hover:translate-x-1.5 transition-transform duration-200">
                        <a href="#" class="text-white/75 hover:text-[#40e0d0] transition-colors duration-300 font-medium">{{ $link }}</a>
                    </li>
                    @endforeach
                </ul>
            </div>
            <div>
                <h4 class="text-[13px] uppercase tracking-widest text-white mb-8 relative after:content-[''] after:absolute after:bottom-[-8px] after:left-0 after:w-8 after:h-[2px] after:bg-[#006a6a] font-semibold">Association</h4>
                <ul class="space-y-4">
                    @foreach(['Join GMA', 'Member Directory', 'Resource Library', 'Privacy Policy', 'Terms of Service'] as $link)
                    <li class="hover:translate-x-1.5 transition-transform duration-200">
                        <a href="#" class="text-white/75 hover:text-[#40e0d0] transition-colors duration-300 font-medium">{{ $link }}</a>
                    </li>
                    @endforeach
                </ul>
            </div>
            <div>
                <h4 class="text-[13px] uppercase tracking-widest text-white mb-8 relative after:content-[''] after:absolute after:bottom-[-8px] after:left-0 after:w-8 after:h-[2px] after:bg-[#006a6a] font-semibold">Stay Updated</h4>
                <p class="text-sm text-white/70 mb-4 leading-relaxed">Receive monthly insights and industry updates.</p>
                <form class="flex flex-col gap-3">
                    <input class="bg-white/10 border border-white/20 rounded-2xl px-5 py-3.5 focus:border-[#006a6a] focus:ring-1 focus:ring-[#006a6a]/20 outline-none transition-all duration-300 text-sm shadow-sm text-white placeholder-white/40" placeholder="Work Email" type="email">
                    <button type="submit" class="bg-[#006a6a] text-white font-label-md text-[13px] uppercase py-3.5 rounded-2xl transition-all duration-300 shadow-md font-semibold tracking-wider text-xs hover:scale-102 hover:bg-[#005353] hover:shadow-[0_8px_16px_-4px_rgba(0,106,106,0.3)] active:scale-98">
                        Subscribe
                    </button>
                </form>
            </div>
        </div>
        <div class="max-w-[1280px] mx-auto px-4 md:px-10 py-8 border-t border-white/10 text-center md:text-left relative z-10">
            <p class="text-base text-white/60">&copy; 2024 Global Mobile Association. All rights reserved.</p>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const founderCard = document.getElementById('founder-parallax');
            if (founderCard) {
                // Add a smooth transition specifically for transform
                founderCard.style.transition = 'transform 0.4s cubic-bezier(0.2, 0.8, 0.2, 1)';
                
                window.addEventListener('scroll', function() {
                    requestAnimationFrame(() => {
                        const parent = founderCard.parentElement;
                        const rect = parent.getBoundingClientRect();
                        
                        // 120px offset to account for navbar and breathing room
                        const offset = 120;
                        
                        if (rect.top < offset && rect.bottom > 0) {
                            // Move at 1:1 speed (equal with scrolling)
                            let yPos = offset - rect.top;
                            
                            // Go to the very bottom of the parent container
                            const maxTravel = rect.height - founderCard.offsetHeight;
                            if (maxTravel > 0) {
                                yPos = Math.max(0, Math.min(yPos, maxTravel));
                                founderCard.style.transform = `translateY(${yPos}px)`;
                            }
                        } else if (rect.top >= offset) {
                            // Reset when scrolled above
                            founderCard.style.transform = `translateY(0px)`;
                        }
                    });
                });
            }
        });
    </script>
</body>
</html>