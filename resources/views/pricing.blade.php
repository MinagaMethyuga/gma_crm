<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GMA - Membership Options</title>
    <link rel="icon" href="/Global_Mobile_Association_Logo__1_-removebg-preview.png" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0,1&display=swap" rel="stylesheet">
    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
    <style>
        /* Shared Header Styles */
        .nav-item { transition: transform 180ms ease, filter 200ms ease, opacity 200ms ease, box-shadow 200ms ease !important; }
        .nav-item:active { transform: scale(0.96) !important; }

        /* Pricing Page Custom Styles */
        body {
            background-color: #001e40; /* GMA Dark Blue */
            color: #fff;
            overflow-x: hidden;
            font-family: 'Inter', sans-serif;
        }

        /* Sparkles Canvas */
        #sparkles-canvas {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            mask-image: radial-gradient(50% 50%, white, transparent 85%);
            -webkit-mask-image: radial-gradient(50% 50%, white, transparent 85%);
            z-index: 10;
        }

        /* Grid Background Pattern */
        .bg-grid-pattern {
            background-image: 
                linear-gradient(to right, rgba(255,255,255,0.05) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(255,255,255,0.05) 1px, transparent 1px);
            background-size: 70px 80px;
        }

        /* Blurry Ellipses */
        .blurry-ellipse {
            position: absolute;
            left: -568px;
            right: -568px;
            top: 0;
            height: 2053px;
            border-radius: 50%;
            border: 200px solid #006a6a; /* GMA Teal */
            filter: blur(92px);
            -webkit-filter: blur(92px);
            pointer-events: none;
            opacity: 0.6;
            z-index: 0;
        }

        /* Pricing Card Drop Shadow Glow */
        .popular-glow {
            box-shadow: 0px 0px 80px 0px rgba(0,106,106,0.4), 0px 0px 30px 0px rgba(64,224,208,0.2);
        }

        .card-hover {
            transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
        }
        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0px 20px 60px 0px rgba(0,0,0,0.5), 0px 0px 40px 0px rgba(0,106,106,0.3);
            border-color: rgba(64,224,208,0.5) !important;
        }

        /* Vertical Cut Reveal */
        .word-reveal {
            display: inline-flex;
            overflow: hidden;
            vertical-align: top;
        }
        .word-reveal span {
            display: inline-block;
            transform: translateY(100%);
        }
    </style>
</head>
<body class="overflow-x-hidden bg-[#001e40] text-white selection:bg-[#40e0d0] selection:text-[#001e40]">
    @include('components.page-transition')

    @php
        $profId = $plans['professional']->id ?? 1;
        $bizId = $plans['business']->id ?? 2;
        $stratId = $plans['strategic']->id ?? 3;
    @endphp

    <!-- Header -->
    <header id="gma-header" class="fixed top-4 left-1/2 -translate-x-1/2 w-[92%] max-w-[1240px] z-[100] bg-white/80 backdrop-blur-md border border-white/40 rounded-full px-6 py-3 shadow-[0_20px_50px_rgba(0,0,0,0.15)] transition-all duration-500">
        <div class="flex justify-between items-center max-w-full mx-auto">
            <!-- Brand / Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-2 group transition-transform duration-300 hover:scale-[1.02]">
                <img src="/Global_Mobile_Association_Logo__1_-removebg-preview.png" alt="Global Mobile Association Logo" class="h-11 md:h-14 w-auto object-contain">
            </a>

            <!-- Navigation Links (Desktop) -->
            <nav class="hidden xl:flex items-center space-x-1 relative">
                <a href="{{ route('home') }}" class="nav-item font-label-md text-xs uppercase tracking-wider text-[#001e40]/80 hover:text-[#006a6a] px-4 py-2 rounded-full relative z-10 font-bold transition-colors duration-300">Home</a>
                <a href="{{ route('about') }}" class="nav-item font-label-md text-xs uppercase tracking-wider text-[#001e40]/80 hover:text-[#006a6a] px-4 py-2 rounded-full relative z-10 font-bold transition-colors duration-300">About GMA</a>
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
                            <a href="{{ route('dashboard') }}" class="group relative inline-flex h-10 items-center justify-center overflow-hidden rounded-full bg-white px-6 text-xs font-bold uppercase tracking-wider text-[#001e40] shadow-[0_4px_14px_0_rgba(0,30,64,0.1)] transition-all duration-300 hover:text-white hover:shadow-[0_4px_14px_0_rgba(0,106,106,0.39)]"><span class="absolute left-0 bottom-0 h-0 w-0 -translate-x-1/2 translate-y-1/2 rounded-full bg-[#006a6a] transition-all duration-500 ease-out group-hover:h-[300px] group-hover:w-[300px]"></span><span class="relative z-10 flex items-center gap-2">Dashboard <span class="material-symbols-outlined text-[16px] transition-transform duration-300 group-hover:translate-x-1">arrow_forward</span></span></a>
                        @else
                            <a href="{{ route('login') }}" class="font-label-md text-xs uppercase tracking-wider text-[#001e40]/80 hover:text-[#006a6a] font-bold transition-colors duration-300">Log in</a>
                        @endauth
                    @endif
                </div>
                <a href="#membership-plans" class="hidden sm:inline-block relative overflow-hidden bg-gradient-to-r from-[#006a6a] to-[#009090] text-white font-label-md text-xs uppercase tracking-widest px-6 py-3 rounded-full shadow-lg transition-all duration-300 hover:scale-105 hover:shadow-[0_0_20px_rgba(0,106,106,0.3)] font-bold border border-[#006a6a]/20">
                    Join GMA
                </a>
            </div>
        </div>
    </header>

    <main class="min-h-screen mx-auto relative overflow-hidden pt-36 pb-24">
        <!-- Top Background Area with Sparkles -->
        <div class="absolute top-0 h-96 w-screen overflow-hidden z-10 [mask-image:radial-gradient(50%_50%,white,transparent)] gsap-fade-up opacity-0 translate-y-[-20px] blur-[10px]">
            <div class="absolute inset-0 bg-grid-pattern"></div>
            <canvas id="sparkles-canvas"></canvas>
        </div>

        <!-- Huge Glowing Ellipses -->
        <div class="absolute left-0 top-[-114px] w-full h-[113.625vh] flex flex-col items-start justify-start overflow-hidden p-0 z-0 opacity-0 translate-y-[-20px] blur-[10px] gsap-fade-up">
            <div class="blurry-ellipse"></div>
            <div class="blurry-ellipse"></div>
        </div>

        <!-- Center Multiply Gradient -->
        <div class="absolute top-0 left-[10%] right-[10%] w-[80%] h-full z-0 opacity-40 mix-blend-multiply pointer-events-none" 
             style="background-image: radial-gradient(circle at center, #006a6a 0%, transparent 70%)">
        </div>

        <!-- Header Content -->
        <article class="text-center mb-16 pt-8 max-w-4xl mx-auto px-4 space-y-5 relative z-50">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-[#006a6a]/20 border border-[#40e0d0]/30 text-[#40e0d0] text-xs font-bold uppercase tracking-widest gsap-fade-up opacity-0">
                <span class="material-symbols-outlined text-[16px]">verified</span>
                <span>One-Time Investment • Lifetime Value</span>
            </div>

            <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold tracking-tight text-white flex justify-center flex-wrap gap-x-3 gap-y-1" id="title-container">
                <!-- GSAP Vertical Cut Reveal will populate this -->
            </h1>

            <p class="text-gray-300 text-lg md:text-xl max-w-2xl mx-auto font-light leading-relaxed gsap-fade-up opacity-0 translate-y-[-20px] blur-[10px]">
                Join GMA and start connecting, learning, and growing today. Choose the membership level tailored for your organizational goals.
            </p>
        </article>

        <!-- Pricing Cards Section -->
        <div id="membership-plans" class="grid lg:grid-cols-3 max-w-6xl gap-8 py-6 mx-auto px-4 relative z-50 items-stretch">
            
            <!-- Professional Membership -->
            <div class="rounded-3xl border border-white/15 bg-gradient-to-b from-white/[0.08] to-white/[0.02] backdrop-blur-xl shadow-xl relative z-10 opacity-0 translate-y-[-20px] blur-[10px] gsap-fade-up p-8 sm:p-10 flex flex-col h-full card-hover">
                <div class="flex flex-col mb-8">
                    <div class="flex items-center justify-between mb-4">
                        <span class="px-3.5 py-1 text-xs font-bold uppercase tracking-wider text-blue-300 bg-blue-500/20 border border-blue-400/30 rounded-full">Individual</span>
                    </div>
                    <h3 class="text-2xl sm:text-3xl font-bold mb-2 text-white">Professional Membership</h3>
                    <p class="text-sm text-blue-200 font-medium mb-6 flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[18px] text-[#40e0d0]">person</span>
                        Single user access
                    </p>
                    
                    <div class="flex items-baseline gap-2 pb-6 border-b border-white/10">
                        <span class="text-5xl sm:text-6xl font-extrabold tracking-tight text-white">$495</span>
                        <span class="text-sm font-semibold uppercase tracking-wider text-gray-400">One-Time</span>
                    </div>
                </div>

                <form action="{{ route('checkout.create') }}" method="POST" class="w-full mb-8">
                    @csrf
                    <input type="hidden" name="plan_id" value="{{ $profId }}">
                    <input type="hidden" name="period" value="one_time">
                    <button type="submit" class="w-full py-4 px-6 text-sm font-bold uppercase tracking-wider rounded-2xl bg-white/10 hover:bg-white/20 border border-white/20 text-white transition-all duration-300 hover:scale-[1.02] active:scale-95 flex items-center justify-center gap-2 group shadow-lg">
                        <span>Select Professional</span>
                        <span class="material-symbols-outlined text-[18px] transition-transform duration-300 group-hover:translate-x-1">arrow_forward</span>
                    </button>
                </form>

                <div class="space-y-4 flex-1">
                    <h4 class="font-bold text-xs uppercase tracking-wider text-gray-300">Membership Benefits:</h4>
                    <ul class="space-y-3.5">
                        <li class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-[#40e0d0] text-[20px] shrink-0 mt-0.5">check_circle</span>
                            <span class="text-sm text-gray-200 leading-snug">Exclusive industry <strong>webinars</strong> and online sessions</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-[#40e0d0] text-[20px] shrink-0 mt-0.5">check_circle</span>
                            <span class="text-sm text-gray-200 leading-snug">Access to proprietary <strong>research & insights</strong></span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-[#40e0d0] text-[20px] shrink-0 mt-0.5">check_circle</span>
                            <span class="text-sm text-gray-200 leading-snug">Global <strong>networking</strong> opportunities</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-[#40e0d0] text-[20px] shrink-0 mt-0.5">check_circle</span>
                            <span class="text-sm text-gray-200 leading-snug">Official member <strong>directory listing</strong></span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-[#40e0d0] text-[20px] shrink-0 mt-0.5">check_circle</span>
                            <span class="text-sm text-gray-200 leading-snug">Significant <strong>event discounts</strong> on conferences</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Business Membership (Popular) -->
            <div class="rounded-3xl border-2 border-[#40e0d0]/60 bg-gradient-to-b from-[#003c60]/90 via-[#002b4d]/90 to-[#001e40]/90 backdrop-blur-xl popular-glow relative z-20 opacity-0 translate-y-[-20px] blur-[10px] gsap-fade-up p-8 sm:p-10 flex flex-col h-full transform lg:-translate-y-4 card-hover">
                <div class="absolute -top-4 left-1/2 -translate-x-1/2 bg-gradient-to-r from-[#006a6a] to-[#40e0d0] text-[#001e40] font-black text-xs uppercase tracking-widest px-4 py-1.5 rounded-full shadow-lg">
                    Recommended for Teams
                </div>

                <div class="flex flex-col mb-8 mt-2">
                    <div class="flex items-center justify-between mb-4">
                        <span class="px-3.5 py-1 text-xs font-bold uppercase tracking-wider text-[#40e0d0] bg-[#006a6a]/40 border border-[#40e0d0]/40 rounded-full">Business</span>
                    </div>
                    <h3 class="text-2xl sm:text-3xl font-bold mb-2 text-white">Business Membership</h3>
                    <p class="text-sm text-[#40e0d0] font-medium mb-6 flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[18px]">groups</span>
                        Up to 5 users
                    </p>
                    
                    <div class="flex items-baseline gap-2 pb-6 border-b border-[#006a6a]/50">
                        <span class="text-5xl sm:text-6xl font-extrabold tracking-tight text-white">$1,495</span>
                        <span class="text-sm font-semibold uppercase tracking-wider text-[#40e0d0]/80">One-Time</span>
                    </div>
                </div>

                <form action="{{ route('checkout.create') }}" method="POST" class="w-full mb-8">
                    @csrf
                    <input type="hidden" name="plan_id" value="{{ $bizId }}">
                    <input type="hidden" name="period" value="one_time">
                    <button type="submit" class="w-full py-4 px-6 text-sm font-black uppercase tracking-wider rounded-2xl bg-gradient-to-r from-[#006a6a] to-[#40e0d0] hover:from-[#009090] hover:to-[#5efff0] text-[#001e40] shadow-xl shadow-[#006a6a]/40 transition-all duration-300 hover:scale-[1.03] active:scale-95 flex items-center justify-center gap-2 group">
                        <span>Select Business</span>
                        <span class="material-symbols-outlined text-[18px] transition-transform duration-300 group-hover:translate-x-1">arrow_forward</span>
                    </button>
                </form>

                <div class="space-y-4 flex-1">
                    <h4 class="font-bold text-xs uppercase tracking-wider text-[#40e0d0]">Everything in Professional, plus:</h4>
                    <ul class="space-y-3.5">
                        <li class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-[#40e0d0] text-[20px] shrink-0 mt-0.5 drop-shadow-[0_0_8px_rgba(64,224,208,0.8)]">check_circle</span>
                            <span class="text-sm text-white leading-snug"><strong>Enhanced visibility</strong> across GMA channels and platforms</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-[#40e0d0] text-[20px] shrink-0 mt-0.5 drop-shadow-[0_0_8px_rgba(64,224,208,0.8)]">check_circle</span>
                            <span class="text-sm text-white leading-snug">Participation in exclusive <strong>roundtables and working groups</strong></span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-[#40e0d0] text-[20px] shrink-0 mt-0.5 drop-shadow-[0_0_8px_rgba(64,224,208,0.8)]">check_circle</span>
                            <span class="text-sm text-white leading-snug"><strong>Early access</strong> to industry research and announcements</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-[#40e0d0] text-[20px] shrink-0 mt-0.5 drop-shadow-[0_0_8px_rgba(64,224,208,0.8)]">check_circle</span>
                            <span class="text-sm text-white leading-snug"><strong>Thought leadership</strong> contribution opportunities</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Strategic Membership -->
            <div class="rounded-3xl border border-white/15 bg-gradient-to-b from-white/[0.08] to-white/[0.02] backdrop-blur-xl shadow-xl relative z-10 opacity-0 translate-y-[-20px] blur-[10px] gsap-fade-up p-8 sm:p-10 flex flex-col h-full card-hover">
                <div class="flex flex-col mb-8">
                    <div class="flex items-center justify-between mb-4">
                        <span class="px-3.5 py-1 text-xs font-bold uppercase tracking-wider text-purple-300 bg-purple-500/20 border border-purple-400/30 rounded-full">Executive</span>
                    </div>
                    <h3 class="text-2xl sm:text-3xl font-bold mb-2 text-white">Strategic Membership</h3>
                    <p class="text-sm text-purple-200 font-medium mb-6 flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[18px] text-purple-400">corporate_fare</span>
                        Up to 15 users
                    </p>
                    
                    <div class="flex items-baseline gap-2 pb-6 border-b border-white/10">
                        <span class="text-5xl sm:text-6xl font-extrabold tracking-tight text-white">$2,995</span>
                        <span class="text-sm font-semibold uppercase tracking-wider text-gray-400">One-Time</span>
                    </div>
                </div>

                <form action="{{ route('checkout.create') }}" method="POST" class="w-full mb-8">
                    @csrf
                    <input type="hidden" name="plan_id" value="{{ $stratId }}">
                    <input type="hidden" name="period" value="one_time">
                    <button type="submit" class="w-full py-4 px-6 text-sm font-bold uppercase tracking-wider rounded-2xl bg-white/10 hover:bg-white/20 border border-white/20 text-white transition-all duration-300 hover:scale-[1.02] active:scale-95 flex items-center justify-center gap-2 group shadow-lg">
                        <span>Select Strategic</span>
                        <span class="material-symbols-outlined text-[18px] transition-transform duration-300 group-hover:translate-x-1">arrow_forward</span>
                    </button>
                </form>

                <div class="space-y-4 flex-1">
                    <h4 class="font-bold text-xs uppercase tracking-wider text-gray-300">Everything in Business, plus:</h4>
                    <ul class="space-y-3.5">
                        <li class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-[#40e0d0] text-[20px] shrink-0 mt-0.5">check_circle</span>
                            <span class="text-sm text-gray-200 leading-snug">High-profile <strong>sponsorship opportunities</strong> at GMA events</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-[#40e0d0] text-[20px] shrink-0 mt-0.5">check_circle</span>
                            <span class="text-sm text-gray-200 leading-snug"><strong>Featured member spotlights</strong> in global communications</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-[#40e0d0] text-[20px] shrink-0 mt-0.5">check_circle</span>
                            <span class="text-sm text-gray-200 leading-snug">Exclusive executive <strong>strategic briefings</strong></span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-[#40e0d0] text-[20px] shrink-0 mt-0.5">check_circle</span>
                            <span class="text-sm text-gray-200 leading-snug">Direct <strong>advisory participation</strong> opportunities</span>
                        </li>
                    </ul>
                </div>
            </div>

        </div>

        <!-- Registration & Contact Banner -->
        <div class="max-w-4xl mx-auto px-4 mt-16 relative z-50 gsap-fade-up opacity-0 translate-y-[-20px] blur-[10px]">
            <div class="rounded-3xl bg-gradient-to-r from-[#002b4d] via-[#003c60] to-[#002b4d] border border-[#006a6a]/50 p-8 sm:p-10 shadow-2xl flex flex-col md:flex-row items-center justify-between gap-8">
                <div class="flex items-center gap-6 text-left">
                    <div class="w-16 h-16 rounded-2xl bg-white/10 border border-white/20 flex items-center justify-center shrink-0 shadow-inner">
                        <span class="material-symbols-outlined text-4xl text-[#40e0d0]">qr_code_2</span>
                    </div>
                    <div>
                        <h4 class="text-xl font-bold text-white mb-1">Scan to Register</h4>
                        <p class="text-sm text-gray-300 font-light">Join GMA and start connecting, learning, and growing today.</p>
                    </div>
                </div>

                <div class="h-px w-full md:w-px md:h-12 bg-white/10 shrink-0"></div>

                <a href="https://www.globalmobileassociation.biz" target="_blank" rel="noopener noreferrer" class="flex items-center gap-3 px-6 py-3.5 rounded-2xl bg-white/10 hover:bg-white/20 border border-white/20 text-white font-medium transition-all duration-300 hover:scale-105 shrink-0 group">
                    <span class="material-symbols-outlined text-[#40e0d0] transition-transform group-hover:rotate-45">language</span>
                    <span class="text-sm sm:text-base font-semibold tracking-wide">www.globalmobileassociation.biz</span>
                </a>
            </div>
        </div>
    </main>

    <script>
        // 1. Initial GSAP Fade-up animations
        document.addEventListener('DOMContentLoaded', () => {
            gsap.to('.gsap-fade-up', {
                y: 0,
                opacity: 1,
                filter: 'blur(0px)',
                duration: 0.6,
                stagger: 0.2,
                ease: 'power2.out',
                delay: 0.2
            });
            
            // Vertical Cut Reveal Text
            const titleStr = "Membership Options";
            const titleWords = titleStr.split(' ');
            const titleContainer = document.getElementById('title-container');
            
            titleWords.forEach(word => {
                const wordWrap = document.createElement('span');
                wordWrap.className = 'word-reveal';
                const innerWord = document.createElement('span');
                innerWord.innerText = word + ' ';
                wordWrap.appendChild(innerWord);
                titleContainer.appendChild(wordWrap);
            });

            gsap.to('.word-reveal span', {
                y: '0%',
                duration: 0.8,
                stagger: 0.15,
                ease: 'back.out(1.7)',
                delay: 0.1
            });
        });

        // 2. Sparkles Canvas Script
        const canvas = document.getElementById('sparkles-canvas');
        const ctx = canvas.getContext('2d');
        let width, height;
        let particles = [];

        function resize() {
            width = canvas.width = window.innerWidth;
            height = canvas.height = document.querySelector('.bg-grid-pattern').parentElement.offsetHeight;
        }

        class Particle {
            constructor() {
                this.reset();
                this.y = Math.random() * height; // initial random spread
            }
            reset() {
                this.x = Math.random() * width;
                this.y = height + Math.random() * 20; // start below
                this.size = Math.random() * 1.5 + 0.5;
                this.speed = Math.random() * 0.5 + 0.1;
                this.opacity = Math.random() * 0.5 + 0.1;
                this.opacitySpeed = (Math.random() * 0.02 - 0.01);
            }
            update() {
                this.y -= this.speed;
                this.opacity += this.opacitySpeed;
                if (this.opacity <= 0.1 || this.opacity >= 1) this.opacitySpeed *= -1;
                if (this.y < -10) this.reset();
            }
            draw() {
                ctx.fillStyle = `rgba(255, 255, 255, ${this.opacity})`;
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                ctx.fill();
            }
        }

        function initParticles() {
            resize();
            particles = [];
            const density = window.innerWidth < 768 ? 500 : 1500;
            for(let i = 0; i < density; i++) {
                particles.push(new Particle());
            }
        }

        function animate() {
            ctx.clearRect(0, 0, width, height);
            particles.forEach(p => {
                p.update();
                p.draw();
            });
            requestAnimationFrame(animate);
        }

        window.addEventListener('resize', () => {
            resize();
        });

        initParticles();
        animate();
    </script>
</body>
</html>
