<x-layouts::auth :title="__('Log in')">
    <style>
        /* Light Theme Pill Inputs & Styling */
        .auth-card input[type="text"],
        .auth-card input[type="email"],
        .auth-card input[type="password"] {
            border-radius: 9999px !important;
            background-color: rgba(0, 0, 0, 0.03) !important;
            border-color: rgba(0, 0, 0, 0.08) !important;
            padding-left: 1.5rem !important;
            padding-right: 1.5rem !important;
            height: 3.25rem !important;
            font-size: 0.95rem !important;
            color: #001e40 !important;
            transition: all 0.25s ease-in-out !important;
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.01) !important;
        }
        .auth-card input::placeholder {
            color: #71717a !important; /* zinc-500 */
        }
        .auth-card input:focus {
            background-color: #ffffff !important;
            border-color: #006a6a !important;
            box-shadow: 0 0 0 3px rgba(0, 106, 106, 0.15), inset 0 2px 4px rgba(0,0,0,0.01) !important;
        }
        /* Style adjustments for password eye toggle button */
        .auth-card [data-flux-input] button {
            right: 0.75rem !important;
            color: rgba(0, 30, 64, 0.5) !important;
        }
        /* Custom checkbox style */
        .custom-checkbox {
            accent-color: #006a6a;
        }
    </style>

    <div class="auth-card flex flex-col gap-6">
        <!-- Logo & Header -->
        <div class="flex flex-col items-center text-center animate-stagger-item delay-100">
            <img src="/Global_Mobile_Association_Logo__1_-removebg-preview.png" alt="GMA Logo" class="h-28 w-auto object-contain mb-3 drop-shadow-sm">
            <h2 class="text-2xl font-black text-[#001e40] tracking-tight">Welcome to GMA</h2>
            <p class="text-sm text-zinc-500 mt-1">Let's get started with GMA CRM</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        @if ($teamInvitation)
            <x-team-invitation-alert :invitation="$teamInvitation" :action="__('Log in')" />
        @endif

        <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-5">
            @csrf

            <!-- Email Address -->
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
            </div>

            <!-- Remember Me & Forgot Password Row -->
            <div class="flex items-center justify-between mt-1 px-1 animate-stagger-item delay-400">
                <label class="flex items-center gap-2 cursor-pointer select-none">
                    <input type="hidden" name="remember" value="0">
                    <input type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}
                        class="custom-checkbox h-4.5 w-4.5 rounded border-zinc-200 bg-white text-[#006a6a] focus:ring-[#006a6a]/30">
                    <span class="text-sm text-zinc-500 font-medium">{{ __('Remember me?') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-sm font-semibold text-[#006a6a] hover:text-[#009090] transition-colors" href="{{ route('password.request') }}" wire:navigate>
                        {{ __('Forgot Password?') }}
                    </a>
                @endif
            </div>

            <!-- Submit Button -->
            <div class="mt-2 animate-stagger-item delay-500">
                <button type="submit" class="w-full h-12.5 rounded-full bg-gradient-to-r from-[#006a6a] to-[#009090] hover:from-[#009090] hover:to-[#006a6a] text-white font-bold transition-all duration-300 transform active:scale-98 shadow-[0_10px_20px_-10px_rgba(0,106,106,0.35)] hover:shadow-[0_10px_20px_-5px_rgba(0,106,106,0.5)] flex items-center justify-center text-base" data-test="login-button">
                    {{ __('Log In') }}
                </button>
            </div>
        </form>

        <!-- Footer link -->
        <div class="text-center text-sm text-zinc-500 mt-2 animate-stagger-item delay-600">
            <span>{{ __('New User?') }}</span>
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
</x-layouts::auth>
