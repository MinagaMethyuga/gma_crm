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

    @include('components.public-header', ['active' => 'research-insights'])

    <main class="pt-0 relative overflow-hidden bg-[#f8fafd]">

        <div class="absolute top-[-10%] left-[-10%] w-[500px] h-[500px] rounded-full bg-[#006a6a]/8 blur-[120px] pointer-events-none animate-float-slow"></div>
        <div class="absolute top-[20%] right-[-10%] w-[600px] h-[600px] rounded-full bg-[#009090]/20 blur-[150px] pointer-events-none animate-float-slow-reverse"></div>
        <div class="absolute top-[50%] left-[20%] w-[450px] h-[450px] rounded-full bg-[#40e0d0]/15 blur-[130px] pointer-events-none animate-float-slow"></div>

        <!-- Hero Section -->
        <section id="hero-section" class="relative min-h-[550px] flex items-center overflow-hidden bg-mesh-glow pt-32 pb-24">
            <div class="absolute inset-0 z-0 bg-gradient-to-br from-[#001e40]/95 via-[#003c70]/85 to-[#006a6a]/80">
                <div class="absolute inset-0 bg-gradient-to-r from-[#001e40] via-[#003c70]/90 to-transparent"></div>
            </div>

            <div class="relative z-10 max-w-[1280px] mx-auto px-4 md:px-10 w-full text-center mt-12">
                <span class="text-[#40e0d0] font-semibold text-[13px] uppercase tracking-[0.2em] mb-4 inline-block relative after:content-[''] after:absolute after:bottom-[-8px] after:left-1/2 after:-translate-x-1/2 after:w-16 after:h-[2px] after:bg-[#40e0d0]">
                    Knowledge Hub
                </span>
                <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-[4.5rem] font-black mt-6 mb-6 leading-tight text-transparent bg-clip-text bg-gradient-to-br from-white via-[#e0f2f1] to-[#40e0d0] drop-shadow-sm">
                    Research & Insights
                </h1>
                <p class="text-lg md:text-2xl text-white/80 max-w-4xl mx-auto leading-relaxed font-light">
                    The Research & Insights section is designed to provide members with valuable knowledge and actionable intelligence to support better business decisions.
                </p>
            </div>

            <div class="absolute bottom-0 left-0 right-0 w-full overflow-hidden leading-[0] z-20">
                <svg viewBox="0 0 1440 92" preserveAspectRatio="none" class="w-full h-[57px] md:h-[92px] block">
                    <path d="M0,90 C360,0 1080,0 1440,90 L1440,92 L0,92 Z" fill="#003c70"/>
                </svg>
            </div>
        </section>

        <!-- Content Section -->
        <section class="py-24 bg-gradient-to-br from-[#003c70] via-[#005a8c] to-[#006a6a] text-white relative pb-[120px] -mt-[2px]">
            <div class="absolute inset-0 bg-mesh-glow opacity-40 pointer-events-none"></div>

            <div class="max-w-[1280px] mx-auto px-4 sm:px-6 md:px-10 relative z-10">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                    
                    <!-- Left Column: Original Info Cards (7 Columns) -->
                    <div class="lg:col-span-7 stagger-children space-y-8">
                        <div class="animate-on-scroll bg-white/10 backdrop-blur-sm border border-white/20 p-8 sm:p-10 md:p-12 rounded-3xl shadow-xl hover:bg-white/20 transition-all duration-500">
                            <p class="text-lg sm:text-xl text-white/95 leading-relaxed font-light">
                                Content may include original research, industry surveys, white papers, case studies, market reports, benchmarking studies, regulatory updates, economic analysis, technology trends, and expert commentary from leaders across the global secondary mobile ecosystem.
                            </p>
                        </div>

                        <div class="animate-on-scroll bg-white/10 backdrop-blur-md border border-[#40e0d0]/40 p-8 sm:p-10 md:p-12 rounded-3xl shadow-xl hover:shadow-[0_10px_30px_rgba(64,224,208,0.2)] hover:border-[#40e0d0] transition-all duration-500">
                            <div class="flex items-start gap-5">
                                <span class="material-symbols-outlined text-[#40e0d0] text-4xl mt-1 shrink-0">auto_stories</span>
                                <div>
                                    <p class="text-lg sm:text-xl text-white/95 leading-relaxed">
                                        As the Association grows, this library will continue to expand, becoming one of the industry's most comprehensive resources for business intelligence and professional development. Somewhat of a &ldquo;knowledge hub.&rdquo;
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right Column: Microscope Showcase (5 Columns) -->
                    <div class="lg:col-span-5 animate-on-scroll">
                        <div class="bg-white/10 backdrop-blur-sm border border-white/20 p-6 rounded-[2.5rem] shadow-2xl flex flex-col justify-between">
                            <div class="relative rounded-[2rem] overflow-hidden shadow-md mb-6 aspect-[4/3] lg:aspect-[3/4]">
                                <img src="/Research.jpg" alt="Technical Research &amp; Investigation" class="w-full h-full object-cover object-center transform group-hover:scale-103 transition-transform duration-500">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                                <div class="absolute bottom-6 left-6 right-6">
                                    <p class="text-[#40e0d0] text-xs font-bold uppercase tracking-widest mb-1">Knowledge Hub</p>
                                    <h4 class="text-white font-bold text-lg leading-tight">Data-Driven Market Intelligence</h4>
                                </div>
                            </div>
                            <p class="text-white/95 font-semibold text-center text-sm mb-1">In-Depth Technical Insights</p>
                            <p class="text-white/70 italic text-xs sm:text-sm leading-relaxed text-center font-light">
                                "Empowering members with technical benchmarks, economic analyses, and compliance frameworks."
                            </p>
                        </div>
                    </div>

                </div>
            </div>

            <div class="absolute bottom-0 left-0 right-0 w-full overflow-hidden leading-[0] z-20">
                <svg viewBox="0 0 1440 92" preserveAspectRatio="none" class="w-full h-[57px] md:h-[92px] block">
                    <path d="M0,0 C360,90 1080,90 1440,0 L1440,92 L0,92 Z" fill="#f0fdfa"/>
                </svg>
            </div>
        </section>

        <!-- White Paper Viewer -->
        <section class="py-24 md:py-32 bg-gradient-to-br from-[#001e40] via-[#002d5a] to-[#003c70] relative overflow-hidden -mt-[2px]">
            <!-- Subtle academic pattern overlay -->
            <div class="absolute inset-0 opacity-[0.04]" style="background-image: radial-gradient(circle at 1px 1px, #ffffff 1px, transparent 0); background-size: 32px 32px;"></div>
            <div class="absolute top-[-15%] right-[-5%] w-[600px] h-[600px] rounded-full bg-[#006a6a]/20 blur-[150px] pointer-events-none"></div>
            <div class="absolute bottom-[-10%] left-[-5%] w-[500px] h-[500px] rounded-full bg-[#40e0d0]/10 blur-[120px] pointer-events-none"></div>

            <div class="max-w-[1280px] mx-auto px-4 sm:px-6 md:px-10 relative z-10">
                <!-- Header -->
                <div class="text-center mb-14 animate-on-scroll max-w-4xl mx-auto">
                    <div class="inline-flex items-center gap-3 px-5 py-2 rounded-full bg-white/10 border border-white/15 text-[#40e0d0] text-xs font-bold uppercase tracking-[0.2em] mb-8 backdrop-blur-sm">
                        <span class="w-2 h-2 rounded-full bg-[#40e0d0] animate-pulse"></span>
                        White Paper
                    </div>
                    <h2 class="text-3xl sm:text-4xl md:text-5xl font-black text-white mt-4 mb-5 leading-[1.1] tracking-tight">
                        GMA State of the Global<br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#40e0d0] to-[#80f0e0]">Secondary Mobile Ecosystem</span>
                    </h2>
                    <p class="text-white/60 text-base sm:text-lg max-w-3xl mx-auto font-light leading-relaxed">
                        Comprehensive analysis of market trends, growth metrics, and strategic insights shaping the global secondary mobile industry. Scroll through to explore the full report.
                    </p>
                </div>

                <!-- Viewer Card -->
                <div class="animate-on-scroll relative" oncontextmenu="return false;">
                    <!-- Decorative top bar -->
                    <div class="flex items-center gap-2 px-6 py-3 bg-white/5 backdrop-blur-md border-b border-white/10 rounded-t-2xl">
                        <span class="w-3 h-3 rounded-full bg-rose-400/80"></span>
                        <span class="w-3 h-3 rounded-full bg-amber-400/80"></span>
                        <span class="w-3 h-3 rounded-full bg-emerald-400/80"></span>
                        <span class="ml-3 text-white/30 text-xs font-mono tracking-wider">GMA_White_Paper_2026.pdf</span>
                    </div>
                    <!-- Document iframe -->
                    <div class="relative bg-[#0a1628] overflow-hidden shadow-[0_30px_60px_-15px_rgba(0,0,0,0.5)]" style="height: 85vh; min-height: 600px;">
                        <iframe
                            src="/GMA%20State%20of%20the%20Global%20Secondary%20Mobile%20Ecosystem%20White%20Paper%20Final.pdf#toolbar=0&navpanes=0&scrollbar=1"
                            class="w-full h-full"
                            style="border: none;"
                            title="GMA White Paper — State of the Global Secondary Mobile Ecosystem"
                            loading="lazy"
                        ></iframe>
                        <!-- Bottom fade hint -->
                        <div class="absolute inset-x-0 bottom-0 h-24 bg-gradient-to-t from-[#0a1628] to-transparent pointer-events-none"></div>
                    </div>
                    <!-- Bottom bar with reading hint -->
                    <div class="flex items-center justify-between px-6 py-4 bg-white/5 backdrop-blur-md border-t border-white/10 rounded-b-2xl">
                        <div class="flex items-center gap-3 text-white/40 text-xs">
                            <span class="material-symbols-outlined text-base">description</span>
                            <span>Read-only view — Scroll to navigate</span>
                        </div>
                        <div class="flex items-center gap-2 text-white/30 text-xs">
                            <span class="material-symbols-outlined text-base">block</span>
                            <span>Download disabled</span>
                        </div>
                    </div>
                </div>

                <!-- Key insights preview -->
                <div class="mt-16 grid grid-cols-1 sm:grid-cols-3 gap-6 animate-on-scroll">
                    <div class="bg-white/10 backdrop-blur-md border border-white/15 rounded-xl p-6 text-center hover:bg-white/15 transition-all duration-300">
                        <div class="text-4xl font-black text-[#40e0d0] mb-1 drop-shadow-[0_0_12px_rgba(64,224,208,0.3)]">2026</div>
                        <div class="text-white/80 text-sm font-semibold uppercase tracking-wider">Report Year</div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-md border border-white/15 rounded-xl p-6 text-center hover:bg-white/15 transition-all duration-300">
                        <div class="text-4xl font-black text-[#40e0d0] mb-1 drop-shadow-[0_0_12px_rgba(64,224,208,0.3)]">Global</div>
                        <div class="text-white/80 text-sm font-semibold uppercase tracking-wider">Market Coverage</div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-md border border-white/15 rounded-xl p-6 text-center hover:bg-white/15 transition-all duration-300">
                        <div class="text-4xl font-black text-[#40e0d0] mb-1 drop-shadow-[0_0_12px_rgba(64,224,208,0.3)]">In-Depth</div>
                        <div class="text-white/80 text-sm font-semibold uppercase tracking-wider">Data &amp; Analysis</div>
                    </div>
                </div>
            </div>

            <div class="absolute bottom-0 left-0 right-0 w-full overflow-hidden leading-[0] z-20">
                <svg viewBox="0 0 1440 92" preserveAspectRatio="none" class="w-full h-[57px] md:h-[92px] block">
                    <path d="M0,0 C360,90 1080,90 1440,0 L1440,92 L0,92 Z" fill="#f0fdfa"/>
                </svg>
            </div>
        </section>

        <!-- Stay Informed -->
        <section class="py-24 bg-gradient-to-br from-[#f0fdfa] to-[#e0f2f1] relative overflow-hidden -mt-[2px]">
            <div class="absolute inset-0 bg-mesh-glow opacity-50 pointer-events-none"></div>
            <div class="absolute top-[-20%] right-[-10%] w-[500px] h-[500px] rounded-full bg-[#006a6a]/5 blur-[120px] pointer-events-none animate-float-slow"></div>

            <div class="max-w-[1280px] mx-auto px-4 sm:px-6 md:px-10 text-center relative z-10">
                <div class="max-w-4xl mx-auto">
                    <div class="animate-on-scroll inline-flex items-center gap-2 px-4 py-2 rounded-full bg-[#006a6a]/10 border border-[#006a6a]/20 text-[#006a6a] text-xs font-bold uppercase tracking-widest mb-8">
                        <span class="material-symbols-outlined text-sm">auto_stories</span> Knowledge Hub
                    </div>

                    <h2 class="animate-on-scroll text-3xl sm:text-4xl md:text-5xl font-black text-[#001e40] mb-6 leading-tight">
                        Stay Informed as the Library Grows
                    </h2>
                    <p class="animate-on-scroll text-lg md:text-xl text-[#555] mb-10 leading-relaxed max-w-3xl mx-auto font-light">
                        The Research &amp; Insights library will continue to expand with original research, market reports, regulatory updates, and expert commentary. Join GMA today to get full access to the Knowledge Hub.
                    </p>

                    <div class="animate-on-scroll flex justify-center">
                        <a href="/register" class="group group-hover:before:duration-500 group-hover:after:duration-500 after:duration-500 hover:border-[#40e0d0] hover:before:[box-shadow:_40px_40px_40px_80px_#009090] duration-500 before:duration-500 hover:duration-500 hover:after:-right-24 hover:after:-top-12 hover:before:right-36 hover:before:-bottom-16 hover:before:blur origin-left hover:text-[#40e0d0] relative bg-[#001e40] h-16 w-64 border border-white/10 flex items-center justify-center text-gray-50 text-base font-bold rounded-xl overflow-hidden before:absolute before:w-12 before:h-12 before:content-[''] before:right-1 before:top-1 before:z-10 before:bg-[#006a6a] before:rounded-full before:blur-lg after:absolute after:z-10 after:w-20 after:h-20 after:content-[''] after:bg-[#40e0d0] after:right-8 after:top-3 after:rounded-full after:blur-lg shadow-lg">
                            <span class="relative z-20 transition-all duration-500 group-hover:scale-112 group-hover:text-white uppercase tracking-widest text-[14px]">Join GMA</span>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @include('partials.footer')

</body>
</html>
