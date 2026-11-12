<?php

use App\Concerns\ProfileValidationRules;
use App\Data\Countries;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Profile settings')] class extends Component {
    use ProfileValidationRules;

    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $company_name = '';
    public string $industry = '';
    public string $job_title = '';
    public string $physical_address = '';
    public string $company_website = '';
    public string $country = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $user = Auth::user();

        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = (string) $user->phone;
        $this->company_name = (string) $user->company_name;
        $this->industry = (string) $user->industry;
        $this->job_title = (string) $user->job_title;
        $this->physical_address = (string) $user->physical_address;
        $this->company_website = (string) $user->company_website;
        $this->country = in_array($user->country, Countries::codes(), true) ? $user->country : '';
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            ...$this->profileRules($user->id),
            ...$this->organizationRules(),
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        Flux::toast(variant: 'success', text: __('Profile updated.'));
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }

    #[Computed]
    public function hasUnverifiedEmail(): bool
    {
        return Auth::user() instanceof MustVerifyEmail && ! Auth::user()->hasVerifiedEmail();
    }

    #[Computed]
    public function showDeleteUser(): bool
    {
        return ! Auth::user() instanceof MustVerifyEmail
            || (Auth::user() instanceof MustVerifyEmail && Auth::user()->hasVerifiedEmail());
    }
}; ?>

<section class="w-full">
    @include('partials.settings-heading')

    <flux:heading class="sr-only">{{ __('Profile settings') }}</flux:heading>

    <x-pages::settings.layout :heading="__('Profile')" :subheading="__('Update your name, email address and organization details')">
        <form wire:submit="updateProfileInformation" class="my-6 w-full space-y-6">
            <flux:input wire:model="name" :label="__('Name')" type="text" required autofocus autocomplete="name" />

            <div>
                <flux:input wire:model="email" :label="__('Email')" type="email" required autocomplete="email" />

                @if ($this->hasUnverifiedEmail)
                    <div>
                        <flux:text class="mt-4">
                            {{ __('Your email address is unverified.') }}

                            <flux:link class="text-sm cursor-pointer" wire:click.prevent="resendVerificationNotification">
                                {{ __('Click here to re-send the verification email.') }}
                            </flux:link>
                        </flux:text>

                        @if (session('status') === 'verification-link-sent')
                            <flux:text class="mt-2 font-medium !dark:text-green-400 !text-green-600">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </flux:text>
                        @endif
                    </div>
                @endif
            </div>

            <flux:separator />

            <flux:heading level="3" size="sm" class="pt-2">{{ __('Organization') }}</flux:heading>
            <flux:text class="-mt-4">{{ __('These details appear on your membership and team pages.') }}</flux:text>

            <flux:input wire:model="company_name" :label="__('Company')" type="text" autocomplete="organization" />

            <flux:input wire:model="industry" :label="__('Industry')" type="text" placeholder="e.g. Retail, Wholesale" />

            <flux:input wire:model="job_title" :label="__('Job title')" type="text" placeholder="e.g. CEO" />

            <flux:input wire:model="phone" :label="__('Phone')" type="tel" autocomplete="tel" />

            <flux:input wire:model="physical_address" :label="__('Physical address')" type="text" />

            <flux:input wire:model="company_website" :label="__('Company website')" type="text" />

            <flux:select wire:model="country" :label="__('Country')" placeholder="Select Country">
                @foreach (Countries::all() as $code => $countryName)
                    <flux:select.option value="{{ $code }}">{{ $countryName }}</flux:select.option>
                @endforeach
            </flux:select>

            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full" data-test="update-profile-button">
                        {{ __('Save') }}
                    </flux:button>
                </div>
            </div>
        </form>

        @if ($this->showDeleteUser)
            <livewire:pages::settings.delete-user-form />
        @endif
    </x-pages::settings.layout>
</section>
