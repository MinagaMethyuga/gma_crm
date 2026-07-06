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

    @include('components.public-header', ['active' => 'who-we-serve'])

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
                    Who We Serve
                </span>
                <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-[4.5rem] font-black mt-6 mb-6 leading-tight text-transparent bg-clip-text bg-gradient-to-br from-white via-[#e0f2f1] to-[#40e0d0] drop-shadow-sm">
                    Who We Serve
                </h1>
                <p class="text-lg md:text-2xl text-white/80 max-w-3xl mx-auto leading-relaxed font-light">
                    GMA supports members by giving them a year-round platform to learn, connect, contribute, and grow within the global used mobile ecosystem.
                </p>
            </div>

            <div class="absolute bottom-0 left-0 right-0 w-full overflow-hidden leading-[0] z-20">
                <svg viewBox="0 0 1440 92" preserveAspectRatio="none" class="w-full h-[57px] md:h-[92px] block">
                    <path d="M0,90 C360,0 1080,0 1440,90 L1440,92 L0,92 Z" fill="#f0fdfa"/>
                </svg>
            </div>
        </section>

        <!-- Value Proposition Section -->
        <section class="py-20 bg-[#f0fdfa] bg-gradient-to-b from-[#f0fdfa] to-[#eff6ff] relative -mt-[2px] pb-[100px]">
            <div class="max-w-[1280px] mx-auto px-4 sm:px-6 md:px-10">
                <div class="max-w-5xl mx-auto space-y-8 stagger-children">
                    <div class="animate-on-scroll bg-white p-8 sm:p-10 md:p-12 rounded-3xl shadow-[0_25px_50px_-12px_rgba(0,106,106,0.15)] border border-[#006a6a]/10 hover:border-[#006a6a]/40 transition-all duration-500">
                        <div class="flex items-start gap-4">
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-[#006a6a] to-[#009a9a] text-white flex items-center justify-center shrink-0 shadow-lg">
                                <span class="material-symbols-outlined text-3xl">diversity_3</span>
                            </div>
                            <div>
                                <p class="text-lg text-[#555] leading-relaxed">
                                    Membership is designed to be active, practical, and valuable. Members gain access to education, webinars, committees, resources, industry conversations, leadership development, business growth support, and opportunities to network with people and companies who understand the challenges and opportunities in the used mobile market.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="animate-on-scroll bg-white p-8 sm:p-10 md:p-12 rounded-3xl shadow-[0_25px_50px_-12px_rgba(0,106,106,0.15)] border border-[#006a6a]/10 hover:border-[#006a6a]/40 transition-all duration-500">
                        <div class="flex items-start gap-4">
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-[#001e40] to-[#003c70] text-white flex items-center justify-center shrink-0 shadow-lg">
                                <span class="material-symbols-outlined text-3xl">forum</span>
                            </div>
                            <div>
                                <p class="text-lg text-[#555] leading-relaxed">
                                    GMA helps members stay engaged in the industry beyond one annual event. Through focused committees, timely education, practical resources, and meaningful networking, members have a place to share ideas, address common challenges, build relationships, and participate in conversations that can help shape the future of the ecosystem.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="animate-on-scroll bg-white p-8 sm:p-10 md:p-12 rounded-3xl shadow-[0_25px_50px_-12px_rgba(0,106,106,0.15)] border border-[#006a6a]/10 hover:border-[#006a6a]/40 transition-all duration-500">
                        <div class="flex items-start gap-4">
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-[#006a6a] to-[#009a9a] text-white flex items-center justify-center shrink-0 shadow-lg">
                                <span class="material-symbols-outlined text-3xl">visibility</span>
                            </div>
                            <div>
                                <p class="text-lg text-[#555] leading-relaxed">
                                    The association also creates opportunities for members to raise their visibility, strengthen their credibility, and contribute their experience to the industry. Whether a member is focused on growth, talent development, technology, innovation, compliance, global trade, leadership, or effective business practices, GMA gives them a platform to engage with others who are working through similar opportunities.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="animate-on-scroll bg-white border-l-4 border-[#006a6a] p-8 sm:p-10 md:p-12 rounded-3xl shadow-[0_25px_50px_-12px_rgba(0,106,106,0.15)] border border-[#006a6a]/10">
                        <div class="flex items-start gap-4">
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-[#001e40] to-[#009090] text-white flex items-center justify-center shrink-0 shadow-lg">
                                <span class="material-symbols-outlined text-3xl">verified</span>
                            </div>
                            <div>
                                <p class="text-xl font-bold text-[#001e40] mb-3">The value of GMA is not just access to information. It is access to the right conversations, the right people, and the right opportunities throughout the year.</p>
                                <p class="text-lg text-[#555] leading-relaxed">
                                    GMA supports members by helping them become more connected, more informed, better equipped, and better positioned to grow in a changing used mobile industry.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="absolute bottom-0 left-0 right-0 w-full overflow-hidden leading-[0] z-20">
                <svg viewBox="0 0 1440 92" preserveAspectRatio="none" class="w-full h-[57px] md:h-[92px] block">
                    <path d="M0,0 C360,90 1080,90 1440,0 L1440,92 L0,92 Z" fill="#eff6ff"/>
                </svg>
            </div>
        </section>

        <!-- Benefits Grid -->
        <section class="py-24 bg-gradient-to-br from-[#003c70] via-[#005a8c] to-[#006a6a] text-white relative pb-[120px] -mt-[2px]">
            <div class="absolute inset-0 bg-mesh-glow opacity-40 pointer-events-none"></div>

            <div class="max-w-[1280px] mx-auto px-4 sm:px-6 md:px-10 relative z-10">
                <div class="animate-on-scroll text-center max-w-4xl mx-auto mb-16">
                    <span class="text-[#40e0d0] font-semibold text-[13px] uppercase tracking-[0.2em] mb-4 inline-block relative after:content-[''] after:absolute after:bottom-[-6px] after:left-1/2 after:-translate-x-1/2 after:w-16 after:h-[2px] after:bg-[#40e0d0]">
                        Membership Value
                    </span>
                    <h2 class="text-3xl md:text-5xl font-bold text-white mb-6 leading-tight drop-shadow-md">What Members Gain</h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 stagger-children">
                    <div class="animate-on-scroll bg-white/10 backdrop-blur-sm border border-white/20 p-6 sm:p-8 rounded-3xl text-center hover:-translate-y-2 hover:bg-white/20 transition-all duration-500 shadow-xl">
                        <div class="w-14 h-14 rounded-2xl bg-[#40e0d0]/20 flex items-center justify-center mx-auto mb-5">
                            <span class="material-symbols-outlined text-[#40e0d0] text-3xl">school</span>
                        </div>
                        <h4 class="text-lg font-bold mb-2">Education &amp; Webinars</h4>
                        <p class="text-sm text-white/70 leading-relaxed">Year-round learning with timely content from industry experts.</p>
                    </div>
                    <div class="animate-on-scroll bg-white/10 backdrop-blur-sm border border-white/20 p-6 sm:p-8 rounded-3xl text-center hover:-translate-y-2 hover:bg-white/20 transition-all duration-500 shadow-xl">
                        <div class="w-14 h-14 rounded-2xl bg-[#40e0d0]/20 flex items-center justify-center mx-auto mb-5">
                            <span class="material-symbols-outlined text-[#40e0d0] text-3xl">groups</span>
                        </div>
                        <h4 class="text-lg font-bold mb-2">Committees &amp; Collaboration</h4>
                        <p class="text-sm text-white/70 leading-relaxed">Focused groups tackling the industry's biggest challenges.</p>
                    </div>
                    <div class="animate-on-scroll bg-white/10 backdrop-blur-sm border border-white/20 p-6 sm:p-8 rounded-3xl text-center hover:-translate-y-2 hover:bg-white/20 transition-all duration-500 shadow-xl">
                        <div class="w-14 h-14 rounded-2xl bg-[#40e0d0]/20 flex items-center justify-center mx-auto mb-5">
                            <span class="material-symbols-outlined text-[#40e0d0] text-3xl">visibility</span>
                        </div>
                        <h4 class="text-lg font-bold mb-2">Visibility &amp; Credibility</h4>
                        <p class="text-sm text-white/70 leading-relaxed">Raise your profile and contribute your expertise to the industry.</p>
                    </div>
                    <div class="animate-on-scroll bg-white/10 backdrop-blur-sm border border-white/20 p-6 sm:p-8 rounded-3xl text-center hover:-translate-y-2 hover:bg-white/20 transition-all duration-500 shadow-xl">
                        <div class="w-14 h-14 rounded-2xl bg-[#40e0d0]/20 flex items-center justify-center mx-auto mb-5">
                            <span class="material-symbols-outlined text-[#40e0d0] text-3xl">trending_up</span>
                        </div>
                        <h4 class="text-lg font-bold mb-2">Business Growth</h4>
                        <p class="text-sm text-white/70 leading-relaxed">Resources and connections to help your business thrive.</p>
                    </div>
                </div>

                @guest
                <div class="animate-on-scroll text-center mt-12">
                    <a href="/register" class="inline-block bg-gradient-to-r from-[#40e0d0] to-[#009090] text-[#001e40] font-bold text-sm uppercase tracking-widest px-10 py-4 rounded-full shadow-lg transition-all duration-300 hover:scale-103 hover:shadow-[0_20px_40px_-10px_rgba(64,224,208,0.3)] active:scale-98">
                        Become a Member
                    </a>
                </div>
                @endguest
            </div>

            <div class="absolute bottom-0 left-0 right-0 w-full overflow-hidden leading-[0] z-20">
                <svg viewBox="0 0 1440 92" preserveAspectRatio="none" class="w-full h-[57px] md:h-[92px] block">
                    <path d="M0,0 C360,90 1080,90 1440,0 L1440,92 L0,92 Z" fill="#f8fafd"/>
                </svg>
            </div>
        </section>
    </main>

    @include('partials.footer')

</body>
</html>
