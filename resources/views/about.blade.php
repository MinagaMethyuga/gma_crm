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

    @include('components.public-header', ['active' => 'about'])

    <main class="pt-0 relative overflow-hidden bg-[#f8fafd]">

        <!-- Ambient floating glow circles -->
        <div class="absolute top-[-10%] left-[-10%] w-[500px] h-[500px] rounded-full bg-[#006a6a]/8 blur-[120px] pointer-events-none animate-float-slow"></div>
        <div class="absolute top-[20%] right-[-10%] w-[600px] h-[600px] rounded-full bg-[#009090]/20 blur-[150px] pointer-events-none animate-float-slow-reverse"></div>
        <div class="absolute top-[50%] left-[20%] w-[450px] h-[450px] rounded-full bg-[#40e0d0]/15 blur-[130px] pointer-events-none animate-float-slow"></div>

        <!-- Hero Section -->
        <section id="hero-section" class="relative min-h-[600px] flex items-center overflow-hidden pt-36 pb-28">
            <div class="absolute inset-0 z-0 bg-gradient-to-br from-[#004070] via-[#005c94] to-[#007ba8]">
                <!-- High-fidelity mesh gradient overlay with vibrant glowing brand colors -->
                <div class="absolute inset-0 opacity-40 bg-[radial-gradient(at_0%_0%,rgba(64,224,208,0.35)_0px,transparent_50%),radial-gradient(at_100%_100%,rgba(0,106,106,0.45)_0px,transparent_50%),radial-gradient(at_50%_0%,rgba(0,144,144,0.25)_0px,transparent_50%)]"></div>
                <div class="absolute inset-0 bg-gradient-to-b from-transparent via-[#004070]/60 to-[#004070]"></div>
            </div>

            <!-- Hero ambient glow circles -->
            <div class="absolute top-[10%] left-[5%] w-[350px] h-[350px] rounded-full bg-[#006a6a]/20 blur-[90px] pointer-events-none animate-float-slow"></div>
            <div class="absolute bottom-[10%] right-[5%] w-[400px] h-[400px] rounded-full bg-[#40e0d0]/15 blur-[100px] pointer-events-none animate-float-slow-reverse"></div>
            
            <div class="relative z-10 max-w-[1280px] mx-auto px-4 md:px-10 w-full text-center mt-6 animate-on-scroll">
                <!-- Premium glass category pill badge -->
                <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-[#40e0d0]/10 border border-[#40e0d0]/25 text-[#40e0d0] font-bold text-xs uppercase tracking-[0.25em] mb-8 shadow-[0_0_15px_rgba(64,224,208,0.1)]">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#40e0d0] animate-pulse"></span> Who We Are
                </span>
                <h1 class="text-5xl sm:text-6xl md:text-7xl lg:text-[5.5rem] font-black tracking-tight leading-[1.05] mb-8 text-transparent bg-clip-text bg-gradient-to-r from-white via-[#f0fdfa] to-[#40e0d0] drop-shadow-[0_2px_15px_rgba(64,224,208,0.15)]">
                    About GMA
                </h1>
                <p class="text-lg md:text-xl text-white/95 max-w-3xl mx-auto leading-relaxed font-light tracking-wide">
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

        <!-- GSAP Pinned Mission & Vision Sequence -->
        <section id="mv-pinned-container" class="h-screen w-full bg-[#f0fdfa] relative overflow-hidden -mt-[2px]">
            <!-- Static Fallback for Reduced Motion -->
            <div class="gs-fallback absolute inset-0 hidden overflow-y-auto pt-24 pb-32 bg-[#f0fdfa] z-50">
                <div class="max-w-[1280px] mx-auto px-4 md:px-10 flex flex-col gap-24">
                    <div class="flex flex-col md:flex-row items-center gap-12">
                        <div class="flex-1 text-center md:text-left">
                            <span class="text-[#006a6a] font-bold text-[13px] uppercase tracking-widest mb-4 inline-block">Mission</span>
                            <h2 class="text-4xl md:text-5xl font-black text-[#001e40] mb-6 leading-tight tracking-tight">Our Mission</h2>
                            <p class="text-lg md:text-xl text-[#475569] leading-relaxed">To connect and empower the global used mobile ecosystem by creating trusted opportunities for members to grow stronger businesses and lasting relationships.</p>
                        </div>
                        <div class="shrink-0 w-40 h-40 rounded-full bg-white/60 border-4 border-white shadow-[0_20px_50px_rgba(0,106,106,0.15)] flex items-center justify-center">
                            <span class="material-symbols-outlined text-[5rem] text-[#006a6a]">hub</span>
                        </div>
                        <div class="flex-1">
                            <img src="/gma_mission.png" class="w-full h-auto rounded-[2rem] shadow-xl">
                        </div>
                    </div>
                    <div class="flex flex-col md:flex-row items-center gap-12">
                        <div class="flex-1 order-3 md:order-1">
                            <img src="/Bob instructing .jpg" class="w-full h-auto rounded-[2rem] shadow-xl">
                        </div>
                        <div class="shrink-0 w-40 h-40 rounded-full bg-white/60 border-4 border-white shadow-[0_20px_50px_rgba(64,224,208,0.15)] flex items-center justify-center order-2 md:order-2">
                            <span class="material-symbols-outlined text-[5rem] text-[#40e0d0]">rocket_launch</span>
                        </div>
                        <div class="flex-1 text-center md:text-left order-1 md:order-3">
                            <span class="text-[#006a6a] font-bold text-[13px] uppercase tracking-widest mb-4 inline-block">Vision</span>
                            <h2 class="text-4xl md:text-5xl font-black text-[#001e40] mb-6 leading-tight tracking-tight">Our Vision</h2>
                            <p class="text-lg md:text-xl text-[#475569] leading-relaxed">To become the leading global community for the used mobile industry, driving trust, innovation, sustainability, and meaningful business growth worldwide.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Animation Wrapper -->
            <div id="mv-anim-wrapper" class="absolute inset-0 w-full h-full">
                <!-- Center Absolute Icon (Shared) -->
                <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 z-50 pointer-events-none w-40 h-40 md:w-64 md:h-64">
                    <!-- Mission Icon -->
                    <div class="gs-center-mission absolute inset-0 flex items-center justify-center">
                        <div class="absolute w-40 h-40 md:w-64 md:h-64 bg-[#006a6a]/15 rounded-full blur-[40px] md:blur-[60px]"></div>
                        <div class="w-24 h-24 md:w-44 md:h-44 rounded-full bg-white/60 backdrop-blur-md border-4 border-white shadow-[0_20px_50px_rgba(0,106,106,0.15)] flex items-center justify-center relative z-10">
                            <span class="material-symbols-outlined text-[3rem] md:text-[5.5rem] text-[#006a6a]">hub</span>
                        </div>
                    </div>
                    <!-- Vision Icon -->
                    <div class="gs-center-vision absolute inset-0 flex items-center justify-center opacity-0 scale-50">
                        <div class="absolute w-40 h-40 md:w-64 md:h-64 bg-[#40e0d0]/15 rounded-full blur-[40px] md:blur-[60px]"></div>
                        <div class="w-24 h-24 md:w-44 md:h-44 rounded-full bg-white/60 backdrop-blur-md border-4 border-white shadow-[0_20px_50px_rgba(64,224,208,0.15)] flex items-center justify-center relative z-10">
                            <span class="material-symbols-outlined text-[3rem] md:text-[5.5rem] text-[#40e0d0]">rocket_launch</span>
                        </div>
                    </div>
                </div>

                <!-- Mission Layer (Slide 1) -->
                <div class="gs-mission-layer absolute inset-0 w-full h-full overflow-hidden">
                    <!-- Left/Top Half (Text) -->
                    <div class="gs-mission-left absolute top-0 left-0 w-full h-1/2 md:w-1/2 md:h-full flex items-center bg-[#f0fdfa]">
                        <div class="w-full px-6 pt-16 pb-8 md:py-0 md:pr-32 lg:pr-48 md:pl-12 flex justify-center md:justify-end">
                            <div class="max-w-lg w-full text-center md:text-left">
                                <span class="text-[#006a6a] font-bold text-[11px] md:text-[13px] uppercase tracking-widest mb-2 md:mb-4 inline-block relative after:content-[''] after:absolute after:bottom-[-6px] after:left-1/2 md:after:left-0 after:-translate-x-1/2 md:after:translate-x-0 after:w-12 after:h-[2px] after:bg-[#006a6a]">Mission</span>
                                <h2 class="text-3xl sm:text-4xl md:text-5xl lg:text-[3.5rem] font-black text-[#001e40] mb-4 md:mb-6 leading-[1.1] mt-4 md:mt-6 tracking-tight">Our Mission</h2>
                                <p class="text-base sm:text-lg md:text-xl text-[#475569] leading-relaxed">
                                    To connect and empower the global used mobile ecosystem by creating trusted opportunities for members to grow stronger businesses and lasting relationships.
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- Right/Bottom Half (Image) -->
                    <div class="gs-mission-right absolute bottom-0 md:top-0 right-0 w-full h-1/2 md:w-1/2 md:h-full flex items-center bg-[#f0fdfa]">
                        <div class="w-full px-6 pb-16 pt-8 md:py-0 md:pl-32 lg:pl-48 md:pr-12 flex justify-center md:justify-start">
                            <img src="/gma_mission.png" class="w-full aspect-[4/3] md:aspect-auto md:h-[350px] object-cover rounded-[2rem] shadow-[0_20px_50px_rgba(0,106,106,0.2)] border-4 border-white/60 saturate-[1.1]">
                        </div>
                    </div>
                </div>

                <!-- Vision Layer (Slide 2) -->
                <div class="gs-vision-layer absolute inset-0 w-full h-full overflow-hidden pointer-events-none">
                    <!-- Left/Top Half (Image) -->
                    <div class="gs-vision-left absolute top-0 left-0 w-full h-1/2 md:w-1/2 md:h-full flex items-center bg-[#f0fdfa]" style="transform: translateY(100%);">
                        <div class="w-full px-6 pt-16 pb-8 md:py-0 md:pr-32 lg:pr-48 md:pl-12 flex justify-center md:justify-end">
                            <img src="/Bob instructing .jpg" class="w-full aspect-[4/3] md:aspect-auto md:h-[350px] object-cover object-left rounded-[2rem] shadow-[0_20px_50px_rgba(0,30,64,0.15)] border-4 border-white/60 saturate-[1.2]">
                        </div>
                    </div>
                    <!-- Right/Bottom Half (Text) -->
                    <div class="gs-vision-right absolute bottom-0 md:top-0 right-0 w-full h-1/2 md:w-1/2 md:h-full flex items-center bg-[#f0fdfa]" style="transform: translateY(-100%);">
                        <div class="w-full px-6 pb-16 pt-8 md:py-0 md:pl-32 lg:pl-48 md:pr-12 flex justify-center md:justify-start">
                            <div class="max-w-lg w-full text-center md:text-left">
                                <span class="text-[#006a6a] font-bold text-[11px] md:text-[13px] uppercase tracking-widest mb-2 md:mb-4 inline-block relative after:content-[''] after:absolute after:bottom-[-6px] after:left-1/2 md:after:left-0 after:-translate-x-1/2 md:after:translate-x-0 after:w-12 after:h-[2px] after:bg-[#006a6a]">Vision</span>
                                <h2 class="text-3xl sm:text-4xl md:text-5xl lg:text-[3.5rem] font-black text-[#001e40] mb-4 md:mb-6 leading-[1.1] mt-4 md:mt-6 tracking-tight">Our Vision</h2>
                                <p class="text-base sm:text-lg md:text-xl text-[#475569] leading-relaxed">
                                    To become the leading global community for the used mobile industry, driving trust, innovation, sustainability, and meaningful business growth worldwide.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Smooth arc divider out of section -->
            <div class="absolute bottom-0 left-0 right-0 w-full overflow-hidden leading-[0] z-30">
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
                        
                        <h3 class="text-xl sm:text-2xl font-bold mb-4 sm:mb-6 text-white relative z-10 leading-snug">A Fragmented Market Demands a Unified Voice</h3>
                        

                        
                        <div class="space-y-4 relative z-10 flex-1 text-white/80 text-sm sm:text-base font-light leading-relaxed">
                            <p>
                                The secondary mobile market is experiencing massive growth, yet remains deeply fragmented. To thrive, companies need more than just occasional networking events. They need continuous connection, shared standards, and collaborative innovation.
                            </p>
                            <p>
                                GMA was created to solve this isolation, bridging the gap between global wholesalers, refurbishers, and retailers with a year-round ecosystem built on trust and excellence.
                            </p>
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
                <svg viewBox="0 0 1440 92" preserveAspectRatio="none" class="w-full h-[57px] md:h-[92px] block">
                    <path d="M0,90 C360,20 1080,20 1440,90 L1440,92 L0,92 Z" fill="#004070"/>
                </svg>
            </div>
        </section>

        <!-- The Gap GMA Fills -->
        <section class="py-24 bg-gradient-to-br from-[#004070] via-[#005c94] to-[#007ba8] text-white relative pb-[120px] -mt-[2px] overflow-hidden">
            <div class="absolute inset-0 z-0 pointer-events-none">
                <img src="/gma_network.png" alt="Global Network" class="w-full h-full object-cover opacity-25 mix-blend-screen saturate-150">
                <div class="absolute inset-0 bg-gradient-to-br from-[#004070]/90 via-[#005c94]/80 to-[#007ba8]/85"></div>
            </div>
            <div class="absolute inset-0 bg-mesh-glow opacity-30 pointer-events-none z-0"></div>
            
            <div class="max-w-[1280px] mx-auto px-4 sm:px-6 md:px-10 relative z-10">
                
                <div class="animate-on-scroll text-center max-w-4xl mx-auto mb-16">
                    <span class="text-[#40e0d0] font-semibold text-[13px] uppercase tracking-[0.2em] mb-4 inline-block">
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

        <!-- Founder's Story (Cinematic GSAP Sequence) -->
        <section id="founder-story-section" class="relative w-full h-[100vh] overflow-hidden bg-gradient-to-b from-[#f8fafd] via-white to-[#edf7f7] flex flex-col items-center justify-center -mt-[2px]">
            
            <!-- Fallback for reduced motion -->
            <div class="founder-fallback hidden flex-col items-center gap-12 w-full max-w-[1000px] mt-24 px-4 sm:px-6 md:px-10 z-10 relative pb-24">
                <div class="text-center mb-10">
                    <span class="text-[#006a6a] font-semibold text-[13px] uppercase tracking-[0.2em] mb-4 inline-block relative after:content-[''] after:absolute after:bottom-[-6px] after:left-1/2 after:-translate-x-1/2 after:w-16 after:h-[2px] after:bg-[#006a6a]">
                        Our Origins
                    </span>
                    <h2 class="text-4xl md:text-5xl font-black text-[#001e40] mt-4 leading-tight">Founder's Story</h2>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-12 gap-12 w-full">
                    <div class="md:col-span-4 flex justify-center md:justify-end">
                        <div class="text-center glass-card-light hover-sheen p-8 rounded-[2rem] shadow-lg border border-[#006a6a]/15 max-w-[300px] w-full">
                            <img src="{{ asset('Bob-updated-profile-photo-2025.jpg') }}" alt="Bob Lafon" class="w-48 h-48 sm:w-56 sm:h-56 rounded-3xl object-cover object-top shadow-xl mx-auto border-4 border-white mb-6">
                            <h3 class="text-2xl font-bold text-[#001e40] mb-2">Bob Lafon</h3>
                            <p class="text-[#006a6a] font-bold uppercase tracking-wider text-xs mb-4">Founder & CEO</p>
                        </div>
                    </div>
                    <div class="md:col-span-8 flex flex-col gap-6 justify-center">
                        <div class="glass-card-light p-6 rounded-[2rem] shadow-sm border border-[#006a6a]/10">
                            <p class="text-[#475569] text-base leading-relaxed">
                                In 2021, Bob Lafon saw an underserved segment of the wireless mobile ecosystem that needed its own platform. After moderating a panel discussion at an industry trade show, Bob spoke with the event promoter about the opportunity he saw in the used mobile space. Larger industry events served important purposes, but the secondary mobile ecosystem did not have a dedicated gathering built around its unique needs, challenges, companies, and opportunities.
                            </p>
                        </div>
                        <div class="glass-card-light p-6 rounded-[2rem] shadow-sm border border-[#006a6a]/10">
                            <p class="text-[#475569] text-base leading-relaxed">
                                That conversation quickly turned into action. Within minutes, a camera was rolling as Bob recorded a short announcement sharing that the used mobile industry would soon have an event created specifically for the people and companies driving that market forward. Ten months later, Mobile Disrupt was born.
                            </p>
                        </div>
                        <div class="glass-card-light p-6 rounded-[2rem] shadow-sm border border-[#006a6a]/10">
                            <p class="text-[#475569] text-base leading-relaxed">
                                Not everyone believed it would work. Some questioned whether the event would happen at all. Others openly doubted whether the industry would support it. But Bob understood what many others had missed. The used mobile ecosystem was not a small side category. It was a growing, global industry made up of operators, innovators, service providers, technology companies, and leaders who needed a place of their own. Mobile Disrupt quickly gained momentum and established itself as the premier event serving the secondary mobile ecosystem.
                            </p>
                        </div>
                        <div class="glass-card-light p-6 rounded-[2rem] shadow-sm border border-[#006a6a]/10">
                            <p class="text-[#475569] text-base leading-relaxed">
                                The creation of the Global Mobile Association follows that same pattern. Bob once again looked across the industry and saw an important gap. While major events bring the ecosystem together at key moments, the used mobile industry also needs year-round support, education, leadership development, business resources, advocacy, and meaningful connection between those events. GMA was founded to serve that need.
                            </p>
                        </div>
                        <div class="glass-card-light p-6 rounded-[2rem] shadow-sm border border-[#006a6a]/10">
                            <p class="text-[#475569] text-base leading-relaxed">
                                Through his work with Lafon & Associates, Mobile Disrupt, the Mobile Mavericks Podcast, and now the Global Mobile Association, Bob has remained focused on strengthening the industry, creating opportunities for collaboration, and supporting the people and companies helping shape the future of used mobile. The Global Mobile Association builds on that commitment by giving the used mobile ecosystem a year-round platform designed to help members learn, connect, lead, grow, and move the industry forward together.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Animation Wrapper -->
            <div id="founder-anim-wrapper" class="relative w-full h-full max-w-[1200px] z-10 px-4">
                
                <!-- Huge Title -->
                <h2 class="founder-title text-6xl sm:text-7xl md:text-8xl lg:text-9xl font-black text-[#001e40] text-center absolute top-1/2 left-1/2 -translate-x-1/2 w-full opacity-0 pointer-events-none drop-shadow-xl z-20">
                    Founder's Story
                </h2>
                
                <!-- Bob Image Card -->
                <div class="founder-card absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-center glass-card-light p-6 rounded-[2rem] shadow-2xl border border-[#006a6a]/15 opacity-0 pointer-events-none z-30 flex flex-col items-center">
                    <img src="{{ asset('Bob-updated-profile-photo-2025.jpg') }}" alt="Bob Lafon" class="w-40 h-40 sm:w-56 sm:h-56 md:w-64 md:h-64 rounded-3xl object-cover object-top shadow-xl border-4 border-white mb-6">
                    <h3 class="text-2xl font-bold text-[#001e40] mb-1">Bob Lafon</h3>
                    <p class="text-[#006a6a] font-bold uppercase tracking-wider text-xs">Founder & CEO</p>
                </div>
                
                <!-- Paragraph 1 -->
                <div class="founder-p1 absolute top-[65%] lg:top-1/2 left-1/2 lg:left-[48%] -translate-x-1/2 lg:-translate-x-0 -translate-y-1/2 max-w-xl lg:max-w-2xl xl:max-w-3xl w-[95%] text-center lg:text-left opacity-0 pointer-events-none z-20 glass-card-light p-6 sm:p-10 lg:p-12 rounded-[2.5rem] shadow-xl border border-[#006a6a]/15">
                    <div class="space-y-4 text-[#001e40] text-sm sm:text-base md:text-lg lg:text-[17px] xl:text-[19px] font-light leading-relaxed">
                        <p>In 2021, Bob Lafon saw an underserved segment of the wireless mobile ecosystem that needed its own platform.</p>
                        <p>After moderating a panel discussion at an industry trade show, Bob spoke with the event promoter about the opportunity he saw in the used mobile space. Larger industry events served important purposes, but the secondary mobile ecosystem did not have a dedicated gathering built around its unique needs, challenges, companies, and opportunities.</p>
                        <p>That conversation quickly turned into action. Within minutes, a camera was rolling as Bob recorded a short announcement sharing that the used mobile industry would soon have an event created specifically for the people and companies driving that market forward. Ten months later, Mobile Disrupt was born.</p>
                    </div>
                </div>
                
                <!-- Paragraph 2 -->
                <div class="founder-p2 absolute top-[65%] lg:top-1/2 left-1/2 lg:left-[48%] -translate-x-1/2 lg:-translate-x-0 -translate-y-1/2 max-w-xl lg:max-w-2xl xl:max-w-3xl w-[95%] text-center lg:text-left opacity-0 pointer-events-none z-20 glass-card-light p-6 sm:p-10 lg:p-12 rounded-[2.5rem] shadow-xl border border-[#006a6a]/15">
                    <div class="space-y-4 text-[#001e40] text-sm sm:text-base md:text-lg lg:text-[17px] xl:text-[19px] font-light leading-relaxed">
                        <p>Not everyone believed it would work. Some questioned whether the event would happen at all. Others openly doubted whether the industry would support it. But Bob understood what many others had missed. The used mobile ecosystem was not a small side category. It was a growing, global industry made up of operators, innovators, service providers, technology companies, and leaders who needed a place of their own.</p>
                        <p>Mobile Disrupt quickly gained momentum and established itself as the premier event serving the secondary mobile ecosystem. Since its launch, the event has continued to grow, expand internationally, and bring together industry leaders from around the world.</p>
                        <p class="font-semibold">The creation of the Global Mobile Association follows that same pattern.</p>
                    </div>
                </div>
                
                <!-- Paragraph 3 -->
                <div class="founder-p3 absolute top-[65%] lg:top-1/2 left-1/2 lg:left-[4%] -translate-x-1/2 lg:-translate-x-0 -translate-y-1/2 max-w-xl lg:max-w-xl xl:max-w-2xl w-[95%] text-center lg:text-left opacity-0 pointer-events-none z-20 glass-card-light p-6 sm:p-10 lg:p-12 rounded-[2.5rem] shadow-xl border border-[#006a6a]/15">
                    <div class="space-y-4 text-[#001e40] text-sm sm:text-base md:text-lg lg:text-[17px] xl:text-[19px] font-light leading-relaxed">
                        <p>Bob once again looked across the industry and saw an important gap. While major events bring the ecosystem together at key moments, the used mobile industry also needs year-round support, education, leadership development, business resources, advocacy, and meaningful connection between those events. <span class="font-bold text-[#006a6a]">GMA was founded to serve that need.</span></p>
                        <p>Through his work with Lafon & Associates, Mobile Disrupt, the Mobile Mavericks Podcast, and now the Global Mobile Association, Bob has remained focused on strengthening the industry, creating opportunities for collaboration, and supporting the people and companies helping shape the future of used mobile.</p>
                        <p class="font-semibold text-[#001e40]">The Global Mobile Association builds on that commitment by giving the used mobile ecosystem a year-round platform designed to help members learn, connect, lead, grow, and move the industry forward together.</p>
                    </div>
                </div>

            </div>
            
            <!-- Smooth arc divider into Founder section -->
            <div class="absolute bottom-0 left-0 right-0 w-full overflow-hidden leading-[0] z-20">
                <svg viewBox="0 0 1440 90" preserveAspectRatio="none" class="w-full h-[55px] md:h-[90px] block">
                    <path d="M0,90 C360,0 1080,0 1440,90 L1440,90 L0,90 Z" fill="#ffffff"/>
                </svg>
            </div>
        </section>

        <!-- Start Animated Team Section -->
        <section id="team-sequence-section" class="relative w-full h-[100vh] min-h-[750px] overflow-hidden bg-white -mt-[2px]">
            
            <!-- Fallback for reduced motion / mobile static view -->
            <div class="team-fallback hidden flex-col items-center gap-12 w-full max-w-[1200px] py-24 px-4 sm:px-6 md:px-10 z-10 relative mx-auto">
                <div class="text-center">
                    <span class="text-[#006a6a] font-semibold text-[13px] uppercase tracking-[0.2em] mb-4 inline-block">Leadership</span>
                    <h2 class="text-4xl md:text-5xl font-black text-[#001e40] leading-tight">GMA Leadership</h2>
                </div>
                
                <!-- Dana (CEO) at the top of hierarchy -->
                <div class="glass-card-light p-8 rounded-[2.5rem] border border-[#006a6a]/15 max-w-4xl w-full flex flex-col md:flex-row items-center gap-8 shadow-xl">
                    <div class="w-40 h-40 sm:w-48 sm:h-48 rounded-3xl overflow-hidden shadow-md border-4 border-white shrink-0">
                        <img src="{{ asset('dana.jpg') }}" alt="Dana Dorcas" class="w-full h-full object-cover object-top">
                    </div>
                    <div class="text-center md:text-left">
                        <h3 class="text-2xl font-bold text-[#001e40] mb-1">Dana Dorcas</h3>
                        <p class="text-[#006a6a] font-semibold uppercase tracking-wider text-xs mb-4">Chief Executive Officer</p>
                        <p class="text-sm text-slate-600 leading-relaxed mb-4">Dana Dorcas is a senior wireless industry executive with more than three decades of experience leading growth, strengthening organizations, and developing high performing teams. As Chief Executive Officer of the Global Mobile Association, he brings extensive leadership experience across sales, operations, business strategy, organizational development, and performance improvement.</p>
                        <p class="text-sm text-slate-600 leading-relaxed">At the Global Mobile Association, Dana is focused specifically on advancing the global used mobile ecosystem by bringing together the companies, leaders, and professionals responsible for the resale, reuse, refurbishment, repair, distribution, and lifecycle management of mobile devices.</p>
                    </div>
                </div>

                <div class="w-full text-center mt-6">
                    <h3 class="text-2xl md:text-3xl font-black text-[#001e40] mb-8">Board of Directors</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                        <!-- Jerry -->
                        <div class="glass-card-light p-6 rounded-[2rem] shadow-md border border-[#006a6a]/10 flex flex-col items-center">
                            <div class="w-24 h-24 rounded-full overflow-hidden mb-4 border-2 border-white shadow"><img src="{{ asset('jerry.jpg') }}" alt="Jerry Abramov" class="w-full h-full object-cover object-top"></div>
                            <h4 class="font-bold text-[#001e40] text-sm">Jerry Abramov</h4>
                            <p class="text-slate-500 text-[10px] uppercase font-semibold mt-1">Founder, Chairman, and CEO of COS Phones</p>
                        </div>
                        <!-- Allyson -->
                        <div class="glass-card-light p-6 rounded-[2rem] shadow-md border border-[#006a6a]/10 flex flex-col items-center">
                            <div class="w-24 h-24 rounded-full overflow-hidden mb-4 border-2 border-white shadow"><img src="{{ asset('Allyson.png') }}" alt="Allyson Lundquist" class="w-full h-full object-cover object-top"></div>
                            <h4 class="font-bold text-[#001e40] text-sm">Allyson Lundquist</h4>
                            <p class="text-slate-500 text-[10px] uppercase font-semibold mt-1">CEO at Allyson Lundquist LLC & Partner CGP</p>
                        </div>
                        <!-- Josh -->
                        <div class="glass-card-light p-6 rounded-[2rem] shadow-md border border-[#006a6a]/10 flex flex-col items-center">
                            <div class="w-24 h-24 rounded-full overflow-hidden mb-4 border-2 border-white shadow"><img src="{{ asset('Josh.jpg') }}" alt="Josh Beasley" class="w-full h-full object-cover object-top"></div>
                            <h4 class="font-bold text-[#001e40] text-sm">Josh Beasley</h4>
                            <p class="text-slate-500 text-[10px] uppercase font-semibold mt-1">CEO & Board Member, Early Upgrade</p>
                        </div>
                        <!-- Sean -->
                        <div class="glass-card-light p-6 rounded-[2rem] shadow-md border border-[#006a6a]/10 flex flex-col items-center">
                            <div class="w-24 h-24 rounded-full overflow-hidden mb-4 border-2 border-white shadow"><img src="{{ asset('Sean.jpg') }}" alt="Sean Cleland" class="w-full h-full object-cover object-top"></div>
                            <h4 class="font-bold text-[#001e40] text-sm">Sean Cleland</h4>
                            <p class="text-slate-500 text-[10px] uppercase font-semibold mt-1">Vice President - Mobility B Stock</p>
                        </div>
                        <!-- Elizabeth -->
                        <div class="glass-card-light p-6 rounded-[2rem] shadow-md border border-[#006a6a]/10 flex flex-col items-center">
                            <div class="w-24 h-24 rounded-full overflow-hidden mb-4 border-2 border-white shadow"><img src="{{ asset('Elizabeth.jpg') }}" alt="Elizabeth Chen" class="w-full h-full object-cover object-top"></div>
                            <h4 class="font-bold text-[#001e40] text-sm">Elizabeth Chen</h4>
                            <p class="text-slate-500 text-[10px] uppercase font-semibold mt-1">Founder & CEO, Trillion Companies</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Animation Wrapper -->
            <div id="team-anim-wrapper" class="relative w-full h-full flex flex-col items-center justify-center z-10 px-4 md:px-10 py-12">
                
                <!-- Dynamic Header Container -->
                <div class="absolute top-20 sm:top-24 left-0 right-0 text-center h-16 flex items-center justify-center z-30 pointer-events-none">
                    <h2 class="team-title-our text-4xl md:text-5xl font-black text-[#001e40] absolute">Our Team</h2>
                    <h2 class="team-title-lead text-4xl md:text-5xl font-black text-[#001e40] absolute opacity-0 scale-90">Leadership</h2>
                </div>

                <!-- Dana Dorcas Profile Area (Centrally aligned initially) -->
                <div id="leader-dana-container" class="absolute top-[53%] left-1/2 -translate-x-1/2 -translate-y-1/2 flex flex-col md:flex-row items-center justify-center gap-8 xl:gap-12 max-w-[1100px] w-[90%] z-20 pointer-events-none">
                    <!-- Avatar and Title Block (Moves up to top/leader position) -->
                    <div class="leader-profile-block flex flex-col items-center shrink-0">
                        <div class="leader-avatar w-48 h-48 sm:w-56 sm:h-56 md:w-64 md:h-64 lg:w-72 lg:h-72 rounded-[2rem] overflow-hidden shadow-lg border-4 border-white">
                            <img src="{{ asset('dana.jpg') }}" alt="Dana Dorcas" class="w-full h-full object-cover object-top">
                        </div>
                        <div class="leader-info text-center mt-4">
                            <h3 class="text-xl sm:text-2xl font-bold text-[#001e40] leading-none mb-1">Dana Dorcas</h3>
                            <p class="text-[#006a6a] font-bold uppercase tracking-wider text-[11px] sm:text-xs">Chief Executive Officer</p>
                        </div>
                    </div>
                    <!-- Bio Text (Fades out when Dana shifts up) -->
                    <div class="leader-bio max-w-2xl text-center md:text-left px-4">
                        <p class="text-slate-600 text-sm sm:text-base leading-relaxed mb-4">
                            Dana Dorcas is a senior wireless industry executive with more than three decades of experience leading growth, strengthening organizations, and developing high performing teams. As Chief Executive Officer of the Global Mobile Association, he brings extensive leadership experience across sales, operations, business strategy, organizational development, and performance improvement.
                        </p>
                        <p class="text-slate-600 text-sm sm:text-base leading-relaxed mb-4">
                            Throughout his career, Dana has led complex businesses, guided teams to exceptional results, and built cultures grounded in clarity, accountability, trust, and execution. His experience as a business advisor, certified leadership coach, sales strategist, and author further strengthens his ability to help leaders navigate change, accelerate growth, and build sustainable success.
                        </p>
                        <p class="text-slate-600 text-sm sm:text-base leading-relaxed">
                            At the Global Mobile Association, Dana is focused specifically on advancing the global used mobile ecosystem by bringing together the companies, leaders, and professionals responsible for the resale, reuse, refurbishment, repair, distribution, and lifecycle management of mobile devices. His work is centered on strengthening industry leadership, supporting member growth, elevating standards, and building a trusted global association that gives the used mobile ecosystem a stronger voice and a more connected future.
                        </p>
                    </div>
                </div>

                <!-- Board of Directors Block (Rises up below Dana) -->
                <div id="board-container" class="absolute top-[62%] left-0 right-0 w-full max-w-[1280px] mx-auto flex flex-col items-center opacity-0 pointer-events-none z-10 pt-4">
                    <h3 class="board-heading text-2xl md:text-3xl font-black text-[#001e40] mb-8 translate-y-6 opacity-0">Board of Directors</h3>
                    
                    <!-- Board Grid (Desktop row / mobile stack) -->
                    <div class="board-grid grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 xl:gap-8 w-full px-4 sm:px-6">
                        
                        <!-- Member 1: Jerry -->
                        <div class="board-card glass-card-light p-5 rounded-[2rem] border border-[#006a6a]/10 shadow-md flex flex-col items-center text-center opacity-0 translate-y-8">
                            <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-full overflow-hidden border-2 border-white shadow mb-3">
                                <img src="{{ asset('jerry.jpg') }}" alt="Jerry Abramov" class="w-full h-full object-cover object-top">
                            </div>
                            <h4 class="font-bold text-[#001e40] text-sm leading-tight">Jerry Abramov</h4>
                            <p class="text-slate-500 text-[10px] font-semibold mt-2 uppercase tracking-wide leading-tight">Founder, Chairman, and CEO of COS Phones</p>
                        </div>

                        <!-- Member 2: Allyson -->
                        <div class="board-card glass-card-light p-5 rounded-[2rem] border border-[#006a6a]/10 shadow-md flex flex-col items-center text-center opacity-0 translate-y-8">
                            <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-full overflow-hidden border-2 border-white shadow mb-3">
                                <img src="{{ asset('Allyson.png') }}" alt="Allyson Lundquist" class="w-full h-full object-cover object-top">
                            </div>
                            <h4 class="font-bold text-[#001e40] text-sm leading-tight">Allyson Lundquist</h4>
                            <p class="text-slate-500 text-[10px] font-semibold mt-2 uppercase tracking-wide leading-tight">CEO at Allyson Lundquist LLC & Partner CGP</p>
                        </div>

                        <!-- Member 3: Josh -->
                        <div class="board-card glass-card-light p-5 rounded-[2rem] border border-[#006a6a]/10 shadow-md flex flex-col items-center text-center opacity-0 translate-y-8">
                            <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-full overflow-hidden border-2 border-white shadow mb-3">
                                <img src="{{ asset('Josh.jpg') }}" alt="Josh Beasley" class="w-full h-full object-cover object-top">
                            </div>
                            <h4 class="font-bold text-[#001e40] text-sm leading-tight">Josh Beasley</h4>
                            <p class="text-slate-500 text-[10px] font-semibold mt-2 uppercase tracking-wide leading-tight">CEO & Board Member, Early Upgrade</p>
                        </div>

                        <!-- Member 4: Sean -->
                        <div class="board-card glass-card-light p-5 rounded-[2rem] border border-[#006a6a]/10 shadow-md flex flex-col items-center text-center opacity-0 translate-y-8">
                            <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-full overflow-hidden border-2 border-white shadow mb-3">
                                <img src="{{ asset('Sean.jpg') }}" alt="Sean Cleland" class="w-full h-full object-cover object-top">
                            </div>
                            <h4 class="font-bold text-[#001e40] text-sm leading-tight">Sean Cleland</h4>
                            <p class="text-slate-500 text-[10px] font-semibold mt-2 uppercase tracking-wide leading-tight">Vice President - Mobility B Stock</p>
                        </div>

                        <!-- Member 5: Elizabeth -->
                        <div class="board-card glass-card-light p-5 rounded-[2rem] border border-[#006a6a]/10 shadow-md flex flex-col items-center text-center opacity-0 translate-y-8">
                            <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-full overflow-hidden border-2 border-white shadow mb-3">
                                <img src="{{ asset('Elizabeth.jpg') }}" alt="Elizabeth Chen" class="w-full h-full object-cover object-top">
                            </div>
                            <h4 class="font-bold text-[#001e40] text-sm leading-tight">Elizabeth Chen</h4>
                            <p class="text-slate-500 text-[10px] font-semibold mt-2 uppercase tracking-wide leading-tight">Founder & CEO, Trillion Companies</p>
                        </div>

                    </div>
                </div>

            </div>
        </section>>
            </section>
            <!-- End Animated Team Section -->
            
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
            
            <div class="max-w-[1280px] mx-auto px-4 sm:px-6 md:px-10 relative z-10">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                    
                    <!-- Left Column: Presentation Image -->
                    <div class="lg:col-span-5 animate-on-scroll">
                        <div class="relative rounded-[2.5rem] overflow-hidden shadow-2xl border-4 border-white bg-white aspect-[4/3] sm:aspect-[16/10] lg:aspect-auto lg:h-[380px] group">
                            <img src="/Presentation.png" alt="GMA Presentation" class="w-full h-full object-cover object-center transform group-hover:scale-102 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                        </div>
                    </div>
                    
                    <!-- Right Column: CTA Content -->
                    <div class="lg:col-span-7 animate-on-scroll">
                        <h2 class="text-4xl sm:text-5xl font-black text-transparent bg-clip-text bg-gradient-to-br from-[#001e40] via-[#00385e] to-[#006a6a] mb-6 leading-[1.1] tracking-tight">
                            Be Part of Building a Stronger Industry
                        </h2>
                        
                        <p class="text-base sm:text-lg text-[#475569] mb-8 leading-relaxed font-light">
                            The used mobile ecosystem is growing, and the companies shaping its future deserve a stronger platform. GMA gives you a place to stay engaged, access resources, and build relationships year-round.
                        </p>
                        
                        <div class="flex flex-col sm:flex-row gap-4 items-center">
                            <a href="{{ route('register') }}" class="w-full sm:w-auto inline-block text-center bg-gradient-to-r from-[#001e40] to-[#006a6a] text-white font-bold text-sm uppercase tracking-widest px-12 py-5 rounded-full shadow-lg hover:scale-[1.03] hover:shadow-[0_15px_30px_-5px_rgba(0,106,106,0.35)] transition-all duration-300">
                                Join GMA
                            </a>
                            <button class="w-full sm:w-auto bg-white hover:bg-slate-50 text-[#001e40] border border-[#001e40]/25 font-bold text-sm uppercase tracking-widest px-12 py-5 rounded-full shadow-md hover:scale-[1.03] transition-all duration-300">
                                Request Info
                            </button>
                        </div>
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

            const founderCards = document.querySelectorAll('.founder-parallax');
            founderCards.forEach(founderCard => {
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
            });
        });
    </script>
</body>
</html>
