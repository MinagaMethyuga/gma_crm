<div class="flex flex-col md:flex-row w-full h-full">
    <!-- Left Sidebar -->
    <div class="w-full md:w-[240px] bg-[#fbfcfd] border-b md:border-b-0 md:border-r border-slate-100 p-4 md:p-6 flex flex-row md:flex-col gap-2 shrink-0 overflow-x-auto md:overflow-y-auto">
        <button type="button" wire:click="switchTab('profile')" id="tab-btn-profile" class="flex items-center gap-2 md:gap-3 px-3 py-2 md:px-4 md:py-3 {{ $activeTab === 'profile' ? 'bg-slate-100/80 text-slate-900 font-semibold' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50 font-medium' }} rounded-xl transition-colors text-left shrink-0 md:w-full">
            <span class="material-symbols-outlined text-[18px] md:text-[20px]">person</span>
            <span class="text-[13px] md:text-[14px]">Profile</span>
        </button>
        
        <button type="button" wire:click="switchTab('security')" id="tab-btn-security" class="flex items-center gap-2 md:gap-3 px-3 py-2 md:px-4 md:py-3 {{ $activeTab === 'security' ? 'bg-slate-100/80 text-slate-900 font-semibold' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50 font-medium' }} rounded-xl transition-colors text-left shrink-0 md:w-full">
            <span class="material-symbols-outlined text-[18px] md:text-[20px]">fingerprint</span>
            <span class="text-[13px] md:text-[14px]">Security</span>
        </button>
        
        @if($user && !$user->isAdmin())
        <button type="button" wire:click="switchTab('notifications')" id="tab-btn-notifications" class="flex items-center gap-2 md:gap-3 px-3 py-2 md:px-4 md:py-3 {{ $activeTab === 'notifications' ? 'bg-slate-100/80 text-slate-900 font-semibold' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50 font-medium' }} rounded-xl transition-colors text-left shrink-0 md:w-full">
            <span class="material-symbols-outlined text-[18px] md:text-[20px]">bolt</span>
            <span class="text-[13px] md:text-[14px]">Notifications</span>
        </button>
        
        <button type="button" wire:click="switchTab('subscription')" id="tab-btn-subscription" class="flex items-center gap-2 md:gap-3 px-3 py-2 md:px-4 md:py-3 {{ $activeTab === 'subscription' ? 'bg-slate-100/80 text-slate-900 font-semibold' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50 font-medium' }} rounded-xl transition-colors text-left shrink-0 md:w-full">
            <span class="material-symbols-outlined text-[18px] md:text-[20px]">account_balance_wallet</span>
            <span class="text-[13px] md:text-[14px]">Subscription</span>
        </button>
        @endif
    </div>

    <!-- Right Content Area -->
    <div class="flex-1 bg-white p-5 md:p-10 overflow-y-auto">
        
        <!-- Profile Tab -->
        @if($activeTab === 'profile')
        <div id="tab-content-profile" class="settings-tab-content block">
            <h2 class="text-[22px] font-medium text-slate-900 mb-6">Profile Settings</h2>
            <div class="text-slate-500 text-sm mb-6">Update your personal information and public profile.</div>
            
            @if($profileSuccess)
            <div class="p-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg mb-6 text-sm flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">check_circle</span>
                <span>{{ $profileSuccess }}</span>
            </div>
            @endif

            <div class="flex justify-between items-center py-4 border-b border-slate-100">
                <span class="text-[14px] font-medium text-slate-700">Username</span>
                @if(!$editingName)
                <div class="flex items-center gap-2 text-slate-900 font-medium text-[14px]">
                    {{ $user->name ?? 'Guest User' }} 
                    <span wire:click="$set('editingName', true)" class="material-symbols-outlined text-[16px] text-slate-400 cursor-pointer hover:text-slate-600" title="Edit Name">edit</span>
                </div>
                @else
                <div class="flex items-center gap-2">
                    <input type="text" wire:model="name" wire:keydown.enter="saveName" class="px-2.5 py-1 text-[14px] font-medium border border-slate-300 rounded-lg text-slate-900 focus:outline-none focus:border-slate-500 w-[180px]" autoFocus>
                    <button type="button" wire:click="saveName" class="text-emerald-600 hover:text-emerald-700 flex items-center" title="Save"><span class="material-symbols-outlined text-[18px]">check_circle</span></button>
                    <button type="button" wire:click="$set('editingName', false)" class="text-slate-400 hover:text-slate-600 flex items-center" title="Cancel"><span class="material-symbols-outlined text-[18px]">cancel</span></button>
                </div>
                @endif
            </div>
            
            <div class="flex justify-between items-center py-4 border-b border-slate-100">
                <span class="text-[14px] font-medium text-slate-700">Email</span>
                @if(!$editingEmail)
                <div class="flex items-center gap-2 text-slate-400 font-medium text-[14px]">
                    {{ $user->email ?? 'guest@example.com' }}
                    <span wire:click="$set('editingEmail', true)" class="material-symbols-outlined text-[16px] text-slate-400 cursor-pointer hover:text-slate-600" title="Edit Email">edit</span>
                </div>
                @else
                <div class="flex items-center gap-2">
                    <input type="email" wire:model="email" wire:keydown.enter="saveEmail" class="px-2.5 py-1 text-[14px] font-medium border border-slate-300 rounded-lg text-slate-900 focus:outline-none focus:border-slate-500 w-[220px]" autoFocus>
                    <button type="button" wire:click="saveEmail" class="text-emerald-600 hover:text-emerald-700 flex items-center" title="Save"><span class="material-symbols-outlined text-[18px]">check_circle</span></button>
                    <button type="button" wire:click="$set('editingEmail', false)" class="text-slate-400 hover:text-slate-600 flex items-center" title="Cancel"><span class="material-symbols-outlined text-[18px]">cancel</span></button>
                </div>
                @endif
            </div>

            <div class="mt-8 flex items-center gap-6">
                <div class="w-20 h-20 rounded-full bg-slate-200 overflow-hidden shrink-0">
                    @if($newAvatar)
                        <img src="{{ $newAvatar->temporaryUrl() }}" alt="Avatar" class="w-full h-full object-cover">
                    @else
                        <img src="{{ $user ? $user->avatarUrl() : 'https://ui-avatars.com/api/?name=Guest+User&background=103C68&color=fff' }}" alt="Avatar" class="w-full h-full object-cover">
                    @endif
                </div>
                <div>
                    <label for="avatar-input" class="bg-white border border-slate-200 shadow-sm text-slate-700 font-medium text-sm px-4 py-2 rounded-lg hover:bg-slate-50 transition-colors cursor-pointer inline-block">Change Avatar</label>
                    <input type="file" wire:model="newAvatar" id="avatar-input" class="hidden" accept="image/jpeg,image/png,image/gif">
                    <p class="text-xs text-slate-400 mt-2">JPG, GIF or PNG. Max size of 800K</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Security Tab -->
        @if($activeTab === 'security')
        <div id="tab-content-security" class="settings-tab-content block">
            <h2 class="text-[22px] font-medium text-slate-900 mb-6">Security</h2>
            <div class="text-slate-500 text-sm mb-6">Manage your password and security preferences.</div>
            
            @if($securitySuccess)
            <div class="p-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg mb-6 text-sm flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">check_circle</span>
                <span>{{ $securitySuccess }}</span>
            </div>
            @endif

            <div class="flex justify-between items-center py-4 border-b border-slate-100">
                <div>
                    <div class="text-[14px] font-medium text-slate-700 mb-1">Two-factor Authentication</div>
                    <div class="text-[12px] text-slate-400">Add an extra layer of security to your account.</div>
                </div>
                <a href="{{ route('security.edit') }}" class="bg-white border border-slate-200 shadow-sm text-slate-700 font-medium text-sm px-4 py-2 rounded-lg hover:bg-slate-50 transition-colors inline-block">Enable 2FA</a>
            </div>

            <div class="flex justify-between items-center py-4 border-b border-slate-100">
                <div>
                    <div class="text-[14px] font-medium text-slate-700 mb-1">Password</div>
                    <div class="text-[12px] text-slate-400">Update your account password to stay secure.</div>
                </div>
                @if(!$editingPassword)
                <button type="button" wire:click="$set('editingPassword', true)" class="bg-white border border-slate-200 shadow-sm text-slate-700 font-medium text-sm px-4 py-2 rounded-lg hover:bg-slate-50 transition-colors">Change Password</button>
                @endif
            </div>

            @if($editingPassword)
            <div class="py-4 border-b border-slate-100 space-y-3 bg-slate-50/50 p-4 rounded-xl mt-2">
                <div>
                    <input type="password" wire:model="current_password" placeholder="Current Password" class="w-full px-3 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:border-slate-500 bg-white">
                    @error('current_password') <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <input type="password" wire:model="new_password" placeholder="New Password" class="w-full px-3 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:border-slate-500 bg-white">
                    <input type="password" wire:model="new_password_confirmation" placeholder="Confirm Password" class="w-full px-3 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:border-slate-500 bg-white">
                </div>
                @error('new_password') <span class="text-xs text-rose-600 block">{{ $message }}</span> @enderror
                <div class="flex justify-end gap-2 pt-1">
                    <button type="button" wire:click="$set('editingPassword', false)" class="text-slate-500 text-xs font-medium px-3 py-1.5 hover:text-slate-700">Cancel</button>
                    <button type="button" wire:click="updatePassword" class="bg-slate-900 text-white font-medium text-xs px-4 py-1.5 rounded-lg hover:bg-slate-800 transition-colors">Save Password</button>
                </div>
            </div>
            @endif
        </div>
        @endif

        @if($user && !$user->isAdmin())
        <!-- Notifications Tab -->
        @if($activeTab === 'notifications')
        <div id="tab-content-notifications" class="settings-tab-content block">
            <h2 class="text-[22px] font-medium text-slate-900 mb-6">Notifications</h2>
            <div class="text-slate-500 text-sm mb-6">Control how and when you receive updates.</div>

            <div class="flex justify-between items-center py-4 border-b border-slate-100">
                <div>
                    <div class="text-[14px] font-medium text-slate-700 mb-1">Email Alerts</div>
                    <div class="text-[12px] text-slate-400">Receive notifications about account activity and security.</div>
                </div>
                <button type="button" wire:click="toggleNotification('email')" class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none {{ $notify_email ? 'bg-slate-900' : 'bg-slate-200' }}">
                    <span class="inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $notify_email ? 'translate-x-5' : 'translate-x-0' }}"></span>
                </button>
            </div>
            <div class="flex justify-between items-center py-4 border-b border-slate-100">
                <div>
                    <div class="text-[14px] font-medium text-slate-700 mb-1">Event Reminders</div>
                    <div class="text-[12px] text-slate-400">Get notified about upcoming GMA summits and meetings.</div>
                </div>
                <button type="button" wire:click="toggleNotification('events')" class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none {{ $notify_events ? 'bg-slate-900' : 'bg-slate-200' }}">
                    <span class="inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $notify_events ? 'translate-x-5' : 'translate-x-0' }}"></span>
                </button>
            </div>
            <div class="flex justify-between items-center py-4 border-b border-slate-100">
                <div>
                    <div class="text-[14px] font-medium text-slate-700 mb-1">Research & Reports</div>
                    <div class="text-[12px] text-slate-400">Be notified when quarterly industry whitepapers are published.</div>
                </div>
                <button type="button" wire:click="toggleNotification('research')" class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none {{ $notify_research ? 'bg-slate-900' : 'bg-slate-200' }}">
                    <span class="inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $notify_research ? 'translate-x-5' : 'translate-x-0' }}"></span>
                </button>
            </div>
        </div>
        @endif

        <!-- Subscription Tab -->
        @if($activeTab === 'subscription')
        <div id="tab-content-subscription" class="settings-tab-content block">
            <h2 class="text-[22px] font-medium text-slate-900 mb-6">Subscription</h2>
            <div class="text-slate-500 text-sm mb-6">Manage your billing and subscription plan.</div>

            <div class="flex justify-between items-center py-4 border-b border-slate-100">
                <div>
                    <div class="text-[14px] font-medium text-slate-700 mb-1">Current Membership</div>
                    <div class="text-[12px] text-slate-400">Your active subscription tier with GMA.</div>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-slate-900 font-semibold text-[14px]">{{ auth()->user()->plan->name ?? 'Professional Plan' }}</span>
                    <a href="{{ route('pricing') }}" class="bg-white border border-slate-200 shadow-sm text-slate-700 font-medium text-sm px-4 py-2 rounded-lg hover:bg-slate-50 transition-colors inline-block">Change Plan</a>
                </div>
            </div>
            <div class="flex justify-between items-center py-4 border-b border-slate-100">
                <div>
                    <div class="text-[14px] font-medium text-slate-700 mb-1">Billing Status</div>
                    <div class="text-[12px] text-slate-400">Next renewal and account status.</div>
                </div>
                <span class="text-emerald-600 font-medium text-[14px] flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Active Member
                </span>
            </div>
        </div>
        @endif
        @endif

    </div>
</div>
