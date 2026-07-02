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

    @include('components.public-header', ['active' => 'committees'])

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
                    Get Involved
                </span>
                <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-[4.5rem] font-black mt-6 mb-6 leading-tight text-transparent bg-clip-text bg-gradient-to-br from-white via-[#e0f2f1] to-[#40e0d0] drop-shadow-sm">
                    Committees
                </h1>
                <p class="text-lg md:text-2xl text-white/80 max-w-3xl mx-auto leading-relaxed font-light">
                    GMA committees give members a focused platform to collaborate, contribute, and lead across the key areas shaping the used mobile ecosystem.
                </p>
            </div>

            <div class="absolute bottom-0 left-0 right-0 w-full overflow-hidden leading-[0] z-20">
                <svg viewBox="0 0 1440 92" preserveAspectRatio="none" class="w-full h-[57px] md:h-[92px] block">
                    <path d="M0,90 C360,0 1080,0 1440,90 L1440,92 L0,92 Z" fill="#f0fdfa"/>
                </svg>
            </div>
        </section>

        <!-- Committees List -->
        <section class="py-20 bg-[#f0fdfa] bg-gradient-to-b from-[#f0fdfa] to-[#eff6ff] relative -mt-[2px] pb-[100px]">
            <div class="max-w-[1280px] mx-auto px-4 sm:px-6 md:px-10">
                <div class="max-w-6xl mx-auto space-y-8 stagger-children">

                    <!-- Leadership & Executive Development -->
                    <div class="animate-on-scroll bg-white p-8 sm:p-10 md:p-12 rounded-3xl shadow-[0_25px_50px_-12px_rgba(0,106,106,0.15)] border border-[#006a6a]/10 hover:border-[#006a6a]/40 hover:-translate-y-1 transition-all duration-500">
                        <div class="flex flex-col sm:flex-row items-start gap-5">
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-[#001e40] to-[#003c70] text-white flex items-center justify-center shrink-0 shadow-lg">
                                <span class="material-symbols-outlined text-3xl">psychology</span>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-[#001e40] mb-4">Leadership & Executive Development Committee</h3>
                                <p class="text-lg text-[#555] leading-relaxed">
                                    The Leadership & Executive Development Committee empowers current and emerging leaders through mentorship, executive education, peer collaboration, and leadership development programs designed to strengthen both individuals and the secondary mobile industry as a whole.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Technology & Innovation -->
                    <div class="animate-on-scroll bg-white p-8 sm:p-10 md:p-12 rounded-3xl shadow-[0_25px_50px_-12px_rgba(0,106,106,0.15)] border border-[#006a6a]/10 hover:border-[#006a6a]/40 hover:-translate-y-1 transition-all duration-500">
                        <div class="flex flex-col sm:flex-row items-start gap-5">
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-[#006a6a] to-[#009090] text-white flex items-center justify-center shrink-0 shadow-lg">
                                <span class="material-symbols-outlined text-3xl">precision_manufacturing</span>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-[#001e40] mb-4">Technology & Innovation Committee</h3>
                                <p class="text-lg text-[#555] leading-relaxed">
                                    The Technology & Innovation Committee is dedicated to advancing the secondary mobile industry by identifying, evaluating, and promoting emerging technologies that improve efficiency, profitability, and customer experience. The committee serves as a forum for collaboration, knowledge sharing, and innovation across the global mobile ecosystem.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Women in Mobile -->
                    <div class="animate-on-scroll bg-white p-8 sm:p-10 md:p-12 rounded-3xl shadow-[0_25px_50px_-12px_rgba(0,106,106,0.15)] border border-[#006a6a]/10 hover:border-[#006a6a]/40 hover:-translate-y-1 transition-all duration-500">
                        <div class="flex flex-col sm:flex-row items-start gap-5">
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-[#40e0d0] to-[#009090] text-white flex items-center justify-center shrink-0 shadow-lg">
                                <span class="material-symbols-outlined text-3xl">diversity_3</span>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-[#001e40] mb-4">Women in Mobile</h3>
                                <p class="text-lg text-[#555] leading-relaxed">
                                    The Women in Mobile Committee brings together women from across the secondary mobile ecosystem to collaborate, share ideas, build professional relationships, and help drive innovation throughout the industry. The committee serves as a platform for networking, mentorship, leadership development, and meaningful contributions that strengthen the global mobile community.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Global Trade & Market Development -->
                    <div class="animate-on-scroll bg-white p-8 sm:p-10 md:p-12 rounded-3xl shadow-[0_25px_50px_-12px_rgba(0,106,106,0.15)] border border-[#006a6a]/10 hover:border-[#006a6a]/40 hover:-translate-y-1 transition-all duration-500">
                        <div class="flex flex-col sm:flex-row items-start gap-5">
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-[#001e40] to-[#003c70] text-white flex items-center justify-center shrink-0 shadow-lg">
                                <span class="material-symbols-outlined text-3xl">public</span>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-[#001e40] mb-4">Global Trade & Market Development Committee</h3>
                                <p class="text-lg text-[#555] leading-relaxed">
                                    The Global Trade & Market Development Committee helps members grow beyond their existing markets by fostering international collaboration, identifying emerging opportunities, and sharing best practices for global business development. The committee focuses on market expansion, cross-border trade, strategic partnerships, and the exchange of knowledge that strengthens the worldwide secondary mobile ecosystem.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Business Growth & Best Practices -->
                    <div class="animate-on-scroll bg-white p-8 sm:p-10 md:p-12 rounded-3xl shadow-[0_25px_50px_-12px_rgba(0,106,106,0.15)] border border-[#006a6a]/10 hover:border-[#006a6a]/40 hover:-translate-y-1 transition-all duration-500">
                        <div class="flex flex-col sm:flex-row items-start gap-5">
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-[#006a6a] to-[#009a9a] text-white flex items-center justify-center shrink-0 shadow-lg">
                                <span class="material-symbols-outlined text-3xl">trending_up</span>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-[#001e40] mb-4">Business Growth & Best Practices Committee</h3>
                                <p class="text-lg text-[#555] leading-relaxed">
                                    The Business Growth & Best Practices Committee serves as a collaborative forum for business leaders to exchange ideas, share successful strategies, and identify opportunities for continuous improvement. The committee focuses on helping members strengthen operations, accelerate growth, improve profitability, and adopt best practices that contribute to long-term success throughout the global secondary mobile ecosystem.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Global Regulatory & Compliance -->
                    <div class="animate-on-scroll bg-white p-8 sm:p-10 md:p-12 rounded-3xl shadow-[0_25px_50px_-12px_rgba(0,106,106,0.15)] border border-[#006a6a]/10 hover:border-[#006a6a]/40 hover:-translate-y-1 transition-all duration-500">
                        <div class="flex flex-col sm:flex-row items-start gap-5">
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-[#001e40] to-[#003c70] text-white flex items-center justify-center shrink-0 shadow-lg">
                                <span class="material-symbols-outlined text-3xl">gavel</span>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-[#001e40] mb-4">Global Regulatory & Compliance Committee</h3>
                                <p class="text-lg text-[#555] leading-relaxed">
                                    The Global Regulatory Committee serves as a resource for members seeking to better understand the laws, regulations, and policy developments impacting the secondary mobile ecosystem around the world. By fostering collaboration, sharing practical insights, and promoting informed discussions, the committee helps members anticipate regulatory changes, manage risk, and make better business decisions in an increasingly complex global marketplace.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Enterprise Mobility -->
                    <div class="animate-on-scroll bg-white p-8 sm:p-10 md:p-12 rounded-3xl shadow-[0_25px_50px_-12px_rgba(0,106,106,0.15)] border border-[#006a6a]/10 hover:border-[#006a6a]/40 hover:-translate-y-1 transition-all duration-500">
                        <div class="flex flex-col sm:flex-row items-start gap-5">
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-[#006a6a] to-[#009090] text-white flex items-center justify-center shrink-0 shadow-lg">
                                <span class="material-symbols-outlined text-3xl">devices</span>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-[#001e40] mb-4">Enterprise Mobility Committee</h3>
                                <p class="text-lg text-[#555] leading-relaxed">
                                    The Enterprise Mobility Committee brings together enterprise organizations, managed mobility providers, and industry leaders to promote best practices for recovering and reusing end-of-life mobile devices. Through education, collaboration, and market outreach, the committee encourages organizations to extend the useful life of mobile technology, maximize asset value, and reduce unnecessary electronic waste by keeping devices in circulation for second, third, and even fourth lives whenever possible. Individuals joining this committee need to be the bridge that connects the reuse space to the enterprise space. After all, end of use should not be end of life.
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

        <!-- Join a Committee -->
        <section class="py-24 bg-gradient-to-br from-[#001e40] via-[#003c70] to-[#006a6a] text-white relative pb-[120px] -mt-[2px]">
            <div class="absolute inset-0 bg-mesh-glow opacity-40 pointer-events-none"></div>

            <div class="max-w-[1280px] mx-auto px-4 sm:px-6 md:px-10 relative z-10">
                <div class="animate-on-scroll text-center max-w-4xl mx-auto mb-16">
                    <span class="text-[#40e0d0] font-semibold text-[13px] uppercase tracking-[0.2em] mb-4 inline-block relative after:content-[''] after:absolute after:bottom-[-6px] after:left-1/2 after:-translate-x-1/2 after:w-16 after:h-[2px] after:bg-[#40e0d0]">
                        Get Involved
                    </span>
                    <h2 class="text-3xl md:text-5xl font-bold text-white mb-6 leading-tight drop-shadow-md">Interested in Joining a Committee?</h2>
                    <p class="text-lg md:text-xl text-white/80 max-w-3xl mx-auto leading-relaxed font-light">
                        Committees are open to GMA members who want to contribute their time, expertise, and leadership to shape the future of the used mobile ecosystem.
                    </p>
                </div>

                <div class="max-w-3xl mx-auto bg-white/10 backdrop-blur-sm border border-white/20 p-8 sm:p-12 rounded-3xl shadow-xl">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 stagger-children">
                        <div class="animate-on-scroll bg-white/10 backdrop-blur-md border border-[#40e0d0]/40 p-6 rounded-2xl text-center hover:-translate-y-1 hover:border-[#40e0d0] hover:shadow-[0_10px_30px_rgba(64,224,208,0.2)] transition-all duration-300">
                            <span class="material-symbols-outlined text-[#40e0d0] text-3xl mb-3 block drop-shadow-md">psychology</span>
                            <h5 class="font-bold text-white mb-1">Leadership &amp; Executive</h5>
                            <p class="text-xs text-white/80">Mentorship &amp; executive education</p>
                        </div>
                        <div class="animate-on-scroll bg-white/10 backdrop-blur-md border border-[#40e0d0]/40 p-6 rounded-2xl text-center hover:-translate-y-1 hover:border-[#40e0d0] hover:shadow-[0_10px_30px_rgba(64,224,208,0.2)] transition-all duration-300">
                            <span class="material-symbols-outlined text-[#40e0d0] text-3xl mb-3 block drop-shadow-md">precision_manufacturing</span>
                            <h5 class="font-bold text-white mb-1">Technology &amp; Innovation</h5>
                            <p class="text-xs text-white/80">Emerging tech &amp; efficiency</p>
                        </div>
                        <div class="animate-on-scroll bg-white/10 backdrop-blur-md border border-[#40e0d0]/40 p-6 rounded-2xl text-center hover:-translate-y-1 hover:border-[#40e0d0] hover:shadow-[0_10px_30px_rgba(64,224,208,0.2)] transition-all duration-300">
                            <span class="material-symbols-outlined text-[#40e0d0] text-3xl mb-3 block drop-shadow-md">diversity_3</span>
                            <h5 class="font-bold text-white mb-1">Women in Mobile</h5>
                            <p class="text-xs text-white/80">Networking &amp; mentorship</p>
                        </div>
                        <div class="animate-on-scroll bg-white/10 backdrop-blur-md border border-[#40e0d0]/40 p-6 rounded-2xl text-center hover:-translate-y-1 hover:border-[#40e0d0] hover:shadow-[0_10px_30px_rgba(64,224,208,0.2)] transition-all duration-300">
                            <span class="material-symbols-outlined text-[#40e0d0] text-3xl mb-3 block drop-shadow-md">public</span>
                            <h5 class="font-bold text-white mb-1">Global Trade</h5>
                            <p class="text-xs text-white/80">Market expansion &amp; cross-border trade</p>
                        </div>
                        <div class="animate-on-scroll bg-white/10 backdrop-blur-md border border-[#40e0d0]/40 p-6 rounded-2xl text-center hover:-translate-y-1 hover:border-[#40e0d0] hover:shadow-[0_10px_30px_rgba(64,224,208,0.2)] transition-all duration-300">
                            <span class="material-symbols-outlined text-[#40e0d0] text-3xl mb-3 block drop-shadow-md">trending_up</span>
                            <h5 class="font-bold text-white mb-1">Business Growth</h5>
                            <p class="text-xs text-white/80">Best practices &amp; operations</p>
                        </div>
                        <div class="animate-on-scroll bg-white/10 backdrop-blur-md border border-[#40e0d0]/40 p-6 rounded-2xl text-center hover:-translate-y-1 hover:border-[#40e0d0] hover:shadow-[0_10px_30px_rgba(64,224,208,0.2)] transition-all duration-300">
                            <span class="material-symbols-outlined text-[#40e0d0] text-3xl mb-3 block drop-shadow-md">gavel</span>
                            <h5 class="font-bold text-white mb-1">Regulatory &amp; Compliance</h5>
                            <p class="text-xs text-white/80">Policy &amp; risk management</p>
                        </div>
                    </div>

                    <div class="animate-on-scroll text-center mt-10">
                        <button class="bg-gradient-to-r from-[#006a6a] to-[#009090] text-white font-bold text-sm uppercase tracking-widest px-10 py-4 rounded-full shadow-lg transition-all duration-300 hover:scale-103 hover:shadow-[0_20px_40px_-10px_rgba(0,106,106,0.4)] active:scale-98">
                            Express Interest
                        </button>
                    </div>
                </div>
            </div>

            <div class="absolute bottom-0 left-0 right-0 w-full overflow-hidden leading-[0] z-20">
                <svg viewBox="0 0 1440 92" preserveAspectRatio="none" class="w-full h-[57px] md:h-[92px] block">
                    <path d="M0,0 C360,90 1080,90 1440,0 L1440,92 L0,92 Z" fill="#f8fafd"/>
                </svg>
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
