<!-- Collapsible "Friends" rail (WhatsApp-style, mirrors the Communities rail) -->

<!-- DESKTOP: spacer to reserve 52px for the fixed rail below -->
<div class="hidden md:block shrink-0 w-[52px]"></div>

<!-- DESKTOP: fixed rail strip pinned right of the Communities rail -->
<div id="friends-desktop-rail" data-tour="friends-rail" class="hidden md:flex fixed top-0 bottom-0 left-[140px] flex-col bg-[#fbfcfd] border-r border-slate-200/60 w-[52px] z-[45] transition-[left] duration-300 ease-in-out">
    <!-- Collapsed: thin toggle column -->
    <button id="friends-desktop-toggle" class="flex flex-col items-center gap-2 pt-24 cursor-pointer group shrink-0 w-[52px] hover:bg-indigo-50/60 transition-colors flex-1">
        <span class="w-9 h-9 rounded-xl flex items-center justify-center bg-[#4338ca] text-white shadow-md shadow-indigo-500/30 group-hover:bg-[#3730a3] transition-colors">
            <span id="friends-desktop-toggle-icon" class="material-symbols-outlined text-[20px]">group</span>
        </span>
        <span class="text-[9px] font-semibold text-slate-400 uppercase tracking-widest" style="writing-mode: vertical-rl;">Friends</span>
    </button>
</div>

<!-- DESKTOP EXPLODED PANEL (slides over content, right of the rail) -->
<aside id="friends-desktop-panel" class="hidden md:flex fixed z-[80] top-0 bottom-0 left-[192px] w-[300px] bg-white border-r border-slate-200/60 flex-col opacity-0 invisible pointer-events-none transition-all duration-300 ease-in-out shadow-2xl">
    <div class="h-16 md:h-20 flex items-center justify-between px-5 border-b border-slate-200/60 shrink-0 bg-[#fbfcfd]">
        <div>
            <h3 class="text-[15px] font-bold text-slate-900 tracking-tight">Friends</h3>
            <p class="text-[11px] text-slate-400">{{ $friends->count() }} connected</p>
        </div>
        <button id="friends-desktop-close" class="text-slate-400 hover:text-slate-700 transition-colors p-1.5 rounded-lg hover:bg-slate-100">
            <span class="material-symbols-outlined">close</span>
        </button>
    </div>
    @include('components.friend-search')
    @include('components.friend-rail-list', ['friends' => $friends])
</aside>

<!-- MOBILE: floating toggle -->
<button id="friends-mobile-toggle" data-tour="friends-rail" class="fixed z-[35] md:hidden top-[72px] left-[138px] sm:left-[152px] flex items-center gap-1.5 px-3 h-10 rounded-xl bg-[#4338ca] text-white shadow-md shadow-indigo-500/25 border border-white/20 hover:bg-[#3730a3] active:scale-95 transition-all" title="Friends">
    <span class="material-symbols-outlined text-[19px]">group</span>
    <span class="text-xs font-bold tracking-wide">Friends</span>
</button>

<!-- Mobile overlay -->
<div id="friends-mobile-overlay" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-[75] hidden md:hidden"></div>

<!-- MOBILE: full-width drawer -->
<aside id="friends-mobile-drawer" class="fixed z-[80] md:hidden top-0 bottom-0 left-0 w-[88%] max-w-[340px] bg-white border-r border-slate-200/60 flex-col -translate-x-full transition-transform duration-300 ease-in-out shadow-2xl flex">
    <div class="h-16 flex items-center justify-between px-5 border-b border-slate-200/60 shrink-0 bg-[#fbfcfd]">
        <div>
            <h3 class="text-[15px] font-bold text-slate-900 tracking-tight">Friends</h3>
            <p class="text-[11px] text-slate-400">{{ $friends->count() }} connected</p>
        </div>
        <button id="friends-mobile-close" class="text-slate-400 hover:text-slate-700 transition-colors p-1.5 rounded-lg hover:bg-slate-100">
            <span class="material-symbols-outlined">close</span>
        </button>
    </div>
    @include('components.friend-search')
    @include('components.friend-rail-list', ['friends' => $friends])
</aside>

<script>
(function () {
    const desktopToggle = document.getElementById('friends-desktop-toggle');
    const desktopPanel = document.getElementById('friends-desktop-panel');
    const desktopClose = document.getElementById('friends-desktop-close');
    const mobileToggle = document.getElementById('friends-mobile-toggle');
    const mobileDrawer = document.getElementById('friends-mobile-drawer');
    const mobileOverlay = document.getElementById('friends-mobile-overlay');
    const mobileClose = document.getElementById('friends-mobile-close');

    function setDesktop(open) {
        if (open) {
            if (typeof window.closeCommunitiesDesktop === 'function') window.closeCommunitiesDesktop();
            desktopPanel.classList.remove('opacity-0', 'invisible', 'pointer-events-none');
            desktopPanel.classList.add('opacity-100', 'visible', 'pointer-events-auto');
        } else {
            desktopPanel.classList.add('opacity-0', 'invisible', 'pointer-events-none');
            desktopPanel.classList.remove('opacity-100', 'visible', 'pointer-events-auto');
        }
    }

    window.closeFriendsMobile = function () {
        if (!mobileDrawer) return;
        mobileDrawer.classList.remove('translate-x-0');
        mobileDrawer.classList.add('-translate-x-full');
        mobileOverlay.classList.add('hidden');
    };

    window.closeFriendsDesktop = function () {
        if (desktopPanel && !desktopPanel.classList.contains('opacity-0')) {
            setDesktop(false);
        }
    };

    function toggleMobile(open) {
        const shouldOpen = open === undefined ? !mobileDrawer.classList.contains('translate-x-0') : open;
        if (shouldOpen) {
            if (typeof window.closeMainSidebar === 'function') window.closeMainSidebar();
            mobileDrawer.classList.remove('-translate-x-full');
            mobileDrawer.classList.add('translate-x-0');
            mobileOverlay.classList.remove('hidden');
        } else {
            mobileDrawer.classList.remove('translate-x-0');
            mobileDrawer.classList.add('-translate-x-full');
            mobileOverlay.classList.add('hidden');
        }
    }

    if (desktopToggle) desktopToggle.addEventListener('click', function () { setDesktop(desktopPanel.classList.contains('opacity-0')); });
    if (desktopClose) desktopClose.addEventListener('click', function () { setDesktop(false); });
    if (mobileToggle) mobileToggle.addEventListener('click', function () { toggleMobile(); });
    if (mobileClose) mobileClose.addEventListener('click', function () { toggleMobile(false); });
    if (mobileOverlay) mobileOverlay.addEventListener('click', function () { toggleMobile(false); });
})();

function highlightFriend(id) {
    const panel = document.getElementById('friends-desktop-panel') || document.getElementById('friends-mobile-drawer');
    const item = panel && panel.querySelector('[data-friend-id="' + id + '"]');
    if (!item) return;
    item.classList.remove('ring-2', 'ring-[#4338ca]', 'shadow-lg');
    void item.offsetWidth;
    item.classList.add('ring-2', 'ring-[#4338ca]', 'shadow-lg');
    setTimeout(function () {
        item.classList.remove('ring-2', 'ring-[#4338ca]', 'shadow-lg');
    }, 2500);
}

window.friendRailClick = window.friendRailClick || function (friendId) {
    highlightFriend(friendId);
};
</script>