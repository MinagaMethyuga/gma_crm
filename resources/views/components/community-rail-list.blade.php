<!-- List of joined communities (shared by desktop rail + mobile drawer) -->
<div class="flex-1 overflow-y-auto custom-scroll py-3 px-3 space-y-1 bg-white">
    @forelse($joinedGroups as $group)
        <div class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-slate-100/70 transition-colors cursor-pointer group" onclick="communityRailClick({{ $group->id }})">
            <div class="relative shrink-0">
                <div class="w-10 h-10 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center overflow-hidden border border-slate-100">
                    @if($group->logoUrl())
                        <img src="{{ $group->logoUrl() }}" alt="{{ $group->name }}" class="w-full h-full object-cover">
                    @else
                        <span class="material-symbols-outlined text-[20px]">groups</span>
                    @endif
                </div>
                <span class="absolute -bottom-1 -right-1 w-5 h-5 rounded-full bg-emerald-500 text-white flex items-center justify-center ring-2 ring-white">
                    <span class="material-symbols-outlined text-[12px]">check</span>
                </span>
            </div>
            <div class="flex-1 min-w-0">
                <div class="font-semibold text-slate-800 text-[13px] tracking-wide truncate">{{ $group->name }}</div>
                <div class="text-[11px] text-slate-400 flex items-center gap-1">
                    <span class="material-symbols-outlined text-[12px]">diversity_3</span>
                    {{ $group->members_count }} members
                </div>
            </div>
            <span class="material-symbols-outlined text-slate-300 group-hover:text-slate-500 transition-colors text-[16px]">chevron_right</span>
        </div>
    @empty
        <div class="py-14 flex flex-col items-center text-center px-4">
            <div class="w-14 h-14 rounded-2xl bg-slate-100 flex items-center justify-center mb-3">
                <span class="material-symbols-outlined text-slate-400 text-[28px]">groups</span>
            </div>
            <p class="text-sm font-semibold text-slate-500">No communities joined yet</p>
            <p class="text-xs text-slate-400 mt-1 max-w-[200px]">Join a community to see it here.</p>
        </div>
    @endforelse
</div>