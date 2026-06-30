<x-layouts::auth :title="__('Log in')">
    <div class="flex flex-col gap-6">
        <x-auth-header :title="__('Log in to your account')" :description="__('Enter your email and password below to log in')" />

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        @if ($teamInvitation)
            <x-team-invitation-alert :invitation="$teamInvitation" :action="__('Log in')" />
        @endif

        <x-passkey-verify />

        <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-6">
            @csrf

            <!-- Email Address -->
            <flux:input
                name="email"
                :label="__('Email address')"
                :value="old('email')"
                type="email"
                required
                autofocus
                autocomplete="email"
                placeholder="email@example.com"
            />

            <!-- Password -->
            <div class="relative">
                <flux:input
                    name="password"
                    :label="__('Password')"
                    type="password"
                    required
                    autocomplete="current-password"
                    :placeholder="__('Password')"
                    viewable
                />

                @if (Route::has('password.request'))
                    <flux:link class="absolute top-0 text-sm end-0" :href="route('password.request')" wire:navigate>
                        {{ __('Forgot your password?') }}
                    </flux:link>
                @endif
            </div>

            <!-- Remember Me -->
            <label class="flex items-center gap-3 cursor-pointer select-none">
                <input type="hidden" name="remember" value="0">
                <input type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}
                    class="h-4 w-4 rounded border-zinc-300 text-zinc-700 focus:ring-accent dark:border-white/10 dark:bg-white/10 dark:text-white">
                <span class="text-sm text-zinc-600 dark:text-zinc-400">{{ __('Remember me') }}</span>
            </label>

            <div class="flex items-center justify-end">
                <flux:button variant="primary" type="submit" class="w-full" data-test="login-button">
                    {{ __('Log in') }}
                </flux:button>
            </div>
        </form>

        <div class="space-x-1 text-sm rtl:space-x-reverse text-zinc-600 dark:text-zinc-400 mt-4 transition-colors">
            <span>{{ __('Don\'t have an account?') }}</span>
            <flux:link
                :href="$teamInvitation ? route('register', ['invitation' => $teamInvitation['code']]) : route('register')"
                data-test="register-link"
                wire:navigate
                class="font-medium text-[#001e40] dark:text-[#40e0d0] hover:text-[#40e0d0] dark:hover:text-white transition-colors"
            >
                {{ __('Sign up') }}
            </flux:link>
        </div>
    </div>
</x-layouts::auth>
