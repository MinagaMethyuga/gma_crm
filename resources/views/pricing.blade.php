<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GMA - Pricing</title>
    <link rel="icon" href="/Global_Mobile_Association_Logo__1_-removebg-preview.png" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0,1&display=swap" rel="stylesheet">
    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
    <style>
        /* Shared Header Styles (Matches other pages) */
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
            box-shadow: 0px -13px 300px 0px rgba(0,106,106,0.5); /* GMA Teal Glow */
        }

        /* Toggle switch active state */
        .toggle-btn {
            position: relative;
            z-index: 10;
        }
        .toggle-bg {
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            border-radius: 9999px;
            border: 4px solid #006a6a;
            background: linear-gradient(to top, #009090, #006a6a); /* GMA Teal Gradient */
            box-shadow: 0 1px 2px rgba(0,106,106,0.5);
            z-index: -1;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        /* Number rolling effect */
        .price-number {
            display: inline-flex;
            overflow: hidden;
            height: 1em;
            vertical-align: baseline;
        }
        .price-digits {
            display: inline-flex;
            flex-direction: column;
            transition: transform 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
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
                <button class="hidden sm:inline-block relative overflow-hidden bg-gradient-to-r from-[#006a6a] to-[#009090] text-white font-label-md text-xs uppercase tracking-widest px-6 py-3 rounded-full shadow-lg transition-all duration-300 hover:scale-103 hover:shadow-[0_0_20px_rgba(0,106,106,0.2)] font-bold border border-[#006a6a]/20">
                    Join GMA
                </button>
            </div>
        </div>
    </header>

    <main class="min-h-screen mx-auto relative overflow-hidden pt-32 pb-24">
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
        <article class="text-center mb-10 pt-16 max-w-3xl mx-auto space-y-4 relative z-50">
            <h2 class="text-4xl md:text-5xl font-medium text-white flex justify-center flex-wrap gap-2" id="title-container">
                <!-- GSAP Vertical Cut Reveal will populate this -->
            </h2>

            <p class="text-gray-300 text-lg gsap-fade-up opacity-0 translate-y-[-20px] blur-[10px]">
                Trusted by millions, We help teams all around the world, Explore which option is right for you.
            </p>

            <div class="flex justify-center mt-8 gsap-fade-up opacity-0 translate-y-[-20px] blur-[10px]">
                <div class="relative z-10 mx-auto flex w-fit rounded-full bg-neutral-900 border border-neutral-700 p-1">
                    <!-- Toggle Pill Background -->
                    <div id="toggle-bg" class="toggle-bg"></div>
                    
                    <button id="btn-monthly" class="toggle-btn w-fit h-10 rounded-full sm:px-6 px-4 py-1 font-medium transition-colors text-white" onclick="setPricing('monthly')">
                        Monthly
                    </button>
                    <button id="btn-yearly" class="toggle-btn w-fit h-10 rounded-full sm:px-6 px-4 py-1 font-medium transition-colors text-gray-400" onclick="setPricing('yearly')">
                        Yearly
                    </button>
                </div>
            </div>
        </article>

        <!-- Pricing Cards -->
        <div class="grid md:grid-cols-3 max-w-5xl gap-6 py-6 mx-auto px-4 relative z-50">
            
            <!-- Starter Plan -->
            <div class="rounded-2xl border border-neutral-800 bg-gradient-to-r from-neutral-900 via-neutral-800 to-neutral-900 shadow-sm relative z-10 opacity-0 translate-y-[-20px] blur-[10px] gsap-fade-up p-8 flex flex-col h-full">
                <div class="flex flex-col space-y-1.5 mb-6">
                    <h3 class="text-3xl font-medium mb-2">Starter</h3>
                    <div class="flex items-baseline text-4xl font-semibold mb-2">
                        $
                        <div class="price-number font-semibold" data-monthly="12" data-yearly="99">
                            <div class="price-digits"><span>12</span><span>99</span></div>
                        </div>
                        <span class="text-sm text-gray-400 ml-1 font-normal pricing-period">/month</span>
                    </div>
                    <p class="text-sm text-gray-400 font-light">Great for small businesses and startups looking to get started with AI</p>
                </div>
                <button class="w-full mb-8 p-3 text-lg font-medium rounded-xl bg-gradient-to-t from-neutral-950 to-neutral-700 shadow-lg shadow-neutral-900 border border-neutral-700 text-white transition-transform hover:scale-[1.02] active:scale-95">
                    Get started
                </button>
                <div class="space-y-4 pt-6 border-t border-neutral-800 flex-1">
                    <h4 class="font-medium text-base text-gray-200">Free includes:</h4>
                    <ul class="space-y-3">
                        <li class="flex items-center gap-3"><span class="h-2 w-2 bg-neutral-500 rounded-full"></span><span class="text-sm text-gray-300 font-light">Unlimited Cards</span></li>
                        <li class="flex items-center gap-3"><span class="h-2 w-2 bg-neutral-500 rounded-full"></span><span class="text-sm text-gray-300 font-light">Custom background & stickers</span></li>
                        <li class="flex items-center gap-3"><span class="h-2 w-2 bg-neutral-500 rounded-full"></span><span class="text-sm text-gray-300 font-light">2-factor authentication</span></li>
                        <li class="flex items-center gap-3"><span class="h-2 w-2 bg-neutral-500 rounded-full"></span><span class="text-sm text-gray-300 font-light">Unlimited Cards</span></li>
                        <li class="flex items-center gap-3"><span class="h-2 w-2 bg-neutral-500 rounded-full"></span><span class="text-sm text-gray-300 font-light">Custom background & stickers</span></li>
                    </ul>
                </div>
            </div>

            <!-- Business Plan (Popular) -->
            <div class="rounded-2xl border border-[#006a6a]/50 bg-gradient-to-r from-[#002b4d] via-[#003c60] to-[#002b4d] popular-glow relative z-20 opacity-0 translate-y-[-20px] blur-[10px] gsap-fade-up p-8 flex flex-col h-full transform md:scale-105">
                <div class="flex flex-col space-y-1.5 mb-6">
                    <div class="flex justify-between items-center mb-2">
                        <h3 class="text-3xl font-medium text-[#40e0d0]">Business</h3>
                        <span class="px-3 py-1 text-xs font-semibold uppercase tracking-wider text-[#40e0d0] bg-[#006a6a]/30 border border-[#006a6a]/50 rounded-full">Popular</span>
                    </div>
                    <div class="flex items-baseline text-4xl font-semibold mb-2 text-white">
                        $
                        <div class="price-number font-semibold" data-monthly="48" data-yearly="399">
                            <div class="price-digits"><span>48</span><span>399</span></div>
                        </div>
                        <span class="text-sm text-[#40e0d0]/60 ml-1 font-normal pricing-period">/month</span>
                    </div>
                    <p class="text-sm text-[#40e0d0]/70 font-light">Best value for growing businesses that need more advanced features</p>
                </div>
                <button class="w-full mb-8 p-3 text-lg font-semibold rounded-xl bg-gradient-to-t from-[#006a6a] to-[#009090] shadow-lg shadow-[#006a6a]/50 border border-[#40e0d0]/50 text-white transition-transform hover:scale-[1.02] active:scale-95">
                    Get started
                </button>
                <div class="space-y-4 pt-6 border-t border-[#006a6a]/30 flex-1">
                    <h4 class="font-medium text-base text-white">Everything in Starter, plus:</h4>
                    <ul class="space-y-3">
                        <li class="flex items-center gap-3"><span class="h-2 w-2 bg-[#40e0d0] rounded-full shadow-[0_0_8px_rgba(64,224,208,0.8)]"></span><span class="text-sm text-gray-200 font-light">Advanced checklists</span></li>
                        <li class="flex items-center gap-3"><span class="h-2 w-2 bg-[#40e0d0] rounded-full shadow-[0_0_8px_rgba(64,224,208,0.8)]"></span><span class="text-sm text-gray-200 font-light">Custom fields</span></li>
                        <li class="flex items-center gap-3"><span class="h-2 w-2 bg-[#40e0d0] rounded-full shadow-[0_0_8px_rgba(64,224,208,0.8)]"></span><span class="text-sm text-gray-200 font-light">Serverless functions</span></li>
                        <li class="flex items-center gap-3"><span class="h-2 w-2 bg-[#40e0d0] rounded-full shadow-[0_0_8px_rgba(64,224,208,0.8)]"></span><span class="text-sm text-gray-200 font-light">Advanced checklists</span></li>
                        <li class="flex items-center gap-3"><span class="h-2 w-2 bg-[#40e0d0] rounded-full shadow-[0_0_8px_rgba(64,224,208,0.8)]"></span><span class="text-sm text-gray-200 font-light">Custom fields</span></li>
                    </ul>
                </div>
            </div>

            <!-- Enterprise Plan -->
            <div class="rounded-2xl border border-neutral-800 bg-gradient-to-r from-neutral-900 via-neutral-800 to-neutral-900 shadow-sm relative z-10 opacity-0 translate-y-[-20px] blur-[10px] gsap-fade-up p-8 flex flex-col h-full">
                <div class="flex flex-col space-y-1.5 mb-6">
                    <h3 class="text-3xl font-medium mb-2">Enterprise</h3>
                    <div class="flex items-baseline text-4xl font-semibold mb-2">
                        $
                        <div class="price-number font-semibold" data-monthly="96" data-yearly="899">
                            <div class="price-digits"><span>96</span><span>899</span></div>
                        </div>
                        <span class="text-sm text-gray-400 ml-1 font-normal pricing-period">/month</span>
                    </div>
                    <p class="text-sm text-gray-400 font-light">Advanced plan with enhanced security and unlimited access for large teams</p>
                </div>
                <button class="w-full mb-8 p-3 text-lg font-medium rounded-xl bg-gradient-to-t from-neutral-950 to-neutral-700 shadow-lg shadow-neutral-900 border border-neutral-700 text-white transition-transform hover:scale-[1.02] active:scale-95">
                    Get started
                </button>
                <div class="space-y-4 pt-6 border-t border-neutral-800 flex-1">
                    <h4 class="font-medium text-base text-gray-200">Everything in Business, plus:</h4>
                    <ul class="space-y-3">
                        <li class="flex items-center gap-3"><span class="h-2 w-2 bg-neutral-500 rounded-full"></span><span class="text-sm text-gray-300 font-light">Multi-board management</span></li>
                        <li class="flex items-center gap-3"><span class="h-2 w-2 bg-neutral-500 rounded-full"></span><span class="text-sm text-gray-300 font-light">Multi-board guest</span></li>
                        <li class="flex items-center gap-3"><span class="h-2 w-2 bg-neutral-500 rounded-full"></span><span class="text-sm text-gray-300 font-light">Attachment permissions</span></li>
                        <li class="flex items-center gap-3"><span class="h-2 w-2 bg-neutral-500 rounded-full"></span><span class="text-sm text-gray-300 font-light">Multi-board management</span></li>
                        <li class="flex items-center gap-3"><span class="h-2 w-2 bg-neutral-500 rounded-full"></span><span class="text-sm text-gray-300 font-light">Multi-board guest</span></li>
                    </ul>
                </div>
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
            const titleStr = "Plans that works best for your";
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

        // 2. Pricing Toggle Logic
        let isYearly = false;
        function setPricing(period) {
            isYearly = (period === 'yearly');
            
            const btnMonthly = document.getElementById('btn-monthly');
            const btnYearly = document.getElementById('btn-yearly');
            const toggleBg = document.getElementById('toggle-bg');
            
            if (isYearly) {
                btnMonthly.classList.replace('text-white', 'text-gray-400');
                btnYearly.classList.replace('text-gray-400', 'text-white');
                toggleBg.style.transform = `translateX(${btnMonthly.offsetWidth}px)`;
                toggleBg.style.width = `${btnYearly.offsetWidth}px`;
            } else {
                btnMonthly.classList.replace('text-gray-400', 'text-white');
                btnYearly.classList.replace('text-white', 'text-gray-400');
                toggleBg.style.transform = 'translateX(0)';
                toggleBg.style.width = `${btnMonthly.offsetWidth}px`;
            }

            // Animate Prices
            document.querySelectorAll('.price-digits').forEach(el => {
                el.style.transform = isYearly ? 'translateY(-100%)' : 'translateY(0)';
            });

            // Update Labels
            document.querySelectorAll('.pricing-period').forEach(el => {
                el.innerText = isYearly ? '/year' : '/month';
            });
        }

        // Initialize toggle background width
        window.addEventListener('load', () => {
            const btnMonthly = document.getElementById('btn-monthly');
            const toggleBg = document.getElementById('toggle-bg');
            toggleBg.style.width = `${btnMonthly.offsetWidth}px`;
        });

        // 3. Sparkles Canvas Script
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
