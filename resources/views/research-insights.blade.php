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
                <div class="max-w-5xl mx-auto stagger-children space-y-8">
                    <div class="animate-on-scroll bg-white/10 backdrop-blur-sm border border-white/20 p-8 sm:p-10 md:p-12 rounded-3xl shadow-xl hover:bg-white/20 transition-all duration-500">
                        <p class="text-lg sm:text-xl text-white/90 leading-relaxed font-light">
                            Content may include original research, industry surveys, white papers, case studies, market reports, benchmarking studies, regulatory updates, economic analysis, technology trends, and expert commentary from leaders across the global secondary mobile ecosystem.
                        </p>
                    </div>

                    <div class="animate-on-scroll bg-white/10 backdrop-blur-md border border-[#40e0d0]/40 p-8 sm:p-10 md:p-12 rounded-3xl shadow-xl hover:shadow-[0_10px_30px_rgba(64,224,208,0.2)] hover:border-[#40e0d0] transition-all duration-500">
                        <div class="flex items-start gap-5">
                            <span class="material-symbols-outlined text-[#40e0d0] text-4xl mt-1 shrink-0">auto_stories</span>
                            <div>
                                <p class="text-lg sm:text-xl text-white/90 leading-relaxed">
                                    As the Association grows, this library will continue to expand, becoming one of the industry's most comprehensive resources for business intelligence and professional development. Somewhat of a &ldquo;knowledge hub.&rdquo;
                                </p>
                            </div>
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
                    <p class="animate-on-scroll text-lg md:text-xl text-[#555] mb-12 leading-relaxed max-w-3xl mx-auto font-light">
                        The Research &amp; Insights library will continue to expand with original research, market reports, regulatory updates, and expert commentary. Subscribe to receive new content directly to your inbox.
                    </p>

                    <div class="animate-on-scroll max-w-lg mx-auto bg-white p-8 sm:p-10 rounded-3xl shadow-[0_25px_50px_-12px_rgba(0,106,106,0.15)] border border-[#006a6a]/10">
                        <form class="flex flex-col sm:flex-row gap-4">
                            <input class="flex-1 border border-[#006a6a]/20 rounded-2xl px-5 py-4 focus:border-[#006a6a] focus:ring-1 focus:ring-[#006a6a]/20 outline-none transition-all duration-300 text-sm text-[#1b1b18] placeholder-[#999]" placeholder="Your work email" type="email">
                            <button type="submit" class="bg-gradient-to-r from-[#006a6a] to-[#009090] text-white font-bold text-xs uppercase tracking-widest px-8 py-4 rounded-2xl shadow-lg transition-all duration-300 hover:scale-103 hover:shadow-[0_8px_16px_-4px_rgba(0,106,106,0.3)] active:scale-98 whitespace-nowrap">
                                Subscribe
                            </button>
                        </form>
                        <p class="text-xs text-[#888] mt-4">No spam. Unsubscribe anytime.</p>
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
