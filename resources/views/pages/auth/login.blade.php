<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head')
    <style>
        /* Custom scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 5px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(0, 106, 106, 0.15);
            border-radius: 10px;
        }

        /* Light Theme Inputs */
        .auth-card input[type="text"],
        .auth-card input[type="email"],
        .auth-card input[type="password"] {
            border-radius: 10px !important;
            background-color: #f8fafc !important;
            border: 1px solid #e2e8f0 !important;
            padding-left: 1rem !important;
            padding-right: 1rem !important;
            height: 2.875rem !important;
            font-size: 0.9rem !important;
            color: #0f172a !important;
            transition: all 0.2s ease-in-out !important;
            width: 100% !important;
            box-shadow: 0 1px 2px rgba(0,0,0,0.02) !important;
        }
        .auth-card input::placeholder {
            color: #94a3b8 !important;
        }
        .auth-card input:focus {
            background-color: #ffffff !important;
            border-color: #006a6a !important;
            box-shadow: 0 0 0 3px rgba(0, 106, 106, 0.1) !important;
            outline: none !important;
        }
        .auth-card [data-flux-input] button {
            right: 0.75rem !important;
            color: rgba(0, 30, 64, 0.5) !important;
        }
        .custom-checkbox {
            accent-color: #006a6a;
        }

        @keyframes blob1 {
            0% { transform: translate(0px, 0px) scale(1) rotate(0deg); }
            33% { transform: translate(60px, -80px) scale(1.2) rotate(45deg); }
            66% { transform: translate(-40px, 50px) scale(0.8) rotate(-45deg); }
            100% { transform: translate(0px, 0px) scale(1) rotate(0deg); }
        }
        @keyframes blob2 {
            0% { transform: translate(0px, 0px) scale(1) rotate(0deg); }
            33% { transform: translate(-70px, 60px) scale(0.8) rotate(-60deg); }
            66% { transform: translate(50px, -80px) scale(1.2) rotate(60deg); }
            100% { transform: translate(0px, 0px) scale(1) rotate(0deg); }
        }
        .animate-blob-1 { animation: blob1 15s infinite alternate ease-in-out; }
        .animate-blob-2 { animation: blob2 18s infinite alternate ease-in-out; }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-stagger-item {
            opacity: 0;
            animation: fadeInUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        .delay-100 { animation-delay: 50ms; }
        .delay-200 { animation-delay: 100ms; }
        .delay-300 { animation-delay: 150ms; }
        .delay-400 { animation-delay: 200ms; }
        .delay-500 { animation-delay: 250ms; }
        .delay-600 { animation-delay: 300ms; }
    </style>
</head>
<body class="min-h-screen antialiased overflow-hidden relative bg-white">
    @include('components.page-transition')

    <div class="grid grid-cols-1 lg:grid-cols-2 min-h-screen w-screen overflow-hidden">

        <!-- Left Side: Brand Panel (Desktop Only) -->
        <div class="hidden lg:flex flex-col justify-between p-8 xl:p-12 text-white h-screen relative overflow-hidden bg-[#0a1120] border-r border-white/5">
            <!-- Background -->
            <div class="absolute inset-0 bg-gradient-to-br from-[#0a1120] via-[#101b33] to-[#0a1120] pointer-events-none"></div>
            <div class="absolute top-[10%] left-[10%] w-[400px] h-[400px] bg-[#00f5d4]/10 rounded-full filter blur-[100px] animate-blob-1 pointer-events-none"></div>
            <div class="absolute bottom-[10%] right-[10%] w-[450px] h-[450px] bg-[#006a6a]/15 rounded-full filter blur-[110px] animate-blob-2 pointer-events-none"></div>
            <div class="absolute inset-0 opacity-[0.02]" style="background-image: radial-gradient(circle at 1px 1px, #00f5d4 1px, transparent 0); background-size: 30px 30px;"></div>

            <!-- Top Header -->
            <div class="relative z-10 flex items-center justify-between">
                <a href="{{ route('home') }}" class="flex items-center gap-3 text-white no-underline group" wire:navigate>
                    <img src="/Global_Mobile_Association_Logo__1_-removebg-preview.png" alt="GMA Logo" class="h-20 w-auto object-contain brightness-0 invert transition-transform group-hover:scale-105">
                </a>
                <a href="{{ route('home') }}" class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-white/70 hover:text-white transition-colors" wire:navigate>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Home
                </a>
            </div>

            <!-- Mid Section: Hero Content -->
            <div class="relative z-10 my-auto w-full flex flex-col justify-center">
                <h1 class="text-3xl xl:text-4xl font-black text-white tracking-tight mb-4 leading-tight">
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#00f5d4] to-[#40e0d0]">Stronger Together.</span><br>
                    Built to Move an Industry Forward.
                </h1>
                <p class="text-white/60 text-sm xl:text-base leading-relaxed max-w-sm mb-10">
                    The year round association for the global used mobile ecosystem.
                </p>

                <!-- Pill Tags -->
                <div class="flex flex-wrap gap-3">
                    <div class="px-4 py-2 rounded-full bg-white/5 border border-white/10 text-white/80 text-xs xl:text-sm font-medium backdrop-blur-sm">
                        Education
                    </div>
                    <div class="px-4 py-2 rounded-full bg-white/5 border border-white/10 text-white/80 text-xs xl:text-sm font-medium backdrop-blur-sm">
                        Resources
                    </div>
                    <div class="px-4 py-2 rounded-full bg-white/5 border border-white/10 text-white/80 text-xs xl:text-sm font-medium backdrop-blur-sm">
                        Leadership Development
                    </div>
                    <div class="px-4 py-2 rounded-full bg-white/5 border border-white/10 text-white/80 text-xs xl:text-sm font-medium backdrop-blur-sm">
                        Advocacy
                    </div>
                    <div class="px-4 py-2 rounded-full bg-white/5 border border-white/10 text-white/80 text-xs xl:text-sm font-medium backdrop-blur-sm">
                        Industry Connection
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="relative z-10 text-[10px] text-white/40 tracking-wider">
                &copy; {{ date('Y') }} Global Mobile Association. All rights reserved.
            </div>
        </div>

        <!-- Right Side: Login Form -->
        <div class="flex flex-col h-screen overflow-y-auto bg-white text-zinc-950 p-6 sm:p-10 md:p-12 lg:p-16 relative custom-scrollbar">
            <!-- Mobile Header -->
            <div class="flex lg:hidden justify-between items-center mb-8 w-full">
                <a href="{{ route('home') }}" class="flex items-center gap-2 text-zinc-950 no-underline" wire:navigate>
                    <img src="/Global_Mobile_Association_Logo__1_-removebg-preview.png" alt="GMA Logo" class="h-14 w-auto object-contain">
                </a>
                <a href="{{ route('home') }}" class="flex items-center gap-1.5 text-[11px] font-bold uppercase tracking-wider text-zinc-500 hover:text-zinc-900 transition-colors" wire:navigate>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Home
                </a>
            </div>

            <div class="mx-auto w-full max-w-md flex flex-col justify-center my-auto">
                <div class="auth-card flex flex-col gap-6 w-full">

                    <!-- Header -->
                    <div class="flex flex-col items-center text-center animate-stagger-item delay-100">
                        <img src="/Global_Mobile_Association_Logo__1_-removebg-preview.png" alt="GMA Logo" class="h-20 w-auto object-contain mb-3 drop-shadow-sm hidden lg:block">
                        <h2 class="text-2xl font-black text-[#001e40] tracking-tight">Welcome back</h2>
                        <p class="text-sm text-zinc-500 mt-1">Sign in to your GMA account</p>
                    </div>

                    <!-- Session Status -->
                    <x-auth-session-status class="mb-2" :status="session('status')" />

                    @if ($teamInvitation)
                        <x-team-invitation-alert :invitation="$teamInvitation" :action="__('Log in')" />
                    @endif

                    <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-4">
                        @csrf

                        <!-- Email -->
                        <div class="animate-stagger-item delay-200">
                            <flux:input
                                name="email"
                                :value="old('email')"
                                type="email"
                                required
                                autofocus
                                autocomplete="email"
                                placeholder="Email Address"
                            />
                            @error('email') <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Password -->
                        <div class="animate-stagger-item delay-300">
                            <flux:input
                                name="password"
                                type="password"
                                required
                                autocomplete="current-password"
                                placeholder="Password"
                                viewable
                            />
                            @error('password') <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="flex items-center justify-between px-1 animate-stagger-item delay-400">
                            <label class="flex items-center gap-2 cursor-pointer select-none">
                                <input type="hidden" name="remember" value="0">
                                <input type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}
                                    class="custom-checkbox h-4 w-4 rounded border-zinc-200 bg-white text-[#006a6a] focus:ring-[#006a6a]/30">
                                <span class="text-sm text-zinc-500 font-medium">{{ __('Remember me') }}</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a class="text-sm font-semibold text-[#006a6a] hover:text-[#009090] transition-colors" href="{{ route('password.request') }}" wire:navigate>
                                    {{ __('Forgot Password?') }}
                                </a>
                            @endif
                        </div>

                        <!-- Submit -->
                        <div class="animate-stagger-item delay-500">
                            <button type="submit" class="w-full h-11 rounded-full bg-gradient-to-r from-[#006a6a] to-[#009090] hover:from-[#009090] hover:to-[#006a6a] text-white font-bold transition-all duration-300 transform active:scale-98 shadow-[0_8px_16px_-8px_rgba(0,106,106,0.3)] hover:shadow-[0_8px_16px_-4px_rgba(0,106,106,0.4)] flex items-center justify-center text-sm" data-test="login-button">
                                {{ __('Sign In') }}
                            </button>
                        </div>
                    </form>

                    <!-- Footer link -->
                    <div class="text-center text-sm text-zinc-500 animate-stagger-item delay-600">
                        <span>{{ __("Don't have an account?") }}</span>
                        <a
                            href="{{ $teamInvitation ? route('register', ['invitation' => $teamInvitation['code']]) : route('register') }}"
                            data-test="register-link"
                            class="font-bold text-[#006a6a] hover:text-[#009090] transition-colors ml-1"
                            wire:navigate
                        >
                            {{ __('Register') }}
                        </a>
                    </div>
                </div>
            </div>
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