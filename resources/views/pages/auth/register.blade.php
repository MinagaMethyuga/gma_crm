<x-layouts::auth :title="__('Register')">
    <style>
        /* Light Theme Pill Inputs & Styling */
        .auth-card input[type="text"],
        .auth-card input[type="email"],
        .auth-card input[type="password"],
        .auth-card input[type="tel"] {
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
        /* Style adjustments for password show/hide button */
        .auth-card [data-flux-input] button {
            right: 0.75rem !important;
            color: rgba(0, 30, 64, 0.5) !important;
        }
    </style>

    <div class="auth-card flex flex-col gap-6">
        <!-- Logo & Header -->
        <div class="flex flex-col items-center text-center animate-stagger-item delay-100">
            <img src="/Global_Mobile_Association_Logo__1_-removebg-preview.png" alt="GMA Logo" class="h-20 w-auto object-contain mb-3 drop-shadow-sm">
            <h2 class="text-2xl font-black text-[#001e40] tracking-tight">Create an Account</h2>
            <p class="text-sm text-zinc-500 mt-1">Enter your details below to join GMA</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        @if ($teamInvitation)
            <x-team-invitation-alert :invitation="$teamInvitation" :action="__('Register')" />
        @endif

        <form method="POST" action="{{ route('register.store') }}" class="flex flex-col gap-5">
            @csrf

            <!-- Name -->
            <div class="animate-stagger-item delay-200">
                <flux:input
                    name="name"
                    :value="old('name')"
                    type="text"
                    required
                    autofocus
                    autocomplete="name"
                    placeholder="Full Name"
                />
            </div>

            <!-- Email Address -->
            <div class="animate-stagger-item delay-300">
                <flux:input
                    name="email"
                    :value="old('email')"
                    type="email"
                    required
                    autocomplete="email"
                    placeholder="Email Address"
                />
            </div>

            <!-- Phone -->
            <div class="animate-stagger-item delay-400">
                <flux:input
                    name="phone"
                    :value="old('phone')"
                    type="tel"
                    autocomplete="tel"
                    placeholder="Phone Number"
                />
            </div>

            <!-- Company Name -->
            <div class="animate-stagger-item delay-500">
                <flux:input
                    name="company_name"
                    :value="old('company_name')"
                    type="text"
                    required
                    autocomplete="organization"
                    placeholder="Company Name"
                />
            </div>

            <!-- Industry -->
            <div class="animate-stagger-item delay-600">
                <flux:input
                    name="industry"
                    :value="old('industry')"
                    type="text"
                    placeholder="Industry (optional) - e.g. Retail, Wholesale"
                />
            </div>

            <!-- Physical Address -->
            <div class="animate-stagger-item delay-650">
                <flux:input
                    name="physical_address"
                    :value="old('physical_address')"
                    type="text"
                    placeholder="Physical Address (optional)"
                />
            </div>

            <!-- Company Website -->
            <div class="animate-stagger-item delay-700">
                <flux:input
                    name="company_website"
                    :value="old('company_website')"
                    type="text"
                    placeholder="Company Website (optional)"
                />
            </div>

            <!-- Password -->
            <div class="animate-stagger-item delay-700">
                <flux:input
                    name="password"
                    type="password"
                    required
                    autocomplete="new-password"
                    placeholder="Password"
                    passwordrules="{{ \Illuminate\Validation\Rules\Password::defaults()->toPasswordRulesString() }}"
                    viewable
                />
            </div>

            <!-- Confirm Password -->
            <div class="animate-stagger-item delay-700">
                <flux:input
                    name="password_confirmation"
                    type="password"
                    required
                    autocomplete="new-password"
                    placeholder="Confirm Password"
                    passwordrules="{{ \Illuminate\Validation\Rules\Password::defaults()->toPasswordRulesString() }}"
                    viewable
                />
            </div>

            <!-- Submit Button -->
            <div class="mt-2 animate-stagger-item delay-800">
                <button type="submit" class="w-full h-12.5 rounded-full bg-gradient-to-r from-[#006a6a] to-[#009090] hover:from-[#009090] hover:to-[#006a6a] text-white font-bold transition-all duration-300 transform active:scale-98 shadow-[0_10px_20px_-10px_rgba(0,106,106,0.35)] hover:shadow-[0_10px_20px_-5px_rgba(0,106,106,0.5)] flex items-center justify-center text-base" data-test="register-user-button">
                    {{ __('Create Account') }}
                </button>
            </div>
        </form>

        <!-- Footer link -->
        <div class="text-center text-sm text-zinc-500 mt-2 animate-stagger-item delay-800">
            <span>{{ __('Already have an account?') }}</span>
            <a
                href="{{ $teamInvitation ? route('login', ['invitation' => $teamInvitation['code']]) : route('login') }}"
                data-test="team-invitation-login-link"
                class="font-bold text-[#006a6a] hover:text-[#009090] transition-colors ml-1"
                wire:navigate
            >
                {{ __('Log in') }}
            </a>
        </div>
    </div>
</x-layouts::auth>
