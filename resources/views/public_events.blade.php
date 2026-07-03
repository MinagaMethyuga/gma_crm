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

    @include('components.public-header', ['active' => 'events'])

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
                    Industry Events
                </span>
                <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-[4.5rem] font-black mt-6 mb-6 leading-tight text-transparent bg-clip-text bg-gradient-to-br from-white via-[#e0f2f1] to-[#40e0d0] drop-shadow-sm">
                    Events
                </h1>
                <p class="text-lg md:text-2xl text-white/80 max-w-4xl mx-auto leading-relaxed font-light">
                    The Events section provides a comprehensive calendar of conferences, trade shows, networking events, webinars, workshops, and educational programs relevant to the global secondary mobile ecosystem.
                </p>
            </div>

            <div class="absolute bottom-0 left-0 right-0 w-full overflow-hidden leading-[0] z-20">
                <svg viewBox="0 0 1440 92" preserveAspectRatio="none" class="w-full h-[57px] md:h-[92px] block">
                    <path d="M0,90 C360,0 1080,0 1440,90 L1440,92 L0,92 Z" fill="#f0fdfa"/>
                </svg>
            </div>
        </section>

        <!-- Content Section -->
        <section class="py-24 bg-gradient-to-b from-[#f0fdfa] to-[#eff6ff] text-[#1b1b18] relative pb-[120px] -mt-[2px]">
            <div class="absolute inset-0 bg-[#006a6a]/3 opacity-20 pointer-events-none"></div>

            <div class="max-w-[1280px] mx-auto px-4 sm:px-6 md:px-10 relative z-10">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                    
                    <!-- Left Column: Info Cards (7 Columns) -->
                    <div class="lg:col-span-7 stagger-children space-y-8">
                        <div class="animate-on-scroll bg-white border border-[#006a6a]/10 p-8 sm:p-10 md:p-12 rounded-3xl shadow-xl hover:-translate-y-1 hover:border-[#006a6a]/30 transition-all duration-500">
                            <p class="text-base sm:text-lg md:text-xl text-[#555] leading-relaxed font-light">
                                Our goal is to help members stay informed about opportunities to learn, connect, and grow&mdash;regardless of the event organizer. We encourage members to explore the events that best align with their business objectives and to let us know about additional industry events that should be included, helping us maintain a valuable and comprehensive resource for the entire community.
                            </p>
                        </div>

                        <div class="animate-on-scroll bg-white border border-[#006a6a]/15 p-8 sm:p-10 md:p-12 rounded-3xl shadow-xl hover:-translate-y-1 hover:border-[#006a6a]/40 hover:shadow-[0_15px_40px_rgba(0,106,106,0.08)] transition-all duration-500">
                            <div class="flex items-start gap-5">
                                <span class="material-symbols-outlined text-[#006a6a] text-4xl mt-1 shrink-0">event_upcoming</span>
                                <div>
                                    <p class="text-base sm:text-lg md:text-xl text-[#555] leading-relaxed font-light">
                                        Know of an event that should be listed? We welcome submissions from across the industry and encourage members to share conferences, trade shows, webinars, and networking events that may benefit the global secondary mobile community.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right Column: Presentation Showcase (5 Columns) -->
                    <div class="lg:col-span-5 animate-on-scroll animate-fade-in-right">
                        <div class="bg-white border border-[#006a6a]/10 p-6 rounded-[2.5rem] shadow-2xl flex flex-col justify-between">
                            <div class="relative rounded-[2rem] overflow-hidden shadow-md mb-6 aspect-[4/3] lg:aspect-[3/4]">
                                <img src="/Presentation.png" alt="Industry Conferences &amp; Workshops" class="w-full h-full object-cover object-center transform hover:scale-103 transition-transform duration-500">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                                <div class="absolute bottom-6 left-6 right-6">
                                    <p class="text-[#40e0d0] text-xs font-bold uppercase tracking-widest mb-1">Public Events</p>
                                    <h4 class="text-white font-bold text-lg leading-tight">Secondary Mobile Conferences</h4>
                                </div>
                            </div>
                            <p class="text-[#001e40] font-semibold text-center text-sm mb-1">Global Trade Opportunities</p>
                            <p class="text-[#666] italic text-xs sm:text-sm leading-relaxed text-center font-light">
                                "Connect with key stakeholders, industry pioneers, and global opportunities throughout the year."
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

        <!-- Submit an Event -->
        <section class="py-24 bg-gradient-to-br from-[#f0fdfa] to-[#eff6ff] relative overflow-hidden -mt-[2px]">
            <div class="absolute inset-0 bg-mesh-glow opacity-60 pointer-events-none"></div>

            <div class="max-w-[1280px] mx-auto px-4 sm:px-6 md:px-10 relative z-10">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div class="animate-on-scroll">
                        <span class="text-[#006a6a] font-semibold text-[13px] uppercase tracking-[0.2em] mb-4 inline-block relative after:content-[''] after:absolute after:bottom-[-6px] after:left-0 after:w-16 after:h-[2px] after:bg-[#006a6a]">
                            Contribute
                        </span>
                        <h2 class="text-3xl sm:text-4xl md:text-5xl font-black text-[#001e40] mb-6 leading-tight">
                            Know an Event That Should Be Listed?
                        </h2>
                        <p class="text-lg md:text-xl text-[#555] mb-8 leading-relaxed font-light">
                            We welcome submissions from across the industry. Share conferences, trade shows, webinars, and networking events that may benefit the global secondary mobile community.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="/register" class="bg-gradient-to-r from-[#001e40] to-[#009090] text-white font-bold text-xs uppercase tracking-widest px-8 py-4 rounded-full shadow-lg transition-all duration-300 hover:scale-103 hover:shadow-[0_20px_40px_-10px_rgba(0,106,106,0.4)] active:scale-98 text-center inline-block">
                                Become a Member
                            </a>
                        </div>
                    </div>

                    <!-- Visual Card with Info Points -->
                    <div class="animate-on-scroll bg-white rounded-3xl shadow-[0_25px_50px_-12px_rgba(0,106,106,0.15)] border border-[#006a6a]/10 overflow-hidden lg:ml-8">
                        <div class="relative h-[220px] overflow-hidden">
                            <img src="/Classroom training 1.jpg" alt="Industry Calendar Training" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-white via-white/20 to-transparent"></div>
                        </div>
                        <div class="p-8 sm:p-10 space-y-6">
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-xl bg-[#006a6a]/5 text-[#006a6a] flex items-center justify-center shrink-0 border border-[#006a6a]/10">
                                    <span class="material-symbols-outlined text-xl">calendar_month</span>
                                </div>
                                <div>
                                    <h4 class="font-bold text-[#001e40] text-base">Help Us Build the Industry Calendar</h4>
                                    <p class="text-sm text-[#666] mt-1">Our goal is to help members stay informed about opportunities to learn, connect, and grow regardless of the event organizer.</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-4 border-t border-slate-100 pt-6">
                                <div class="w-10 h-10 rounded-xl bg-[#001e40]/5 text-[#001e40] flex items-center justify-center shrink-0 border border-[#001e40]/10">
                                    <span class="material-symbols-outlined text-xl">diversity_3</span>
                                </div>
                                <div>
                                    <h4 class="font-bold text-[#001e40] text-base">Encourage Member Participation</h4>
                                    <p class="text-sm text-[#666] mt-1">Explore events that align with your business objectives and help us maintain a valuable resource for the entire community.</p>
                                </div>
                            </div>
                        </div>
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

