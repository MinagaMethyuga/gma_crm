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
                                <img src="/PublicEvents.jpg" alt="Industry Conferences &amp; Workshops" class="w-full h-full object-cover object-center transform hover:scale-103 transition-transform duration-500">
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

        <!-- Upcoming Events Roadmap 2026 -->
        <section class="py-24 bg-[#f0fdfa] relative overflow-hidden -mt-[2px]">
            <style>
                .roadmap-card {
                    width: 100%;
                    flex-shrink: 0;
                }
                .roadmap-card > div {
                    aspect-ratio: 4 / 5 !important;
                }
                @media (min-width: 640px) {
                    .roadmap-card {
                        width: calc(50% - 12px) !important;
                    }
                }
                @media (min-width: 1024px) {
                    .roadmap-card {
                        width: calc(33.333% - 16px) !important;
                    }
                }
                .roadmap-card-inner {
                    position: relative;
                    overflow: hidden;
                    border: 1px solid rgba(255, 255, 255, 0.08);
                    transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
                }
                .roadmap-card-inner::after {
                    content: '';
                    position: absolute;
                    top: -50%;
                    left: -100%;
                    width: 50%;
                    height: 200%;
                    background: linear-gradient(
                        to right,
                        rgba(255, 255, 255, 0) 0%,
                        rgba(255, 255, 255, 0.22) 50%,
                        rgba(255, 255, 255, 0) 100%
                    );
                    transform: rotate(30deg);
                    transition: none;
                    pointer-events: none;
                    opacity: 0;
                    z-index: 10;
                }
                .roadmap-card-inner:hover::after {
                    transition: left 850ms cubic-bezier(0.23, 1, 0.32, 1);
                    left: 150%;
                    opacity: 1;
                }
                .roadmap-card-inner:hover {
                    transform: translateY(-8px);
                    box-shadow: 0 22px 45px -10px rgba(0, 106, 106, 0.25);
                    border-color: rgba(64, 224, 208, 0.35);
                }
            </style>
            <div class="max-w-[1280px] mx-auto px-4 sm:px-6 md:px-10 relative z-10">
                
                <!-- Heading -->
                <div class="text-center mb-16 animate-on-scroll">
                    <h2 class="text-4xl sm:text-5xl font-black text-[#001e40] tracking-tight mb-4">
                        Upcoming Events Roadmap 2026
                    </h2>
                    <p class="text-base sm:text-lg text-slate-600 max-w-2xl mx-auto font-light">
                        A comprehensive guide to the year's most influential secondary market summits.
                    </p>
                </div>

                <!-- Slider Container -->
                <div class="relative px-4 sm:px-0 animate-on-scroll">
                    @php
                    $roadmapEvents = [
                        [
                            'title' => 'ITAD Summit',
                            'date' => 'August 4-5',
                            'location' => 'Bellagio Casino Resort, Las Vegas',
                            'link' => 'https://www.itadsummit.com/',
                            'image' => '/ITADSummitPhoto.png',
                            'description' => 'The premier event for IT asset disposition, focusing on mobile hardware remarketing, sustainability, and data security.'
                        ],
                        [
                            'title' => 'IFA Berlin',
                            'date' => 'Sept 4-8',
                            'location' => 'Messe Berlin',
                            'link' => 'https://www.ifa-berlin.com/',
                            'image' => '/ifa_berlin.png',
                            'description' => 'The world\'s most significant trade show for consumer electronics and home appliances. A major hub for global mobile secondary supply.'
                        ],
                        [
                            'title' => 'Circular Tech Awards',
                            'date' => 'Sept 5',
                            'location' => 'JW Marriott Berlin',
                            'link' => 'https://www.circulartechawards.com/',
                            'image' => '/TechAwards.jpg',
                            'description' => 'Celebrating excellence and groundbreaking innovations in sustainable technologies, circular design, and electronics recycling.'
                        ],
                        [
                            'title' => 'Circular Tech Expo',
                            'date' => 'Oct 13-14',
                            'location' => 'Farnborough International Exhibition Conference Center',
                            'link' => 'https://www.circulartechexpo.co.uk/',
                            'image' => '/CircularTechExpo.png',
                            'description' => 'A premier exhibition showcasing end-of-life recovery, reuse, and secondary market supply chain innovations.'
                        ],
                        [
                            'title' => 'HKICEC',
                            'date' => 'October 18-21',
                            'location' => 'Global Mobile Exchange Pavillion',
                            'link' => 'https://hkicec.org/en/',
                            'image' => '/HKICECEvent.jpg',
                            'description' => 'Connecting mobile industry buyers and sellers at one of Asia\'s largest trading centers for secondary mobile devices.'
                        ],
                        [
                            'title' => 'European Broker Meeting',
                            'date' => 'Oct. 21-23',
                            'location' => 'Tivoli Marina Vilamoura Algarve',
                            'link' => 'https://www.europeanbrokermeeting.com/',
                            'image' => '/EuropeanBrokerMeetingPhoto.png',
                            'description' => 'The leading networking event for computer brokers, traders, and refurbishers to establish secure global trade lines.'
                        ],
                        [
                            'title' => 'GITEX Global 2026',
                            'date' => 'Dec. 7-11',
                            'location' => 'Dubai World Trade Center',
                            'link' => 'https://www.gitex.com/',
                            'image' => '/gitex_global.png',
                            'description' => 'The largest and most inclusive tech event in the world, bringing together technology leaders, pioneers, and secondary mobile experts.'
                        ]
                    ];
                    @endphp
                    <div id="roadmap-slider" class="flex gap-6 overflow-x-auto scroll-smooth snap-x snap-mandatory no-scrollbar pb-8 stagger-children" style="scrollbar-width: none; -ms-overflow-style: none;">
                        @foreach ($roadmapEvents as $event)
                        <!-- Event Card -->
                        <div class="roadmap-card snap-start">
                            <div class="roadmap-card-inner relative group aspect-[4/5] rounded-[2rem] overflow-hidden shadow-xl bg-slate-950">
                                <img src="{{ $event['image'] }}" alt="{{ $event['title'] }}" class="absolute inset-0 w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700 opacity-80">
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-950/20 to-transparent"></div>
                                
                                <!-- Date Badge -->
                                <div class="absolute top-6 left-6 bg-slate-950 border border-[#40e0d0]/35 rounded-full px-5 py-2.5 text-white font-black text-sm uppercase tracking-wider shadow-md">
                                    {{ $event['date'] }}
                                </div>

                                <!-- Floating Glass Card Content -->
                                <div class="absolute bottom-4 left-4 right-4 bg-slate-950/90 backdrop-blur-md border border-white/10 rounded-2xl p-5 hover:bg-slate-950/95 transition-all duration-300 transform group-hover:translate-y-[-4px]">
                                    <h3 class="text-lg sm:text-xl font-bold text-white mb-1.5 tracking-tight group-hover:text-[#40e0d0] transition-colors duration-300">
                                        {{ $event['title'] }}
                                    </h3>
                                    <div class="flex items-center gap-1.5 mb-3 text-white/95 text-xs font-medium">
                                        <span class="material-symbols-outlined text-sm text-[#40e0d0] shrink-0">location_on</span>
                                        <span class="line-clamp-1">{{ $event['location'] }}</span>
                                    </div>
                                    <p class="text-[11px] sm:text-xs text-white/85 line-clamp-2 mb-4 leading-relaxed font-light">
                                        {{ $event['description'] }}
                                    </p>
                                    
                                    <!-- Action Button Area -->
                                    <div class="flex items-center justify-between pt-3 border-t border-white/5">
                                        <a href="{{ $event['link'] }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1 text-[#40e0d0] font-bold text-[10px] sm:text-xs uppercase tracking-widest group-hover:text-white transition-colors duration-300">
                                            View Details
                                            <span class="material-symbols-outlined text-[10px] sm:text-xs group-hover:translate-x-1 transition-transform duration-300">chevron_right</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Navigation Controls -->
                    <div class="flex justify-center gap-4 mt-8">
                        <button id="slider-prev" class="w-12 h-12 rounded-full border border-slate-300 hover:border-[#006a6a] hover:bg-[#006a6a]/5 transition-all duration-300 flex items-center justify-center text-slate-700 hover:text-[#006a6a] cursor-pointer" aria-label="Previous event">
                            <span class="material-symbols-outlined">arrow_back</span>
                        </button>
                        <button id="slider-next" class="w-12 h-12 rounded-full border border-slate-300 hover:border-[#006a6a] hover:bg-[#006a6a]/5 transition-all duration-300 flex items-center justify-center text-slate-700 hover:text-[#006a6a] cursor-pointer" aria-label="Next event">
                            <span class="material-symbols-outlined">arrow_forward</span>
                        </button>
                    </div>
                </div>

            </div>

            <!-- Curved transition bottom -->
            <div class="absolute bottom-0 left-0 right-0 w-full overflow-hidden leading-[0] z-20">
                <svg viewBox="0 0 1440 92" preserveAspectRatio="none" class="w-full h-[57px] md:h-[92px] block">
                    <path d="M0,0 C360,90 1080,90 1440,0 L1440,92 L0,92 Z" fill="#f0fdfa"/>
                </svg>
            </div>
        </section>

        <!-- Slider Script -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const slider = document.getElementById('roadmap-slider');
                const prevBtn = document.getElementById('slider-prev');
                const nextBtn = document.getElementById('slider-next');

                if (slider && prevBtn && nextBtn) {
                    const scrollAmount = () => {
                        const firstCard = slider.querySelector('.roadmap-card');
                        return firstCard ? firstCard.offsetWidth + 24 : 300;
                    };

                    let isScrolling = false;

                    function customSmoothScroll(element, target, duration) {
                        if (isScrolling) return; // Prevent concurrent scrolls to ensure smoothness
                        isScrolling = true;

                        const start = element.scrollLeft;
                        const change = target - start;
                        const startTime = performance.now();

                        function animate(currentTime) {
                            const elapsed = currentTime - startTime;
                            const progress = Math.min(elapsed / duration, 1);
                            
                            // Cubic Ease-Out curve for liquid fluid animation feel
                            const ease = 1 - Math.pow(1 - progress, 3.5);
                            
                            element.scrollLeft = start + change * ease;

                            if (progress < 1) {
                                requestAnimationFrame(animate);
                            } else {
                                isScrolling = false;
                            }
                        }

                        requestAnimationFrame(animate);
                    }

                    prevBtn.addEventListener('click', function() {
                        const targetScroll = slider.scrollLeft - scrollAmount();
                        customSmoothScroll(slider, targetScroll, 650);
                    });

                    nextBtn.addEventListener('click', function() {
                        const targetScroll = slider.scrollLeft + scrollAmount();
                        customSmoothScroll(slider, targetScroll, 650);
                    });
                }
            });
        </script>

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
                        @guest
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="/register" class="bg-gradient-to-r from-[#001e40] to-[#009090] text-white font-bold text-xs uppercase tracking-widest px-8 py-4 rounded-full shadow-lg transition-all duration-300 hover:scale-103 hover:shadow-[0_20px_40px_-10px_rgba(0,106,106,0.4)] active:scale-98 text-center inline-block">
                                Become a Member
                            </a>
                        </div>
                        @endguest
                    </div>

                    <!-- Visual Card with Info Points -->
                    <div class="animate-on-scroll bg-white rounded-3xl shadow-[0_25px_50px_-12px_rgba(0,106,106,0.15)] border border-[#006a6a]/10 overflow-hidden lg:ml-8">
                        <div class="relative h-[220px] overflow-hidden">
                            <img src="/EventsLastImage.jpg" alt="Industry Calendar Training" class="w-full h-full object-cover">
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

    @include('partials.footer')

</body>
</html>

