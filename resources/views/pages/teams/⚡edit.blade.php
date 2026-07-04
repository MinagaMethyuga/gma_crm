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

<x-pages::settings.layout :heading="__('Teams')" :subheading="__('Manage your team settings')">
    <div class="space-y-12 pb-12 w-full max-w-4xl" style="color: #0f172a !important;">
        <!-- Team Name Section -->
        <section class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-slate-900">{{ __('Team Name') }}</h2>
                    <p class="text-sm text-slate-500">{{ __('Update your team\'s name.') }}</p>
                </div>
            </div>
            <div class="p-6 bg-slate-50/50">
                @if ($this->permissions->canUpdateTeam)
                    <form wire:submit="updateTeam" class="max-w-md space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('Team name') }}</label>
                            <input wire:model="teamName" type="text" required class="w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm text-slate-900 bg-white" />
                        </div>
                        <button type="submit" class="inline-flex justify-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition-all">
                            {{ __('Save Changes') }}
                        </button>
                    </form>
                @else
                    <div class="text-lg font-medium text-slate-900">{{ $teamData['name'] }}</div>
                @endif
            </div>
        </section>

        <!-- Subscription Section -->
        <section class="relative overflow-hidden rounded-2xl border border-indigo-100 bg-gradient-to-br from-indigo-50 to-white shadow-sm">
            <div class="absolute -right-20 -top-20 h-64 w-64 rounded-full bg-indigo-600/5 blur-3xl"></div>
            <div class="relative z-10 p-6 md:p-8">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                    <div>
                        <h2 class="text-xl font-bold text-indigo-950">{{ __('Team Subscription') }}</h2>
                        <p class="text-indigo-900/70 mt-1">{{ __('Manage your corporate billing and seat capacity.') }}</p>
                    </div>
                    @if ($teamData['has_active_plan'])
                        <span class="inline-flex items-center gap-2 rounded-full bg-emerald-100 px-4 py-1.5 text-sm font-semibold text-emerald-800 shadow-sm ring-1 ring-inset ring-emerald-600/20">
                            <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                            {{ $teamData['plan_name'] }}
                        </span>
                    @else
                        <span class="inline-flex items-center rounded-full bg-slate-100 px-4 py-1.5 text-sm font-semibold text-slate-800 shadow-sm ring-1 ring-inset ring-slate-500/20">
                            Free Tier
                        </span>
                    @endif
                </div>

                @if ($teamData['has_active_plan'] && $teamData['max_seats'])
                    <div class="bg-white/60 backdrop-blur-sm rounded-xl p-6 ring-1 ring-indigo-900/5">
                        <div class="flex items-center justify-between text-sm mb-3">
                            <span class="font-semibold text-slate-700">
                                Seats Used <span class="text-slate-500 font-normal ml-1">({{ max(0, $teamData['max_seats'] - $teamData['seats_used']) }} remaining)</span>
                            </span>
                            <span class="font-bold text-indigo-950 text-base">{{ $teamData['seats_used'] }} <span class="text-slate-400 font-normal">/ {{ $teamData['max_seats'] }}</span></span>
                        </div>
                        <div class="w-full bg-slate-200/80 rounded-full h-3 overflow-hidden shadow-inner">
                            @php
                                $usagePercent = min(100, ($teamData['seats_used'] / $teamData['max_seats']) * 100);
                                $barColor = $usagePercent >= 100 ? 'bg-rose-500' : ($usagePercent >= 80 ? 'bg-amber-500' : 'bg-indigo-600');
                            @endphp
                            <div class="{{ $barColor }} h-full rounded-full transition-all duration-700 ease-out" style="width: {{ $usagePercent }}%"></div>
                        </div>
                        @if ($teamData['seats_used'] >= $teamData['max_seats'])
                            <p class="text-sm text-rose-600 mt-3 font-medium flex items-center gap-1.5"><span class="material-symbols-outlined text-[16px]">error</span> You have reached your seat limit. Upgrade your plan to invite more members.</p>
                        @elseif ($usagePercent >= 80)
                            <p class="text-sm text-amber-600 mt-3 font-medium flex items-center gap-1.5"><span class="material-symbols-outlined text-[16px]">warning</span> You are nearing your seat limit.</p>
                        @endif
                    </div>
                @endif
            </div>
        </section>

        <!-- Team Members Section -->
        <section class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-slate-900">{{ __('Team members') }}</h2>
                    <p class="text-sm text-slate-500">{{ __('Manage who belongs to this team.') }}</p>
                </div>
                @if ($this->permissions->canCreateInvitation)
                    @php
                        $isFull = $teamData['max_seats'] && $teamData['seats_used'] >= $teamData['max_seats'];
                    @endphp
                    @if ($isFull)
                        <button disabled class="inline-flex items-center gap-2 rounded-lg bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-400 cursor-not-allowed">
                            <span class="material-symbols-outlined text-[18px]">person_add</span>
                            {{ __('Invite member') }}
                        </button>
                    @else
                        <flux:modal.trigger name="invite-member">
                            <button type="button" class="inline-flex items-center gap-2 rounded-lg bg-indigo-50 px-4 py-2 text-sm font-semibold text-indigo-700 hover:bg-indigo-100 transition-colors">
                                <span class="material-symbols-outlined text-[18px]">person_add</span>
                                {{ __('Invite member') }}
                            </button>
                        </flux:modal.trigger>
                    @endif
                @endif
            </div>
            
            <div class="divide-y divide-slate-100">
                @foreach ($members as $member)
                    <div class="flex items-center justify-between px-6 py-4 hover:bg-slate-50/50 transition-colors">
                        <div class="flex items-center gap-4">
                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-indigo-100 text-indigo-700 font-bold">
                                {{ $member['initials'] }}
                            </div>
                            <div>
                                <div class="font-medium text-slate-900">{{ $member['name'] }}</div>
                                <div class="text-sm text-slate-500">{{ $member['email'] }}</div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            @if ($member['role'] !== 'owner' && $this->permissions->canUpdateMember)
                                <flux:dropdown position="bottom" align="end">
                                    <button type="button" class="inline-flex items-center gap-1 rounded-md px-3 py-1.5 text-sm font-medium text-slate-700 hover:bg-slate-100">
                                        {{ $member['role_label'] }}
                                        <span class="material-symbols-outlined text-[16px]">expand_more</span>
                                    </button>
                                    <flux:menu>
                                        @foreach ($availableRoles as $role)
                                            <flux:menu.item wire:click="updateMember({{ $member['id'] }}, '{{ $role['value'] }}')">
                                                {{ $role['label'] }}
                                            </flux:menu.item>
                                        @endforeach
                                    </flux:menu>
                                </flux:dropdown>
                            @else
                                <span class="inline-flex items-center rounded-md bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-600">
                                    {{ $member['role_label'] }}
                                </span>
                            @endif

                            @if ($member['role'] !== 'owner' && $this->permissions->canRemoveMember)
                                <flux:modal.trigger name="remove-member-{{ $member['id'] }}">
                                    <button type="button" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-md transition-colors" title="Remove member">
                                        <span class="material-symbols-outlined text-[18px]">close</span>
                                    </button>
                                </flux:modal.trigger>
                            @endif
                        </div>
                    </div>
                    
                    @if ($member['role'] !== 'owner' && $this->permissions->canRemoveMember)
                        <livewire:pages::teams.remove-member-modal :team="$teamModel" :member-id="$member['id']" :member-name="$member['name']" :modal-name="'remove-member-'.$member['id']" :key="'remove-member-modal-'.$member['id']" />
                    @endif
                @endforeach
            </div>
        </section>

        <!-- Pending Invitations -->
        @if (count($invitations) > 0)
            <section class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-100">
                    <h2 class="text-lg font-semibold text-slate-900">{{ __('Pending invitations') }}</h2>
                    <p class="text-sm text-slate-500">{{ __('Invitations that have not been accepted yet.') }}</p>
                </div>
                
                <div class="divide-y divide-slate-100">
                    @foreach ($invitations as $invitation)
                        <div class="flex items-center justify-between px-6 py-4 hover:bg-slate-50/50 transition-colors">
                            <div class="flex items-center gap-4">
                                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-slate-100 text-slate-500">
                                    <span class="material-symbols-outlined text-[18px]">mail</span>
                                </div>
                                <div>
                                    <div class="font-medium text-slate-900">{{ $invitation['email'] }}</div>
                                    <div class="flex items-center gap-2 mt-0.5 text-sm text-slate-500">
                                        <span>Sent {{ $invitation['sent_at'] ?? \Carbon\Carbon::parse($invitation['created_at'])->format('M d, Y') }}</span>
                                        @if ($invitation['is_expired'] ?? false)
                                            <span class="inline-flex items-center rounded-md bg-rose-50 px-2 py-0.5 text-xs font-bold text-rose-700 ring-1 ring-inset ring-rose-600/20 uppercase tracking-wide">Expired</span>
                                        @elseif ($invitation['expires_at'] ?? false)
                                            <span class="text-slate-400">&bull; Exp: {{ $invitation['expires_at'] }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <span class="inline-flex items-center rounded-md bg-amber-50 px-2.5 py-1 text-xs font-medium text-amber-700 ring-1 ring-inset ring-amber-600/20">
                                    {{ __('Pending') }}
                                </span>
                                
                                @if ($this->permissions->canCreateInvitation)
                                    <button wire:click="resendInvitation('{{ $invitation['code'] }}')" type="button" class="p-1.5 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-md transition-colors" title="Resend invitation">
                                        <span class="material-symbols-outlined text-[18px]">sync</span>
                                    </button>
                                @endif

                                @if ($this->permissions->canCancelInvitation)
                                    <flux:modal.trigger name="cancel-invitation-{{ $invitation['code'] }}">
                                        <button type="button" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-md transition-colors" title="Cancel invitation">
                                            <span class="material-symbols-outlined text-[18px]">close</span>
                                        </button>
                                    </flux:modal.trigger>
                                @endif
                            </div>
                        </div>

                        @if ($this->permissions->canCancelInvitation)
                            <livewire:pages::teams.cancel-invitation-modal :team="$teamModel" :invitation-code="$invitation['code']" :invitation-email="$invitation['email']" :modal-name="'cancel-invitation-'.$invitation['code']" :key="'cancel-invitation-modal-'.$invitation['code']" />
                        @endif
                    @endforeach
                </div>
            </section>
        @endif

        <!-- Delete Team -->
        @if ($this->permissions->canDeleteTeam && ! $teamData['is_personal'])
            <section class="bg-rose-50/50 rounded-2xl shadow-sm border border-rose-200 overflow-hidden mt-6">
                <div class="px-6 py-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-lg font-semibold text-rose-900">{{ __('Delete team') }}</h2>
                        <p class="text-sm text-rose-700 mt-1">{{ __('Permanently delete your team. This action cannot be undone.') }}</p>
                    </div>
                    
                    <flux:modal.trigger name="delete-team">
                        <button type="button" class="inline-flex justify-center rounded-lg bg-rose-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-rose-500 transition-colors">
                            {{ __('Delete team') }}
                        </button>
                    </flux:modal.trigger>
                </div>
            </section>
            
            <livewire:pages::teams.delete-team-modal :team="$teamModel" />
        @endif
    </div>
</x-pages::settings.layout>