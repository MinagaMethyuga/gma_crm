<!-- Collapsible "Joined Communities" rail (WhatsApp-style) -->

<!-- DESKTOP: spacer to reserve 52px for the fixed rail below -->
<div class="hidden md:block shrink-0 w-[52px]"></div>

<!-- DESKTOP: fixed rail strip pinned after the main sidebar -->
<div id="communities-desktop-rail" data-tour="joined-communities" class="hidden md:flex fixed top-0 bottom-0 left-[88px] flex-col bg-[#fbfcfd] border-r border-slate-200/60 w-[52px] z-[45] transition-[left] duration-300 ease-in-out">
    <!-- Collapsed: thin toggle column -->
    <button id="communities-desktop-toggle" data-tour="joined-communities" class="flex flex-col items-center gap-2 pt-24 cursor-pointer group shrink-0 w-[52px] hover:bg-indigo-50/60 transition-colors flex-1">
        <span class="w-9 h-9 rounded-xl flex items-center justify-center bg-[#4338ca] text-white shadow-md shadow-indigo-500/30 group-hover:bg-[#3730a3] transition-colors">
            <span id="communities-desktop-toggle-icon" class="material-symbols-outlined text-[20px]">diversity_3</span>
        </span>
        <span class="text-[9px] font-semibold text-slate-400 uppercase tracking-widest" style="writing-mode: vertical-rl;">Communities</span>
    </button>
</div>

<!-- DESKTOP EXPLODED PANEL (slides over content, right of the rail) -->
<aside id="communities-desktop-panel" class="hidden md:flex fixed z-[80] top-0 bottom-0 left-[192px] w-[300px] bg-white border-r border-slate-200/60 flex-col opacity-0 invisible pointer-events-none transition-all duration-300 ease-in-out shadow-2xl">
    <div class="h-16 md:h-20 flex items-center justify-between px-5 border-b border-slate-200/60 shrink-0 bg-[#fbfcfd]">
        <div>
            <h3 class="text-[15px] font-bold text-slate-900 tracking-tight">Communities</h3>
            <p class="text-[11px] text-slate-400">Communities you've joined</p>
        </div>
        <button id="communities-desktop-close" class="text-slate-400 hover:text-slate-700 transition-colors p-1.5 rounded-lg hover:bg-slate-100">
            <span class="material-symbols-outlined">close</span>
        </button>
    </div>
    @include('components.community-rail-list', ['joinedGroups' => $joinedGroups])
</aside>

<!-- MOBILE: floating toggle -->
<button id="communities-mobile-toggle" data-tour="joined-communities" class="fixed z-[35] md:hidden top-[72px] left-3 sm:left-4 flex items-center gap-1.5 px-3 h-10 rounded-xl bg-[#4338ca] text-white shadow-md shadow-indigo-500/25 border border-white/20 hover:bg-[#3730a3] active:scale-95 transition-all" title="Joined Communities">
    <span class="material-symbols-outlined text-[19px]">diversity_3</span>
    <span class="text-xs font-bold tracking-wide">Communities</span>
</button>

<!-- Mobile overlay -->
<div id="communities-mobile-overlay" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-[75] hidden md:hidden"></div>

<!-- MOBILE: full-width drawer -->
<aside id="communities-mobile-drawer" class="fixed z-[80] md:hidden top-0 bottom-0 left-0 w-[88%] max-w-[340px] bg-white border-r border-slate-200/60 flex-col -translate-x-full transition-transform duration-300 ease-in-out shadow-2xl flex">
    <div class="h-16 flex items-center justify-between px-5 border-b border-slate-200/60 shrink-0 bg-[#fbfcfd]">
        <div>
            <h3 class="text-[15px] font-bold text-slate-900 tracking-tight">Communities</h3>
            <p class="text-[11px] text-slate-400">Communities you've joined</p>
        </div>
        <button id="communities-mobile-close" class="text-slate-400 hover:text-slate-700 transition-colors p-1.5 rounded-lg hover:bg-slate-100">
            <span class="material-symbols-outlined">close</span>
        </button>
    </div>
    @include('components.community-rail-list', ['joinedGroups' => $joinedGroups])
</aside>

<script>
(function () {
    const desktopToggle = document.getElementById('communities-desktop-toggle');
    const desktopPanel = document.getElementById('communities-desktop-panel');
    const desktopClose = document.getElementById('communities-desktop-close');
    const mobileToggle = document.getElementById('communities-mobile-toggle');
    const mobileDrawer = document.getElementById('communities-mobile-drawer');
    const mobileOverlay = document.getElementById('communities-mobile-overlay');
    const mobileClose = document.getElementById('communities-mobile-close');

    function toggleDesktop() {
        const isOpen = !desktopPanel.classList.contains('opacity-0');
        if (isOpen) {
            desktopPanel.classList.add('opacity-0', 'invisible', 'pointer-events-none');
            desktopPanel.classList.remove('opacity-100', 'visible', 'pointer-events-auto');
        } else {
            if (typeof window.closeFriendsDesktop === 'function') window.closeFriendsDesktop();
            desktopPanel.classList.remove('opacity-0', 'invisible', 'pointer-events-none');
            desktopPanel.classList.add('opacity-100', 'visible', 'pointer-events-auto');
        }
    }

    window.closeCommunitiesMobile = function () {
        if (!mobileDrawer) return;
        mobileDrawer.classList.remove('translate-x-0');
        mobileDrawer.classList.add('-translate-x-full');
        mobileOverlay.classList.add('hidden');
    };

    window.closeCommunitiesDesktop = function () {
        if (!desktopPanel.classList.contains('opacity-0')) {
            toggleDesktop();
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

    if (desktopToggle) desktopToggle.addEventListener('click', toggleDesktop);
    if (desktopClose) desktopClose.addEventListener('click', toggleDesktop);
    if (mobileToggle) mobileToggle.addEventListener('click', function () { toggleMobile(); });
    if (mobileClose) mobileClose.addEventListener('click', function () { toggleMobile(false); });
    if (mobileOverlay) mobileOverlay.addEventListener('click', function () { toggleMobile(false); });
})();

function highlightCommunityGroup(id) {
    const card = document.querySelector('[data-group-id="' + id + '"]');
    if (!card) return;
    card.scrollIntoView({ behavior: 'smooth', block: 'center' });
    card.classList.remove('ring-2', 'ring-[#4338ca]', 'shadow-lg');
    void card.offsetWidth;
    card.classList.add('ring-2', 'ring-[#4338ca]', 'shadow-lg');
    setTimeout(function () {
        card.classList.remove('ring-2', 'ring-[#4338ca]', 'shadow-lg');
    }, 2500);
}

window.communityRailClick = window.communityRailClick || function (groupId) {
    highlightCommunityGroup(groupId);
};
</script>