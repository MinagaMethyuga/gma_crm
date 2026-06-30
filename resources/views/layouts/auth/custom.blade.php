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
    </style>
</head>
<body class="min-h-screen lg:h-screen lg:overflow-hidden antialiased bg-white text-[#1b1b18] overflow-x-hidden flex flex-col lg:flex-row">
    @include('components.page-transition')

    <!-- Left Side: Brand Canvas (Hidden on mobile) -->
    <div class="hidden lg:flex lg:w-[55%] lg:h-full relative bg-[#001e40] overflow-hidden items-center justify-center p-12">
        <!-- Dynamic glowing orbs -->
        <div class="absolute top-[-10%] left-[-10%] w-[500px] h-[500px] bg-[#40e0d0] rounded-full mix-blend-screen filter blur-[150px] opacity-40 animate-blob"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[600px] h-[600px] bg-[#003366] rounded-full mix-blend-screen filter blur-[150px] opacity-60 animate-blob animation-delay-2000"></div>
        <div class="absolute top-[40%] left-[30%] w-[400px] h-[400px] bg-[#0f172a] rounded-full mix-blend-screen filter blur-[150px] opacity-70 animate-blob animation-delay-4000"></div>

        <div class="relative z-10 flex flex-col items-start w-full max-w-xl xl:max-w-2xl px-8">
            <a href="{{ route('home') }}" class="mb-16 flex items-center gap-3" wire:navigate>
                <div class="flex items-center justify-center">
                    <x-app-logo-icon class="h-16 w-auto object-contain drop-shadow-md" />
                </div>
                <span class="text-white text-3xl font-extrabold tracking-tight">GMA Global</span>
            </a>
            
            <h1 class="text-4xl lg:text-5xl xl:text-6xl font-bold text-white leading-[1.15] mb-8 tracking-tight" style="font-family: 'Outfit', sans-serif;">
                Powering the future of the global secondary market.
            </h1>
            <p class="text-lg xl:text-xl text-blue-100/80 mb-16 leading-relaxed font-light max-w-lg">
                Join thousands of businesses worldwide using our platform to drive sustainability, profitability, and operational excellence.
            </p>

            <!-- Testimonial or Trust Badge -->
            <div class="bg-white/5 backdrop-blur-xl rounded-3xl p-8 border border-white/10 shadow-2xl relative overflow-hidden group hover:bg-white/10 transition-all duration-500">
                <div class="absolute inset-0 bg-gradient-to-br from-[#40e0d0]/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="relative z-10">
                    <div class="flex items-center gap-5 mb-5">
                        <div class="w-14 h-14 rounded-full bg-gradient-to-br from-[#40e0d0] to-[#003366] flex items-center justify-center text-white font-bold text-xl shadow-lg">
                            AR
                        </div>
                        <div>
                            <div class="text-white font-semibold text-lg">Alex Rivera</div>
                            <div class="text-[#40e0d0] text-sm font-medium tracking-wide uppercase">VP of Operations, TechRenew</div>
                        </div>
                    </div>
                    <p class="text-blue-50/90 italic leading-relaxed text-lg">
                        "This platform completely revolutionized how we handle our grading and logistics. The ROI was apparent within the first quarter of deployment."
                    </p>
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
