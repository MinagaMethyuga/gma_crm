<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class SettingsModal extends Component
{
    use WithFileUploads;

    public string $activeTab = 'profile';

    public bool $editingName = false;
    public bool $editingEmail = false;
    public bool $editingPassword = false;

    public string $name = '';
    public string $email = '';

    public string $current_password = '';
    public string $new_password = '';
    public string $new_password_confirmation = '';

    public bool $notify_email = true;
    public bool $notify_events = true;
    public bool $notify_research = true;

    public $newAvatar;

    public ?string $profileSuccess = null;
    public ?string $securitySuccess = null;

    public function mount()
    {
        $this->loadUserData();
    }

    public function loadUserData()
    {
        $user = Auth::user();
        if ($user) {
            $this->name = $user->name ?? '';
            $this->email = $user->email ?? '';
        }
    }

    public function switchTab(string $tab)
    {
        $this->activeTab = $tab;
        $this->profileSuccess = null;
        $this->securitySuccess = null;
        $this->editingName = false;
        $this->editingEmail = false;
        $this->editingPassword = false;
        $this->resetValidation();
    }

    public function saveName()
    {
        $user = Auth::user();
        if (! $user) {
            return;
        }

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $user->update($validated);
        $this->editingName = false;
        $this->profileSuccess = 'Username updated successfully!';
    }

    public function saveEmail()
    {
        $user = Auth::user();
        if (! $user) {
            return;
        }

        $validated = $this->validate([
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        ]);

        $user->update($validated);

        if ($user->wasChanged('email')) {
            $user->email_verified_at = null;
            $user->save();
        }

        $this->editingEmail = false;
        $this->profileSuccess = 'Email updated successfully!';
    }

    public function updatedNewAvatar()
    {
        $this->validate([
            'newAvatar' => ['image', 'max:2048'],
        ]);

        $user = Auth::user();
        if ($user && $this->newAvatar) {
            if ($user->avatar && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->avatar)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->avatar);
            }

            $path = $this->newAvatar->store('avatars', 'public');
            $user->update(['avatar' => $path]);
        }

        $this->profileSuccess = 'Avatar photo updated successfully!';
    }

    public function updatePassword()
    {
        $user = Auth::user();
        if (! $user) {
            return;
        }

        $this->validate([
            'current_password' => ['required', 'current_password'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user->update([
            'password' => Hash::make($this->new_password),
        ]);

        $this->reset(['current_password', 'new_password', 'new_password_confirmation', 'editingPassword']);
        $this->securitySuccess = 'Password updated successfully!';
    }

    public function toggleNotification(string $type)
    {
        if ($type === 'email') {
            $this->notify_email = ! $this->notify_email;
        }
        if ($type === 'events') {
            $this->notify_events = ! $this->notify_events;
        }
        if ($type === 'research') {
            $this->notify_research = ! $this->notify_research;
        }
    }

    public function render()
    {
        $user = Auth::user();
        $isProfessional = false;
        if ($user && $user->plan) {
            $slug = strtolower($user->plan->slug ?? '');
            $name = strtolower($user->plan->name ?? '');
            $isProfessional = ($slug === 'professional' || str_contains($name, 'professional'));
        }

        return view('livewire.settings-modal', [
            'user' => $user,
            'isProfessional' => $isProfessional,
        ]);
    }
}
