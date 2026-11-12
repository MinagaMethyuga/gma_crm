<!-- List of friends (shared by desktop rail + mobile drawer) -->
<div class="flex-1 overflow-y-auto custom-scroll py-3 px-3 space-y-1 bg-white">
    @forelse($friends as $friend)
        <div class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-slate-100/70 transition-colors cursor-pointer group" onclick="friendRailClick({{ $friend->id }})" data-friend-id="{{ $friend->id }}">
            <div class="relative shrink-0">
                <div class="w-10 h-10 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center overflow-hidden border border-slate-100">
                    <img src="{{ $friend->avatarUrl() }}" alt="{{ $friend->name }}" class="w-full h-full object-cover" onerror="this.outerHTML='<span class=&quot;material-symbols-outlined text-[20px]&quot;>person</span>'">
                </div>
                <span class="absolute bottom-0 right-0 w-3 h-3 rounded-full bg-emerald-400 ring-2 ring-white"></span>
            </div>
            <div class="flex-1 min-w-0">
                <div class="font-semibold text-slate-800 text-[13px] tracking-wide truncate">{{ $friend->name }}</div>
                <div class="text-[11px] text-slate-400 truncate">{{ $friend->company_name ?: 'Friend' }}</div>
            </div>
            <span class="material-symbols-outlined text-slate-300 group-hover:text-slate-500 transition-colors text-[16px]">chevron_right</span>
        </div>
    @empty
        <div class="py-14 flex flex-col items-center text-center px-4">
            <div class="w-14 h-14 rounded-2xl bg-slate-100 flex items-center justify-center mb-3">
                <span class="material-symbols-outlined text-slate-400 text-[28px]">group</span>
            </div>
            <p class="text-sm font-semibold text-slate-500">No friends yet</p>
            <p class="text-xs text-slate-400 mt-1 max-w-[200px]">Browse community groups and send friend requests to connect.</p>
        </div>
    @endforelse
</div>