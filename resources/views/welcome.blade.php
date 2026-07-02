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
    @include('components.page-transition')

    @include('components.public-header', ['active' => 'home'])

    <main class="pt-0 relative overflow-hidden bg-[#f8fafd]">

        <!-- Ambient floating glow circles -->
        <div class="absolute top-[-10%] left-[-10%] w-[500px] h-[500px] rounded-full bg-[#006a6a]/8 blur-[120px] pointer-events-none animate-float-slow"></div>
        <div class="absolute top-[20%] right-[-10%] w-[600px] h-[600px] rounded-full bg-[#009090]/20 blur-[150px] pointer-events-none animate-float-slow-reverse"></div>
        <div class="absolute top-[50%] left-[20%] w-[450px] h-[450px] rounded-full bg-[#40e0d0]/15 blur-[130px] pointer-events-none animate-float-slow"></div>
        <div class="absolute bottom-[10%] right-[10%] w-[500px] h-[500px] rounded-full bg-[#006a6a]/8 blur-[140px] pointer-events-none animate-float-slow-reverse"></div>

        <!-- Hero Section -->
        <section id="hero-section" class="relative min-h-[850px] flex items-center overflow-hidden bg-mesh-glow pt-32 pb-[120px]">
            <div class="absolute inset-0 z-0 bg-gradient-to-br from-[#001e40]/95 via-[#003c70]/85 to-[#006a6a]/80">
                <img alt="Tech Laboratory background" src="/gma_hero_bg.png" class="w-full h-full object-cover opacity-30 mix-blend-overlay saturate-125 contrast-125">
                <div class="absolute inset-0 bg-gradient-to-r from-[#001e40] via-[#003c70]/90 to-transparent"></div>
            </div>
            <div class="relative z-10 max-w-[1280px] mx-auto px-4 md:px-10 w-full py-16">
                <div class="max-w-3xl">
                    <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-[4rem] font-bold mb-6 leading-tight text-transparent bg-clip-text bg-gradient-to-br from-white via-[#40e0d0] to-[#009090] animate-fade-in-up" style="animation-delay: 0.25s">
                        Advancing Trust, Leadership, and Growth in the Used Mobile Ecosystem
                    </h1>
                    <p class="text-lg md:text-xl text-white/80 mb-10 max-w-2xl leading-relaxed animate-fade-in-up" style="animation-delay: 0.4s">
                        The Global Mobile Association provides the strategic framework, standards, and community necessary to scale businesses in the secondary mobile market.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 animate-fade-in-up" style="animation-delay: 0.55s">
                        <button class="bg-gradient-to-r from-[#006a6a] to-[#009090] text-white font-label-md text-[13px] uppercase tracking-widest px-10 py-4 rounded-full shadow-lg transition-all duration-300 hover:scale-103 hover:shadow-[0_20px_40px_-10px_rgba(0,106,106,0.45)] active:scale-98">
                            Join GMA
                        </button>
                        <a href="{{ route('about') }}" class="border-2 border-white/60 text-white font-label-md text-[13px] uppercase tracking-widest px-10 py-4 rounded-full transition-all duration-300 hover:scale-103 hover:bg-white/10 hover:border-white active:scale-98 shadow-sm text-center">
                            Learn How GMA Supports the Industry
                        </a>
                    </div>
                </div>
            </div>
            <!-- Smooth arc divider into Problem section -->
            <div class="absolute bottom-0 left-0 right-0 w-full overflow-hidden leading-[0] z-20">
                <svg viewBox="0 0 1440 92" preserveAspectRatio="none" class="w-full h-[57px] md:h-[92px] block">
                    <path d="M0,90 C360,0 1080,0 1440,90 L1440,92 L0,92 Z" fill="#f0fdfa"/>
                </svg>
            </div>
        </section>

        <!-- Problem Section -->
        <section class="py-24 bg-[#f0fdfa] bg-gradient-to-tr from-[#f0fdfa] via-[#ecfeff] to-[#eff6ff] relative pb-[120px] -mt-[2px]">
            <div class="max-w-[1280px] mx-auto px-4 md:px-10">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                    <div class="observer-fade-in opacity-0 translate-y-8 transition-all duration-1000 ease-[cubic-bezier(0.2,0.8,0.2,1)]">
                        <span class="text-[#006a6a] font-semibold text-[13px] uppercase tracking-widest mb-4 block relative after:content-[''] after:absolute after:bottom-[-6px] after:left-0 after:w-12 after:h-[2px] after:bg-[#006a6a]">
                            The Problem
                        </span>
                        <h2 class="text-[2.5rem] font-bold text-[#001e40] mb-6 leading-tight mt-6">A Fragmented Market Demands a Unified Voice</h2>
                        <p class="text-lg text-[#666] mb-6 leading-relaxed">The secondary mobile market is experiencing massive growth, yet remains deeply fragmented. To thrive, companies need more than just occasional networking events. They need continuous connection, shared standards, and collaborative innovation.</p>
                        <p class="text-lg text-[#666] leading-relaxed">GMA was created to solve this isolation, bridging the gap between global wholesalers, refurbishers, and retailers with a year-round ecosystem built on trust and excellence.</p>
                    </div>
                    <div class="relative aspect-square md:aspect-video rounded-2xl overflow-hidden border-2 border-[#006a6a]/20 shadow-lg hover:scale-[1.025] hover:shadow-[0_25px_50px_-12px_rgba(0,106,106,0.15)] transition-all duration-1000 observer-fade-in opacity-0 translate-y-8 delay-200 ease-[cubic-bezier(0.2,0.8,0.2,1)]">
                        <img alt="Graded used smartphones in facility" src="/gma_problem_phones.png" class="w-full h-full object-cover saturate-[0.95] contrast-[1.05]">
                    </div>
                </div>
            </div>
            </div>
        </section>

        <!-- Guide Section -->
        <section class="py-24 bg-gradient-to-br from-[#001e40] via-[#003c70] to-[#006a6a] text-white relative pb-[120px]">
            <!-- Top SVG Divider (Light Curve) -->
            <div class="absolute top-0 left-0 right-0 w-full overflow-hidden leading-[0] z-20">
                <svg viewBox="0 0 1440 92" preserveAspectRatio="none" class="w-full h-[57px] md:h-[92px] block">
                    <path d="M0,0 C360,90 1080,90 1440,0 Z" fill="#eff6ff"/>
                </svg>
            </div>
            
            <div class="absolute inset-0 bg-mesh-glow opacity-30 pointer-events-none"></div>
            <div class="max-w-[1280px] mx-auto px-4 md:px-10 relative z-10 pt-10">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <span class="text-[#40e0d0] font-semibold text-[13px] uppercase tracking-widest mb-4 inline-block relative after:content-[''] after:absolute after:bottom-[-6px] after:left-1/2 after:-translate-x-1/2 after:w-12 after:h-[2px] after:bg-[#40e0d0]">
                        The Guide
                    </span>
                    <h2 class="text-[2.5rem] font-bold text-white mb-4 mt-6 leading-tight">Your Strategic Partner for Growth</h2>
                    <p class="text-lg text-white/90">GMA acts as the definitive body for the used mobile industry, providing the tools and networks essential for modern enterprises to scale.</p>
                </div>
                <!-- Removed stagger-children class below -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="backdrop-blur-md bg-white/10 p-8 rounded-2xl border-2 border-white/10 shadow-sm transition-all duration-1000 ease-[cubic-bezier(0.2,0.8,0.2,1)] hover:-translate-y-2 hover:scale-[1.01] hover:shadow-[0_25px_50px_-12px_rgba(255,255,255,0.06)] hover:border-white/45 observer-fade-in opacity-0 translate-y-8">
                        <div class="w-14 h-14 rounded-xl bg-white/15 flex items-center justify-center mb-6 text-[#40e0d0] shadow-sm border border-white/10">
                            <span class="material-symbols-outlined text-4xl block">hub</span>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-4 leading-snug">Year-Round Industry Connection</h3>
                        <p class="text-base text-white/80 leading-relaxed">Access a global network of secondary market leaders 365 days a year through our member-only platforms.</p>
                    </div>
                    <div class="backdrop-blur-md bg-white/10 p-8 rounded-2xl border-2 border-white/10 shadow-sm transition-all duration-1000 ease-[cubic-bezier(0.2,0.8,0.2,1)] delay-150 hover:-translate-y-2 hover:scale-[1.01] hover:shadow-[0_25px_50px_-12px_rgba(255,255,255,0.06)] hover:border-white/45 observer-fade-in opacity-0 translate-y-8">
                        <div class="w-14 h-14 rounded-xl bg-white/15 flex items-center justify-center mb-6 text-[#40e0d0] shadow-sm border border-white/10">
                            <span class="material-symbols-outlined text-4xl block">school</span>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-4 leading-snug">Practical Education Through Webinars, Workshops, Case Studies and more...</h3>
                        <p class="text-base text-white/80 leading-relaxed">Participate in expert-led sessions focused on operational excellence, AI integration, and profit optimization.</p>
                    </div>
                    <div class="backdrop-blur-md bg-white/10 p-8 rounded-2xl border-2 border-white/10 shadow-sm transition-all duration-1000 ease-[cubic-bezier(0.2,0.8,0.2,1)] delay-300 hover:-translate-y-2 hover:scale-[1.01] hover:shadow-[0_25px_50px_-12px_rgba(255,255,255,0.06)] hover:border-white/45 observer-fade-in opacity-0 translate-y-8">
                        <div class="w-14 h-14 rounded-xl bg-white/15 flex items-center justify-center mb-6 text-[#40e0d0] shadow-sm border border-white/10">
                            <span class="material-symbols-outlined text-4xl block">groups</span>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-4 leading-snug">Committee-Led Industry Collaboration</h3>
                        <p class="text-base text-white/80 leading-relaxed">Influence the direction of the industry, partnerships, and cooperation globally through these member-led groups.</p>
                    </div>
                </div>
            </div>
            <!-- Smooth arc divider into Serve section -->
            <div class="absolute bottom-0 left-0 right-0 w-full overflow-hidden leading-[0] z-20">
                <svg viewBox="0 0 1440 90" preserveAspectRatio="none" class="w-full h-[55px] md:h-[90px] block">
                    <path d="M0,90 C360,0 1080,0 1440,90 L1440,90 L0,90 Z" fill="#f5fbfb"/>
                </svg>
            </div>
        </section>

        <!-- Who GMA Serves -->
        <!-- FIX: Added -mt-[2px] here to fix the dark line overlap -->
        <section class="py-24 bg-gradient-to-b from-[#f5fbfb] to-[#edf7f7] relative pb-[120px] -mt-[2px]">
            <div class="max-w-[1280px] mx-auto px-4 md:px-10">
                <div class="text-center mb-16">
                    <h2 class="text-[2.5rem] font-bold text-[#001e40] mb-4 leading-tight">A Diverse Ecosystem, One Community</h2>
                    <p class="text-lg text-[#666] max-w-2xl mx-auto">GMA represents the full spectrum of stakeholders in the global mobile secondary market.</p>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @php
                        $ecoItems = [
                            ['title' => 'Wholesalers & Distributors', 'img' => '/gma_wholesale_dist.png'],
                            ['title' => 'Device Improving Repairs', 'img' => '/gma_device_repairs.png'],
                            ['title' => 'Mobile Device Marketplaces', 'img' => '/gma_mobile_marketplaces.png'],
                            ['title' => 'Diagnostics & Testing Platforms', 'img' => '/gma_diagnostic_testing.png'],
                            ['title' => 'Packaging Solution Companies', 'img' => '/gma_packaging.png'],
                            ['title' => 'Automation & Robotics Providers', 'img' => '/gma_automation.png'],
                            ['title' => 'Insurance Providers', 'img' => '/gma_insurance.png'],
                            ['title' => 'Enterprise Mobility', 'img' => '/gma_enterprise.png'],
                        ];
                    @endphp
                    @foreach($ecoItems as $item)
                    <div class="group relative overflow-hidden h-52 sm:h-64 bg-gradient-to-br from-[#003c70] to-[#006a6a] rounded-2xl shadow-md border-2 border-[#e0e0e0]/10 cursor-pointer hover:scale-103 hover:-translate-y-1 hover:border-[#40e0d0]/50 hover:shadow-[0_20px_35px_-8px_rgba(64,224,208,0.3)] transition-all duration-400">
                        <img alt="{{ $item['title'] }}" src="{{ $item['img'] }}" class="absolute inset-0 w-full h-full object-cover opacity-30 group-hover:opacity-40 group-hover:scale-108 transition-all duration-1000 saturate-[1.1]">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#001e40] via-[#003c70]/40 to-transparent opacity-90"></div>
                        <div class="absolute bottom-0 left-0 p-6 z-10">
                            <h3 class="text-white text-lg tracking-wide group-hover:translate-x-1 group-hover:text-[#40e0d0] transition-all duration-300 font-semibold">{{ $item['title'] }}</h3>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <!-- Arc divider into Plan section -->
            <div class="absolute bottom-0 left-0 right-0 w-full overflow-hidden leading-[0] z-20">
                <svg viewBox="0 0 1440 92" preserveAspectRatio="none" class="w-full h-[57px] md:h-[92px] block">
                    <path d="M0,0 C360,90 1080,90 1440,0 L1440,92 L0,92 Z" fill="#eff6ff"/>
                </svg>
            </div>
        </section>

        <!-- Plan Section with Parallax -->
        <section id="plan-section" class="py-24 bg-gradient-to-r from-blue-50/70 via-indigo-50/60 to-purple-50/70 relative pb-[120px] overflow-hidden -mt-[2px]">
            <!-- Parallax Watermark -->
            <div id="plan-watermark" class="absolute top-1/4 left-0 right-0 text-center text-[10vw] font-black text-[#001e40]/5 select-none pointer-events-none uppercase tracking-widest leading-none whitespace-nowrap z-0">
                EXCELLENCE
            </div>
            <div class="max-w-[1280px] mx-auto px-4 md:px-10 relative z-10">
                <div class="text-center mb-16">
                    <span class="text-[#006a6a] font-semibold text-[13px] uppercase tracking-widest mb-4 inline-block relative after:content-[''] after:absolute after:bottom-[-6px] after:left-1/2 after:-translate-x-1/2 after:w-12 after:h-[2px] after:bg-[#006a6a]">The Plan</span>
                    <h2 class="text-[2.5rem] font-bold text-[#001e40] mb-4 mt-6 leading-tight">Your Path to Excellence</h2>
                    <p class="text-lg text-[#666] max-w-2xl mx-auto">Three clear steps to institutionalizing your leadership in the mobile ecosystem.</p>
                </div>
                <div class="flex flex-col md:flex-row gap-12 items-center justify-center relative z-10 mt-12 md:mt-20">
                    <div class="flex-1 text-center max-w-xs group">
                        <div class="w-20 h-20 bg-gradient-to-br from-[#001e40] to-[#003c70] text-white text-[2.5rem] font-bold rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-md transition-all duration-300 hover:rotate-5 hover:scale-108 hover:shadow-[0_15px_30px_-5px_rgba(0,30,64,0.3)]">
                            1
                        </div>
                        <h4 class="text-xl font-bold text-[#001e40] mb-2 transition-colors duration-300 group-hover:text-[#006a6a]">Join GMA</h4>
                        <p class="text-base text-[#666] leading-relaxed">Complete your application and gain immediate access to our member-only portal and global directory.</p>
                    </div>
                    <div class="hidden md:block w-24 h-[2px] bg-gradient-to-r from-[#001e40] via-[#006a6a] to-[#006a6a]"></div>
                    <div class="flex-1 text-center max-w-xs group">
                        <div class="w-20 h-20 bg-gradient-to-br from-[#006a6a] to-[#009a9a] text-white text-[2.5rem] font-bold rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-md transition-all duration-300 hover:rotate-5 hover:scale-108 hover:shadow-[0_15px_30px_-5px_rgba(0,106,106,0.3)]">
                            2
                        </div>
                        <h4 class="text-xl font-bold text-[#001e40] mb-2 transition-colors duration-300 group-hover:text-[#006a6a]">Engage With the Work</h4>
                        <p class="text-base text-[#666] leading-relaxed">Participate in monthly committee meetings, webinars, workshops, and live events.</p>
                    </div>
                    <div class="hidden md:block w-24 h-[2px] bg-gradient-to-r from-[#006a6a] via-[#009090] to-[#001e40]"></div>
                    <div class="flex-1 text-center max-w-xs group">
                        <div class="w-20 h-20 bg-gradient-to-br from-[#009090] to-[#001e40] text-white text-[2.5rem] font-bold rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-md transition-all duration-300 hover:rotate-5 hover:scale-108 hover:shadow-[0_15px_30px_-5px_rgba(0,51,102,0.3)]">
                            3
                        </div>
                        <h4 class="text-xl font-bold text-[#001e40] mb-2 transition-colors duration-300 group-hover:text-[#006a6a]">Strengthen Your Company</h4>
                        <p class="text-base text-[#666] leading-relaxed">Leverage collective knowledge and industry connections to build a resilient, high-growth business.</p>
                    </div>
                </div>
            </div>
            <!-- Arc divider into Pillars section -->
            <div class="absolute bottom-0 left-0 right-0 w-full overflow-hidden leading-[0] z-20">
                <svg viewBox="0 0 1440 92" preserveAspectRatio="none" class="w-full h-[57px] md:h-[92px] block">
                    <path d="M0,90 C360,0 1080,0 1440,90 L1440,92 L0,92 Z" fill="#f8fafd"/>
                </svg>
            </div>
        </section>



        <!-- Membership Section -->
        <section class="py-24 bg-gradient-to-tr from-[#0e3b68] via-[#1b5d92] to-[#4c1d95] text-white relative overflow-hidden pb-[120px] -mt-[2px]">
            <div class="absolute top-[-20%] left-[-10%] w-[500px] h-[500px] rounded-full bg-[#006a6a]/25 blur-[130px] pointer-events-none animate-float-slow"></div>
            <div class="absolute bottom-[-20%] right-[-10%] w-[450px] h-[450px] rounded-full bg-[#009090]/25 blur-[120px] pointer-events-none animate-float-slow-reverse"></div>
            <div class="max-w-[1280px] mx-auto px-4 md:px-10 relative z-10">
                <div class="flex flex-col lg:flex-row items-center gap-12">
                    <div class="flex-1">
                        <h2 class="text-[2.5rem] font-bold mb-6 leading-tight">Membership with Purpose</h2>
                        <p class="text-lg mb-8 opacity-90 leading-relaxed max-w-xl">GMA membership is an investment in your company's future and the future growth of the secondary mobile ecosystem. Join leaders from around the world who are working to evolve the industry!</p>
                        <button class="bg-[#006a6a] text-white font-label-md text-[13px] uppercase tracking-widest px-12 py-5 rounded-full shadow-lg border-2 border-transparent transition-all duration-300 hover:scale-104 hover:bg-white hover:text-[#006a6a] hover:shadow-[0_20px_40px_rgba(0,0,0,0.25)] hover:border-white active:scale-98">
                            Explore Membership
                        </button>
                    </div>
                    <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 gap-6 w-full">
                        <div class="backdrop-blur-md bg-white/5 p-6 rounded-2xl border-2 border-white/10 shadow-lg transition-all duration-300 hover:scale-102 hover:bg-white/10 hover:border-white/25">
                            <h4 class="text-lg mb-2 text-[#40e0d0] tracking-wide font-semibold">Global Directory</h4>
                            <p class="text-sm opacity-80 leading-relaxed">Seen by the secondary mobile market worldwide.</p>
                        </div>
                        <div class="backdrop-blur-md bg-white/5 p-6 rounded-2xl border-2 border-white/10 shadow-lg transition-all duration-300 hover:scale-102 hover:bg-white/10 hover:border-white/25">
                            <h4 class="text-lg mb-2 text-[#40e0d0] tracking-wide font-semibold">Member Portal</h4>
                            <p class="text-sm opacity-80 leading-relaxed">Member Portal access to exclusive research, data, training, members, services, and more.</p>
                        </div>
                        <div class="backdrop-blur-md bg-white/5 p-6 rounded-2xl border-2 border-white/10 shadow-lg transition-all duration-300 hover:scale-102 hover:bg-white/10 hover:border-white/25">
                            <h4 class="text-lg mb-2 text-[#40e0d0] tracking-wide font-semibold">Educational Solutions</h4>
                            <p class="text-sm opacity-80 leading-relaxed">Giving you access to world class education on every facet of the industry.</p>
                        </div>
                        <div class="backdrop-blur-md bg-white/5 p-6 rounded-2xl border-2 border-white/10 shadow-lg transition-all duration-300 hover:scale-102 hover:bg-white/10 hover:border-white/25">
                            <h4 class="text-lg mb-2 text-[#40e0d0] tracking-wide font-semibold">Global Event Listings</h4>
                            <p class="text-sm opacity-80 leading-relaxed">Discover secondary phone related events and activities around the world.</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Arc divider into Committees section -->
            <div class="absolute bottom-0 left-0 right-0 w-full overflow-hidden leading-[0] z-20">
                <svg viewBox="0 0 1440 92" preserveAspectRatio="none" class="w-full h-[57px] md:h-[92px] block">
                    <path d="M0,90 C360,0 1080,0 1440,90 L1440,92 L0,92 Z" fill="#f5fbf9"/>
                </svg>
            </div>
        </section>

        <!-- Committees Section -->
        <section class="py-24 bg-gradient-to-br from-[#f5fbf9] via-[#edf7f7] to-[#f7f2fb] relative pb-[120px] -mt-[2px]">
            <div class="max-w-[1280px] mx-auto px-4 md:px-10">
                <div class="text-center mb-16">
                    <h2 class="text-[2.5rem] font-bold text-[#001e40] mb-4 leading-tight">Member Committees</h2>
                    <p class="text-lg text-[#666] font-medium">Creating Collaboration and Advancing the Industry Worldwide.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach([
                        ['title' => 'Leadership', 'desc' => 'Developing executive excellence for leaders at all levels.'],
                        ['title' => 'Tech & Innovation', 'desc' => 'Supporting the rise of AI, robotics, SaaS solutions and other forms of performance enhancing automation.'],
                        ['title' => 'Women in Mobile', 'desc' => 'Creating a forum for women to share ideas and best practices to help drive the industry forward.'],
                        ['title' => 'Global Trade', 'desc' => 'Connecting the ecosystem worldwide and encouraging cross cultural business relationships.'],
                        ['title' => 'Business Growth', 'desc' => 'Training, strategies, and connections enabling growth and prosperity.'],
                        ['title' => 'Enterprise Mobility', 'desc' => 'Helping the secondary market inform corporations about the environmental importance of reuse.'],
                    ] as $item)
                    <div class="bg-white p-8 border-2 border-[#e0e0e0]/20 rounded-2xl shadow-sm transition-all duration-300 group cursor-pointer hover:-translate-y-1.5 hover:scale-[1.01] hover:shadow-[0_25px_45px_-10px_rgba(0,106,106,0.12)] hover:border-[#006a6a]/30">
                        <h3 class="text-xl text-[#001e40] mb-3 group-hover:text-[#006a6a] transition-colors duration-300 tracking-wide font-semibold">{{ $item['title'] }}</h3>
                        <p class="text-base text-[#666] leading-relaxed">{{ $item['desc'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
            <!-- Arc divider into CTA section -->
            <div class="absolute bottom-0 left-0 right-0 w-full overflow-hidden leading-[0] z-20">
                <svg viewBox="0 0 1440 90" preserveAspectRatio="none" class="w-full h-[55px] md:h-[90px] block">
                    <path d="M0,0 C360,90 1080,90 1440,0 L1440,90 L0,90 Z" fill="#f0fdfa"/>
                </svg>
            </div>
        </section>

        <!-- Final CTA -->
        <!-- FIX: Added -mt-[2px] here -->
        <section class="py-24 bg-gradient-to-r from-[#f0fdfa]/60 via-[#eff6ff]/70 to-[#eef2ff]/60 relative overflow-hidden -mt-[2px]">
            <div class="absolute inset-0 bg-mesh-glow opacity-70 pointer-events-none"></div>
            <div class="absolute bottom-[-10%] left-[-10%] w-[400px] h-[400px] rounded-full bg-[#006a6a]/5 blur-[120px] pointer-events-none animate-float-slow"></div>
            <div class="max-w-[1280px] mx-auto px-4 md:px-10 text-center relative z-10">
                <div class="max-w-4xl mx-auto observer-fade-in opacity-0 translate-y-8 transition-all duration-1000 ease-[cubic-bezier(0.2,0.8,0.2,1)]">
                    <h2 class="text-3xl sm:text-4xl md:text-5xl lg:text-[4rem] font-bold text-transparent bg-clip-text bg-gradient-to-br from-[#001e40] via-[#00385e] to-[#006a6a] mb-6 leading-tight">Be Part of Building a Stronger Used Mobile Industry</h2>
                    <p class="text-lg text-[#666] mb-10 leading-relaxed max-w-3xl mx-auto">GMA is more than an association&mdash;it's the engine that drives your business and the entire secondary market forward. Join us today to access the connections and insights you need.</p>
                    <div class="flex flex-col sm:flex-row justify-center gap-6">
                        <button class="bg-gradient-to-r from-[#001e40] to-[#009090] text-white font-label-md text-[13px] uppercase tracking-widest px-12 py-5 rounded-full shadow-lg transition-all duration-300 hover:scale-103 hover:shadow-[0_20px_40px_-10px_rgba(0,106,106,0.4)] active:scale-98">
                            Join GMA Now
                        </button>
                        <button class="bg-white text-[#001e40] border-2 border-[#001e40] font-label-md text-[13px] uppercase tracking-widest px-12 py-5 rounded-full transition-all duration-300 shadow-sm hover:scale-103 hover:bg-[#001e40]/10 active:scale-98">
                            Request More Information
                        </button>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
        <footer class="bg-gradient-to-br from-[#001e40] via-[#003c70] to-[#001e40] text-white border-t border-white/10 relative overflow-hidden">
        <div class="absolute top-[-20%] left-[-10%] w-[500px] h-[500px] rounded-full bg-[#006a6a]/20 blur-[130px] pointer-events-none"></div>
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

</body>
</html>