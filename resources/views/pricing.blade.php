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

        .card-prof, .card-biz, .card-strat {
            transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
        }
        .card-prof:hover {
            transform: translateY(-8px);
            box-shadow: 0px 20px 60px 0px rgba(0,0,0,0.5), 0px 0px 45px 0px rgba(59,130,246,0.45);
            border-color: rgba(96,165,250,0.6) !important;
        }
        .card-biz:hover {
            transform: translateY(-8px);
            box-shadow: 0px 20px 60px 0px rgba(0,0,0,0.5), 0px 0px 45px 0px rgba(20,184,166,0.45);
            border-color: rgba(45,212,191,0.6) !important;
        }
        .card-strat:hover {
            transform: translateY(-8px);
            box-shadow: 0px 20px 60px 0px rgba(0,0,0,0.5), 0px 0px 45px 0px rgba(139,92,246,0.45);
            border-color: rgba(167,139,250,0.6) !important;
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

    <div class="fixed top-6 left-6 z-50">
        <a href="{{ route('home') }}" class="flex items-center gap-2 bg-white/10 backdrop-blur-md border border-white/20 text-white px-5 py-2.5 rounded-full shadow-lg transition-all duration-300 hover:bg-white/20 hover:scale-105 active:scale-95 text-sm font-medium">
            <span class="material-symbols-outlined text-lg">arrow_back</span>
            <span>Back to Home</span>
        </a>
    </div>

    <main class="min-h-screen mx-auto relative overflow-hidden pt-36 pb-24">
        @if(session('error'))
        <div class="max-w-2xl mx-auto px-4 mb-8 relative z-50">
            <div class="bg-red-500/15 border border-red-500/35 text-red-200 px-6 py-4 rounded-2xl flex items-start gap-3 backdrop-blur-md shadow-lg">
                <span class="material-symbols-outlined text-red-400 mt-0.5">error</span>
                <div class="flex-1 text-left">
                    <h4 class="font-bold text-red-300">Access Restricted</h4>
                    <p class="text-sm mt-0.5 text-zinc-300">{{ session('error') }}</p>
                </div>
            </div>
        </div>
        @endif
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
                <span>Annual Investment • Lifetime Value</span>
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
            <div class="rounded-3xl border border-white/15 bg-gradient-to-b from-white/[0.08] to-white/[0.02] backdrop-blur-xl shadow-xl relative z-10 opacity-0 translate-y-[-20px] blur-[10px] gsap-fade-up p-8 sm:p-10 flex flex-col h-full card-prof">
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
                        <span class="text-sm font-semibold uppercase tracking-wider text-gray-400">Annually</span>
                    </div>
                </div>

                <a href="{{ route('checkout.init', ['plan' => $profId, 'period' => 'one_time']) }}" class="w-full mb-8 block">
                    <button type="button" class="w-full py-4 px-6 text-sm font-bold uppercase tracking-wider rounded-2xl bg-gradient-to-r from-blue-600 to-sky-400 hover:from-blue-500 hover:to-sky-300 text-white shadow-xl shadow-blue-500/20 transition-all duration-300 hover:scale-[1.02] active:scale-95 flex items-center justify-center gap-2 group">
                        <span>Select Professional</span>
                        <span class="material-symbols-outlined text-[18px] transition-transform duration-300 group-hover:translate-x-1">arrow_forward</span>
                    </button>
                </a>

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

            <!-- Business Membership -->
            <div class="rounded-3xl border border-white/15 bg-gradient-to-b from-white/[0.08] to-white/[0.02] backdrop-blur-xl shadow-xl relative z-10 opacity-0 translate-y-[-20px] blur-[10px] gsap-fade-up p-8 sm:p-10 flex flex-col h-full card-biz">
                <div class="flex flex-col mb-8">
                    <div class="flex items-center justify-between mb-4">
                        <span class="px-3.5 py-1 text-xs font-bold uppercase tracking-wider text-[#40e0d0] bg-[#006a6a]/40 border border-[#40e0d0]/40 rounded-full">Business</span>
                    </div>
                    <h3 class="text-2xl sm:text-3xl font-bold mb-2 text-white">Business Membership</h3>
                    <p class="text-sm text-[#40e0d0] font-medium mb-6 flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[18px]">groups</span>
                        Up to 5 users
                    </p>
                    
                    <div class="flex items-baseline gap-2 pb-6 border-b border-white/10">
                        <span class="text-5xl sm:text-6xl font-extrabold tracking-tight text-white">$1,495</span>
                        <span class="text-sm font-semibold uppercase tracking-wider text-[#40e0d0]/80">Annually</span>
                    </div>
                </div>

                <a href="{{ route('checkout.init', ['plan' => $bizId, 'period' => 'one_time']) }}" class="w-full mb-8 block">
                    <button type="button" class="w-full py-4 px-6 text-sm font-bold uppercase tracking-wider rounded-2xl bg-gradient-to-r from-[#006a6a] to-[#40e0d0] hover:from-[#009090] hover:to-[#5efff0] text-[#001e40] shadow-xl shadow-[#006a6a]/20 transition-all duration-300 hover:scale-[1.02] active:scale-95 flex items-center justify-center gap-2 group">
                        <span>Select Business</span>
                        <span class="material-symbols-outlined text-[18px] transition-transform duration-300 group-hover:translate-x-1">arrow_forward</span>
                    </button>
                </a>

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
            <div class="rounded-3xl border border-white/15 bg-gradient-to-b from-white/[0.08] to-white/[0.02] backdrop-blur-xl shadow-xl relative z-10 opacity-0 translate-y-[-20px] blur-[10px] gsap-fade-up p-8 sm:p-10 flex flex-col h-full card-strat">
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
                        <span class="text-sm font-semibold uppercase tracking-wider text-gray-400">Annually</span>
                    </div>
                </div>

                <a href="{{ route('checkout.init', ['plan' => $stratId, 'period' => 'one_time']) }}" class="w-full mb-8 block">
                    <button type="button" class="w-full py-4 px-6 text-sm font-bold uppercase tracking-wider rounded-2xl bg-gradient-to-r from-[#7c3aed] to-[#8b5cf6] hover:from-[#6d28d9] hover:to-[#7c3aed] text-white shadow-xl shadow-purple-500/20 transition-all duration-300 hover:scale-[1.02] active:scale-95 flex items-center justify-center gap-2 group">
                        <span>Select Strategic</span>
                        <span class="material-symbols-outlined text-[18px] transition-transform duration-300 group-hover:translate-x-1">arrow_forward</span>
                    </button>
                </a>

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
