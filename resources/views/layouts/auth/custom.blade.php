<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head')
    <style>
        /* Custom Keyframes for dynamic background */
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob {
            animation: blob 10s infinite alternate cubic-bezier(0.4, 0, 0.2, 1);
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        .animation-delay-4000 {
            animation-delay: 4s;
        }
        /* Entrance animation for the form */
        .auth-form-enter {
            animation: formFadeUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
            transform: translateY(20px);
        }
        @keyframes formFadeUp {
            to { opacity: 1; transform: translateY(0); }
        }
        .benefit-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .benefit-card:hover {
            transform: translateY(-2px);
            background: rgba(255,255,255,0.12);
            box-shadow: 0 8px 32px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body class="min-h-screen lg:h-screen lg:overflow-hidden antialiased bg-white text-[#1b1b18] overflow-x-hidden flex flex-col lg:flex-row">
    @include('components.page-transition')

    <!-- Left Side: Brand Canvas (Hidden on mobile) -->
    <div class="hidden lg:flex lg:w-[55%] lg:h-full relative bg-[#001e40] overflow-hidden">
        <div class="absolute top-[-10%] left-[-10%] w-[500px] h-[500px] bg-[#40e0d0] rounded-full mix-blend-screen filter blur-[150px] opacity-40 animate-blob"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[600px] h-[600px] bg-[#003366] rounded-full mix-blend-screen filter blur-[150px] opacity-60 animate-blob animation-delay-2000"></div>
        <div class="absolute top-[40%] left-[30%] w-[400px] h-[400px] bg-[#0f172a] rounded-full mix-blend-screen filter blur-[150px] opacity-70 animate-blob animation-delay-4000"></div>

        <div class="relative z-10 w-full h-full overflow-y-auto flex flex-col">
            <div class="flex flex-col w-full max-w-2xl mx-auto px-10 xl:px-14 py-12">

                <!-- Logo centered -->
                <a href="{{ route('home') }}" class="flex justify-center w-full relative mb-6 group" wire:navigate>
                    <div class="absolute inset-0 bg-white/40 rounded-full blur-3xl scale-[2.5] -z-10"></div>
                    <div class="transition-transform duration-300 group-hover:scale-105">
                        <x-app-logo-icon class="h-48 sm:h-56 lg:h-64 w-auto max-w-full object-contain drop-shadow-2xl relative z-10" />
                    </div>
                </a>

                <!-- Headline -->
                <h1 class="text-4xl xl:text-5xl font-bold text-white leading-[1.2] mb-5 tracking-tight">
                    Powering the Future of the Global Secondary Mobile Market
                </h1>

                <!-- Description -->
                <p class="text-base xl:text-lg text-blue-100/80 leading-relaxed mb-10 max-w-xl">
                    GMA membership gives companies and professionals across the used mobile ecosystem the resources, relationships, knowledge, and representation needed to grow stronger businesses and help shape the future of the industry.
                </p>

                <!-- Why Become a Member? -->
                <h2 class="text-xl font-bold text-[#40e0d0] mb-6 tracking-tight uppercase">Why Become a Member?</h2>

                <div class="grid grid-cols-2 gap-4 pb-6">
                    <div class="benefit-card rounded-xl bg-white/5 backdrop-blur-sm border border-white/10 p-4">
                        <span class="material-symbols-outlined text-[#40e0d0] text-2xl mb-2">campaign</span>
                        <h3 class="text-white font-semibold text-sm mb-1">A Stronger Industry Voice</h3>
                        <p class="text-blue-100/60 text-xs leading-relaxed">Be part of a unified organization that represents the priorities, challenges, and opportunities of the global secondary mobile market.</p>
                    </div>
                    <div class="benefit-card rounded-xl bg-white/5 backdrop-blur-sm border border-white/10 p-4">
                        <span class="material-symbols-outlined text-[#40e0d0] text-2xl mb-2">insights</span>
                        <h3 class="text-white font-semibold text-sm mb-1">Trusted Industry Intelligence</h3>
                        <p class="text-blue-100/60 text-xs leading-relaxed">Access research, market insights, white papers, and practical information that help you make informed business decisions.</p>
                    </div>
                    <div class="benefit-card rounded-xl bg-white/5 backdrop-blur-sm border border-white/10 p-4">
                        <span class="material-symbols-outlined text-[#40e0d0] text-2xl mb-2">handshake</span>
                        <h3 class="text-white font-semibold text-sm mb-1">Meaningful Business Connections</h3>
                        <p class="text-blue-100/60 text-xs leading-relaxed">Build relationships with trusted companies, industry leaders, service providers, and potential partners across the global ecosystem.</p>
                    </div>
                    <div class="benefit-card rounded-xl bg-white/5 backdrop-blur-sm border border-white/10 p-4">
                        <span class="material-symbols-outlined text-[#40e0d0] text-2xl mb-2">school</span>
                        <h3 class="text-white font-semibold text-sm mb-1">Year Round Education</h3>
                        <p class="text-blue-100/60 text-xs leading-relaxed">Participate in webinars, leadership development, business education, and industry discussions designed to help you and your team perform at a higher level.</p>
                    </div>
                    <div class="benefit-card rounded-xl bg-white/5 backdrop-blur-sm border border-white/10 p-4">
                        <span class="material-symbols-outlined text-[#40e0d0] text-2xl mb-2">groups</span>
                        <h3 class="text-white font-semibold text-sm mb-1">A Seat at the Table</h3>
                        <p class="text-blue-100/60 text-xs leading-relaxed">Join committees, contribute your expertise, and help influence the conversations and initiatives that affect the future of the industry.</p>
                    </div>
                    <div class="benefit-card rounded-xl bg-white/5 backdrop-blur-sm border border-white/10 p-4">
                        <span class="material-symbols-outlined text-[#40e0d0] text-2xl mb-2">trending_up</span>
                        <h3 class="text-white font-semibold text-sm mb-1">Resources That Support Growth</h3>
                        <p class="text-blue-100/60 text-xs leading-relaxed">Gain access to tools, best practices, and business support focused on leadership, compliance, operations, sales, workforce development, and profitable growth.</p>
                    </div>
                    <div class="benefit-card rounded-xl bg-white/5 backdrop-blur-sm border border-white/10 p-4">
                        <span class="material-symbols-outlined text-[#40e0d0] text-2xl mb-2">verified</span>
                        <h3 class="text-white font-semibold text-sm mb-1">Greater Visibility and Credibility</h3>
                        <p class="text-blue-100/60 text-xs leading-relaxed">Strengthen your company's industry presence by aligning with an association committed to professionalism, collaboration, trust, and responsible growth.</p>
                    </div>
                    <div class="benefit-card rounded-xl bg-white/5 backdrop-blur-sm border border-white/10 p-4">
                        <span class="material-symbols-outlined text-[#40e0d0] text-2xl mb-2">public</span>
                        <h3 class="text-white font-semibold text-sm mb-1">A Global Community Working for You</h3>
                        <p class="text-blue-100/60 text-xs leading-relaxed">Connect with an organization built to listen to its members, respond to their needs, and create lasting value for the global secondary mobile market.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Side: Auth Panel -->
    <div class="w-full lg:w-[45%] flex items-center justify-center p-6 sm:p-12 lg:p-16 xl:p-24 bg-white dark:bg-zinc-900 relative min-h-screen lg:min-h-0 lg:h-full lg:overflow-y-auto transition-colors duration-300">
        <!-- Mobile Logo (Visible only on mobile) -->
        <a href="{{ route('home') }}" class="absolute top-8 left-8 lg:hidden flex items-center gap-3" wire:navigate>
            <div class="flex items-center justify-center">
                <x-app-logo-icon class="h-12 w-auto object-contain" />
            </div>
            <span class="text-[#001e40] dark:text-white text-2xl font-extrabold tracking-tight">GMA Global</span>
        </a>

        <div class="w-full max-w-md auth-form-enter mt-12 lg:mt-0">
            {{ $slot }}
        </div>
    </div>

    @persist('toast')
        <flux:toast.group>
            <flux:toast />
        </flux:toast.group>
    @endpersist

    @fluxScripts
</body>
</html>
