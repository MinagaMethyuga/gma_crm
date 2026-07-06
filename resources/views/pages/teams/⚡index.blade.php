<?php

use Flux\Flux;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\TeamInvitation;

new #[Title('My Teams')] #[Layout('layouts.member-base', ['active' => 'manage-team'])] class extends Component {
    public string $email = '';
    public bool $showInviteModal = false;
    public ?string $inviteLink = null;

    public function mount()
    {
        $user = Auth::user();
        if (!$user->current_team_id) {
            app(\App\Actions\Teams\CreateTeam::class)->handle($user, $user->name . "'s Team", true);
        }
    }

    public function with(): array
    {
        $user = Auth::user();
        $team = $user->currentTeam;
        
        $members = $team ? $team->members : collect();
        $invitations = $team ? $team->invitations : collect();
        
        $owner = $user;
        if ($team) {
            $teamOwner = $team->owner();
            if ($teamOwner) {
                $owner = $teamOwner;
            }
        }
        
        $limit = $owner->plan ? $owner->plan->team_limit : 1;
        $totalUsed = $members->count() + $invitations->count();

        return [
            'user' => $user,
            'team' => $team,
            'members' => $members,
            'invitations' => $invitations,
            'limit' => $limit,
            'totalUsed' => $totalUsed,
            'canInvite' => $totalUsed < $limit,
            'effectivePlan' => $owner->plan,
            'effectivePlanSubscribedAt' => $owner->plan_subscribed_at,
        ];
    }

    public function addMember()
    {
        $this->validate([
            'email' => 'required|email|max:255',
        ]);

        $user = Auth::user();

        $team = $user->currentTeam;

        if (!$team) {
            $this->addError('email', 'You do not have an active team.');
            return;
        }

        if (!$user->canInviteMoreMembers()) {
            $this->addError('email', 'You have reached your team membership limit.');
            return;
        }

        // Check if already member
        if ($team->members()->where('email', $this->email)->exists() || $user->email === $this->email) {
            $this->addError('email', 'This user is already a member of your team.');
            return;
        }

        // Check if already invited
        if ($team->invitations()->where('email', $this->email)->exists()) {
            $this->addError('email', 'This user has already been invited.');
            return;
        }

        $invitation = $team->invitations()->create([
            'email' => $this->email,
            'role' => 'member',
            'invited_by' => $user->id,
            'code' => \Illuminate\Support\Str::random(40),
        ]);

        $this->inviteLink = \Illuminate\Support\Facades\URL::signedRoute('invitations.accept', $invitation);
        $this->reset('email');
        $this->showInviteModal = false;
        Flux::toast(variant: 'success', text: 'Invite link generated!');
    }

    public function removeMember($userId)
    {
        $user = Auth::user();
        $team = $user->currentTeam;
        
        if ($team && $user->id !== $userId) { // Owner cannot remove themselves here
            $team->members()->detach($userId);
            Flux::toast(variant: 'success', text: 'Member removed.');
        }
    }

    public function cancelInvite()
    {
        $this->reset('email', 'showInviteModal');
    }

    public function dismissLink()
    {
        $this->inviteLink = null;
    }

    public function getInviteLink($invitationId)
    {
        $invitation = TeamInvitation::where('id', $invitationId)
            ->where('team_id', Auth::user()->current_team_id)
            ->first();

        if ($invitation && $invitation->isPending()) {
            $this->inviteLink = \Illuminate\Support\Facades\URL::signedRoute('invitations.accept', $invitation);
        }
    }

    public function revokeInvitation($invitationId)
    {
        $invitation = TeamInvitation::where('id', $invitationId)
            ->where('team_id', Auth::user()->current_team_id)
            ->first();
            
        if ($invitation) {
            $invitation->delete();
            Flux::toast(variant: 'success', text: 'Invitation revoked.');
        }
    }
}; ?>

<div class="max-w-7xl 2xl:max-w-[1600px] mx-auto flex flex-col lg:flex-row gap-6">
    
    <!-- Main Column -->
    <div class="flex-1 bg-white border border-slate-200 rounded-3xl shadow-sm p-6">
        
        <!-- Header area resembling the order top bar -->
        <div class="flex items-center justify-between mb-8 pb-4 border-b border-slate-100">
            <div class="flex items-center gap-4">
                <a href="{{ route('member.dashboard') }}" class="w-8 h-8 rounded-full flex items-center justify-center text-slate-400 hover:text-slate-900 hover:bg-slate-50 transition-colors emil-btn">
                    <span class="material-symbols-outlined text-xl">arrow_back</span>
                </a>
                <div class="text-lg font-bold text-slate-900 tracking-tight flex items-center gap-3 m-0 p-0 leading-none">
                    My Teams
                </div>
            </div>
            <div class="px-3 py-1 bg-indigo-50 text-indigo-700 rounded-full text-xs font-bold tracking-wide">
                Active
            </div>
        </div>

        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-base font-bold text-slate-900 m-0 p-0 leading-none mb-1">Member List</h3>
                <p class="text-sm text-slate-500 m-0 p-0 leading-none">Limit: {{ $totalUsed }} / {{ $limit }}</p>
            </div>
            <div class="flex items-center gap-3">
                @if($canInvite)
                <button wire:click="$set('showInviteModal', true)" class="px-4 py-2 text-teal-600 bg-white border border-teal-600 rounded-lg text-sm font-bold flex items-center gap-2 hover:bg-teal-50 transition-colors emil-btn">
                    <span class="material-symbols-outlined text-lg">add</span> Add Member
                </button>
                @else
                <button disabled class="px-4 py-2 text-slate-400 bg-slate-100 border border-slate-200 rounded-lg text-sm font-bold flex items-center gap-2 cursor-not-allowed">
                    <span class="material-symbols-outlined text-lg">add</span> Limit Reached
                </button>
                @endif
            </div>
        </div>

        @if($showInviteModal)
        <div class="mb-6 p-5 bg-slate-50 border border-slate-200 rounded-2xl">
            <h4 class="text-sm font-bold text-slate-900 mb-3">Invite a new member</h4>
            <div class="flex flex-col gap-4">
                <div>
                    <input type="email" wire:model="email" placeholder="Email address" class="w-full h-10 px-4 rounded-lg border border-slate-300 focus:ring-teal-500 focus:border-teal-500 text-sm m-0">
                    @error('email') <p class="text-rose-500 text-xs mt-1 m-0">{{ $message }}</p> @enderror
                </div>
                <div class="flex gap-3">
                    <button wire:click="addMember" class="h-10 px-5 rounded-lg text-sm font-bold transition-colors shadow-sm emil-btn" style="background-color: #00a896; color: white;">
                        Generate Invite Link
                    </button>
                    <button wire:click="cancelInvite" class="h-10 px-4 text-slate-500 hover:bg-slate-200 rounded-lg text-sm font-bold transition-colors">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
        @endif

        <!-- List items mimicking the "Ring Holding" etc. -->
        <div class="space-y-4">
            
            <!-- Owner -->
            <div class="flex items-center justify-between p-4 rounded-2xl bg-white border border-slate-100 hover:border-slate-200 hover:shadow-sm transition-all">
                <div class="flex items-center gap-5">
                    <div class="w-12 h-12 rounded-xl bg-indigo-50 border border-indigo-100 flex items-center justify-center shadow-sm shrink-0">
                        @if($user->avatarUrl())
                            <img src="{{ $user->avatarUrl() }}" alt="User" class="w-full h-full rounded-xl object-cover">
                        @else
                            <span class="text-indigo-700 font-bold">{{ substr($user->name, 0, 2) }}</span>
                        @endif
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-slate-900 m-0 p-0 leading-tight mb-1">{{ $user->name }} (You)</h4>
                        <p class="text-xs text-slate-500 m-0 p-0 leading-tight">{{ $user->email }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-6">
                    <span class="px-3 py-1 bg-slate-100 text-slate-700 rounded-full text-xs font-bold">Owner</span>
                </div>
            </div>

            <!-- Members -->
            @foreach($members->where('id', '!=', $user->id) as $member)
            <div class="flex items-center justify-between p-4 rounded-2xl bg-slate-50 border border-slate-100 hover:border-slate-200 hover:shadow-sm transition-all">
                <div class="flex items-center gap-5">
                    <div class="w-12 h-12 rounded-xl bg-white border border-slate-200 flex items-center justify-center shadow-sm shrink-0">
                        @if($member->avatarUrl())
                            <img src="{{ $member->avatarUrl() }}" alt="User" class="w-full h-full rounded-xl object-cover">
                        @else
                            <span class="text-slate-500 font-bold">{{ substr($member->name, 0, 2) }}</span>
                        @endif
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-slate-900 m-0 p-0 leading-tight mb-1">{{ $member->name }}</h4>
                        <p class="text-xs text-slate-500 m-0 p-0 leading-tight">{{ $member->email }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-6">
                    <span class="px-3 py-1 bg-cyan-50 text-cyan-700 rounded-full text-xs font-bold">Member</span>
                    <div class="flex items-center gap-2">
                        <button wire:click="removeMember({{ $member->id }})" wire:confirm="Are you sure you want to remove this member?" class="w-8 h-8 rounded-full text-rose-400 hover:text-rose-600 hover:bg-rose-50 flex items-center justify-center transition-colors">
                            <span class="material-symbols-outlined text-lg">delete_outline</span>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach

            <!-- Invitations -->
            @foreach($invitations as $invitation)
            <div class="flex items-center justify-between p-4 rounded-2xl bg-orange-50/50 border border-orange-100 hover:border-orange-200 hover:shadow-sm transition-all">
                <div class="flex items-center gap-5">
                    <div class="w-12 h-12 rounded-xl bg-white border border-orange-200 flex items-center justify-center shadow-sm shrink-0 text-orange-400">
                        <span class="material-symbols-outlined text-xl">mail</span>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-slate-900 m-0 p-0 leading-tight mb-1">Pending Invitation</h4>
                        <p class="text-xs text-slate-500 m-0 p-0 leading-tight">{{ $invitation->email }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-6">
                    <span class="text-xs text-orange-500 font-semibold italic">Invited {{ $invitation->created_at->diffForHumans() }}</span>
                    <div class="flex items-center gap-2">
                        <button wire:click="getInviteLink({{ $invitation->id }})" class="w-8 h-8 rounded-full text-teal-500 hover:text-teal-700 hover:bg-teal-50 flex items-center justify-center transition-colors" title="Get Invite Link">
                            <span class="material-symbols-outlined text-lg">link</span>
                        </button>
                        <button wire:click="revokeInvitation({{ $invitation->id }})" wire:confirm="Revoke this invitation?" class="w-8 h-8 rounded-full text-rose-400 hover:text-rose-600 hover:bg-rose-50 flex items-center justify-center transition-colors" title="Revoke Invitation">
                            <span class="material-symbols-outlined text-lg">close</span>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach

        </div>

        <!-- Invite Link Display -->
        @if($inviteLink)
        <div class="mt-6 p-5 bg-teal-50 border border-teal-200 rounded-2xl">
            <h4 class="text-sm font-bold text-teal-900 mb-2 flex items-center gap-2">
                <span class="material-symbols-outlined text-lg">link</span>
                Invite Link Generated
            </h4>
            <p class="text-xs text-teal-700 mb-3">Share this link with the invitee. They'll be taken to register with their email prefilled and will join your team automatically.</p>
            <div class="flex gap-2">
                <input type="text" readonly value="{{ $inviteLink }}" id="invite-link-input" class="flex-1 h-10 px-3 rounded-lg border border-teal-300 bg-white text-sm text-slate-700 select-all" onclick="this.select()">
                <button onclick="copyInviteLink()" class="h-10 px-4 rounded-lg text-sm font-bold bg-teal-600 hover:bg-teal-700 text-white shadow-sm emil-btn shrink-0">
                    Copy
                </button>
            </div>
            <button wire:click="dismissLink" class="mt-2 text-xs text-teal-600 hover:underline font-medium">Dismiss</button>
        </div>
        <script>
            function copyInviteLink() {
                const input = document.getElementById('invite-link-input');
                input.select();
                navigator.clipboard.writeText(input.value).then(() => {
                    const btn = input.nextElementSibling;
                    btn.textContent = 'Copied!';
                    setTimeout(() => { btn.textContent = 'Copy'; }, 2000);
                });
            }
        </script>
        @endif

        <!-- Footer / total mimicking the screenshot bottom section -->
        <div class="mt-8 pt-6 border-t border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-xl font-bold text-slate-900 m-0 p-0 leading-none mb-1">{{ $totalUsed }}</h3>
                <p class="text-sm text-slate-500 m-0 p-0 leading-none">Total Users</p>
            </div>
        </div>

    </div>

    <!-- Right Side Column -->
    <div class="w-full lg:w-80 flex flex-col gap-6 shrink-0 max-w-full min-w-0">
        
        <!-- User card -->
        <div class="bg-white border border-slate-200 rounded-3xl shadow-sm p-5 min-w-0">
            <div class="flex items-center gap-4 mb-5 min-w-0">
                <div class="w-12 h-12 rounded-full bg-cyan-50 flex items-center justify-center text-cyan-600 font-bold shrink-0 border border-cyan-100">
                    @if($user->avatarUrl())
                        <img src="{{ $user->avatarUrl() }}" alt="User" class="w-full h-full rounded-full object-cover">
                    @else
                        {{ substr($user->name, 0, 2) }}
                    @endif
                </div>
                <div class="min-w-0 flex-1">
                    <h3 class="text-sm font-bold text-slate-900 m-0 p-0 leading-tight mb-1 truncate" title="{{ $user->name }}">{{ $user->name }}</h3>
                    <p class="text-xs text-slate-500 m-0 p-0 leading-tight truncate" title="{{ $user->id }}">{{ $user->id }}</p>
                </div>
            </div>
            <div class="min-w-0">
                <p class="text-xs text-slate-400 uppercase tracking-wider font-semibold mb-1 m-0 p-0 leading-tight">Email</p>
                <p class="text-sm text-slate-900 font-medium m-0 p-0 leading-tight truncate" title="{{ $user->email }}">{{ $user->email }}</p>
            </div>
        </div>

        <!-- Details card 1 -->
        <div class="bg-white border border-slate-200 rounded-3xl shadow-sm p-5 min-w-0">
            <h3 class="text-sm font-bold text-slate-900 mb-4 m-0 p-0 leading-none">Membership Details</h3>
            
            <div class="space-y-3 mt-4">
                <div class="flex justify-between gap-2 min-w-0">
                    <span class="text-sm text-slate-500 shrink-0">Plan</span>
                    <span class="text-sm font-bold text-slate-900 truncate min-w-0 text-right" title="{{ $effectivePlan ? $effectivePlan->name : 'None' }}">{{ $effectivePlan ? $effectivePlan->name : 'None' }}</span>
                </div>
                <div class="flex justify-between gap-2 min-w-0">
                    <span class="text-sm text-slate-500 shrink-0">Start date</span>
                    <span class="text-sm font-bold text-slate-900 truncate min-w-0 text-right">{{ $effectivePlanSubscribedAt ? $effectivePlanSubscribedAt->format('M Y') : 'N/A' }}</span>
                </div>
                <div class="flex justify-between gap-2 min-w-0">
                    <span class="text-sm text-slate-500 shrink-0">Member Limit</span>
                    <span class="text-sm font-bold text-slate-900 truncate min-w-0 text-right">{{ $limit }} Users</span>
                </div>
            </div>
        </div>

        <!-- Details card 2 -->
        <div class="bg-white border border-slate-200 rounded-3xl shadow-sm p-5 min-w-0">
            <h3 class="text-sm font-bold text-slate-900 mb-4 m-0 p-0 leading-none">Organization</h3>
            
            <div class="grid grid-cols-[80px_1fr] gap-x-2 gap-y-3 mt-4 min-w-0 w-full">
                <span class="text-sm text-slate-500 shrink-0">Company</span>
                <span class="text-sm text-slate-900 truncate min-w-0 overflow-hidden" title="{{ $user->company_name ?? 'N/A' }}">{{ $user->company_name ?? 'N/A' }}</span>
                
                <span class="text-sm text-slate-500 shrink-0">Industry</span>
                <span class="text-sm text-slate-900 truncate min-w-0 overflow-hidden" title="{{ $user->industry ?? 'N/A' }}">{{ $user->industry ?? 'N/A' }}</span>
                
                <span class="text-sm text-slate-500 shrink-0">Joined</span>
                <span class="text-sm text-slate-900 truncate min-w-0 overflow-hidden">{{ $user->created_at->format('j M Y') }}</span>
                
                <span class="text-sm text-slate-500 shrink-0">Country</span>
                <span class="text-sm text-slate-900 truncate min-w-0 overflow-hidden" title="{{ $user->country ?? 'N/A' }}">{{ $user->country ?? 'N/A' }}</span>
            </div>
        </div>

    </div>

</div>
