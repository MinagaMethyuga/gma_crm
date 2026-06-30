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
    <style>
        /* Emil Kowalski & UI/UX Pro Max Variables */
        :root {
            --ease-out: cubic-bezier(0.23, 1, 0.32, 1);
            --ease-in-out: cubic-bezier(0.77, 0, 0.175, 1);
            --ease-elastic: cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        /* Glassmorphism Presets */
        .glass-card-dark {
            background: rgba(0, 20, 45, 0.55);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        
        .glass-card-light {
            background: rgba(255, 255, 255, 0.65);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(0, 106, 106, 0.08);
        }

        /* Ambient floating glow animation */
        @keyframes float-slow {
            0%, 100% { transform: translateY(0) scale(1) rotate(0deg); }
            50% { transform: translateY(-40px) scale(1.06) rotate(6deg); }
        }
        @keyframes float-slow-reverse {
            0%, 100% { transform: translateY(0) scale(1.06) rotate(0deg); }
            50% { transform: translateY(40px) scale(1) rotate(-6deg); }
        }
        .animate-float-slow {
            animation: float-slow 16s ease-in-out infinite;
        }
        .animate-float-slow-reverse {
            animation: float-slow-reverse 19s ease-in-out infinite;
        }

        /* Hover Sheen Sweep Effect */
        .hover-sheen {
            position: relative;
            overflow: hidden;
        }
        .hover-sheen::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -100%;
            width: 50%;
            height: 200%;
            background: linear-gradient(
                to right,
                rgba(255, 255, 255, 0) 0%,
                rgba(255, 255, 255, 0.25) 50%,
                rgba(255, 255, 255, 0) 100%
            );
            transform: rotate(30deg);
            transition: none;
            pointer-events: none;
            opacity: 0;
        }
        .hover-sheen:hover::after {
            transition: left 900ms var(--ease-out);
            left: 150%;
            opacity: 1;
        }

        /* Global UI Elements: Buttons & Nav */
        button, .nav-item, .emil-btn {
            transition: transform 180ms var(--ease-out), filter 200ms ease, opacity 200ms ease, box-shadow 200ms ease !important;
        }
        button:active, .nav-item:active, .emil-btn:active {
            transform: scale(0.96) !important;
        }

        /* Scroll Animation Triggers */
        .animate-on-scroll {
            opacity: 0;
            transform: translateY(35px) scale(0.97);
            transition: opacity 800ms var(--ease-out), transform 800ms var(--ease-out);
        }
        .animate-on-scroll.is-visible {
            opacity: 1;
            transform: translateY(0) scale(1);
        }

        /* Staggered Children Animations */
        .stagger-children > * {
            opacity: 0;
            transform: translateY(25px) scale(0.97);
            transition: opacity 700ms var(--ease-out), transform 700ms var(--ease-out);
        }
        .stagger-children.is-visible > *:nth-child(1) { transition-delay: 0ms; opacity: 1; transform: translateY(0) scale(1); }
        .stagger-children.is-visible > *:nth-child(2) { transition-delay: 75ms; opacity: 1; transform: translateY(0) scale(1); }
        .stagger-children.is-visible > *:nth-child(3) { transition-delay: 150ms; opacity: 1; transform: translateY(0) scale(1); }
        .stagger-children.is-visible > *:nth-child(4) { transition-delay: 225ms; opacity: 1; transform: translateY(0) scale(1); }
        .stagger-children.is-visible > *:nth-child(5) { transition-delay: 300ms; opacity: 1; transform: translateY(0) scale(1); }
        .stagger-children.is-visible > *:nth-child(6) { transition-delay: 375ms; opacity: 1; transform: translateY(0) scale(1); }
        
        /* 3D Flip Utilities */
        .preserve-3d { transform-style: preserve-3d; }
        .backface-hidden { backface-visibility: hidden; -webkit-backface-visibility: hidden; }
        .perspective-1000 { perspective: 1000px; }

        /* Clip-path Image Reveal */
        .emil-clip-reveal {
            clip-path: inset(0 0 100% 0);
            transition: clip-path 900ms var(--ease-out);
        }
        .emil-clip-reveal.is-visible {
            clip-path: inset(0 0 0 0);
        }

        @keyframes spin-slow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .animate-spin-slow {
            animation: spin-slow 8s linear infinite;
        }

        /* Accessibility: respect user preferences */
        @media (prefers-reduced-motion: reduce) {
            .animate-on-scroll,
            .stagger-children > *,
            .emil-clip-reveal,
            .hover-sheen::after {
                transition: none !important;
                transform: none !important;
                opacity: 1 !important;
                clip-path: none !important;
            }
        }
    </style>
</head>
<body class="overflow-x-hidden bg-[#f8fafd] text-[#1b1b18]">
    @include('components.page-transition')

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
        <section id="hero-section" class="relative min-h-[600px] flex items-center overflow-hidden pt-36 pb-28">
            <div class="absolute inset-0 z-0 bg-[#000e21]">
                <!-- High-fidelity mesh gradient overlay -->
                <div class="absolute inset-0 opacity-40 bg-[radial-gradient(at_0%_0%,rgba(64,224,208,0.3)_0px,transparent_50%),radial-gradient(at_100%_100%,rgba(0,106,106,0.4)_0px,transparent_50%),radial-gradient(at_50%_0%,rgba(0,144,144,0.2)_0px,transparent_50%)]"></div>
                <div class="absolute inset-0 bg-gradient-to-b from-transparent via-[#000e21]/80 to-[#000e21]"></div>
            </div>

            <!-- Hero ambient glow circles -->
            <div class="absolute top-[10%] left-[5%] w-[350px] h-[350px] rounded-full bg-[#006a6a]/15 blur-[90px] pointer-events-none animate-float-slow"></div>
            <div class="absolute bottom-[10%] right-[5%] w-[400px] h-[400px] rounded-full bg-[#40e0d0]/10 blur-[100px] pointer-events-none animate-float-slow-reverse"></div>
            
            <div class="relative z-10 max-w-[1280px] mx-auto px-4 md:px-10 w-full text-center mt-6 animate-on-scroll">
                <!-- Premium glass category pill badge -->
                <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-[#40e0d0]/10 border border-[#40e0d0]/25 text-[#40e0d0] font-bold text-xs uppercase tracking-[0.25em] mb-8 shadow-[0_0_15px_rgba(64,224,208,0.1)]">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#40e0d0] animate-pulse"></span> Who We Are
                </span>
                <h1 class="text-5xl sm:text-6xl md:text-7xl lg:text-[5.5rem] font-black tracking-tight leading-[1.05] mb-8 text-transparent bg-clip-text bg-gradient-to-r from-white via-[#f0fdfa] to-[#40e0d0] drop-shadow-[0_2px_15px_rgba(64,224,208,0.15)]">
                    About GMA
                </h1>
                <p class="text-lg md:text-xl text-white/90 max-w-3xl mx-auto leading-relaxed font-light tracking-wide">
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
            <div class="max-w-[1280px] mx-auto px-4 sm:px-6 md:px-10 relative">
                <!-- Glowing Backdrop Blobs for Glassmorphism Depth -->
                <div class="absolute top-1/2 left-1/4 -translate-y-1/2 w-80 h-80 rounded-full bg-[#006a6a]/8 blur-[90px] pointer-events-none"></div>
                <div class="absolute top-1/2 right-1/4 -translate-y-1/2 w-80 h-80 rounded-full bg-[#003c70]/8 blur-[90px] pointer-events-none"></div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12 relative z-30 -mt-12 stagger-children max-w-5xl mx-auto">
                    
                    <!-- Mission Card -->
                    <div class="relative w-full max-w-[320px] aspect-[5/7] mx-auto perspective-1000 group cursor-pointer opacity-0 translate-y-12 transition-all duration-1000 ease-[cubic-bezier(0.2,0.8,0.2,1)] observer-fade-in" onclick="openMVModal('mission', this)">
                        <div class="w-full h-full preserve-3d">
                            <!-- Front side -->
                            <div class="absolute inset-0 bg-gradient-to-br from-[#006a6a] via-[#007a7a] to-[#009090] shadow-[0_20px_40px_-15px_rgba(0,106,106,0.3)] rounded-3xl p-8 hover:-translate-y-4 hover:shadow-[0_40px_60px_-15px_rgba(0,106,106,0.5)] transition-all duration-700 overflow-hidden flex flex-col justify-center items-center backface-hidden border border-white/15">
                                
                                <!-- Ambient Glow -->
                                <div class="absolute -top-20 -right-20 w-48 h-48 bg-[#40e0d0]/20 rounded-full blur-[40px] group-hover:bg-[#40e0d0]/40 transition-colors duration-700 pointer-events-none"></div>

                                <!-- Center Icon -->
                                <div class="w-24 h-24 rounded-[2rem] bg-white/10 backdrop-blur-sm border border-white/20 flex items-center justify-center mb-8 relative group-hover:scale-110 transition-transform duration-700 group-hover:bg-white/20 text-white shadow-[0_8px_20px_rgba(0,0,0,0.1)]">
                                    <span class="material-symbols-outlined text-[3.5rem] group-hover:-rotate-12 transition-transform duration-500" style="font-variation-settings: 'FILL' 1;">flag</span>
                                </div>
                                
                                <h2 class="text-3xl md:text-4xl font-extrabold text-white tracking-tight mb-2 relative z-10">Mission</h2>
                                <p class="text-xs font-bold tracking-[0.25em] text-[#40e0d0] uppercase mb-8 relative z-10">Global Mobile</p>
                                
                                <div class="opacity-0 group-hover:opacity-100 transition-all duration-500 transform translate-y-4 group-hover:translate-y-0 absolute bottom-12 px-6 py-2.5 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-xs font-bold text-white tracking-wider uppercase flex items-center gap-2 shadow-lg">
                                    Click to view <span class="material-symbols-outlined text-[15px] animate-spin-slow">360</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Vision Card -->
                    <div class="relative w-full max-w-[320px] aspect-[5/7] mx-auto perspective-1000 group cursor-pointer opacity-0 translate-y-12 transition-all duration-1000 delay-200 ease-[cubic-bezier(0.2,0.8,0.2,1)] observer-fade-in" onclick="openMVModal('vision', this)">
                        <div class="w-full h-full preserve-3d">
                            <!-- Front side -->
                            <div class="absolute inset-0 bg-gradient-to-br from-[#001e40] via-[#002b4d] to-[#003c60] shadow-[0_20px_40px_-15px_rgba(0,30,64,0.3)] rounded-3xl p-8 hover:-translate-y-4 hover:shadow-[0_40px_60px_-15px_rgba(0,30,64,0.5)] transition-all duration-700 overflow-hidden flex flex-col justify-center items-center backface-hidden border border-white/10">
                                
                                <!-- Ambient Glow -->
                                <div class="absolute -top-20 -right-20 w-48 h-48 bg-[#006a6a]/30 rounded-full blur-[40px] group-hover:bg-[#006a6a]/50 transition-colors duration-700 pointer-events-none"></div>

                                <!-- Center Icon -->
                                <div class="w-24 h-24 rounded-[2rem] bg-white/10 backdrop-blur-sm border border-white/20 flex items-center justify-center mb-8 relative group-hover:scale-110 transition-transform duration-700 group-hover:bg-white/20 text-white shadow-[0_8px_20px_rgba(0,0,0,0.1)]">
                                    <span class="material-symbols-outlined text-[3.5rem] group-hover:-rotate-12 transition-transform duration-500" style="font-variation-settings: 'FILL' 1;">visibility</span>
                                </div>
                                
                                <h2 class="text-3xl md:text-4xl font-extrabold text-white tracking-tight mb-2 relative z-10">Vision</h2>
                                <p class="text-xs font-bold tracking-[0.25em] text-[#006a6a] uppercase mb-8 relative z-10">Global Mobile</p>
                                
                                <div class="opacity-0 group-hover:opacity-100 transition-all duration-500 transform translate-y-4 group-hover:translate-y-0 absolute bottom-12 px-6 py-2.5 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-xs font-bold text-white tracking-wider uppercase flex items-center gap-2 shadow-lg">
                                    Click to view <span class="material-symbols-outlined text-[15px] animate-spin-slow">360</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- Smooth arc divider into The Gap section -->
            <div class="absolute bottom-0 left-0 right-0 w-full overflow-hidden leading-[0] z-20">
                <svg viewBox="0 0 1440 92" preserveAspectRatio="none" class="w-full h-[57px] md:h-[92px] block">
                    <path d="M0,0 C360,90 1080,90 1440,0 L1440,92 L0,92 Z" fill="#006a6a"/>
                </svg>
            </div>
        </section>

        <!-- Why the Used Mobile Ecosystem Needs GMA -->
        <section class="py-24 bg-gradient-to-br from-[#006a6a] via-[#009090] to-[#003c70] text-white relative pb-[120px] -mt-[2px] overflow-hidden">
            <div class="absolute inset-0 z-0 pointer-events-none">
                <img src="/gma_mission.png" alt="Professionals collaborating" class="w-full h-full object-cover opacity-25 mix-blend-overlay saturate-125">
                <div class="absolute inset-0 bg-gradient-to-br from-[#006a6a]/90 via-[#009090]/85 to-[#003c70]/90"></div>
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
                    <div class="animate-on-scroll glass-card-dark p-6 sm:p-8 md:p-10 rounded-[2.5rem] border border-red-500/10 shadow-2xl relative overflow-hidden group hover:border-red-500/35 transition-all duration-500 flex flex-col hover:shadow-[0_30px_60px_-15px_rgba(239,68,68,0.12)]">
                        <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-red-500/5 rounded-full blur-[60px] group-hover:bg-red-500/10 group-hover:scale-110 transition-all duration-700 pointer-events-none"></div>
                        
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-red-500/10 border border-red-500/25 text-red-400 text-xs font-bold uppercase tracking-widest w-max mb-6 sm:mb-8 relative z-10">
                            <span class="material-symbols-outlined text-sm">warning</span> The Problem
                        </div>
                        
                        <h3 class="text-xl sm:text-2xl font-bold mb-6 sm:mb-8 text-white relative z-10 leading-snug">The industry moves fast, and isolation is expensive.</h3>
                        
                        <div class="space-y-3 sm:space-y-4 relative z-10 flex-1 stagger-children">
                            <div class="flex gap-3 sm:gap-4 items-start bg-white/[0.02] p-4 sm:p-5 rounded-2xl border border-white/5 hover:border-red-500/20 hover:bg-white/[0.04] transition-all duration-300">
                                <div class="mt-1 w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-red-500/15 border border-red-500/25 flex items-center justify-center shrink-0 text-red-400">
                                    <span class="material-symbols-outlined text-lg sm:text-xl">speed</span>
                                </div>
                                <div class="min-w-0">
                                    <h4 class="text-base sm:text-lg font-semibold mb-1 text-white">Rapid Market Shifts</h4>
                                    <p class="text-white/60 text-xs sm:text-sm leading-relaxed">Technology continues to change, customer expectations keep rising, and global trade evolves daily.</p>
                                </div>
                            </div>
                            <div class="flex gap-3 sm:gap-4 items-start bg-white/[0.02] p-4 sm:p-5 rounded-2xl border border-white/5 hover:border-red-500/20 hover:bg-white/[0.04] transition-all duration-300">
                                <div class="mt-1 w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-red-500/15 border border-red-500/25 flex items-center justify-center shrink-0 text-red-400">
                                    <span class="material-symbols-outlined text-lg sm:text-xl">rule</span>
                                </div>
                                <div class="min-w-0">
                                    <h4 class="text-base sm:text-lg font-semibold mb-1 text-white">Complex Compliance</h4>
                                    <p class="text-white/60 text-xs sm:text-sm leading-relaxed">Requirements are becoming more complex, putting pressure on companies to grow profitably while developing stronger teams.</p>
                                </div>
                            </div>
                            <div class="flex gap-3 sm:gap-4 items-start bg-white/[0.02] p-4 sm:p-5 rounded-2xl border border-white/5 hover:border-red-500/20 hover:bg-white/[0.04] transition-all duration-300">
                                <div class="mt-1 w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-red-500/15 border border-red-500/25 flex items-center justify-center shrink-0 text-red-400">
                                    <span class="material-symbols-outlined text-lg sm:text-xl">person_off</span>
                                </div>
                                <div class="min-w-0">
                                    <h4 class="text-base sm:text-lg font-semibold mb-1 text-white">Working in Silos</h4>
                                    <p class="text-white/60 text-xs sm:text-sm leading-relaxed">Too often, businesses in this space are working through similar challenges on their own, without access to shared insight or peer connection.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- The Solution Card (Right) -->
                    <div class="animate-on-scroll glass-card-dark p-6 sm:p-8 md:p-10 rounded-[2.5rem] border border-[#40e0d0]/20 shadow-2xl relative overflow-hidden group hover:border-[#40e0d0]/45 transition-all duration-500 flex flex-col hover:shadow-[0_30px_60px_-15px_rgba(64,224,208,0.1)]">
                        <div class="absolute -top-24 -right-24 w-64 h-64 bg-[#40e0d0]/5 rounded-full blur-[60px] group-hover:bg-[#40e0d0]/10 group-hover:scale-110 transition-all duration-700 pointer-events-none"></div>
                        
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-[#40e0d0]/10 border border-[#40e0d0]/25 text-[#40e0d0] text-xs font-bold uppercase tracking-widest w-max mb-6 sm:mb-8 relative z-10">
                            <span class="material-symbols-outlined text-sm">check_circle</span> The Solution
                        </div>

                        <h3 class="text-xl sm:text-2xl font-bold mb-3 sm:mb-4 relative z-10 text-white">GMA was created to fill the gap.</h3>
                        
                        <p class="text-white/70 mb-6 sm:mb-8 font-light leading-relaxed relative z-10 text-sm sm:text-base">
                            The used mobile industry does not need more noise. It needs practical resources, better leadership development, and a year-round voice.
                        </p>

                        <div class="grid grid-cols-2 gap-3 sm:gap-4 relative z-10 flex-1 content-start stagger-children">
                            <div class="bg-white/[0.02] border border-white/5 p-4 sm:p-5 rounded-2xl hover:-translate-y-1 hover:border-[#40e0d0]/20 hover:bg-white/[0.04] transition-all duration-300 shadow-lg">
                                <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-[#40e0d0]/15 flex items-center justify-center mb-2 sm:mb-3">
                                    <span class="material-symbols-outlined text-[#40e0d0] text-lg sm:text-xl">school</span>
                                </div>
                                <h5 class="font-bold text-white text-sm sm:text-base mb-0.5">Education</h5>
                                <p class="text-[10px] sm:text-xs text-white/60 leading-relaxed">Consistent webinars &amp; resources</p>
                            </div>
                            <div class="bg-white/[0.02] border border-white/5 p-4 sm:p-5 rounded-2xl hover:-translate-y-1 hover:border-[#40e0d0]/20 hover:bg-white/[0.04] transition-all duration-300 shadow-lg">
                                <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-[#40e0d0]/15 flex items-center justify-center mb-2 sm:mb-3">
                                    <span class="material-symbols-outlined text-[#40e0d0] text-lg sm:text-xl">groups</span>
                                </div>
                                <h5 class="font-bold text-white text-sm sm:text-base mb-0.5">Committees</h5>
                                <p class="text-[10px] sm:text-xs text-white/60 leading-relaxed">Meaningful industry collaboration</p>
                            </div>
                            <div class="bg-white/[0.02] border border-white/5 p-4 sm:p-5 rounded-2xl hover:-translate-y-1 hover:border-[#40e0d0]/20 hover:bg-white/[0.04] transition-all duration-300 shadow-lg">
                                <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-[#40e0d0]/15 flex items-center justify-center mb-2 sm:mb-3">
                                    <span class="material-symbols-outlined text-[#40e0d0] text-lg sm:text-xl">military_tech</span>
                                </div>
                                <h5 class="font-bold text-white text-sm sm:text-base mb-0.5">Leadership</h5>
                                <p class="text-[10px] sm:text-xs text-white/60 leading-relaxed">Developing talent year-round</p>
                            </div>
                            <div class="bg-white/[0.02] border border-white/5 p-4 sm:p-5 rounded-2xl hover:-translate-y-1 hover:border-[#40e0d0]/20 hover:bg-white/[0.04] transition-all duration-300 shadow-lg">
                                <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-[#40e0d0]/15 flex items-center justify-center mb-2 sm:mb-3">
                                    <span class="material-symbols-outlined text-[#40e0d0] text-lg sm:text-xl">forum</span>
                                </div>
                                <h5 class="font-bold text-white text-sm sm:text-base mb-0.5">Connection</h5>
                                <p class="text-[10px] sm:text-xs text-white/60 leading-relaxed">Bridging segments between events</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            
            <!-- Smooth arc divider into The Gap section -->
            <div class="absolute bottom-0 left-0 right-0 w-full overflow-hidden leading-[0] z-20">
                <svg viewBox="0 0 1440 90" preserveAspectRatio="none" class="w-full h-[55px] md:h-[90px] block">
                    <path d="M0,90 L1440,90 L1440,0 L0,0 Z" fill="#001e40"/>
                </svg>
            </div>
        </section>

        <!-- The Gap GMA Fills -->
        <section class="py-24 bg-gradient-to-br from-[#001e40] via-[#003c70] to-[#006a6a] text-white relative pb-[120px] -mt-[2px] overflow-hidden">
            <div class="absolute inset-0 z-0 pointer-events-none">
                <img src="/gma_network.png" alt="Global Network" class="w-full h-full object-cover opacity-25 mix-blend-screen saturate-150">
                <div class="absolute inset-0 bg-gradient-to-br from-[#001e40]/90 via-[#003c70]/80 to-[#006a6a]/85"></div>
            </div>
            <div class="absolute inset-0 bg-mesh-glow opacity-30 pointer-events-none z-0"></div>
            
            <div class="max-w-[1280px] mx-auto px-4 sm:px-6 md:px-10 relative z-10">
                
                <div class="animate-on-scroll text-center max-w-4xl mx-auto mb-16">
                    <span class="text-[#40e0d0] font-semibold text-[13px] uppercase tracking-[0.2em] mb-4 inline-block relative after:content-[''] after:absolute after:bottom-[-6px] after:left-1/2 after:-translate-x-1/2 after:w-16 after:h-[2px] after:bg-[#40e0d0]">
                        The Opportunity
                    </span>
                    <h2 class="text-3xl md:text-5xl font-bold text-white mb-6 leading-tight drop-shadow-md">The Gap GMA Fills</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 items-stretch stagger-children">
                    
                    <!-- Card 1 -->
                    <div class="glass-card-dark hover-sheen p-6 sm:p-8 md:p-10 rounded-[2.5rem] border border-white/10 hover:border-[#40e0d0]/30 shadow-xl hover:shadow-[0_20px_50px_rgba(64,224,208,0.1)] transition-all duration-500 flex flex-col justify-center group">
                        <div class="w-12 h-12 rounded-xl bg-[#40e0d0]/10 border border-[#40e0d0]/20 flex items-center justify-center mb-6 shrink-0 text-[#40e0d0] group-hover:scale-110 group-hover:bg-[#40e0d0]/20 transition-all duration-300">
                            <span class="material-symbols-outlined text-2xl">event_busy</span>
                        </div>
                        <p class="text-base sm:text-[17px] text-white/85 leading-relaxed font-light">
                            The used mobile industry has strong events, experienced operators, respected service providers, and companies doing important work across the global market. What has been missing is a consistent year-round association focused on bringing these segments together, supporting their growth, and helping the industry stay connected between major events.
                        </p>
                    </div>

                    <!-- Card 2 -->
                    <div class="glass-card-dark hover-sheen p-6 sm:p-8 md:p-10 rounded-[2.5rem] border border-white/10 hover:border-[#40e0d0]/30 shadow-xl hover:shadow-[0_20px_50px_rgba(64,224,208,0.1)] transition-all duration-500 flex flex-col justify-center group">
                        <div class="w-12 h-12 rounded-xl bg-[#40e0d0]/10 border border-[#40e0d0]/20 flex items-center justify-center mb-6 shrink-0 text-[#40e0d0] group-hover:scale-110 group-hover:bg-[#40e0d0]/20 transition-all duration-300">
                            <span class="material-symbols-outlined text-2xl">handshake</span>
                        </div>
                        <p class="text-base sm:text-[17px] text-white/85 leading-relaxed font-light">
                            GMA fills that gap by creating a dedicated platform for education, resources, collaboration, leadership development, business growth, and industry connection. The association is designed to support the companies, leaders, vendors, and professionals working across the used mobile ecosystem with practical value they can use throughout the year.
                        </p>
                    </div>

                    <!-- Card 3 -->
                    <div class="glass-card-dark hover-sheen p-6 sm:p-8 md:p-10 rounded-[2.5rem] border border-white/10 hover:border-[#40e0d0]/30 shadow-xl hover:shadow-[0_20px_50px_rgba(64,224,208,0.1)] transition-all duration-500 flex flex-col justify-center group">
                        <div class="w-12 h-12 rounded-xl bg-[#40e0d0]/10 border border-[#40e0d0]/20 flex items-center justify-center mb-6 shrink-0 text-[#40e0d0] group-hover:scale-110 group-hover:bg-[#40e0d0]/20 transition-all duration-300">
                            <span class="material-symbols-outlined text-2xl">forum</span>
                        </div>
                        <p class="text-base sm:text-[17px] text-white/85 leading-relaxed font-light">
                            Instead of only gathering periodically, GMA gives the industry a place to continue important conversations, address shared challenges, develop talent, support innovation, create business opportunities, and build stronger relationships across the ecosystem.
                        </p>
                    </div>

                    <!-- Card 4 -->
                    <div class="glass-card-dark hover-sheen p-6 sm:p-8 md:p-10 rounded-[2.5rem] border border-white/15 hover:border-[#40e0d0]/40 shadow-xl hover:shadow-[0_20px_50px_rgba(64,224,208,0.12)] transition-all duration-500 flex flex-col justify-center bg-gradient-to-br from-[#006a6a]/15 to-[#001e40]/40 group">
                        <div class="w-12 h-12 rounded-xl bg-[#40e0d0]/20 border border-[#40e0d0]/40 flex items-center justify-center mb-6 shrink-0 text-[#40e0d0] group-hover:scale-110 group-hover:bg-[#40e0d0]/30 transition-all duration-300">
                            <span class="material-symbols-outlined text-2xl">track_changes</span>
                        </div>
                        <p class="text-base sm:text-[17px] text-white/95 leading-relaxed font-medium">
                            The goal is not to duplicate what already exists. The goal is to provide the missing year-round structure that helps the used mobile industry become more connected, better supported, and more prepared for the opportunities ahead.
                        </p>
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
                        <div id="founder-parallax" class="text-center lg:text-left glass-card-light hover-sheen p-8 rounded-[2rem] shadow-lg border border-[#006a6a]/15 hover:shadow-2xl hover:border-[#006a6a]/30 transition-all duration-300 will-change-transform">
                            <img src="/Bob-updated-profile-photo-2025.jpg" alt="Bob Lafon" class="emil-clip-reveal w-48 h-48 sm:w-56 sm:h-56 rounded-3xl object-cover shadow-xl mx-auto lg:mx-0 border-4 border-white mb-6">
                            <h3 class="text-2xl font-bold text-[#001e40] mb-2">Bob Lafon</h3>
                            <p class="text-[#006a6a] font-bold uppercase tracking-wider text-xs mb-4">Founder & CEO</p>
                        </div>
                    </div>
                    <div class="lg:col-span-8">
                        <!-- Vertical Timeline Container -->
                        <div class="relative border-l-2 border-teal-500/20 pl-8 sm:pl-12 ml-4 sm:ml-6 md:ml-0 space-y-16 stagger-children">
                    
                    <!-- Timeline Node 1 -->
                    <div class="relative group">
                        <!-- Node Marker -->
                        <div class="absolute -left-[43px] sm:-left-[59px] top-1.5 w-6 h-6 rounded-full bg-[#40e0d0] border-4 border-white shadow-md group-hover:scale-125 group-hover:shadow-[0_0_15px_rgba(64,224,208,0.8)] transition-all duration-300"></div>
                        
                        <div class="glass-card-light hover-sheen p-6 sm:p-8 rounded-[2rem] shadow-md border border-[#006a6a]/10 hover:border-[#006a6a]/25 hover:shadow-xl transition-all duration-300">
                            <span class="text-xs font-bold text-[#006a6a] mb-2 block tracking-widest uppercase">2021</span>
                            <h3 class="text-2xl font-bold text-[#001e40] mb-4">Recognizing an Underserved Market</h3>
                            <p class="text-[#475569] text-base sm:text-lg leading-relaxed mb-4">
                                In 2021, Bob Lafon saw an underserved segment of the wireless mobile ecosystem that needed its own platform.
                            </p>
                            <p class="text-[#475569] text-base sm:text-lg leading-relaxed">
                                After moderating a panel discussion at an industry trade show, Bob spoke with the event promoter about the opportunity he saw. Larger industry events served important purposes, but the secondary mobile ecosystem did not have a dedicated gathering built around its unique needs, challenges, companies, and opportunities.
                            </p>
                        </div>
                    </div>

                    <!-- Timeline Node 2 -->
                    <div class="relative group">
                        <div class="absolute -left-[43px] sm:-left-[59px] top-1.5 w-6 h-6 rounded-full bg-[#006a6a] border-4 border-white shadow-md group-hover:scale-125 group-hover:bg-[#40e0d0] group-hover:shadow-[0_0_15px_rgba(64,224,208,0.8)] transition-all duration-300"></div>
                        
                        <div class="glass-card-dark hover-sheen text-white p-6 sm:p-8 rounded-[2rem] shadow-lg border border-white/10 hover:border-[#40e0d0]/30 hover:shadow-2xl transition-all duration-300">
                            <span class="material-symbols-outlined text-[#40e0d0] text-4xl mb-4 opacity-75 block">format_quote</span>
                            <p class="text-xl md:text-2xl font-light italic leading-snug mb-6 text-teal-50">
                                "The used mobile ecosystem was not a small side category. It was a growing, global industry made up of operators, innovators, service providers, technology companies, and leaders who needed a place of their own."
                            </p>
                            <p class="text-white/70 text-sm sm:text-base leading-relaxed">
                                That conversation quickly turned into action. Within minutes, a camera was rolling as Bob recorded a short announcement. Ten months later, Mobile Disrupt was born. Not everyone believed it would work, but it quickly gained momentum and established itself as the premier event serving the secondary mobile ecosystem.
                            </p>
                        </div>
                    </div>

                    <!-- Timeline Node 3 -->
                    <div class="relative group">
                        <div class="absolute -left-[43px] sm:-left-[59px] top-1.5 w-6 h-6 rounded-full bg-[#009090] border-4 border-white shadow-md group-hover:scale-125 group-hover:shadow-[0_0_15px_rgba(64,224,208,0.8)] transition-all duration-300"></div>
                        
                        <div class="glass-card-light hover-sheen p-6 sm:p-8 rounded-[2rem] shadow-md border border-[#006a6a]/10 hover:border-[#006a6a]/25 hover:shadow-xl transition-all duration-300">
                            <span class="text-xs font-bold text-[#006a6a] mb-2 block tracking-widest uppercase">TODAY</span>
                            <h3 class="text-2xl font-bold text-[#001e40] mb-4">The Creation of GMA</h3>
                            <p class="text-[#475569] text-base sm:text-lg leading-relaxed mb-4">
                                The creation of the Global Mobile Association follows that same pattern. Bob once again looked across the industry and saw an important gap.
                            </p>
                            <p class="text-[#475569] text-base sm:text-lg leading-relaxed mb-4">
                                While major events bring the ecosystem together at key moments, the used mobile industry also needs year-round support, education, leadership development, business resources, advocacy, and meaningful connection between those events. GMA was founded to serve that need.
                            </p>
                            <p class="text-[#475569] text-base sm:text-lg leading-relaxed">
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
        <section class="py-28 bg-gradient-to-r from-[#f0fdfa]/40 via-[#eff6ff]/50 to-[#eef2ff]/40 relative overflow-hidden -mt-[2px]">
            <div class="absolute inset-0 opacity-50 bg-[radial-gradient(at_0%_100%,rgba(64,224,208,0.1)_0px,transparent_40%),radial-gradient(at_100%_0%,rgba(0,106,106,0.1)_0px,transparent_40%)]"></div>
            <div class="absolute bottom-[-10%] left-[-10%] w-[400px] h-[400px] rounded-full bg-[#006a6a]/5 blur-[120px] pointer-events-none animate-float-slow"></div>
            
            <div class="max-w-[1280px] mx-auto px-4 sm:px-6 md:px-10 text-center relative z-10">
                <div class="animate-on-scroll max-w-4xl mx-auto glass-card-light p-8 md:p-16 rounded-[3rem] shadow-2xl relative overflow-hidden group hover:border-[#006a6a]/20 transition-all duration-500">
                    <div class="absolute -top-32 -left-32 w-64 h-64 bg-[#40e0d0]/5 rounded-full blur-[65px] pointer-events-none group-hover:scale-110 transition-all duration-700"></div>
                    <div class="absolute -bottom-32 -right-32 w-64 h-64 bg-[#006a6a]/5 rounded-full blur-[65px] pointer-events-none group-hover:scale-110 transition-all duration-700"></div>
                    
                    <h2 class="relative z-10 text-4xl sm:text-5xl md:text-6xl font-black text-transparent bg-clip-text bg-gradient-to-br from-[#001e40] via-[#00385e] to-[#006a6a] mb-8 leading-[1.1] tracking-tight">
                        Be Part of Building a Stronger Industry
                    </h2>
                    
                    <p class="relative z-10 text-base sm:text-lg md:text-xl text-[#475569] mb-12 leading-relaxed max-w-3xl mx-auto font-light">
                        The used mobile ecosystem is growing, and the companies shaping its future deserve a stronger platform. GMA gives you a place to stay engaged, access resources, and build relationships year-round.
                    </p>
                    
                    <div class="relative z-10 flex flex-col sm:flex-row justify-center gap-6 items-center">
                        <button class="w-full sm:w-auto bg-gradient-to-r from-[#001e40] to-[#006a6a] text-white font-bold text-sm uppercase tracking-widest px-12 py-5 rounded-full shadow-lg hover:scale-[1.03] hover:shadow-[0_15px_30px_-5px_rgba(0,106,106,0.35)] transition-all duration-300">
                            Join GMA
                        </button>
                        <button class="w-full sm:w-auto bg-white hover:bg-slate-50 text-[#001e40] border border-[#001e40]/25 font-bold text-sm uppercase tracking-widest px-12 py-5 rounded-full shadow-md hover:scale-[1.03] transition-all duration-300">
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

    <!-- Mission & Vision 3D Flip Modal -->
    <div id="mv-modal" class="fixed inset-0 z-[100] pointer-events-none flex items-center justify-center">
        <!-- Backdrop -->
        <div id="mv-backdrop" class="absolute inset-0 bg-white/30 backdrop-blur-md opacity-0 transition-opacity duration-700 ease-out" onclick="closeMVModal()"></div>
        
        <!-- Modal Card Wrapper -->
        <div id="mv-card-wrapper" class="relative perspective-1000 pointer-events-none">
            <div id="mv-card-inner" class="w-full h-full preserve-3d opacity-0 cursor-pointer" style="transform: rotateY(0deg) scale(1);" onclick="closeMVModal()">
                
                <!-- Front side (matches the grid card visually during transit) -->
                <div id="mv-front" class="absolute inset-0 glass-card-light p-8 md:p-12 rounded-3xl shadow-[0_30px_60px_-15px_rgba(0,106,106,0.25)] border border-[#006a6a]/20 flex flex-col items-center justify-center text-center backface-hidden">
                    <div id="mv-front-icon-container" class="w-20 h-20 rounded-2xl bg-gradient-to-br from-[#006a6a] to-[#009a9a] text-white flex items-center justify-center mb-6 shadow-lg">
                        <span id="mv-front-icon" class="material-symbols-outlined text-4xl">flag</span>
                    </div>
                    <h2 id="mv-front-title" class="text-3xl md:text-4xl font-black text-[#001e40] mb-4">Mission</h2>
                    <div class="text-sm font-semibold text-[#006a6a] flex items-center gap-1">
                        Click to view our <span id="mv-front-label">mission</span> <span class="material-symbols-outlined text-sm">360</span>
                    </div>
                </div>

                <!-- Back side (The Description) -->
                <div id="mv-back" class="absolute inset-0 bg-gradient-to-br from-[#001e40] to-[#003c70] text-white p-8 md:p-12 rounded-3xl shadow-[0_30px_60px_-15px_rgba(0,0,0,0.5)] flex flex-col items-center justify-center text-center backface-hidden [transform:rotateY(180deg)] overflow-hidden">
                    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(circle_at_center,rgba(255,255,255,0.8)_0%,transparent_100%)] pointer-events-none"></div>
                    <div id="mv-back-icon-container" class="relative z-10 w-16 h-16 rounded-2xl bg-white/10 text-white flex flex-shrink-0 items-center justify-center mb-4 shadow-lg">
                        <span id="mv-back-icon" class="material-symbols-outlined text-3xl">flag</span>
                    </div>
                    <h2 id="mv-back-title" class="relative z-10 text-2xl font-black mb-4 text-white">Mission</h2>
                    <p id="mv-back-desc" class="relative z-10 text-[15px] md:text-[17px] text-white/90 leading-relaxed font-light">
                        <!-- description here -->
                    </p>
                    <!-- Visual cue that it's clickable -->
                    <div class="absolute bottom-6 left-0 right-0 text-center text-white/40 text-[11px] font-semibold uppercase tracking-widest animate-pulse pointer-events-none">
                        Click anywhere to close
                    </div>
                </div>
                
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Intersection Observer for Emil Kowalski Animations
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: "-50px"
            });

            document.querySelectorAll('.animate-on-scroll, .stagger-children, .emil-clip-reveal').forEach(el => {
                observer.observe(el);
            });

            const mvData = {
                mission: {
                    title: 'Mission',
                    label: 'mission',
                    icon: 'flag',
                    desc: 'The Global Mobile Association exists to serve the global used mobile ecosystem by bringing members together year-round through education, resources, leadership development, advocacy, business support, and meaningful industry connection.',
                    frontBg: 'from-[#006a6a] to-[#009a9a]',
                    backBg: 'from-[#001e40] to-[#003c70]'
                },
                vision: {
                    title: 'Vision',
                    label: 'vision',
                    icon: 'visibility',
                    desc: 'Our vision is to become the trusted global association for the used mobile ecosystem, helping members build stronger businesses, develop stronger leaders, create stronger connections, and give the industry the voice and support it deserves.',
                    frontBg: 'from-[#001e40] to-[#003c70]',
                    backBg: 'from-[#006a6a] to-[#009a9a]'
                }
            };

            window.openMVModal = function(type, cardEl) {
                const frontFace = cardEl.querySelector('.backface-hidden');
                const rect = frontFace.getBoundingClientRect();
                const data = mvData[type];
                
                // Set text and icons
                document.getElementById('mv-front-title').textContent = data.title;
                document.getElementById('mv-front-label').textContent = data.label;
                document.getElementById('mv-front-icon').textContent = data.icon;
                document.getElementById('mv-back-title').textContent = data.title;
                document.getElementById('mv-back-icon').textContent = data.icon;
                document.getElementById('mv-back-desc').textContent = data.desc;
                
                // Set gradients
                document.getElementById('mv-front-icon-container').className = `w-20 h-20 rounded-2xl bg-gradient-to-br ${data.frontBg} text-white flex items-center justify-center mb-6 shadow-lg`;
                document.getElementById('mv-back').className = `absolute inset-0 bg-gradient-to-br ${data.backBg} text-white p-6 md:p-12 rounded-3xl shadow-[0_30px_60px_-15px_rgba(0,0,0,0.5)] flex flex-col items-center justify-center text-center backface-hidden [transform:rotateY(180deg)] overflow-hidden`;

                const modal = document.getElementById('mv-modal');
                const backdrop = document.getElementById('mv-backdrop');
                const wrapper = document.getElementById('mv-card-wrapper');
                const inner = document.getElementById('mv-card-inner');
                
                modal.classList.remove('pointer-events-none');
                wrapper.classList.remove('pointer-events-none');
                wrapper.classList.add('pointer-events-auto');
                
                // Hide original card temporarily
                cardEl.style.opacity = '0';
                cardEl.setAttribute('data-is-animating', 'true');
                
                // Calculate position relative to viewport center
                const centerX = window.innerWidth / 2;
                const centerY = window.innerHeight / 2;
                const startX = (rect.left + rect.width / 2) - centerX;
                const startY = (rect.top + rect.height / 2) - centerY;
                
                // 1. Initial State: At original position, un-flipped
                wrapper.style.transition = 'none';
                inner.style.transition = 'none';
                
                // Start exactly at the size of the grid card
                wrapper.style.width = rect.width + 'px';
                wrapper.style.height = rect.height + 'px';
                
                inner.style.transform = `translate(${startX}px, ${startY}px) rotateY(0deg)`;
                inner.style.opacity = '1';
                
                // Force reflow
                void inner.offsetWidth;
                
                // 2. Animate to Center, Flip, and Morph Size
                requestAnimationFrame(() => {
                    requestAnimationFrame(() => {
                        backdrop.classList.remove('opacity-0');
                        backdrop.classList.add('opacity-100');
                        
                        const transitionEase = '1000ms cubic-bezier(0.77, 0, 0.175, 1)';
                        wrapper.style.transition = `width ${transitionEase}, height ${transitionEase}`;
                        inner.style.transition = `transform ${transitionEase}`;
                        
                        // Morph to an ideal beautiful modal size to fit the content perfectly
                        const finalWidth = Math.min(window.innerWidth - 32, 550);
                        const finalHeight = Math.min(window.innerHeight - 32, 450);
                        
                        wrapper.style.width = finalWidth + 'px';
                        wrapper.style.height = finalHeight + 'px';
                        
                        inner.style.transform = `translate(0px, 0px) rotateY(180deg)`;
                    });
                });
            };

            window.closeMVModal = function() {
                const modal = document.getElementById('mv-modal');
                const backdrop = document.getElementById('mv-backdrop');
                const wrapper = document.getElementById('mv-card-wrapper');
                const inner = document.getElementById('mv-card-inner');
                const cardEl = document.querySelector('[data-is-animating="true"]');
                
                if (!cardEl) return;
                
                backdrop.classList.remove('opacity-100');
                backdrop.classList.add('opacity-0');
                
                const rect = cardEl.getBoundingClientRect();
                const centerX = window.innerWidth / 2;
                const centerY = window.innerHeight / 2;
                const endX = (rect.left + rect.width / 2) - centerX;
                const endY = (rect.top + rect.height / 2) - centerY;
                
                const transitionEase = '1000ms cubic-bezier(0.77, 0, 0.175, 1)';
                wrapper.style.transition = `width ${transitionEase}, height ${transitionEase}`;
                inner.style.transition = `transform ${transitionEase}`;
                
                // Morph back to original grid card size
                wrapper.style.width = rect.width + 'px';
                wrapper.style.height = rect.height + 'px';
                
                // Animate back to original position and un-flip
                inner.style.transform = `translate(${endX}px, ${endY}px) rotateY(0deg)`;
                
                setTimeout(() => {
                    cardEl.style.opacity = '1';
                    cardEl.removeAttribute('data-is-animating');
                    inner.style.opacity = '0';
                    modal.classList.add('pointer-events-none');
                    wrapper.classList.remove('pointer-events-auto');
                    wrapper.classList.add('pointer-events-none');
                }, 1000);
            };

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