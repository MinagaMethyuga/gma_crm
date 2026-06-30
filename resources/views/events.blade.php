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
<body class="overflow-hidden text-slate-800">

    <div class="flex h-screen w-full">
        <!-- Sidebar -->
        <aside class="w-64 bg-[#f8f9fc] border-r border-slate-200 flex flex-col flex-shrink-0">
            <!-- Branding -->
            <div class="pt-6 pb-2 px-6 flex flex-col gap-1.5">
                <a href="{{ route('home') }}" class="block">
                    <img src="/Global_Mobile_Association_Logo__1_-removebg-preview.png" alt="GMA Logo" class="h-14 w-auto object-contain object-left">
                </a>
                <p class="text-[10.5px] font-bold text-slate-500 uppercase tracking-widest pl-1">Admin Console</p>
            </div>

            <div class="px-5 mb-6">
                <button class="w-full bg-[#4338ca] hover:bg-[#3730a3] text-white rounded-lg py-2.5 px-4 flex items-center justify-center gap-2 font-medium text-sm transition-colors shadow-md shadow-[#4338ca]/20">
                    <span class="material-symbols-outlined text-lg">add</span>
                    New Entry
                </button>
            </div>

            <!-- Nav Links -->
            <nav class="flex-1 px-3 space-y-1 overflow-y-auto">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 text-slate-600 hover:bg-slate-100 rounded-lg transition-colors">
                    <span class="material-symbols-outlined text-xl">grid_view</span>
                    <span class="text-sm font-medium">Dashboard</span>
                </a>
                <a href="{{ route('members') }}" class="flex items-center gap-3 px-3 py-2.5 text-slate-600 hover:bg-slate-100 rounded-lg transition-colors mt-1">
                    <span class="material-symbols-outlined text-xl">group</span>
                    <span class="text-sm font-medium">Members</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-slate-600 hover:bg-slate-100 rounded-lg transition-colors mt-1">
                    <span class="material-symbols-outlined text-xl">payments</span>
                    <span class="text-sm font-medium">Financials</span>
                </a>
                
                <div class="relative mt-1">
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-[#4338ca] rounded-r-md"></div>
                    <a href="{{ route('events') }}" class="flex items-center gap-3 px-3 py-2.5 text-[#4338ca] bg-indigo-50/70 rounded-lg transition-colors ml-1">
                        <span class="material-symbols-outlined text-xl fill">calendar_month</span>
                        <span class="text-sm font-semibold">Events</span>
                    </a>
                </div>

                <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-slate-600 hover:bg-slate-100 rounded-lg transition-colors mt-1">
                    <span class="material-symbols-outlined text-xl">bar_chart</span>
                    <span class="text-sm font-medium">Reports</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-slate-600 hover:bg-slate-100 rounded-lg transition-colors mt-1">
                    <span class="material-symbols-outlined text-xl">settings</span>
                    <span class="text-sm font-medium">Settings</span>
                </a>
            </nav>

            <!-- Bottom Links -->
            <div class="p-4 border-t border-slate-200">
                <a href="#" class="flex items-center gap-3 px-3 py-2 text-slate-600 hover:bg-slate-100 rounded-lg transition-colors">
                    <span class="material-symbols-outlined text-xl">help</span>
                    <span class="text-sm font-medium">Help</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-3 py-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors mt-1">
                    <span class="material-symbols-outlined text-xl">logout</span>
                    <span class="text-sm font-medium">Sign Out</span>
                </a>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 flex flex-col min-w-0 bg-[#fbfcfd]">
            
            <!-- Top Header -->
            <header class="h-20 border-b border-slate-200 flex items-center justify-between px-8 bg-white shrink-0">
                <div class="flex items-center gap-6">
                    <a href="#" class="text-sm font-medium text-slate-500 hover:text-slate-800 transition-colors">Directory</a>
                    <a href="#" class="text-sm font-medium text-slate-500 hover:text-slate-800 transition-colors">Invoices</a>
                    <a href="#" class="text-sm font-medium text-slate-500 hover:text-slate-800 transition-colors">Support</a>
                </div>
                
                <div class="flex items-center gap-5">
                    <button class="text-slate-400 hover:text-slate-600 transition-colors">
                        <span class="material-symbols-outlined">notifications</span>
                    </button>
                    <button class="text-slate-400 hover:text-slate-600 transition-colors">
                        <span class="material-symbols-outlined">apps</span>
                    </button>
                    <div class="w-8 h-8 rounded-full bg-slate-200 overflow-hidden shadow-sm">
                        <!-- Placeholder avatar -->
                        <img src="https://ui-avatars.com/api/?name=Admin&background=103C68&color=fff" alt="User" class="w-full h-full object-cover">
                    </div>
                    <button class="bg-[#4338ca] hover:bg-[#3730a3] text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition-colors shadow-md shadow-[#4338ca]/20 ml-2 tracking-wide">
                        Create Event
                    </button>
                </div>
            </header>

            <!-- Content Body -->
            <div class="flex-1 flex overflow-hidden">
                
                <!-- Left: Events List -->
                <div class="flex-1 overflow-y-auto custom-scroll p-10 pb-20">
                    <div class="flex justify-between items-start mb-8">
                        <div>
                            <h2 class="text-3xl font-bold text-slate-900 mb-2 tracking-tight">Events</h2>
                            <p class="text-slate-500 text-sm">Manage and track upcoming organization activities.</p>
                        </div>
                        <div class="flex bg-slate-100/80 p-1.5 rounded-xl border border-slate-200/60 shadow-sm">
                            <button class="flex items-center gap-2 bg-white shadow-sm border border-slate-200/50 rounded-lg px-4 py-2 text-sm font-semibold text-[#4338ca]">
                                <span class="material-symbols-outlined text-[18px]">view_list</span>
                                List
                            </button>
                            <button class="flex items-center gap-2 rounded-lg px-4 py-2 text-sm font-semibold text-slate-500 hover:text-slate-700 transition-colors">
                                <span class="material-symbols-outlined text-[18px]">calendar_month</span>
                                Calendar
                            </button>
                        </div>
                    </div>

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
                    <path d="M0,90 C360,0 1080,0 1440,90 L1440,92 L0,92 Z" fill="#001e40"/>
                </svg>
            </div>
        </section>

        <!-- Content Section -->
        <section class="py-24 bg-gradient-to-br from-[#001e40] via-[#003c70] to-[#006a6a] text-white relative pb-[120px] -mt-[2px]">
            <div class="absolute inset-0 bg-mesh-glow opacity-40 pointer-events-none"></div>

            <div class="max-w-[1280px] mx-auto px-4 sm:px-6 md:px-10 relative z-10">
                <div class="max-w-5xl mx-auto stagger-children space-y-8">
                    <div class="animate-on-scroll bg-white/10 backdrop-blur-sm border border-white/20 p-8 sm:p-10 md:p-12 rounded-3xl shadow-xl hover:bg-white/20 transition-all duration-500">
                        <p class="text-lg sm:text-xl text-white/90 leading-relaxed font-light">
                            Our goal is to help members stay informed about opportunities to learn, connect, and grow&mdash;regardless of the event organizer. We encourage members to explore the events that best align with their business objectives and to let us know about additional industry events that should be included, helping us maintain a valuable and comprehensive resource for the entire community.
                        </p>
                    </div>

                    <div class="animate-on-scroll bg-white/10 backdrop-blur-md border border-[#40e0d0]/40 p-8 sm:p-10 md:p-12 rounded-3xl shadow-xl hover:shadow-[0_10px_30px_rgba(64,224,208,0.2)] hover:border-[#40e0d0] transition-all duration-500">
                        <div class="flex items-start gap-5">
                            <span class="material-symbols-outlined text-[#40e0d0] text-4xl mt-1 shrink-0">event_upcoming</span>
                            <div>
                                <p class="text-lg sm:text-xl text-white/90 leading-relaxed">
                                    Know of an event that should be listed? We welcome submissions from across the industry and encourage members to share conferences, trade shows, webinars, and networking events that may benefit the global secondary mobile community.
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
                            <button class="bg-gradient-to-r from-[#001e40] to-[#009090] text-white font-bold text-xs uppercase tracking-widest px-8 py-4 rounded-full shadow-lg transition-all duration-300 hover:scale-103 hover:shadow-[0_20px_40px_-10px_rgba(0,106,106,0.4)] active:scale-98">
                                Submit an Event
                            </button>
                            <button class="bg-white text-[#001e40] border-2 border-[#001e40] font-bold text-xs uppercase tracking-widest px-8 py-4 rounded-full transition-all duration-300 shadow-sm hover:scale-103 hover:bg-[#001e40]/5 active:scale-98">
                                Become a Member
                            </button>
                        </div>
                    </div>

                    <div class="animate-on-scroll bg-white p-8 sm:p-10 rounded-3xl shadow-[0_25px_50px_-12px_rgba(0,106,106,0.15)] border border-[#006a6a]/10 lg:ml-8">
                        <div class="flex items-start gap-4 mb-6">
                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-[#006a6a] to-[#009090] text-white flex items-center justify-center shrink-0 shadow-lg">
                                <span class="material-symbols-outlined text-2xl">calendar_month</span>
                            </div>
                            <div>
                                <h4 class="font-bold text-[#001e40] text-lg">Help Us Build the Industry Calendar</h4>
                                <p class="text-sm text-[#666] mt-1">Our goal is to help members stay informed about opportunities to learn, connect, and grow regardless of the event organizer.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-[#001e40] to-[#003c70] text-white flex items-center justify-center shrink-0 shadow-lg">
                                <span class="material-symbols-outlined text-2xl">diversity_3</span>
                            </div>
                            <div>
                                <h4 class="font-bold text-[#001e40] text-lg">Encourage Members to Participate</h4>
                                <p class="text-sm text-[#666] mt-1">Explore events that align with your business objectives and help us maintain a valuable resource for the entire community.</p>
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
