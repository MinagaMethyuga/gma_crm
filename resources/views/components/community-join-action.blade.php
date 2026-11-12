@php
    use App\Models\CommunityGroup;
@endphp

@if($group->isPending() && $group->created_by === auth()->id())
    <div class="w-full inline-flex items-center justify-center gap-1.5 text-amber-700 text-xs font-bold px-4 py-2.5 rounded-xl border border-amber-200 bg-amber-50">
        <span class="material-symbols-outlined text-[14px]">hourglass_top</span>
        Awaiting Approval
    </div>
@elseif($group->is_member)
    <div class="flex items-center gap-2 w-full">
        <button type="button" onclick="event.stopPropagation(); if (typeof window.communityRailClick === 'function') window.communityRailClick({{ $group->id }})" class="flex-1 inline-flex items-center justify-center gap-1.5 text-white text-xs font-bold px-3 py-2.5 rounded-xl bg-[#4338ca] hover:bg-[#3730a3] active:scale-[0.98] transition-all duration-200 shadow-sm hover:shadow">
            <span class="material-symbols-outlined text-[16px]">chat</span>
            Open Chat
        </button>
        <form action="{{ route('member.community.leave', $group) }}" method="POST" class="shrink-0" onsubmit="event.stopPropagation(); return confirm('Leave this group?')">
            @csrf
            <button type="submit" class="inline-flex items-center justify-center text-slate-400 hover:text-red-600 hover:bg-red-50 p-2.5 rounded-xl border border-slate-200 hover:border-red-200 transition-colors" title="Leave Group" aria-label="Leave Group">
                <span class="material-symbols-outlined text-[16px]">logout</span>
            </button>
        </form>
    </div>
@elseif($group->has_pending_request)
    <div class="flex flex-col gap-2 w-full">
        <div class="w-full inline-flex items-center justify-center gap-1.5 text-amber-700 text-xs font-bold px-4 py-2.5 rounded-xl border border-amber-200 bg-amber-50">
            <span class="material-symbols-outlined text-[14px]">hourglass_top</span>
            Request Pending
        </div>
        <form action="{{ route('member.community.request.cancel', $group->pending_request_id) }}" method="POST" class="w-full">
            @csrf
            <button type="submit" class="w-full inline-flex items-center justify-center gap-1.5 text-slate-500 text-xs font-bold px-4 py-2 rounded-xl border border-slate-200 hover:bg-slate-50 transition-all duration-200">
                Cancel Request
            </button>
        </form>
    </div>
@elseif($group->join_method === CommunityGroup::JOIN_REQUEST)
    <form action="{{ route('member.community.request', $group) }}" method="POST" class="w-full">
        @csrf
        <button type="submit" class="w-full inline-flex items-center justify-center gap-1.5 text-white text-xs font-bold px-4 py-2.5 rounded-xl transition-all duration-200 shadow-sm hover:shadow-md" style="background-color: #0f172a;">
            <span class="material-symbols-outlined text-[14px]">how_to_reg</span>
            Request to Join
        </button>
    </form>
@else
    <form action="{{ route('member.community.join', $group) }}" method="POST" class="w-full">
        @csrf
        <button type="submit" class="w-full inline-flex items-center justify-center gap-1.5 text-white text-xs font-bold px-4 py-2.5 rounded-xl transition-all duration-200 shadow-sm hover:shadow-md" style="background-color: #0f172a;">
            <span class="material-symbols-outlined text-[14px]">add</span>
            Join Group
        </button>
    </form>
@endif
