<?php

use App\Data\TeamPermissions;
use App\Enums\TeamRole;
use App\Models\Team;
use App\Rules\TeamName;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component
{
    public Team $teamModel;

    public string $teamName = '';

    public array $teamData = [];

    public array $members = [];

    public array $invitations = [];

    public array $availableRoles = [];

    public bool $isCurrentTeam = false;

    public function mount(Team $team): void
    {
        $this->teamModel = $team;
        $this->teamName = $team->name;

        $this->populateTeamData();
    }

    public function updateTeam(): void
    {
        Gate::authorize('update', $this->teamModel);

        $validated = $this->validate([
            'teamName' => ['required', 'string', 'max:255', new TeamName],
        ]);

        $team = DB::transaction(function () use ($validated) {
            $team = Team::whereKey($this->teamModel->id)->lockForUpdate()->firstOrFail();

            $team->update(['name' => $validated['teamName']]);

            return $team;
        });

        $this->teamModel = $team;

        $this->populateTeamData();

        Flux::toast(variant: 'success', text: __('Team updated.'));

        $this->redirectRoute('teams.edit', ['team' => $this->teamModel->fresh()->slug], navigate: true);
    }

    public function updateMember(int $userId, string $role): void
    {
        Gate::authorize('updateMember', $this->teamModel);

        $validated = Validator::make(['role' => $role], [
            'role' => ['required', 'string', Rule::enum(TeamRole::class)],
        ])->validate();

        $this->teamModel->memberships()
            ->where('user_id', $userId)
            ->firstOrFail()
            ->update(['role' => TeamRole::from($validated['role'])]);

        $this->populateTeamData();

        Flux::toast(variant: 'success', text: __('Member role updated.'));
    }

    public function resendInvitation(string $code): void
    {
        Gate::authorize('inviteMember', $this->teamModel);

        $invitation = clone $this->teamModel->invitations()->where('code', $code)->firstOrFail();

        \Illuminate\Support\Facades\Notification::route('mail', $invitation->email)
            ->notify(new \App\Notifications\Teams\TeamInvitation($invitation));

        Flux::toast(variant: 'success', text: __('Invitation resent.'));
    }

    private function populateTeamData(): void
    {
        $user = Auth::user();

        $team = $this->teamModel->fresh(['plan']);

        $activeMembers = $team->members()->count();
        $pendingInvites = $team->invitations()
            ->whereNull('accepted_at')
            ->where(function($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
            })->count();
        $seatsUsed = $activeMembers + $pendingInvites + 1;

        $this->teamData = [
            'id' => $team->id,
            'name' => $team->name,
            'slug' => $team->slug,
            'is_personal' => $team->is_personal,
            'plan_name' => $team->plan ? $team->plan->name : 'Free / Personal',
            'has_active_plan' => $team->hasActivePlan(),
            'max_seats' => $team->max_seats,
            'seats_used' => $seatsUsed,
        ];

        $this->members = $team->members()->get()->map(fn ($member) => [
            'id' => $member->id,
            'name' => $member->name,
            'email' => $member->email,
            'avatar' => $member->avatar ?? null,
            'initials' => $member->initials(),
            'role' => $member->pivot->role->value,
            'role_label' => $member->pivot->role->label(),
        ])->toArray();

        $this->invitations = $team->invitations()
            ->whereNull('accepted_at')
            ->get()
            ->map(fn ($invitation) => [
                'code' => $invitation->code,
                'email' => $invitation->email,
                'role' => $invitation->role->value,
                'role_label' => $invitation->role->label(),
                'created_at' => $invitation->created_at->toISOString(),
                'sent_at' => $invitation->created_at->format('M d, Y'),
                'expires_at' => $invitation->expires_at ? $invitation->expires_at->format('M d, Y') : null,
                'is_expired' => $invitation->expires_at && $invitation->expires_at->isPast(),
            ])->toArray();

        $this->availableRoles = TeamRole::assignable();

        $this->isCurrentTeam = $user->isCurrentTeam($team);
    }

    public function render()
    {
        $teamName = $this->teamData['name'] ?? $this->teamModel->name;

        $title = $this->permissions->canUpdateTeam
            ? __('Edit :name', ['name' => $teamName])
            : __('View :name', ['name' => $teamName]);

        return $this->view()->title($title);
    }

    #[Computed]
    public function permissions(): TeamPermissions
    {
        return Auth::user()->toTeamPermissions($this->teamModel);
    }
}; ?>

<section class="w-full">
    @include('partials.settings-heading')

    <flux:heading class="sr-only">{{ __('Teams') }}</flux:heading>

    <x-pages::settings.layout :heading="__('Teams')" :subheading="__('Manage your team settings')">
        <div class="space-y-10">
            <div class="space-y-6">
                @if ($this->permissions->canUpdateTeam)
                    <div class="space-y-4">
                        <form wire:submit="updateTeam" class="space-y-6">
                            <flux:input wire:model="teamName" :label="__('Team name')" required data-test="team-name-input" />

                            <flux:button variant="primary" type="submit" data-test="team-save-button">
                                {{ __('Save') }}
                            </flux:button>
                        </form>
                    </div>
                @else
                    <div>
                        <flux:heading>{{ $teamData['name'] }}</flux:heading>
                    </div>
                @endif
            </div>

            <div class="space-y-6">
                <!-- Subscription Status Card -->
                <div class="relative overflow-hidden rounded-2xl border border-indigo-100 bg-gradient-to-b from-indigo-50/50 to-white p-6 shadow-[0_2px_8px_-4px_rgba(0,0,0,0.05)] transition-all duration-300 ease-[cubic-bezier(0.23,1,0.32,1)] hover:border-indigo-200 hover:shadow-[0_8px_24px_-8px_rgba(0,0,0,0.08)] dark:border-indigo-900/30 dark:from-indigo-950/20 dark:to-zinc-900">
                    <div class="absolute -right-20 -top-20 h-40 w-40 rounded-full bg-[#3525cd]/5 blur-3xl"></div>
                    <div class="relative z-10 flex items-start justify-between">
                        <div>
                            <flux:heading>{{ __('Team Subscription') }}</flux:heading>
                            <flux:subheading>{{ __('Manage your corporate billing and seat capacity.') }}</flux:subheading>
                        </div>
                        @if ($teamData['has_active_plan'])
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                <div class="w-1.5 h-1.5 rounded-full bg-emerald-500"></div>
                                {{ $teamData['plan_name'] }}
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-zinc-100 text-zinc-700 border border-zinc-200">
                                Free Tier
                            </span>
                        @endif
                    </div>
                    
                    @if ($teamData['has_active_plan'] && $teamData['max_seats'])
                        <div class="mt-6">
                            <div class="flex justify-between text-sm mb-2">
                                <span class="font-medium text-zinc-700 dark:text-zinc-300">
                                    Seats Used <span class="text-zinc-500 font-normal">({{ max(0, $teamData['max_seats'] - $teamData['seats_used']) }} remaining)</span>
                                </span>
                                <span class="font-medium text-zinc-900 dark:text-white">{{ $teamData['seats_used'] }} / {{ $teamData['max_seats'] }}</span>
                            </div>
                            <div class="w-full bg-zinc-100 dark:bg-zinc-800 rounded-full h-2">
                                @php
                                    $usagePercent = min(100, ($teamData['seats_used'] / $teamData['max_seats']) * 100);
                                    $barColor = $usagePercent >= 100 ? 'bg-red-500' : ($usagePercent >= 80 ? 'bg-amber-500' : 'bg-[#3525cd]');
                                @endphp
                                <div class="{{ $barColor }} h-2 rounded-full transition-all duration-500" style="width: {{ $usagePercent }}%"></div>
                            </div>
                            @if ($teamData['seats_used'] >= $teamData['max_seats'])
                                <p class="text-xs text-red-500 mt-2 font-medium flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">error</span> You have reached your seat limit. Upgrade your plan to invite more members.</p>
                            @elseif ($usagePercent >= 80)
                                <p class="text-xs text-amber-600 dark:text-amber-500 mt-2 font-medium flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">warning</span> You are nearing your seat limit.</p>
                            @endif
                        </div>
                    @endif
                </div>

                <div class="flex items-center justify-between">
                    <div>
                        <flux:heading>{{ __('Team members') }}</flux:heading>
                        @if ($this->permissions->canAddMember || $this->permissions->canUpdateMember || $this->permissions->canRemoveMember)
                            <flux:subheading>{{ __('Manage who belongs to this team') }}</flux:subheading>
                        @endif
                    </div>

                    @if ($this->permissions->canCreateInvitation)
                        @php
                            $isFull = $teamData['max_seats'] && $teamData['seats_used'] >= $teamData['max_seats'];
                        @endphp
                        @if ($isFull)
                            <flux:tooltip content="Seat limit reached">
                                <flux:button variant="primary" icon="user-plus" disabled class="opacity-50 cursor-not-allowed">
                                    {{ __('Invite member') }}
                                </flux:button>
                            </flux:tooltip>
                        @else
                            <flux:modal.trigger name="invite-member">
                                <flux:button variant="primary" icon="user-plus" data-test="invite-member-button">
                                    {{ __('Invite member') }}
                                </flux:button>
                            </flux:modal.trigger>
                        @endif
                    @endif
                </div>

                <div class="space-y-3">
                    @foreach ($members as $member)
                        <div class="group relative flex items-center justify-between gap-4 rounded-xl border border-zinc-200/80 bg-white p-4 shadow-sm transition-all duration-300 ease-out hover:-translate-y-0.5 hover:border-zinc-300 hover:shadow-md dark:border-zinc-700/80 dark:bg-zinc-900 dark:hover:border-zinc-600" data-test="member-row">
                            <div class="flex items-center gap-4">
                                <flux:avatar :name="$member['name']" :initials="$member['initials']" />
                                <div>
                                    <div class="font-medium">{{ $member['name'] }}</div>
                                    <flux:text class="text-sm text-zinc-500 dark:text-zinc-400">{{ $member['email'] }}</flux:text>
                                </div>
                            </div>

                            <div class="flex items-center gap-2">
                                @if ($member['role'] !== 'owner' && $this->permissions->canUpdateMember)
                                    <flux:dropdown position="bottom" align="end">
                                        <flux:button variant="outline" size="sm" icon:trailing="chevron-down" data-test="member-role-trigger">
                                            {{ $member['role_label'] }}
                                        </flux:button>
                                        <flux:menu>
                                            @foreach ($availableRoles as $role)
                                                <flux:menu.item
                                                    as="button"
                                                    type="button"
                                                    wire:click="updateMember({{ $member['id'] }}, '{{ $role['value'] }}')"
                                                    data-test="member-role-option"
                                                >
                                                    {{ $role['label'] }}
                                                </flux:menu.item>
                                            @endforeach
                                        </flux:menu>
                                    </flux:dropdown>
                                @else
                                    <flux:badge color="zinc">{{ $member['role_label'] }}</flux:badge>
                                @endif

                                @if ($member['role'] !== 'owner' && $this->permissions->canRemoveMember)
                                    <flux:modal.trigger name="remove-member-{{ $member['id'] }}">
                                        <flux:tooltip :content="__('Remove member')">
                                            <flux:button
                                                variant="ghost"
                                                size="sm"
                                                icon="x-mark"
                                                data-test="member-remove-button"
                                            />
                                        </flux:tooltip>
                                    </flux:modal.trigger>
                                @endif
                            </div>
                        </div>

                        @if ($member['role'] !== 'owner' && $this->permissions->canRemoveMember)
                            <livewire:pages::teams.remove-member-modal
                                :team="$teamModel"
                                :member-id="$member['id']"
                                :member-name="$member['name']"
                                :modal-name="'remove-member-'.$member['id']"
                                :key="'remove-member-modal-'.$member['id']"
                            />
                        @endif
                    @endforeach
                </div>
            </div>

            @if (count($invitations) > 0)
                <div class="space-y-6">
                    <div>
                        <flux:heading>{{ __('Pending invitations') }}</flux:heading>
                        <flux:subheading>{{ __('Invitations that have not been accepted yet') }}</flux:subheading>
                    </div>

                    <div class="space-y-3">
                        @foreach ($invitations as $invitation)
                            <div class="group relative flex items-center justify-between gap-4 rounded-xl border border-zinc-200 bg-white p-4 shadow-sm dark:border-zinc-700 dark:bg-zinc-900" data-test="invitation-row">
                                <div class="flex items-center gap-4">
                                    <div class="flex size-10 items-center justify-center rounded-full bg-zinc-100 dark:bg-zinc-800">
                                        <flux:icon name="envelope" class="text-zinc-500" />
                                    </div>
                                    <div>
                                        <div class="font-medium">{{ $invitation['email'] }}</div>
                                        <div class="flex items-center gap-2 mt-0.5">
                                            <flux:text class="text-xs text-zinc-500 dark:text-zinc-400">Sent {{ $invitation['sent_at'] ?? \Carbon\Carbon::parse($invitation['created_at'])->format('M d, Y') }}</flux:text>
                                            @if ($invitation['is_expired'] ?? false)
                                                <flux:badge color="red" size="sm" class="text-[10px] uppercase tracking-wider font-bold">Expired</flux:badge>
                                            @elseif ($invitation['expires_at'] ?? false)
                                                <flux:text class="text-xs text-zinc-400 dark:text-zinc-500">Exp: {{ $invitation['expires_at'] }}</flux:text>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center gap-2">
                                    <flux:badge color="zinc" size="sm">{{ __('Pending') }}</flux:badge>
                                    
                                    @if ($this->permissions->canCreateInvitation)
                                        <flux:tooltip content="Resend invitation">
                                            <flux:button variant="ghost" size="sm" icon="arrow-path" wire:click="resendInvitation('{{ $invitation['code'] }}')" class="text-indigo-500 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-500/10" data-test="resend-invitation-button" />
                                        </flux:tooltip>
                                    @endif

                                    @if ($this->permissions->canCancelInvitation)
                                        <flux:modal.trigger name="cancel-invitation-{{ $invitation['code'] }}">
                                            <flux:tooltip :content="__('Cancel invitation')">
                                                <flux:button
                                                    variant="ghost"
                                                    size="sm"
                                                    icon="x-mark"
                                                    data-test="invitation-cancel-button"
                                                />
                                            </flux:tooltip>
                                        </flux:modal.trigger>
                                    @endif
                                </div>
                            @if ($this->permissions->canCancelInvitation)
                                <livewire:pages::teams.cancel-invitation-modal
                                    :team="$teamModel"
                                    :invitation-code="$invitation['code']"
                                    :invitation-email="$invitation['email']"
                                    :modal-name="'cancel-invitation-'.$invitation['code']"
                                    :key="'cancel-invitation-modal-'.$invitation['code']"
                                />
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif

            @if ($this->permissions->canDeleteTeam && ! $teamData['is_personal'])
                <div class="space-y-6">
                    <div>
                        <flux:heading>{{ __('Delete team') }}</flux:heading>
                        <flux:subheading>{{ __('Permanently delete your team') }}</flux:subheading>
                    </div>

                    <div class="space-y-4 rounded-lg border border-red-200 bg-red-50 p-4 text-red-700 dark:border-red-200/10 dark:bg-red-900/20 dark:text-red-100">
                        <div>
                            <p class="font-medium">{{ __('Warning') }}</p>
                            <p class="text-sm">{{ __('Please proceed with caution, this cannot be undone.') }}</p>
                        </div>

                        <flux:modal.trigger name="delete-team">
                            <flux:button variant="danger" data-test="delete-team-button">
                                {{ __('Delete team') }}
                            </flux:button>
                        </flux:modal.trigger>
                    </div>
                </div>
            @endif
        </div>
    </x-pages::settings.layout>

    @if ($this->permissions->canCreateInvitation)
        <livewire:pages::teams.invite-member-modal :team="$teamModel" />
    @endif

    @if ($this->permissions->canDeleteTeam && ! $teamData['is_personal'])
        <livewire:pages::teams.delete-team-modal :team="$teamModel" />
    @endif
</section>
