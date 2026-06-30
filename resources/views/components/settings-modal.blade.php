<div id="settingsModal" class="fixed inset-0 z-[100] hidden items-center justify-center opacity-0 transition-opacity duration-300">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-slate-900/20 backdrop-blur-sm" onclick="closeSettingsModal()"></div>
    
    <!-- Modal Content -->
    <div class="relative bg-white rounded-[28px] shadow-2xl flex w-full max-w-[850px] h-[550px] overflow-hidden scale-95 transition-transform duration-300" id="settingsModalContent">
        
        <!-- Close Button -->
        <button onclick="closeSettingsModal()" class="absolute top-4 right-4 w-8 h-8 flex items-center justify-center rounded-full hover:bg-slate-100 text-slate-400 hover:text-slate-600 transition-colors z-10">
            <span class="material-symbols-outlined text-[20px]">close</span>
        </button>

        <!-- Left Sidebar -->
        <div class="w-[240px] bg-[#fbfcfd] border-r border-slate-100 p-6 flex flex-col gap-2">
            
            <button onclick="switchSettingsTab('profile')" id="tab-btn-profile" class="flex items-center gap-3 px-4 py-3 bg-slate-100/80 text-slate-900 rounded-xl transition-colors text-left w-full">
                <span class="material-symbols-outlined text-[20px]">person</span>
                <span class="text-[14px] font-semibold">Profile</span>
            </button>
            
            <button onclick="switchSettingsTab('security')" id="tab-btn-security" class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-slate-900 hover:bg-slate-50 rounded-xl transition-colors text-left w-full">
                <span class="material-symbols-outlined text-[20px]">fingerprint</span>
                <span class="text-[14px] font-medium">Security</span>
            </button>
            
            @if(auth()->check() && !auth()->user()->isAdmin())
            <button onclick="switchSettingsTab('notifications')" id="tab-btn-notifications" class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-slate-900 hover:bg-slate-50 rounded-xl transition-colors text-left w-full">
                <span class="material-symbols-outlined text-[20px]">bolt</span>
                <span class="text-[14px] font-medium">Notifications</span>
            </button>
            
            <button onclick="switchSettingsTab('subscription')" id="tab-btn-subscription" class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-slate-900 hover:bg-slate-50 rounded-xl transition-colors text-left w-full">
                <span class="material-symbols-outlined text-[20px]">account_balance_wallet</span>
                <span class="text-[14px] font-medium">Subscription</span>
            </button>
            @endif
        </div>

        <!-- Right Content Area -->
        <div class="flex-1 bg-white p-10 overflow-y-auto">
            
            <!-- Profile Tab -->
            <div id="tab-content-profile" class="settings-tab-content block">
                <h2 class="text-[22px] font-medium text-slate-900 mb-6">Profile Settings</h2>
                <div class="text-slate-500 text-sm mb-6">Update your personal information and public profile.</div>
                
                <div class="flex justify-between items-center py-4 border-b border-slate-100">
                    <span class="text-[14px] font-medium text-slate-700">Username</span>
                    <div class="flex items-center gap-2 text-slate-900 font-medium text-[14px]">
                        sophie 
                        <span class="material-symbols-outlined text-[16px] text-slate-400 cursor-pointer hover:text-slate-600">edit</span>
                    </div>
                </div>
                
                <div class="flex justify-between items-center py-4 border-b border-slate-100">
                    <span class="text-[14px] font-medium text-slate-700">Email</span>
                    <div class="text-slate-400 font-medium text-[14px]">sophie@ui.live</div>
                </div>

                <div class="mt-8 flex items-center gap-6">
                    <div class="w-20 h-20 rounded-full bg-slate-200 overflow-hidden shrink-0">
                        <img src="https://ui-avatars.com/api/?name=Sophie&background=103C68&color=fff" alt="Avatar" class="w-full h-full object-cover">
                    </div>
                    <div>
                        <button class="bg-white border border-slate-200 shadow-sm text-slate-700 font-medium text-sm px-4 py-2 rounded-lg hover:bg-slate-50 transition-colors">Change Avatar</button>
                        <p class="text-xs text-slate-400 mt-2">JPG, GIF or PNG. Max size of 800K</p>
                    </div>
                </div>
            </div>

            <!-- Security Tab -->
            <div id="tab-content-security" class="settings-tab-content hidden">
                <h2 class="text-[22px] font-medium text-slate-900 mb-6">Security</h2>
                <div class="text-slate-500 text-sm mb-6">Manage your password and security preferences.</div>
                
                <div class="flex justify-between items-center py-4 border-b border-slate-100">
                    <div>
                        <div class="text-[14px] font-medium text-slate-700 mb-1">Two-factor Authentication</div>
                        <div class="text-[12px] text-slate-400">Add an extra layer of security to your account.</div>
                    </div>
                    <button class="bg-white border border-slate-200 shadow-sm text-slate-700 font-medium text-sm px-4 py-2 rounded-lg hover:bg-slate-50 transition-colors">Enable 2FA</button>
                </div>
            </div>

            @if(auth()->check() && !auth()->user()->isAdmin())
            <!-- Notifications Tab -->
            <div id="tab-content-notifications" class="settings-tab-content hidden">
                <h2 class="text-[22px] font-medium text-slate-900 mb-6">Notifications</h2>
                <div class="text-slate-500 text-sm">Control how and when you receive updates.</div>
            </div>

            <!-- Subscription Tab -->
            <div id="tab-content-subscription" class="settings-tab-content hidden">
                <h2 class="text-[22px] font-medium text-slate-900 mb-6">Subscription</h2>
                <div class="text-slate-500 text-sm">Manage your billing and subscription plan.</div>
            </div>
            @endif

        </div>
    </div>
</div>

<script>
    function openSettingsModal() {
        const modal = document.getElementById('settingsModal');
        const content = document.getElementById('settingsModalContent');
        
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        
        // Small delay to allow display flex to apply before animating opacity
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            content.classList.remove('scale-95');
        }, 10);
    }

    function closeSettingsModal() {
        const modal = document.getElementById('settingsModal');
        const content = document.getElementById('settingsModalContent');
        
        modal.classList.add('opacity-0');
        content.classList.add('scale-95');
        
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 300);
    }

    function switchSettingsTab(tabId) {
        // Hide all contents
        document.querySelectorAll('.settings-tab-content').forEach(el => {
            el.classList.add('hidden');
            el.classList.remove('block');
        });
        
        // Reset all buttons
        document.querySelectorAll('[id^="tab-btn-"]').forEach(el => {
            el.className = "flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-slate-900 hover:bg-slate-50 rounded-xl transition-colors text-left w-full";
            el.children[1].classList.remove('font-semibold');
            el.children[1].classList.add('font-medium');
        });
        
        // Show active content
        document.getElementById('tab-content-' + tabId).classList.remove('hidden');
        document.getElementById('tab-content-' + tabId).classList.add('block');
        
        // Highlight active button
        const btn = document.getElementById('tab-btn-' + tabId);
        btn.className = "flex items-center gap-3 px-4 py-3 bg-slate-100/80 text-slate-900 rounded-xl transition-colors text-left w-full";
        btn.children[1].classList.remove('font-medium');
        btn.children[1].classList.add('font-semibold');
    }
</script>
