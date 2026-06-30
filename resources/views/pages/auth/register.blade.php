<x-layouts::auth :title="__('Register')">
    <div class="flex flex-col gap-6">
        <x-auth-header :title="__('Create an account')" :description="__('Enter your details below to create your account')" />

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        @if ($teamInvitation)
            <x-team-invitation-alert :invitation="$teamInvitation" :action="__('Register')" />
        @endif

        <form method="POST" action="{{ route('register.store') }}" class="flex flex-col gap-6">
            @csrf

            <!-- Name -->
            <flux:input
                name="name"
                :label="__('Full name')"
                :value="old('name')"
                type="text"
                required
                autofocus
                autocomplete="name"
                :placeholder="__('Full name')"
            />

            <!-- Email Address -->
            <flux:input
                name="email"
                :label="__('Email address')"
                :value="old('email')"
                type="email"
                required
                autocomplete="email"
                placeholder="email@example.com"
            />

            <!-- Phone -->
            <flux:input
                name="phone"
                :label="__('Phone number')"
                :value="old('phone')"
                type="tel"
                autocomplete="tel"
                :placeholder="__('Phone number')"
            />

            <!-- Company Name -->
            <flux:input
                name="company_name"
                :label="__('Company / Organization name')"
                :value="old('company_name')"
                type="text"
                autocomplete="organization"
                :placeholder="__('Company name (optional)')"
            />

            <!-- Industry -->
            <flux:input
                name="industry"
                :label="__('Industry')"
                :value="old('industry')"
                type="text"
                :placeholder="__('e.g. Technology, Healthcare, Finance')"
            />

            <!-- Job Title -->
            <flux:input
                name="job_title"
                :label="__('Job title')"
                :value="old('job_title')"
                type="text"
                autocomplete="organization-title"
                :placeholder="__('Job title')"
            />

            <!-- Password -->
            <flux:input
                name="password"
                :label="__('Password')"
                type="password"
                required
                autocomplete="new-password"
                :placeholder="__('Password')"
                passwordrules="{{ \Illuminate\Validation\Rules\Password::defaults()->toPasswordRulesString() }}"
                viewable
            />

            <!-- Confirm Password -->
            <flux:input
                name="password_confirmation"
                :label="__('Confirm password')"
                type="password"
                required
                autocomplete="new-password"
                :placeholder="__('Confirm password')"
                passwordrules="{{ \Illuminate\Validation\Rules\Password::defaults()->toPasswordRulesString() }}"
                viewable
            />

            <div class="flex items-center justify-end">
                <flux:button type="submit" variant="primary" class="w-full" data-test="register-user-button">
                    {{ __('Create account') }}
                </flux:button>
            </div>
        </form>

        <div class="space-x-1 rtl:space-x-reverse text-sm text-zinc-600 dark:text-zinc-400 mt-4 transition-colors">
            <span>{{ __('Already have an account?') }}</span>
            <flux:link
                :href="$teamInvitation ? route('login', ['invitation' => $teamInvitation['code']]) : route('login')"
                data-test="team-invitation-login-link"
                wire:navigate
                class="font-medium text-[#001e40] dark:text-[#40e0d0] hover:text-[#40e0d0] dark:hover:text-white transition-colors"
            >
                {{ __('Log in') }}
            </flux:link>
        </div>
    </div>
</x-layouts::auth>
