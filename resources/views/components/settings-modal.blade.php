<div id="settingsModal" class="fixed inset-0 z-[100] hidden items-center justify-center opacity-0 transition-opacity duration-300">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-slate-900/20 backdrop-blur-sm" onclick="closeSettingsModal()"></div>
    
    <!-- Modal Content -->
    <div class="relative bg-white rounded-[28px] shadow-2xl flex w-full max-w-[850px] h-[550px] overflow-hidden scale-95 transition-transform duration-300" id="settingsModalContent">
        
        <!-- Close Button -->
        <button onclick="closeSettingsModal()" class="absolute top-4 right-4 w-8 h-8 flex items-center justify-center rounded-full hover:bg-slate-100 text-slate-400 hover:text-slate-600 transition-colors z-10">
            <span class="material-symbols-outlined text-[20px]">close</span>
        </button>

        <livewire:settings-modal />
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
</script>
