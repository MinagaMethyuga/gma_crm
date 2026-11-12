@php
    $chatGroupMeta = ($joinedGroups ?? collect())->map(function ($g) {
        return [
            'id' => $g->id,
            'name' => $g->name,
            'description' => $g->description,
            'logo' => $g->logoUrl(),
            'members' => (int) ($g->members_count ?? 0),
            'is_admin' => $g->created_by === auth()->id() || ($g->members->first()?->pivot->role === 'admin'),
            'admin_only_messages' => (bool) $g->admin_only_messages,
            'pending_reports' => (int) $g->messageReports()->where('status', 'pending')->count(),
        ];
    })->values();

    $reportReasons = \App\Models\CommunityMessageReport::REASONS;
@endphp
<div id="chat-view" class="hidden fixed inset-0 z-50 md:absolute md:inset-x-0 md:bottom-0 md:top-20 md:z-30 flex flex-col bg-[#eef2f6] h-[100dvh] md:h-auto">
    <div class="shrink-0 bg-white border-b border-slate-200/70 px-3 md:px-5 h-14 md:h-16 flex items-center gap-2 sm:gap-2.5 shadow-sm">
        <button id="chat-back-btn" class="w-10 h-10 inline-flex items-center justify-center text-slate-600 hover:text-slate-900 active:bg-slate-100 rounded-xl transition-colors shrink-0 -ml-1 cursor-pointer" title="Back to communities" aria-label="Back to communities">
            <span class="material-symbols-outlined text-[24px]">arrow_back</span>
        </button>
        <div class="w-10 h-10 rounded-full bg-indigo-50 border border-slate-200 overflow-hidden flex items-center justify-center shrink-0">
            <img id="chat-group-logo" class="w-full h-full object-cover hidden" alt="">
            <span id="chat-group-logo-fallback" class="material-symbols-outlined text-indigo-500 text-[22px]">groups</span>
        </div>
        <button id="chat-group-info" class="min-w-0 flex-1 flex items-center gap-1.5 sm:gap-2 py-1 text-left cursor-pointer group" title="View group info">
            <div class="min-w-0 flex-1">
                <div id="chat-group-name" class="font-bold text-slate-900 text-sm sm:text-[15px] truncate leading-tight"></div>
                <div id="chat-group-meta" class="text-[11px] text-slate-400 truncate leading-tight mt-0.5"></div>
            </div>
            <span class="material-symbols-outlined text-slate-400 group-hover:text-slate-600 transition-colors text-[20px] shrink-0 p-1">info</span>
        </button>
        <button id="chat-select-btn" class="w-10 h-10 inline-flex items-center justify-center text-slate-500 hover:text-slate-800 active:bg-slate-100 rounded-xl transition-colors shrink-0 cursor-pointer" title="Select messages" aria-label="Select messages">
            <span class="material-symbols-outlined text-[22px]">check_box</span>
        </button>
    </div>

    <div id="chat-pinned-bar" class="hidden shrink-0 bg-indigo-50/70 border-b border-indigo-100">
        <div class="px-3 md:px-6 py-2 flex items-center gap-2">
            <span class="material-symbols-outlined text-indigo-500 text-[18px] shrink-0">push_pin</span>
            <div class="min-w-0 flex-1 flex items-center gap-2">
                <span id="chat-pinned-title" class="text-[12px] font-bold text-indigo-700 shrink-0 truncate">Pinned</span>
                <span id="chat-pinned-text" class="text-[12px] text-slate-500 truncate min-w-0 flex-1"></span>
            </div>
            <span id="chat-pinned-count" class="text-[11px] font-bold text-indigo-400 shrink-0"></span>
            <button id="chat-pinned-toggle" class="text-[12px] font-semibold text-indigo-600 hover:text-indigo-800 px-2 py-1 rounded transition-colors shrink-0" type="button"></button>
        </div>
        <div id="chat-pinned-list" class="hidden border-t border-indigo-100 max-h-40 overflow-y-auto custom-scroll"></div>
    </div>

    <div id="chat-messages" class="flex-1 overflow-y-auto custom-scroll px-3 sm:px-6 md:px-8 py-3 sm:py-5 overscroll-contain"></div>

<div id="chat-read-only" class="hidden shrink-0 bg-white border-t border-slate-200/70 px-4 md:px-6 py-3.5 items-center justify-center gap-2 text-[13px] font-medium text-slate-500">
        <span class="material-symbols-outlined text-[18px] text-slate-400">lock</span>
        <span>Only admins can send messages in this group.</span>
    </div>
    <div id="chat-drop-overlay" class="hidden absolute inset-0 z-40 bg-slate-900/35 backdrop-blur-[1px] items-center justify-center pointer-events-none">
        <div class="bg-white rounded-2xl px-7 py-5 shadow-2xl flex items-center gap-3 text-slate-700 font-bold text-[15px]">
            <span class="material-symbols-outlined text-indigo-500 text-[28px]">image</span>
            Drop image to attach
        </div>
    </div>
    <div id="chat-select-bar" class="hidden shrink-0 bg-white border-t border-slate-200/70 px-3 md:px-6 py-3 flex items-center justify-between gap-3">
        <div class="flex items-center gap-2 max-w-3xl mx-auto w-full">
            <span class="material-symbols-outlined text-slate-400 text-[20px]">check_circle</span>
            <span id="chat-select-count" class="text-[13px] font-semibold text-slate-700">No messages selected</span>
            <div class="flex-1"></div>
            <button id="chat-select-cancel" class="h-9 px-3.5 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold text-[13px] transition-colors">Cancel</button>
            <button id="chat-select-delete" class="h-9 px-3.5 rounded-full bg-red-500 hover:bg-red-600 text-white font-semibold text-[13px] transition-colors flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[16px]">delete</span> Delete
            </button>
        </div>
    </div>
    <div id="chat-reply-preview" class="hidden shrink-0 bg-indigo-50/60 border-t border-indigo-100 px-3 sm:px-4 md:px-6 pt-2.5">
        <div class="max-w-3xl mx-auto flex items-center gap-2.5">
            <span class="material-symbols-outlined text-indigo-500 text-[16px] shrink-0">reply</span>
            <div class="min-w-0 flex-1 border-l-2 border-indigo-300 pl-2.5">
                <div id="chat-reply-name" class="text-[11px] font-bold text-indigo-700 truncate"></div>
                <div id="chat-reply-text" class="text-[12px] text-slate-500 truncate"></div>
            </div>
            <button id="chat-reply-cancel" class="text-slate-400 hover:text-slate-700 p-1 rounded-lg hover:bg-white transition-colors shrink-0" title="Cancel reply">
                <span class="material-symbols-outlined text-[16px]">close</span>
            </button>
        </div>
    </div>

    <div id="chat-composer" class="shrink-0 bg-white border-t border-slate-200/70 p-2.5 sm:p-3 md:px-6 md:py-4 pb-[max(0.625rem,env(safe-area-inset-bottom))]">
        <div id="chat-cooldown-timer" class="hidden max-w-3xl mx-auto mb-2 px-3 sm:px-4 py-2 sm:py-2.5 rounded-xl bg-amber-50 border border-amber-200 flex items-center gap-2 text-amber-800 text-xs sm:text-[13px] font-semibold">
            <span class="material-symbols-outlined text-[18px]">hourglass_top</span>
            <span id="chat-cooldown-timer-text">Please wait before sending again</span>
        </div>
        <div id="chat-preview" class="hidden max-w-3xl mx-auto mb-2">
            <div class="relative inline-block">
                <img id="chat-preview-img" class="h-20 sm:h-24 w-auto max-w-[180px] object-cover rounded-xl border border-slate-200 shadow-sm" alt="Attachment preview">
                <button type="button" id="chat-preview-remove" class="absolute -top-2 -right-2 w-6 h-6 rounded-full bg-slate-900/75 hover:bg-slate-900 text-white flex items-center justify-center transition-colors" title="Remove image">
                    <span class="material-symbols-outlined text-[14px]">close</span>
                </button>
            </div>
        </div>
        <form id="chat-form" class="flex items-center gap-1.5 sm:gap-2 max-w-3xl mx-auto">
            <button type="button" id="chat-poll-btn" class="hidden w-10 h-10 sm:w-11 sm:h-11 rounded-full bg-slate-100 hover:bg-slate-200 active:bg-slate-300 text-slate-500 hover:text-slate-800 flex items-center justify-center transition-colors shrink-0 cursor-pointer" title="Create a poll" aria-label="Create a poll">
                <span class="material-symbols-outlined text-[20px]">poll</span>
            </button>
            <button type="button" id="chat-attach-btn" class="w-10 h-10 sm:w-11 sm:h-11 rounded-full bg-slate-100 hover:bg-slate-200 active:bg-slate-300 text-slate-500 hover:text-slate-800 flex items-center justify-center transition-colors shrink-0 cursor-pointer" title="Attach image" aria-label="Attach image">
                <span class="material-symbols-outlined text-[20px]">add_photo_alternate</span>
            </button>
            <input id="chat-input" type="text" autocomplete="off" placeholder="Type a message or a caption..." maxlength="2000"
                class="flex-1 min-w-0 h-10 sm:h-11 px-3.5 sm:px-4 rounded-full border border-slate-200 bg-slate-50 text-base sm:text-sm text-slate-800 placeholder:text-slate-400 focus:outline-none focus:border-indigo-400 focus:bg-white transition">
            <button type="submit" id="chat-send-btn" class="w-10 h-10 sm:w-11 sm:h-11 rounded-full bg-[#4338ca] hover:bg-[#3730a3] active:scale-95 transition-all text-white flex items-center justify-center shadow-sm shrink-0 cursor-pointer" aria-label="Send message">
                <span class="material-symbols-outlined text-[20px]">send</span>
            </button>
        </form>
        <input id="chat-file-input" type="file" accept="image/jpeg,image/png,image/gif,image/webp" class="hidden">
    </div>
</div>

<div id="chat-lightbox" class="hidden fixed inset-0 z-50 bg-slate-950/80 backdrop-blur-sm items-center justify-center p-4 md:p-8">
        <button type="button" id="chat-lightbox-close" class="absolute top-4 right-4 w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-colors" title="Close">
            <span class="material-symbols-outlined text-[22px]">close</span>
        </button>
        <img id="chat-lightbox-img" class="max-h-full max-w-full object-contain rounded-lg shadow-2xl" alt="">
    </div>

    <div id="chat-ctx-menu" class="hidden fixed z-[70] w-48 bg-white rounded-xl shadow-2xl border border-slate-200/70 py-1.5">
        <button type="button" id="chat-ctx-reply" class="w-full flex items-center gap-2.5 px-3.5 py-2 text-[13px] font-semibold text-slate-700 hover:bg-slate-50 transition-colors">
            <span class="material-symbols-outlined text-[17px]">reply</span> Reply
        </button>
        <button type="button" id="chat-ctx-pin" class="w-full flex items-center gap-2.5 px-3.5 py-2 text-[13px] font-semibold text-slate-700 hover:bg-slate-50 transition-colors">
            <span class="material-symbols-outlined text-[17px]">push_pin</span> <span id="chat-ctx-pin-label">Pin</span>
        </button>
        <button type="button" id="chat-ctx-react" class="w-full flex items-center gap-2.5 px-3.5 py-2 text-[13px] font-semibold text-slate-700 hover:bg-slate-50 transition-colors">
            <span class="material-symbols-outlined text-[17px]">mood</span> React
        </button>
        <button type="button" id="chat-ctx-report" class="w-full flex items-center gap-2.5 px-3.5 py-2 text-[13px] font-semibold text-amber-700 hover:bg-amber-50 transition-colors">
            <span class="material-symbols-outlined text-[17px]">flag</span> Report
        </button>
        <button type="button" id="chat-ctx-delete" class="w-full flex items-center gap-2.5 px-3.5 py-2 text-[13px] font-semibold text-red-600 hover:bg-red-50 transition-colors">
            <span class="material-symbols-outlined text-[17px]">delete</span> Delete message
        </button>
    </div>

    <div id="chat-emoji-picker" class="hidden fixed z-[80] w-[272px] p-2 bg-white rounded-2xl shadow-2xl border border-slate-200/80">
        <div class="px-1.5 pb-1.5 pt-0.5 text-[10px] font-bold uppercase tracking-wide text-slate-400">React</div>
        <div id="chat-emoji-grid" class="grid grid-cols-8 gap-0.5"></div>
    </div>

    <div id="chat-report-modal" class="hidden fixed inset-0 z-[80] bg-slate-900/50 backdrop-blur-sm items-center justify-center p-3 sm:p-4">
        <div class="bg-white rounded-2xl w-full max-w-sm shadow-2xl overflow-hidden" role="dialog" aria-modal="true" aria-labelledby="chat-report-title">
            <div class="flex items-center gap-2.5 px-5 pt-5 pb-3">
                <span class="w-9 h-9 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-[19px]">flag</span>
                </span>
                <div class="min-w-0">
                    <div id="chat-report-title" class="font-bold text-slate-900 text-[15px]">Report message</div>
                    <div class="text-[11px] text-slate-400">A community admin will review it.</div>
                </div>
            </div>
            <div class="px-5 pb-4">
                <div id="chat-report-quote" class="text-[12px] text-slate-500 bg-slate-50 border border-slate-100 rounded-lg px-3 py-2 mb-3 line-clamp-2"></div>
                <div id="chat-report-reasons" class="space-y-1.5"></div>
                <textarea id="chat-report-details" rows="2" maxlength="500" placeholder="Add context (optional)"
                    class="w-full mt-3 px-3 py-2 border border-slate-200 rounded-lg text-base sm:text-[13px] text-slate-800 focus:outline-none focus:border-indigo-400 resize-none"></textarea>
                <div id="chat-report-error" class="hidden text-[12px] text-red-600 font-medium mt-2"></div>
            </div>
            <div class="flex items-center justify-end gap-2 px-5 py-3.5 border-t border-slate-100 bg-slate-50/60">
                <button id="chat-report-cancel" class="h-9 px-3.5 rounded-full bg-white border border-slate-300 hover:bg-slate-50 text-[13px] font-semibold text-slate-600 transition-colors">Cancel</button>
                <button id="chat-report-submit" class="h-9 px-4 rounded-full bg-amber-600 hover:bg-amber-700 text-white text-[13px] font-semibold transition-colors">Report</button>
            </div>
        </div>
    </div>

    <div id="chat-poll-modal" class="hidden fixed inset-0 z-[80] bg-slate-900/50 backdrop-blur-sm items-center justify-center p-3 sm:p-4">
        <div class="bg-white rounded-2xl w-full max-w-md shadow-2xl overflow-hidden" role="dialog" aria-modal="true" aria-labelledby="chat-poll-title">
            <div class="flex items-center gap-2.5 px-5 pt-5 pb-3">
                <span class="w-9 h-9 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-[19px]">poll</span>
                </span>
                <div class="min-w-0">
                    <div id="chat-poll-title" class="font-bold text-slate-900 text-[15px]">Create a poll</div>
                    <div class="text-[11px] text-slate-400">Members can vote right away.</div>
                </div>
            </div>
            <div class="px-5 pb-4">
                <label for="chat-poll-question" class="block text-[12px] font-bold text-slate-700 mb-1.5">Question</label>
                <input id="chat-poll-question" type="text" maxlength="500" placeholder="What should we discuss next?"
                    class="w-full px-3 py-2 border border-slate-200 rounded-lg text-base sm:text-[13px] text-slate-800 focus:outline-none focus:border-indigo-400">
                <label class="block text-[12px] font-bold text-slate-700 mt-3 mb-1.5">Options</label>
                <div id="chat-poll-options" class="space-y-1.5"></div>
                <button id="chat-poll-add" type="button" class="mt-2 text-[12px] font-semibold text-indigo-600 hover:text-indigo-800 flex items-center gap-1 cursor-pointer">
                    <span class="material-symbols-outlined text-[15px]">add</span> Add option
                </button>
                <div id="chat-poll-error" class="hidden text-[12px] text-red-600 font-medium mt-2"></div>
            </div>
            <div class="flex items-center justify-end gap-2 px-5 py-3.5 border-t border-slate-100 bg-slate-50/60">
                <button id="chat-poll-cancel" class="h-9 px-3.5 rounded-full bg-white border border-slate-300 hover:bg-slate-50 text-[13px] font-semibold text-slate-600 transition-colors">Cancel</button>
                <button id="chat-poll-submit" class="h-9 px-4 rounded-full bg-[#4338ca] hover:bg-[#3730a3] text-white text-[13px] font-semibold transition-colors">Post poll</button>
            </div>
        </div>
    </div>

    <div id="community-members-backdrop" class="fixed inset-0 z-[70] bg-slate-900/40 backdrop-blur-sm hidden"></div>
<div id="community-members-view" class="fixed inset-y-0 right-0 z-[75] w-full max-w-full sm:max-w-md bg-white shadow-2xl transition-transform duration-300 ease-out translate-x-full invisible flex flex-col h-[100dvh]">
    <div class="flex items-center gap-2 px-4 md:px-5 h-14 md:h-16 border-b border-slate-200/70 shrink-0">
        <button id="community-members-close" class="text-slate-500 hover:text-slate-800 p-2 -ml-2 rounded-xl hover:bg-slate-100 transition-colors cursor-pointer" title="Close" aria-label="Close">
            <span class="material-symbols-outlined text-[22px]">close</span>
        </button>
        <button id="members-profile-back" class="hidden text-slate-500 hover:text-slate-800 p-2 -ml-2 rounded-xl hover:bg-slate-100 transition-colors cursor-pointer" title="Back to members" aria-label="Back to members">
            <span class="material-symbols-outlined text-[22px]">arrow_back</span>
        </button>
        <div id="members-panel-title" class="text-slate-900 font-bold text-[15px] truncate">Members</div>
    </div>

    <div id="members-tabs" class="hidden shrink-0 px-4 md:px-5 pt-3">
        <div class="flex items-center gap-1 p-1 rounded-xl bg-slate-100/80">
            <button id="members-tab-community" type="button" class="flex-1 h-8 rounded-lg text-[12px] font-bold transition-colors bg-white text-slate-800 shadow-sm">Community</button>
            <button id="members-tab-moderation" type="button" class="flex-1 h-8 rounded-lg text-[12px] font-bold transition-colors text-slate-500 flex items-center justify-center gap-1.5">
                <span class="material-symbols-outlined text-[15px]">shield</span> Moderation
                <span id="members-moderation-badge" class="hidden min-w-[18px] h-[18px] px-1 rounded-full bg-amber-500 text-white text-[10px] font-bold flex items-center justify-center"></span>
            </button>
        </div>
    </div>

    <div id="members-moderation-view" class="hidden flex-1 flex-col min-h-0">
        <div class="flex items-center justify-between gap-2 px-5 py-3 border-b border-slate-100 shrink-0">
            <div class="text-[13px] font-bold text-slate-800">Reported messages</div>
            <div class="flex items-center gap-1 p-0.5 rounded-lg bg-slate-100/80">
                <button type="button" data-reports-filter="pending" class="reports-filter-btn h-7 px-2.5 rounded-md text-[11px] font-bold bg-white text-slate-800 shadow-sm transition-colors">Pending</button>
                <button type="button" data-reports-filter="resolved" class="reports-filter-btn h-7 px-2.5 rounded-md text-[11px] font-bold text-slate-500 transition-colors">Resolved</button>
            </div>
        </div>
        <div id="reports-list" class="flex-1 overflow-y-auto custom-scroll px-4 py-3 space-y-2"></div>
    </div>

    <div id="members-list-view" class="flex-1 flex flex-col min-h-0">
        <!-- Community details -->
        <div class="px-5 pt-5 pb-4 border-b border-slate-100 shrink-0">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-indigo-50 border border-slate-200 overflow-hidden flex items-center justify-center shrink-0">
                    <img id="members-group-logo" class="w-full h-full object-cover hidden" alt="">
                    <span id="members-group-logo-fallback" class="material-symbols-outlined text-indigo-500 text-[28px]">groups</span>
                </div>
                <div class="min-w-0 flex-1">
                    <div id="members-group-name" class="font-bold text-slate-900 text-[16px] truncate"></div>
                    <div id="members-group-count" class="text-[12px] text-slate-400"></div>
                </div>
            </div>
            <p id="members-group-description" class="hidden text-[12px] text-slate-500 leading-relaxed mt-3"></p>
        </div>

        <!-- Community settings (admin only) -->
        <div id="community-settings" class="hidden border-b border-slate-100 shrink-0">
            <div class="px-5 py-4">
                <div class="text-[11px] font-bold uppercase tracking-wide text-slate-400 mb-3">Community Settings</div>

                <div class="flex items-center justify-between gap-3">
                    <div class="min-w-0">
                        <div class="text-[13px] font-semibold text-slate-800">Admin-only posting</div>
                        <div class="text-[11px] text-slate-400">Only admins can send messages</div>
                    </div>
                    <button id="setting-admin-toggle" type="button" class="relative shrink-0 w-11 h-6 rounded-full transition-colors duration-200" style="background-color:#cbd5e1;" title="Only admins can post">
                        <span id="setting-admin-knob" class="absolute top-0.5 left-0.5 w-5 h-5 rounded-full bg-white shadow transition-transform duration-200"></span>
                    </button>
                </div>

                <div class="mt-4">
                    <div class="text-[13px] font-semibold text-slate-800 mb-1">Message cooldown</div>
                    <div class="text-[11px] text-slate-400 mb-2">Prevent spam by limiting how fast members can post.</div>
                    <div class="flex items-center gap-2 flex-wrap">
                        <input id="setting-cooldown-count" type="number" min="0" max="1000" placeholder="0"
                            class="w-16 h-9 rounded-lg border border-slate-200 text-center text-sm text-slate-800 focus:outline-none focus:border-indigo-400">
                        <span class="text-[12px] text-slate-500">messages, then wait</span>
                        <input id="setting-cooldown-minutes" type="number" min="0" max="1440" placeholder="0"
                            class="w-16 h-9 rounded-lg border border-slate-200 text-center text-sm text-slate-800 focus:outline-none focus:border-indigo-400">
                        <span class="text-[12px] text-slate-500">minutes</span>
                    </div>
                </div>

                <div class="mt-4 flex items-center gap-2">
                    <button id="setting-save" class="h-9 px-4 rounded-lg bg-[#4338ca] hover:bg-[#3730a3] text-white text-[13px] font-semibold transition-colors">Save Settings</button>
                    <span id="setting-saved-hint" class="hidden text-[12px] text-emerald-600 font-semibold">Settings saved</span>
                </div>
            </div>
        </div>

        <!-- Members -->
        <div class="flex-1 flex flex-col min-h-0">
            <div class="flex items-center gap-2 px-5 py-3 border-b border-slate-100 shrink-0">
                <div class="text-[13px] font-bold text-slate-800">Members</div>
                <span id="members-count-pill" class="text-[11px] font-semibold text-slate-400"></span>
            </div>
            <div id="members-list" class="flex-1 overflow-y-auto custom-scroll px-3 py-3 space-y-1"></div>
        </div>
    </div>
    <div id="members-profile-view" class="hidden flex-1 overflow-y-auto custom-scroll min-h-0">
        <div class="flex flex-col items-center px-6 pt-8 pb-6 border-b border-slate-100">
            <div class="w-20 h-20 rounded-full bg-indigo-50 border border-slate-200 overflow-hidden flex items-center justify-center mb-3">
                <img id="profile-avatar" class="w-full h-full object-cover hidden" alt="">
                <span id="profile-avatar-fallback" class="material-symbols-outlined text-indigo-400 text-[36px]">person</span>
            </div>
            <div id="profile-name" class="font-bold text-slate-900 text-[16px] truncate max-w-full text-center"></div>
            <div id="profile-badges" class="flex items-center gap-1.5 mt-1.5"></div>
            <div id="profile-joined" class="text-[12px] text-slate-400 mt-1"></div>
            <div id="profile-friend-actions" class="w-full mt-4 flex items-center justify-center gap-2"></div>
        </div>
        <div id="profile-rows" class="px-5 py-4 space-y-3"></div>
    </div>
</div>

<div id="chat-toasts" class="fixed top-3 right-3 left-3 sm:left-auto sm:w-[370px] z-[95] flex flex-col gap-2.5 pointer-events-none"></div>

<script>
(function () {
    var chatView = document.getElementById('chat-view');
    var chatMessages = document.getElementById('chat-messages');
    var chatInput = document.getElementById('chat-input');
    var chatForm = document.getElementById('chat-form');
    var chatSendBtn = document.getElementById('chat-send-btn');
    var chatBackBtn = document.getElementById('chat-back-btn');
    var chatGroupName = document.getElementById('chat-group-name');
    var chatGroupMeta = document.getElementById('chat-group-meta');
    var chatGroupLogo = document.getElementById('chat-group-logo');
    var chatGroupLogoFallback = document.getElementById('chat-group-logo-fallback');
    var chatGroupInfo = document.getElementById('chat-group-info');
    var membersBackdrop = document.getElementById('community-members-backdrop');
    var membersPanel = document.getElementById('community-members-view');
    var membersClose = document.getElementById('community-members-close');
    var membersList = document.getElementById('members-list');
    var membersGroupName = document.getElementById('members-group-name');
    var membersGroupCount = document.getElementById('members-group-count');
    var membersGroupLogo = document.getElementById('members-group-logo');
    var membersGroupLogoFallback = document.getElementById('members-group-logo-fallback');
    var membersListView = document.getElementById('members-list-view');
    var membersTabs = document.getElementById('members-tabs');
    var membersTabCommunity = document.getElementById('members-tab-community');
    var membersTabModeration = document.getElementById('members-tab-moderation');
    var membersModerationBadge = document.getElementById('members-moderation-badge');
    var membersModerationView = document.getElementById('members-moderation-view');
    var reportsList = document.getElementById('reports-list');
    var membersProfileView = document.getElementById('members-profile-view');
    var membersProfileBack = document.getElementById('members-profile-back');
    var membersPanelTitle = document.getElementById('members-panel-title');
    var membersGroupDescription = document.getElementById('members-group-description');
    var membersCountPill = document.getElementById('members-count-pill');
    var settingsBlock = document.getElementById('community-settings');
    var reportFilterValue = 'pending';
    var settingAdminToggle = document.getElementById('setting-admin-toggle');
    var settingAdminKnob = document.getElementById('setting-admin-knob');
    var settingCooldownCount = document.getElementById('setting-cooldown-count');
    var settingCooldownMinutes = document.getElementById('setting-cooldown-minutes');
    var settingSave = document.getElementById('setting-save');
    var settingSavedHint = document.getElementById('setting-saved-hint');
    var toastStack = document.getElementById('chat-toasts');
    var activeToasts = [];
    var TOAST_MAX = 4;
    var suppressNextAnnounce = false;

    var reactionEmoji = @json(\App\Models\MessageReaction::EMOJI);
    var emojiPicker = document.getElementById('chat-emoji-picker');
    var emojiGrid = document.getElementById('chat-emoji-grid');
var chatCtxReact = document.getElementById('chat-ctx-react');
var emojiPickerMsg = null;
var emojiGridBuilt = false;

    var TOAST_THEMES = {
        success: { icon: 'check_circle', badge: 'bg-emerald-50 text-emerald-600', bar: 'bg-emerald-500' },
        error: { icon: 'error', badge: 'bg-rose-50 text-rose-600', bar: 'bg-rose-500' },
        info: { icon: 'info', badge: 'bg-indigo-50 text-indigo-600', bar: 'bg-indigo-500' },
        warning: { icon: 'warning', badge: 'bg-amber-50 text-amber-600', bar: 'bg-amber-500' },
        message: { icon: 'chat_bubble', badge: 'bg-indigo-50 text-indigo-600', bar: 'bg-indigo-500' }
    };

    function dismissToast(el, immediate) {
        if (!el || el.getAttribute('data-closing') === '1') return;
        el.setAttribute('data-closing', '1');
        if (el.ctTimer) { clearTimeout(el.ctTimer); el.ctTimer = null; }
        el.classList.remove('is-paused');
        var i = activeToasts.indexOf(el);
        if (i !== -1) activeToasts.splice(i, 1);

        var remove = function () { if (el.parentNode) el.parentNode.removeChild(el); };
        if (immediate) { remove(); return; }
        el.classList.remove('is-in');
        el.classList.add('is-out');
        setTimeout(remove, 260);
    }

    function toast(text, options) {
        if (!toastStack) return null;
        options = options || {};

        var type = TOAST_THEMES[options.type] ? options.type : 'info';
        var theme = TOAST_THEMES[type];
        var duration = typeof options.duration === 'number'
            ? options.duration
            : (type === 'error' ? 6000 : 4000);

        var el = document.createElement('div');
        el.className = 'ct-toast is-in relative flex items-start gap-3 rounded-2xl bg-white ' +
            'border border-slate-200/80 shadow-[0_14px_34px_-14px_rgba(15,23,42,0.32)] ' +
            'px-4 pt-3.5 pb-4 overflow-hidden cursor-pointer select-none';
        el.setAttribute('role', type === 'error' ? 'alert' : 'status');
        el.setAttribute('aria-live', type === 'error' ? 'assertive' : 'polite');
        el.tabIndex = 0;

        var badge = document.createElement('span');
        badge.className = 'ct-icon shrink-0 w-9 h-9 rounded-xl flex items-center justify-center ' + theme.badge;
        badge.innerHTML = '<span class="material-symbols-outlined text-[19px]">' + (options.icon || theme.icon) + '</span>';

        var body = document.createElement('div');
        body.className = 'min-w-0 flex-1 pt-0.5';
        if (options.title) {
            var titleEl = document.createElement('div');
            titleEl.className = 'text-[13px] font-bold text-slate-900 leading-snug break-words';
            titleEl.textContent = options.title;
            body.appendChild(titleEl);
        }
        if (text) {
            var textEl = document.createElement('div');
            textEl.className = (options.title ? 'mt-0.5 ' : '') +
                'text-[12.5px] leading-snug text-slate-500 break-words';
            textEl.textContent = text;
            body.appendChild(textEl);
        }

        var close = document.createElement('button');
        close.type = 'button';
        close.className = 'shrink-0 -mt-1 -mr-1 w-6 h-6 rounded-lg text-slate-300 hover:text-slate-600 ' +
            'hover:bg-slate-100 flex items-center justify-center transition-colors';
        close.setAttribute('aria-label', 'Dismiss notification');
        close.innerHTML = '<span class="material-symbols-outlined text-[16px]">close</span>';
        close.addEventListener('click', function (e) {
            e.stopPropagation();
            dismissToast(el);
        });

        var bar = document.createElement('span');
        bar.className = 'ct-bar absolute bottom-0 left-0 h-[3px] ' + theme.bar;
        bar.style.animationDuration = duration + 'ms';

        el.appendChild(badge);
        el.appendChild(body);
        el.appendChild(close);
        el.appendChild(bar);

        // Newest first, so the most recent notification sits by the corner.
        toastStack.insertBefore(el, toastStack.firstChild);
        activeToasts.push(el);

        while (activeToasts.length > TOAST_MAX) {
            dismissToast(activeToasts[0], true);
        }

        // Hover / focus pauses both the countdown bar and the dismissal timer.
        var remaining = duration;
        var startedAt = 0;

        var startTimer = function () {
            startedAt = Date.now();
            el.ctTimer = setTimeout(function () { dismissToast(el); }, remaining);
        };
        var pauseTimer = function () {
            if (!el.ctTimer) return;
            clearTimeout(el.ctTimer);
            el.ctTimer = null;
            remaining = Math.max(700, remaining - (Date.now() - startedAt));
            el.classList.add('is-paused');
        };
        var resumeTimer = function () {
            if (el.ctTimer || el.getAttribute('data-closing') === '1') return;
            el.classList.remove('is-paused');
            startTimer();
        };

        el.addEventListener('mouseenter', pauseTimer);
        el.addEventListener('mouseleave', resumeTimer);
        el.addEventListener('focusin', pauseTimer);
        el.addEventListener('focusout', resumeTimer);

        el.addEventListener('click', function () {
            if (typeof options.onClick === 'function') options.onClick();
            dismissToast(el);
        });
        el.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                if (typeof options.onClick === 'function') options.onClick();
                dismissToast(el);
            }
        });

        startTimer();
        return el;
    }

    function jumpToLatest() {
        if (chatMessages) chatMessages.scrollTop = chatMessages.scrollHeight;
        if (chatInput) chatInput.focus();
    }

    function announceMessages(list) {
        if (!list || !list.length) return;
        var groupName = chatGroupName && chatGroupName.textContent
            ? chatGroupName.textContent
            : 'Community Group';

        if (list.length === 1) {
            var m = list[0];
            var who = m.user_name || 'Someone';
            var preview;
            if (m.type === 'poll' && m.poll) {
                preview = 'Created a new poll.';
            } else if (m.image_url) {
                preview = 'Sent a photo.';
            } else {
                preview = m.message || 'Sent a message.';
            }
            toast(preview, {
                type: 'message',
                title: who + ' \u00b7 ' + groupName,
                onClick: jumpToLatest
            });
            return;
        }

        var names = [];
        list.forEach(function (m) {
            var n = m.user_name || 'Someone';
            if (names.indexOf(n) === -1) names.push(n);
        });
        var who = names.length <= 2 ? names.join(' & ') : names.length + ' members';
        toast(list.length + ' new message' + (list.length === 1 ? '' : 's') + ' in ' + groupName, {
            type: 'message',
            title: who,
            onClick: jumpToLatest
        });
    }
    var chatComposer = document.getElementById('chat-composer');
    var chatReadOnly = document.getElementById('chat-read-only');
    var chatFileInput = document.getElementById('chat-file-input');
    var chatAttachBtn = document.getElementById('chat-attach-btn');
    var chatPollBtn = document.getElementById('chat-poll-btn');
    var chatPreview = document.getElementById('chat-preview');
    var chatPreviewImg = document.getElementById('chat-preview-img');
    var chatPreviewRemove = document.getElementById('chat-preview-remove');
    var chatDropOverlay = document.getElementById('chat-drop-overlay');
    var chatLightbox = document.getElementById('chat-lightbox');
    var chatLightboxImg = document.getElementById('chat-lightbox-img');
    var chatLightboxClose = document.getElementById('chat-lightbox-close');
    var chatSelectBtn = document.getElementById('chat-select-btn');
    var chatSelectBar = document.getElementById('chat-select-bar');
    var chatSelectCount = document.getElementById('chat-select-count');
    var chatSelectCancel = document.getElementById('chat-select-cancel');
    var chatSelectDelete = document.getElementById('chat-select-delete');
    var chatCtxMenu = document.getElementById('chat-ctx-menu');
    var chatCtxDelete = document.getElementById('chat-ctx-delete');
    var chatCtxReply = document.getElementById('chat-ctx-reply');
    var chatCtxPin = document.getElementById('chat-ctx-pin');
    var chatCtxPinLabel = document.getElementById('chat-ctx-pin-label');
    var chatCtxReport = document.getElementById('chat-ctx-report');
    var chatPinnedBar = document.getElementById('chat-pinned-bar');
    var chatPinnedTitle = document.getElementById('chat-pinned-title');
    var chatPinnedText = document.getElementById('chat-pinned-text');
    var chatPinnedCount = document.getElementById('chat-pinned-count');
    var chatPinnedToggle = document.getElementById('chat-pinned-toggle');
    var chatPinnedList = document.getElementById('chat-pinned-list');
    var chatReplyPreview = document.getElementById('chat-reply-preview');
    var chatReplyName = document.getElementById('chat-reply-name');
    var chatReplyText = document.getElementById('chat-reply-text');
    var chatReplyCancel = document.getElementById('chat-reply-cancel');
    var chatReportModal = document.getElementById('chat-report-modal');
    var chatReportQuote = document.getElementById('chat-report-quote');
    var chatReportReasons = document.getElementById('chat-report-reasons');
    var chatReportDetails = document.getElementById('chat-report-details');
    var chatReportError = document.getElementById('chat-report-error');
    var chatReportCancel = document.getElementById('chat-report-cancel');
    var chatReportSubmit = document.getElementById('chat-report-submit');
    var chatPollModal = document.getElementById('chat-poll-modal');
    var chatPollQuestion = document.getElementById('chat-poll-question');
    var chatPollOptions = document.getElementById('chat-poll-options');
    var chatPollAdd = document.getElementById('chat-poll-add');
    var chatPollError = document.getElementById('chat-poll-error');
    var chatPollCancel = document.getElementById('chat-poll-cancel');
    var chatPollSubmit = document.getElementById('chat-poll-submit');
    var reportReasons = @json($reportReasons);
    var lightboxAnim = null;
    var lightboxImgAnim = null;
    var pendingImage = null;
    var pendingImageUrl = null;
    var dragCounter = 0;
    var selectMode = false;
    var selectedIds = {};
    var ctxMsgId = null;
    var chatCooldownTimer = document.getElementById('chat-cooldown-timer');
    var chatCooldownTimerText = document.getElementById('chat-cooldown-timer-text');
    var cooldownTimerInterval = null;
    var cooldownActive = false;
    var profileAvatar = document.getElementById('profile-avatar');
    var profileAvatarFallback = document.getElementById('profile-avatar-fallback');
    var profileName = document.getElementById('profile-name');
    var profileBadges = document.getElementById('profile-badges');
    var profileJoined = document.getElementById('profile-joined');
    var profileRows = document.getElementById('profile-rows');
    var profileFriendActions = document.getElementById('profile-friend-actions');

    if (!chatView) return;

    var csrfToken = (document.querySelector('meta[name="csrf-token"]') || {}).content || '';
    var activeChat = null;
    var lastMessageId = 0;
    var pollTimer = null;
    var membersCloseTimer = null;
    var membersCanManage = false;
    var membersCurrentGroupId = null;
    var membersCurrentGroupName = '';
    var currentSettings = null;
    var adminToggleOn = false;
    var profileUserId = null;
    var profileIsOwn = false;
    var pinnedMessages = [];
    var pinnedExpanded = false;
    var replyToId = null;
    var replyToName = '';
    var reportMsgId = null;
    var reportReason = null;
    var pollOptionCount = 0;

    window.__joinedGroups = @json($chatGroupMeta);

    function escapeHtml(str) {
        return String(str == null ? '' : str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }

    function clearPendingImage() {
        if (pendingImageUrl) URL.revokeObjectURL(pendingImageUrl);
        pendingImage = null;
        pendingImageUrl = null;
        chatPreview.classList.add('hidden');
        chatPreviewImg.removeAttribute('src');
    }

    function setPendingImage(file) {
        if (!file || !/^image\//.test(file.type)) {
            showChatError('Please choose an image file (JPEG, PNG, GIF, or WebP).');
            return;
        }
        clearPendingImage();
        pendingImage = file;
        pendingImageUrl = URL.createObjectURL(file);
        chatPreviewImg.src = pendingImageUrl;
        chatPreview.classList.remove('hidden');
        chatInput.focus();
    }

    function hasFileDrag(e) {
        return e.dataTransfer && Array.prototype.indexOf.call(e.dataTransfer.types, 'Files') !== -1;
    }

    function openLightbox(url) {
        if (!url) return;
        if (lightboxAnim) lightboxAnim.cancel();
        if (lightboxImgAnim) lightboxImgAnim.cancel();

        chatLightboxImg.src = url;
        chatLightbox.style.display = 'flex';
        chatLightbox.style.opacity = '';
        chatLightboxImg.style.opacity = '0';
        chatLightboxImg.style.transform = 'scale(0.92)';

        var spring = 'cubic-bezier(0.22, 1, 0.36, 1)';
        lightboxAnim = chatLightbox.animate(
            [{ opacity: 0 }, { opacity: 1 }],
            { duration: 200, easing: 'ease-out', fill: 'forwards' }
        );
        lightboxImgAnim = chatLightboxImg.animate(
            [
                { transform: 'scale(0.92)', opacity: 0 },
                { transform: 'scale(1.02)', opacity: 1 }
            ],
            { duration: 340, easing: spring, fill: 'forwards' }
        );
        lightboxImgAnim.onfinish = function () {
            lightboxImgAnim = chatLightboxImg.animate(
                [
                    { transform: 'scale(1.02)' },
                    { transform: 'scale(1)' }
                ],
                { duration: 120, easing: spring, fill: 'forwards' }
            );
        };
    }

    function closeLightbox() {
        if (chatLightbox.style.display === 'none') return;
        if (lightboxAnim) lightboxAnim.cancel();
        if (lightboxImgAnim) lightboxImgAnim.cancel();

        var spring = 'cubic-bezier(0.22, 1, 0.36, 1)';
        lightboxImgAnim = chatLightboxImg.animate(
            [
                { transform: 'scale(1)', opacity: 1 },
                { transform: 'scale(0.92)', opacity: 0 }
            ],
            { duration: 200, easing: spring, fill: 'forwards' }
        );
        lightboxAnim = chatLightbox.animate(
            [{ opacity: 1 }, { opacity: 0 }],
            { duration: 160, easing: 'ease-in', fill: 'forwards' }
        );
        lightboxAnim.onfinish = function () {
            chatLightbox.style.display = 'none';
            chatLightboxImg.removeAttribute('src');
            chatLightboxImg.style.transform = '';
            chatLightboxImg.style.opacity = '';
        };
    }

    function replyBlock(m, isOwn) {
        var r = m.reply;
        if (!r) return null;
        var block = document.createElement('div');
        block.className = 'mb-2.5 pl-3 border-l-2 rounded-r';
        block.style.borderColor = isOwn ? 'rgba(255,255,255,0.45)' : '#c7d2fe';
        var name = document.createElement('div');
        name.className = 'text-[10px] font-bold truncate ' + (isOwn ? 'text-indigo-100' : 'text-indigo-600');
        name.textContent = r.user_name || 'Member';
        var body = document.createElement('div');
        body.className = 'text-[11px] truncate ' + (isOwn ? 'text-indigo-100/80' : 'text-slate-500');
        body.textContent = r.image_url ? 'Photo' : (r.message || '');
        block.appendChild(name);
        block.appendChild(body);
        return block;
    }

    function pollBlock(p, timeEl) {
        var box = document.createElement('div');
        box.className = 'mt-3 pt-3 border-t ' + (p.is_closed ? 'border-indigo-100' : 'border-slate-100');

        var total = p.total_votes || 0;
        var foot = document.createElement('div');
        foot.className = 'flex items-center justify-between gap-2';
        var votes = document.createElement('span');
        votes.className = 'text-[11px] text-slate-400';
        votes.textContent = total + (total === 1 ? ' vote' : ' votes');
        foot.appendChild(votes);

        var right = document.createElement('div');
        right.className = 'flex items-center gap-2';
        if (p.is_closed) {
            var closed = document.createElement('span');
            closed.className = 'text-[10px] font-bold uppercase tracking-wide text-slate-400';
            closed.textContent = 'Closed';
            right.appendChild(closed);
        }
        if (timeEl) {
            right.appendChild(timeEl);
        }
        foot.appendChild(right);

        box.appendChild(foot);
        return box;
    }

    function pollOptions(m) {
        var wrapEl = document.createElement('div');
        wrapEl.className = 'flex flex-col gap-1.5 mt-2';

        (m.poll.options || []).forEach(function (opt) {
            var isMine = m.poll.user_vote_index === opt.index;
            var btn = document.createElement('button');
            btn.type = 'button';
            btn.disabled = !!m.poll.is_closed;
            btn.className = 'relative w-full text-left px-3 py-2 rounded-lg text-[12px] font-semibold overflow-hidden border transition-colors ' +
                (isMine
                    ? 'border-indigo-400 bg-indigo-50 text-indigo-800'
                    : 'border-slate-200 bg-white text-slate-700 hover:border-indigo-300 hover:bg-indigo-50/50');

            var fill = document.createElement('span');
            fill.className = 'absolute inset-y-0 left-0 bg-indigo-100/70 pointer-events-none transition-[width] duration-500 ease-out';
            fill.style.width = (opt.percent || 0) + '%';
            btn.appendChild(fill);

            var label = document.createElement('span');
            label.className = 'relative flex items-center justify-between gap-2';
            var text = document.createElement('span');
            text.className = 'truncate';
            text.textContent = opt.text;
            var pct = document.createElement('span');
            pct.className = 'shrink-0 text-[11px] font-bold ' + (isMine ? 'text-indigo-700' : 'text-slate-400');
            pct.textContent = (opt.percent || 0) + '%';
            label.appendChild(text);
            label.appendChild(pct);
            btn.appendChild(label);

            btn.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                if (selectMode) return;
                votePoll(m, opt.index);
            });
            wrapEl.appendChild(btn);
        });

        return wrapEl;
    }

    function messageBubble(m) {
        rememberMessage(m);

        var wrap = document.createElement('div');
        var isOwn = !!m.is_own;
        var isAdmin = currentUserIsAdmin();
        var isPoll = m.type === 'poll' && m.poll;

        wrap.className = 'group flex items-end gap-2.5 mb-3 px-1 w-full ' + (isOwn ? 'justify-end' : 'justify-start');
        wrap.dataset.msgId = m.id;

        var hasImage = !!m.image_url;
        var hasText = !isPoll && !!(m.message && String(m.message).trim());
        var isMediaOnly = hasImage && !hasText && !m.reply && !m.is_pinned;

        var bubble = document.createElement('div');
        bubble.className = (isPoll ? 'w-[min(340px,85vw)] ' : 'w-fit max-w-full ') +
            'rounded-2xl text-[14px] leading-relaxed break-words transition-all duration-200 ' +
            (isMediaOnly ? 'p-2 ' : 'px-4 py-2.5 ') +
            (isOwn
                ? 'bg-[#4338ca] text-white rounded-br-xs shadow-[0_4px_14px_-4px_rgba(67,56,202,0.45)]'
                : 'bg-white text-slate-800 border border-slate-200/80 rounded-bl-xs shadow-sm');

        if (m.is_pinned) {
            var pin = document.createElement('div');
            pin.className = 'flex items-center gap-1 mb-1.5 text-[10px] font-bold uppercase tracking-wide ' +
                (isOwn ? 'text-indigo-100' : 'text-indigo-600');
            pin.innerHTML = '<span class="material-symbols-outlined text-[12px]">push_pin</span> Pinned';
            bubble.appendChild(pin);
        }

        var quoted = replyBlock(m, isOwn);
        if (quoted) bubble.appendChild(quoted);

        var time = document.createElement('span');
        time.className = (isMediaOnly
            ? 'block w-full mt-1 text-right whitespace-nowrap text-[10px] font-medium '
            : 'whitespace-nowrap text-[10px] font-medium shrink-0 self-end ml-auto ') +
            (isOwn ? 'text-indigo-200/90' : 'text-slate-400');
        time.textContent = m.time || '';

        if (m.image_url) {
            var imgEl = document.createElement('img');
            imgEl.src = m.image_url;
            imgEl.className = 'block max-h-80 w-auto max-w-full rounded-xl cursor-zoom-in' + (hasText ? ' mb-2' : '');
            imgEl.alt = '';
            imgEl.loading = 'lazy';
            imgEl.addEventListener('click', function (e) {
                if (selectMode) return;
                e.preventDefault();
                e.stopPropagation();
                openLightbox(m.image_url);
            });
            bubble.appendChild(imgEl);
        }

        if (isPoll) {
            bubble.appendChild(pollOptions(m));
            bubble.appendChild(pollBlock(m.poll, time));
        } else if (isMediaOnly) {
            bubble.appendChild(time);
        } else {
            var msgContent = document.createElement('div');
            msgContent.className = 'flex flex-wrap items-baseline justify-between gap-x-3 gap-y-1 min-w-0';

            var text = document.createElement('span');
            text.className = 'break-words whitespace-pre-wrap min-w-0 flex-1';
            text.textContent = m.message || '';

            msgContent.appendChild(text);
            msgContent.appendChild(time);
            bubble.appendChild(msgContent);
        }

        var actions = document.createElement('div');
        actions.className = 'flex items-center gap-0.5 opacity-0 group-hover:opacity-100 transition-opacity shrink-0 mb-0.5';

        var reactBtn = miniActionBtn('mood', 'React', function () { openEmojiPicker(reactBtn, m); });
        actions.appendChild(reactBtn);
        var replyBtn = miniActionBtn('reply', 'Reply', function () { startReply(m); });
        actions.appendChild(replyBtn);
        if (!isOwn) {
            actions.appendChild(miniActionBtn('flag', 'Report', function () { openReportModal(m); }));
        }
        if (isAdmin) {
            actions.appendChild(miniActionBtn('push_pin', m.is_pinned ? 'Unpin' : 'Pin', function () { togglePin(m); }));
        }

        wrap.addEventListener('click', function (e) {
            if (selectMode) toggleSelect(m.id, wrap);
        });
        wrap.addEventListener('dblclick', function (e) {
            e.preventDefault();
            startReply(m);
        });
        wrap.addEventListener('contextmenu', function (e) {
            if (selectMode) return;
            e.preventDefault();
            openContextMenu(e, m.id);
        });

        // Touch device long-press affordance
        var touchTimer = null;
        wrap.addEventListener('touchstart', function (e) {
            if (selectMode) return;
            touchTimer = setTimeout(function () {
                openContextMenu(e, m.id);
            }, 450);
        }, { passive: true });
        wrap.addEventListener('touchmove', function () {
            if (touchTimer) { clearTimeout(touchTimer); touchTimer = null; }
        }, { passive: true });
        wrap.addEventListener('touchend', function () {
            if (touchTimer) { clearTimeout(touchTimer); touchTimer = null; }
        });
        wrap.addEventListener('touchcancel', function () {
            if (touchTimer) { clearTimeout(touchTimer); touchTimer = null; }
        });

        var bubbleRow = document.createElement('div');
        bubbleRow.className = 'flex items-end gap-1.5 w-full ' + (isOwn ? 'justify-end' : 'justify-start');

        if (isOwn) {
            bubbleRow.appendChild(actions);
            bubbleRow.appendChild(bubble);
        } else {
            bubbleRow.appendChild(bubble);
            bubbleRow.appendChild(actions);
        }

        var col = document.createElement('div');
        col.className = 'flex flex-col min-w-0 max-w-[88%] sm:max-w-[75%] md:max-w-[65%] ' + (isOwn ? 'items-end' : 'items-start');

        if (!isOwn) {
            var name = document.createElement('span');
            name.className = 'text-[10px] font-bold text-indigo-600 uppercase tracking-wide mb-1 px-1';
            name.textContent = (m.user_name || 'Member') + (isAdmin ? ' · admin' : '');
            col.appendChild(name);
        }

        col.appendChild(bubbleRow);
        col.appendChild(reactionStrip(m));

        if (isOwn) {
            wrap.appendChild(col);
            return wrap;
        }

        var avatar = document.createElement('div');
        avatar.className = 'w-8 h-8 rounded-full bg-indigo-50 border border-slate-200 overflow-hidden flex items-center justify-center shrink-0 mb-0.5';
        if (m.avatar_url) {
            var img = document.createElement('img');
            img.src = m.avatar_url;
            img.className = 'w-full h-full object-cover';
            img.alt = '';
            avatar.appendChild(img);
        } else {
            var ic = document.createElement('span');
            ic.className = 'material-symbols-outlined text-indigo-400 text-[17px]';
            ic.textContent = 'person';
            avatar.appendChild(ic);
        }

        wrap.appendChild(avatar);
        wrap.appendChild(col);
        return wrap;
    }

    function miniActionBtn(icon, title, handler) {
        var b = document.createElement('button');
        b.type = 'button';
        b.title = title;
        b.setAttribute('aria-label', title);
        b.className = 'w-6 h-6 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-800 flex items-center justify-center transition-colors';
        b.innerHTML = '<span class="material-symbols-outlined text-[13px]">' + icon + '</span>';
        b.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            handler();
        });
        return b;
    }

    function bubbleEl(msgId) {
        return chatMessages.querySelector('[data-msg-id="' + msgId + '"]');
    }

    function replaceBubble(m) {
        var existing = bubbleEl(m.id);
        if (!existing) return false;
        existing.replaceWith(messageBubble(m));
        return true;
    }

    function renderMessages(messages) {
        if (!messages || !messages.length) return;
        var fresh = messages.filter(function (m) { return m.id > lastMessageId; });
        if (!fresh.length) return;
        var box = chatMessages;
        var stick = box.scrollHeight - box.scrollTop - box.clientHeight < 140;
        fresh.forEach(function (m) { box.appendChild(messageBubble(m)); });
        lastMessageId = fresh[fresh.length - 1].id;
        if (stick || fresh.some(function (m) { return m.is_own; })) {
            box.scrollTop = box.scrollHeight;
        }

        // Skip the initial batch on group open (everything is "fresh" then),
        // and stay quiet when the user is already looking at the newest message.
        if (suppressNextAnnounce) {
            suppressNextAnnounce = false;
            return;
        }
        var incoming = fresh.filter(function (m) { return !m.is_own; });
        if (incoming.length && (!stick || document.hidden)) {
            announceMessages(incoming);
        }
    }

    function renderPinned(list) {
        pinnedMessages = list || [];
        if (!pinnedMessages.length) {
            chatPinnedBar.classList.add('hidden');
            chatPinnedList.innerHTML = '';
            chatPinnedList.classList.add('hidden');
            return;
        }

        chatPinnedBar.classList.remove('hidden');

        if (pinnedMessages.length === 1) {
            chatPinnedTitle.textContent = 'Pinned';
            chatPinnedText.textContent = pinnedMessages[0].message || pinnedMessages[0].type;
            chatPinnedCount.textContent = '';
            chatPinnedToggle.classList.add('hidden');
        } else {
            chatPinnedTitle.textContent = pinnedMessages.length + ' pinned';
            chatPinnedText.textContent = pinnedMessages[0].message || pinnedMessages[0].type;
            chatPinnedCount.textContent = '1 of ' + pinnedMessages.length;
            chatPinnedToggle.classList.remove('hidden');
            chatPinnedToggle.textContent = pinnedExpanded ? 'Collapse' : 'View all';
            chatPinnedList.classList.toggle('hidden', !pinnedExpanded);
            chatPinnedList.innerHTML = '';
            pinnedMessages.forEach(function (m) {
                var row = document.createElement('button');
                row.type = 'button';
                row.className = 'w-full text-left px-4 md:px-6 py-2 flex items-center gap-2 hover:bg-indigo-100/50 transition-colors';
                var txt = document.createElement('span');
                txt.className = 'text-[12px] text-slate-600 truncate flex-1';
                txt.textContent = (m.user_name ? m.user_name + ': ' : '') + (m.message || m.type);
                var who = document.createElement('span');
                who.className = 'text-[10px] text-slate-400 shrink-0';
                who.textContent = m.time || '';
                row.appendChild(txt);
                row.appendChild(who);
                row.addEventListener('click', function () { scrollToMessage(m.id); });
                chatPinnedList.appendChild(row);
            });
        }

        if (pinnedMessages.length === 1) {
            chatPinnedList.classList.add('hidden');
            chatPinnedList.innerHTML = '';
        }
    }

    function scrollToMessage(msgId) {
        var el = bubbleEl(msgId);
        if (!el) return;
        el.scrollIntoView({ behavior: 'smooth', block: 'center' });
        el.classList.remove('msg-highlight');
        void el.offsetWidth;
        el.classList.add('msg-highlight');
        setTimeout(function () { el.classList.remove('msg-highlight'); }, 1600);
    }

    function loadMessages() {
        if (!activeChat) return;
        fetch('/member/community/' + activeChat.id + '/messages', { headers: { 'Accept': 'application/json' } })
            .then(function (r) { return r.ok ? r.json() : Promise.reject(); })
            .then(function (data) {
                renderMessages(data.messages || []);
                renderPinned(data.pinned || []);
            })
            .catch(function () {});
    }

    function setGroupLogo(img, fallback, url) {
        if (url) {
            img.src = url;
            img.style.display = 'block';
            fallback.style.display = 'none';
        } else {
            img.removeAttribute('src');
            img.style.display = 'none';
            fallback.style.display = '';
        }
    }

    function updateComposer() {
        chatComposer.style.display = '';
        chatReadOnly.style.display = 'none';
        if (chatPollBtn) chatPollBtn.classList.add('hidden');
        if (!activeChat) return;

        var meta = (window.__joinedGroups || []).find(function (g) { return String(g.id) === String(activeChat.id); });
        var restricted = !!(meta && meta.admin_only_messages && !meta.is_admin);
        if (restricted) {
            chatComposer.style.display = 'none';
            chatReadOnly.style.display = 'flex';
            clearPendingImage();
        } else if (chatPollBtn && meta && meta.is_admin) {
            chatPollBtn.classList.remove('hidden');
        }
    }

    function currentUserIsAdmin() {
        if (!activeChat) return false;
        var meta = (window.__joinedGroups || []).find(function (g) { return String(g.id) === String(activeChat.id); });
        return !!(meta && meta.is_admin);
    }

    function closeContextMenu() {
        chatCtxMenu.classList.add('hidden');
        ctxMsgId = null;
    }

    var messageStore = {};

    function rememberMessage(m) {
        messageStore[m.id] = m;
    }

    function messageData(msgId) {
        return messageStore[msgId] || null;
    }

    function ctxMessageData() {
        return ctxMsgId != null ? messageData(ctxMsgId) : null;
    }

    function openContextMenu(e, msgId) {
        if (selectMode) return;
        var m = messageData(msgId);
        ctxMsgId = msgId;

        chatCtxReply.style.display = '';
        chatCtxReact.style.display = m ? '' : 'none';
        chatCtxPin.style.display = currentUserIsAdmin() ? '' : 'none';
        chatCtxReport.style.display = m && m.is_own ? 'none' : '';
        chatCtxDelete.style.display = (m && m.is_own) || currentUserIsAdmin() ? '' : 'none';
        if (m) chatCtxPinLabel.textContent = m.is_pinned ? 'Unpin' : 'Pin';

        chatCtxMenu.classList.remove('hidden');
        var clientX = (e && e.clientX != null && e.clientX > 0) ? e.clientX : (e && e.touches && e.touches[0] ? e.touches[0].clientX : window.innerWidth / 2);
        var clientY = (e && e.clientY != null && e.clientY > 0) ? e.clientY : (e && e.touches && e.touches[0] ? e.touches[0].clientY : window.innerHeight / 2);
        var menuW = chatCtxMenu.offsetWidth || 192;
        var menuH = chatCtxMenu.offsetHeight || 180;
        var left = Math.max(12, Math.min(clientX, window.innerWidth - menuW - 12));
        var top = Math.max(12, Math.min(clientY, window.innerHeight - menuH - 12));
        chatCtxMenu.style.left = left + 'px';
        chatCtxMenu.style.top = top + 'px';
    }

    function startReply(m) {
        replyToId = m.id;
        replyToName = m.user_name || 'Member';
        chatReplyName.textContent = 'Replying to ' + replyToName;
        chatReplyText.textContent = m.image_url ? 'Photo' : (m.message || (m.poll ? m.poll.question : ''));
        chatReplyPreview.classList.remove('hidden');
        chatInput.focus();
    }

    function cancelReply() {
        replyToId = null;
        replyToName = '';
        chatReplyPreview.classList.add('hidden');
        chatReplyText.textContent = '';
    }

    function togglePin(m) {
        if (!activeChat || !m) return;
        var action = m.is_pinned ? 'unpin' : 'pin';
        fetch('/member/community/' + activeChat.id + '/messages/' + m.id + '/' + action, {
            method: 'POST',
            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken }
        })
            .then(function (r) {
                return r.json().then(function (j) {
                    if (!r.ok) return Promise.reject(j);
                    return j;
                });
            })
            .then(function (data) {
                if (data && data.message) replaceBubble(data.message);
                toast(action === 'pin' ? 'Message pinned to this group.' : 'Message unpinned.', { type: 'success' });
                loadMessages();
            })
            .catch(function (j) { showChatError((j && (j.message || j.error)) || 'Could not update the pin.'); });
    }

    /* ── Emoji reactions ─────────────────────────────────────────────────────
       The pill strip under a bubble doubles as the toggle, so a member can
       add or take back a reaction without opening the picker again. */

function reactionTooltip(r) {
        var names = (r.names || []).join(', ');
        var label = r.mine ? 'You' : names;
        if (r.count > 1) label += ' and ' + (r.count - 1) + ' more';
        return label + ' reacted with ' + r.emoji;
    }

function reactionPill(r) {
        var btn = document.createElement('button');
        btn.type = 'button';
        btn.dataset.emoji = r.emoji;
        btn.title = reactionTooltip(r);
        btn.className = 'msg-reaction inline-flex items-center gap-1 h-[22px] px-1.5 rounded-full border text-[11px] leading-none transition-colors '
            + (r.mine
                ? 'bg-indigo-50 border-indigo-200 text-indigo-700 hover:bg-indigo-100'
                : 'bg-white border-slate-200 text-slate-600 hover:bg-slate-50');

        var face = document.createElement('span');
        face.className = 'text-[13px] leading-none';
        face.textContent = r.emoji;
        btn.appendChild(face);

        // A count of one is implied by the emoji alone, so keep the pill quiet.
        if (r.count > 1) {
            var num = document.createElement('span');
            num.className = 'font-semibold';
            num.textContent = r.count;
            btn.appendChild(num);
        }

        return btn;
    }

function paintReactions(strip, m) {
        if (!strip) return;
        strip.innerHTML = '';
        var rows = (m && m.reactions) || [];
        rows.forEach(function (r) {
            var pill = reactionPill(r);
            pill.addEventListener('click', function (e) {
                e.stopPropagation();
                toggleReaction(m, r.emoji);
            });
            strip.appendChild(pill);
        });

        // An empty strip must not leave a gap under every bubble.
        strip.classList.toggle('hidden', rows.length === 0);
    }

function reactionStrip(m) {
        var strip = document.createElement('div');
        strip.className = 'msg-reactions flex flex-wrap items-center gap-1 mt-1 px-1.5';
        paintReactions(strip, m);
        return strip;
    }

function toggleReaction(m, emoji) {
        if (!activeChat || !m) return;
        fetch('/member/community/' + activeChat.id + '/messages/' + m.id + '/reaction', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken },
            body: JSON.stringify({ emoji: emoji })
        })
            .then(function (r) {
                return r.json().then(function (j) {
                    if (!r.ok) return Promise.reject(j);
                    return j;
                });
            })
            .then(function (data) {
                if (!data) return;
                // Keep the cached copy fresh so a later re-render matches.
                m.reactions = data.reactions || [];
                var row = bubbleEl(m.id);
                paintReactions(row && row.querySelector('.msg-reactions'), m);
                closeEmojiPicker();
            })
            .catch(function (j) { showChatError((j && (j.message || j.error)) || 'Could not save that reaction.'); });
    }

function buildEmojiGrid() {
        if (!emojiGrid || emojiGridBuilt) return;
        emojiGridBuilt = true;
        reactionEmoji.forEach(function (emoji) {
            var b = document.createElement('button');
            b.type = 'button';
            b.textContent = emoji;
            b.title = 'React with ' + emoji;
            b.className = 'w-7 h-7 rounded-lg text-[17px] leading-none flex items-center justify-center hover:bg-slate-100 transition-colors';
            b.addEventListener('click', function () {
                if (emojiPickerMsg) toggleReaction(emojiPickerMsg, emoji);
            });
            emojiGrid.appendChild(b);
        });
    }

function openEmojiPicker(anchor, m, anchorRect) {
        if (!emojiPicker || !m) return;
        emojiPickerMsg = m;
        buildEmojiGrid();
        emojiPicker.classList.remove('hidden');

        // Anchored to the button, but kept inside the viewport. The context
        // menu path passes its rect because the menu is already closed.
        var rect = anchorRect || anchor.getBoundingClientRect();
        var width = emojiPicker.offsetWidth || 272;
        var height = emojiPicker.offsetHeight || 96;
        var left = Math.max(8, Math.min(rect.left, window.innerWidth - width - 8));
        var top = rect.top - height - 8;
        if (top < 8) top = Math.min(rect.bottom + 8, Math.max(8, window.innerHeight - height - 8));
        emojiPicker.style.left = left + 'px';
        emojiPicker.style.top = top + 'px';
    }

function closeEmojiPicker() {
        if (!emojiPicker) return;
        emojiPicker.classList.add('hidden');
        emojiPickerMsg = null;
    }

function votePoll(m, optionIndex) {
        if (!activeChat || !m || !m.poll) return;
        if (m.poll.is_closed) return;
        fetch('/member/community/' + activeChat.id + '/polls/' + m.poll.id + '/vote', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ option_index: optionIndex })
        })
            .then(function (r) {
                return r.json().then(function (j) {
                    if (!r.ok) return Promise.reject(j);
                    return j;
                });
            })
            .then(function (data) {
                if (!data || !data.poll) return;
                m.poll = data.poll;
                replaceBubble(m);
                toast('Vote recorded.', { type: 'success' });
            })
            .catch(function (j) { showChatError((j && (j.message || j.error)) || 'Could not record your vote.'); });
    }

    function openReportModal(m) {
        reportMsgId = m.id;
        reportReason = null;
        chatReportQuote.textContent = (m.image_url ? 'Photo: ' : '') + (m.message || '');
        chatReportDetails.value = '';
        chatReportError.classList.add('hidden');
        chatReportReasons.innerHTML = '';
        Object.keys(reportReasons).forEach(function (key) {
            var b = document.createElement('button');
            b.type = 'button';
            b.className = 'w-full text-left px-3 py-2 rounded-lg border text-[12px] font-semibold transition-colors border-slate-200 hover:border-amber-300 hover:bg-amber-50/60';
            b.textContent = reportReasons[key];
            b.addEventListener('click', function () {
                reportReason = key;
                chatReportReasons.querySelectorAll('button').forEach(function (el) {
                    el.classList.remove('border-amber-400', 'bg-amber-50', 'text-amber-800');
                    el.classList.add('border-slate-200');
                });
                b.classList.add('border-amber-400', 'bg-amber-50', 'text-amber-800');
                b.classList.remove('border-slate-200');
            });
            chatReportReasons.appendChild(b);
        });
        chatReportModal.classList.remove('hidden');
        chatReportModal.style.display = 'flex';
    }

    function closeReportModal() {
        chatReportModal.style.display = 'none';
        chatReportModal.classList.add('hidden');
        reportMsgId = null;
        reportReason = null;
    }

    function submitReport() {
        if (!activeChat || !reportMsgId) return;
        if (!reportReason) {
            chatReportError.textContent = 'Please choose a reason.';
            chatReportError.classList.remove('hidden');
            return;
        }
        chatReportSubmit.disabled = true;
        fetch('/member/community/' + activeChat.id + '/messages/' + reportMsgId + '/report', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ reason: reportReason, details: chatReportDetails.value })
        })
            .then(function (r) {
                return r.json().then(function (j) {
                    if (!r.ok) return Promise.reject(j);
                    return j;
                });
            })
            .then(function () {
                closeReportModal();
                showChatNotice('Thanks — a community admin will review this message.');
            })
            .catch(function (j) {
                chatReportError.textContent = (j && (j.message || j.error)) || 'Could not send the report.';
                chatReportError.classList.remove('hidden');
            })
            .finally(function () { chatReportSubmit.disabled = false; });
    }

    function showChatNotice(text) {
        toast(text || 'Done.', { type: 'success' });
    }

    function pollOptionRow(value) {
        var row = document.createElement('div');
        row.className = 'flex items-center gap-2';
        var input = document.createElement('input');
        input.type = 'text';
        input.maxLength = 200;
        input.value = value || '';
        input.placeholder = 'Option';
        input.className = 'poll-option-input flex-1 px-3 py-2 border border-slate-200 rounded-lg text-[13px] text-slate-800 focus:outline-none focus:border-indigo-400';
        row.appendChild(input);
        return row;
    }

    function resetPollForm() {
        pollOptionCount = 0;
        chatPollOptions.innerHTML = '';
        for (var i = 0; i < 2; i++) {
            chatPollOptions.appendChild(pollOptionRow(''));
            pollOptionCount++;
        }
    }

    function openPollModal() {
        if (!activeChat) return;
        chatPollQuestion.value = '';
        chatPollError.classList.add('hidden');
        resetPollForm();
        chatPollModal.classList.remove('hidden');
        chatPollModal.style.display = 'flex';
        setTimeout(function () { chatPollQuestion.focus(); }, 30);
    }

    function closePollModal() {
        chatPollModal.style.display = 'none';
        chatPollModal.classList.add('hidden');
    }

    function submitPoll() {
        if (!activeChat) return;
        var question = chatPollQuestion.value.trim();
        var options = [];
        chatPollOptions.querySelectorAll('.poll-option-input').forEach(function (input) {
            var v = input.value.trim();
            if (v) options.push(v);
        });

        if (question.length < 3) {
            chatPollError.textContent = 'Please add a question.';
            chatPollError.classList.remove('hidden');
            return;
        }
        if (options.length < 2) {
            chatPollError.textContent = 'Please add at least two options.';
            chatPollError.classList.remove('hidden');
            return;
        }

        chatPollSubmit.disabled = true;
        fetch('/member/community/' + activeChat.id + '/polls', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ question: question, options: options })
        })
            .then(function (r) {
                return r.json().then(function (j) {
                    if (!r.ok) return Promise.reject(j);
                    return j;
                });
            })
            .then(function (data) {
                closePollModal();
                if (data && data.message) {
                    renderMessages([data.message]);
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                }
                toast('Poll posted to the group.', { type: 'success' });
            })
            .catch(function (j) {
                chatPollError.textContent = (j && (j.message || j.error)) || 'Could not post the poll.';
                chatPollError.classList.remove('hidden');
            })
            .finally(function () { chatPollSubmit.disabled = false; });
    }

    function updateSelectBar() {
        var count = Object.keys(selectedIds).length;
        chatSelectCount.textContent = count === 0
            ? 'No messages selected'
            : count + (count === 1 ? ' message' : ' messages') + ' selected';
        chatSelectDelete.disabled = count === 0;
        chatSelectDelete.classList.toggle('opacity-40', count === 0);
        chatSelectDelete.classList.toggle('pointer-events-none', count === 0);
    }

    function clearSelection() {
        selectedIds = {};
        chatMessages.querySelectorAll('.msg-selected').forEach(function (el) { el.classList.remove('msg-selected'); });
        updateSelectBar();
    }

    function setSelectMode(on) {
        selectMode = on;
        chatSelectBtn.querySelector('.material-symbols-outlined').textContent = on ? 'close' : 'check_box';
        chatSelectBtn.title = on ? 'Exit selection' : 'Select messages';
        if (on) {
            chatComposer.style.display = 'none';
            updateSelectBar();
            chatSelectBar.style.display = 'flex';
        } else {
            clearSelection();
            closeContextMenu();
            chatSelectBar.style.display = 'none';
            chatComposer.style.display = '';
        }
    }

    function toggleSelect(msgId, wrap) {
        if (selectedIds[msgId]) {
            delete selectedIds[msgId];
            wrap.classList.remove('msg-selected');
        } else {
            selectedIds[msgId] = true;
            wrap.classList.add('msg-selected');
        }
        updateSelectBar();
    }

    function removeMessagesByIds(ids) {
        var idSet = {};
        ids.forEach(function (id) {
            idSet[String(id)] = true;
            delete messageStore[id];
        });
        pinnedMessages = pinnedMessages.filter(function (m) { return !idSet[String(m.id)]; });
        chatMessages.querySelectorAll('[data-msg-id]').forEach(function (el) {
            if (idSet[el.getAttribute('data-msg-id')]) el.remove();
        });
        renderPinned(pinnedMessages);
    }

    function deleteMessages(ids) {
        if (!activeChat || !ids.length) return;
        fetch('/member/community/' + activeChat.id + '/messages/bulk-delete', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ ids: ids })
        })
            .then(function (r) { return r.ok ? r.json() : Promise.reject(); })
            .then(function () {
                removeMessagesByIds(ids);
                if (selectMode) { setSelectMode(false); }
                toast(
                    ids.length + ' message' + (ids.length === 1 ? '' : 's') + ' deleted.',
                    { type: 'success' }
                );
            })
            .catch(function () { showChatError('Could not delete message(s). Please try again.'); });
    }

    function openChat(groupId, skipHistory) {
        var meta = (window.__joinedGroups || []).find(function (g) { return String(g.id) === String(groupId); });
        if (!meta) return;

        stopCooldown();

        activeChat = { id: meta.id };
        lastMessageId = 0;
        suppressNextAnnounce = true;
        messageStore = {};
        chatMessages.innerHTML = '';
        clearPendingImage();
        cancelReply();
        pinnedMessages = [];
        pinnedExpanded = false;
        renderPinned([]);
        setSelectMode(false);
        closeContextMenu();

        chatGroupName.textContent = meta.name || 'Community Group';
        chatGroupMeta.textContent = (meta.members || 0) + (meta.members === 1 ? ' member' : ' members');

        setGroupLogo(chatGroupLogo, chatGroupLogoFallback, meta.logo);

        chatView.classList.remove('hidden');
        chatView.style.display = 'flex';

        if (typeof window.closeCommunitiesMobile === 'function') window.closeCommunitiesMobile();
        if (typeof window.closeCommunitiesDesktop === 'function') window.closeCommunitiesDesktop();
        if (typeof window.closeFriendsMobile === 'function') window.closeFriendsMobile();
        if (typeof window.closeFriendsDesktop === 'function') window.closeFriendsDesktop();

        var commToggle = document.getElementById('communities-mobile-toggle');
        var friendToggle = document.getElementById('friends-mobile-toggle');
        if (commToggle) commToggle.style.display = 'none';
        if (friendToggle) friendToggle.style.display = 'none';

        if (!skipHistory && window.history) {
            var cur = window.location.search;
            if (!cur.includes('group=' + meta.id)) {
                if (window.history.pushState) window.history.pushState({ group: meta.id }, '', '/member/community?group=' + meta.id);
            } else if (window.history.replaceState) {
                window.history.replaceState({ group: meta.id }, '', '/member/community?group=' + meta.id);
            }
        }

        var dmChat = document.getElementById('dm-chat-view');
        if (dmChat) {
            dmChat.style.display = 'none';
            dmChat.classList.add('hidden');
        }

        loadMessages();
        if (pollTimer) clearInterval(pollTimer);
        pollTimer = setInterval(loadMessages, 4000);
        updateComposer();
        setTimeout(function () { if (!chatInput.disabled) chatInput.focus(); }, 100);
    }

    function closeChat(skipHistory) {
        if (pollTimer) { clearInterval(pollTimer); pollTimer = null; }
        stopCooldown();
        clearPendingImage();
        setSelectMode(false);
        closeContextMenu();
        closeEmojiPicker();
        activeChat = null;
        lastMessageId = 0;
        messageStore = {};
        chatMessages.innerHTML = '';
        cancelReply();
        closeReportModal();
        closePollModal();
        pinnedMessages = [];
        renderPinned([]);
        chatView.style.display = 'none';
        chatView.classList.add('hidden');
        closeMembersPanel();

        var commToggle = document.getElementById('communities-mobile-toggle');
        var friendToggle = document.getElementById('friends-mobile-toggle');
        if (commToggle) commToggle.style.display = '';
        if (friendToggle) friendToggle.style.display = '';

        if (!skipHistory && window.history && window.history.pushState && window.location.search.includes('group=')) {
            window.history.pushState(null, '', '/member/community');
        }
    }

    function memberBadge(text, cls) {
        var s = document.createElement('span');
        s.className = 'text-[9px] font-bold uppercase tracking-wide px-1.5 py-0.5 rounded-full ' + cls;
        s.textContent = text;
        return s;
    }

    function groupActionBtn(icon, title, handler) {
        var b = document.createElement('button');
        b.type = 'button';
        b.title = title;
        b.className = 'w-8 h-8 rounded-full hover:bg-slate-100 flex items-center justify-center transition-colors text-slate-500 hover:text-slate-800';
        b.innerHTML = '<span class="material-symbols-outlined text-[18px]">' + icon + '</span>';
        b.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            handler();
        });
        return b;
    }

    function groupAction(action, memberId) {
        fetch('/member/community/' + membersCurrentGroupId + '/members/' + memberId + '/' + action, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        })
            .then(function (r) { return r.ok ? r.json() : Promise.reject(); })
            .then(function () {
                var labels = {
                    'make-admin': 'Promoted to admin.',
                    'revoke-admin': 'Admin role removed.',
                    'remove': 'Member removed from the group.'
                };
                toast(labels[action] || 'Member updated.', { type: 'success' });
                openMembersPanel(membersCurrentGroupId);
            })
            .catch(function () { toast('Action failed. Please try again.', { type: 'error' }); });
    }

    function profileInfoRow(label, value) {
        var row = document.createElement('div');
        row.className = 'px-4 py-3 flex items-start gap-3';
        var l = document.createElement('div');
        l.className = 'w-24 shrink-0 text-[11px] font-semibold uppercase tracking-wide text-slate-400 pt-0.5';
        l.textContent = label;
        var v = document.createElement('div');
        v.className = 'text-[13px] text-slate-700 break-words';
        v.textContent = value;
        row.appendChild(l);
        row.appendChild(v);
        return row;
    }

    function friendAction(action) {
        if (!profileUserId) return;
        fetch('/member/friends/' + profileUserId + '/' + action, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        })
            .then(function (r) { return r.ok ? r.json() : Promise.reject(); })
            .then(function (data) { renderFriendActions(data.friend_status || 'none'); })
            .catch(function () { toast('Action failed. Please try again.', { type: 'error' }); });
    }

    function friendBtn(icon, title, cls, handler) {
        var b = document.createElement('button');
        b.type = 'button';
        b.title = title;
        b.className = 'inline-flex items-center gap-1.5 px-3.5 h-10 rounded-full text-[13px] font-semibold transition-all active:scale-95 ' + cls;
        b.innerHTML = '<span class="material-symbols-outlined text-[18px]">' + icon + '</span>' + escapeHtml(title);
        b.addEventListener('click', function (e) { e.preventDefault(); e.stopPropagation(); handler(); });
        return b;
    }

    function renderFriendActions(status) {
        profileFriendActions.innerHTML = '';
        if (!profileUserId || profileIsOwn) return;
        if (status === 'friends') {
            var tag = document.createElement('span');
            tag.className = 'inline-flex items-center gap-1.5 px-3.5 h-10 rounded-full bg-emerald-50 text-emerald-700 text-[13px] font-semibold';
            tag.innerHTML = '<span class="material-symbols-outlined text-[18px]">group</span>Friends';
            profileFriendActions.appendChild(tag);
        } else if (status === 'pending_sent') {
            profileFriendActions.appendChild(friendBtn('close', 'Cancel request', 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50', function () { friendAction('cancel'); }));
        } else if (status === 'pending_received') {
            profileFriendActions.appendChild(friendBtn('check', 'Accept', 'bg-[#4338ca] text-white shadow-sm hover:bg-[#3730a3]', function () { friendAction('accept'); }));
            profileFriendActions.appendChild(friendBtn('close', 'Decline', 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50', function () { friendAction('decline'); }));
        } else {
            profileFriendActions.appendChild(friendBtn('person_add', 'Add friend', 'bg-[#4338ca] text-white shadow-sm hover:bg-[#3730a3]', function () { friendAction('request'); }));
        }
    }

    function renderMemberProfile(p) {
        profileUserId = p.id;
        profileIsOwn = !!p.is_own;
        setGroupLogo(profileAvatar, profileAvatarFallback, p.avatar_url);
        profileName.textContent = p.name || 'Member';
        profileJoined.textContent = p.joined_at ? 'Joined ' + p.joined_at : '';
        profileBadges.innerHTML = '';
        if (p.is_creator) {
            profileBadges.appendChild(memberBadge('Creator', 'bg-indigo-100 text-indigo-700'));
        } else if (p.is_own) {
            profileBadges.appendChild(memberBadge('You', 'bg-emerald-100 text-emerald-700'));
        } else if (p.is_admin) {
            profileBadges.appendChild(memberBadge('Admin', 'bg-violet-100 text-violet-700'));
        }
        profileRows.innerHTML = '';
        [['Email', p.email], ['Job title', p.job_title], ['Company', p.company_name], ['Industry', p.industry], ['Country', p.country]]
            .forEach(function (e) {
                if (e[1]) profileRows.appendChild(profileInfoRow(e[0], e[1]));
            });
        membersListView.classList.add('hidden');
        membersProfileView.classList.remove('hidden');
        membersProfileBack.classList.remove('hidden');
        membersPanelTitle.textContent = 'Profile';
        renderFriendActions(p.friend_status || 'none');
    }

    function openMemberProfile(memberId) {
        fetch('/member/community/' + membersCurrentGroupId + '/members/' + memberId + '/profile', { headers: { 'Accept': 'application/json' } })
            .then(function (r) { return r.ok ? r.json() : Promise.reject(); })
            .then(function (data) {
                if (!(data && data.profile)) return;
                renderMemberProfile(data.profile);
            })
            .catch(function () { toast('Could not load profile.', { type: 'error' }); });
    }

    function showMembersList() {
        membersProfileView.classList.add('hidden');
        membersModerationView.classList.add('hidden');
        membersListView.classList.remove('hidden');
        membersProfileBack.classList.add('hidden');
        membersPanelTitle.textContent = 'Community';
        setActiveTab('community');
    }

    function setActiveTab(tab) {
        var isMod = tab === 'moderation';
        membersListView.classList.toggle('hidden', isMod);
        membersModerationView.classList.toggle('hidden', !isMod);
        membersTabCommunity.classList.toggle('bg-white', !isMod);
        membersTabCommunity.classList.toggle('shadow-sm', !isMod);
        membersTabCommunity.classList.toggle('text-slate-800', !isMod);
        membersTabCommunity.classList.toggle('text-slate-500', isMod);
        membersTabModeration.classList.toggle('bg-white', isMod);
        membersTabModeration.classList.toggle('shadow-sm', isMod);
        membersTabModeration.classList.toggle('text-slate-800', isMod);
        membersTabModeration.classList.toggle('text-slate-500', !isMod);
        if (isMod) loadReports();
    }

    function updateReportsBadge(count) {
        if (!membersModerationBadge) return;
        if (count > 0) {
            membersModerationBadge.textContent = count > 99 ? '99+' : String(count);
            membersModerationBadge.classList.remove('hidden');
        } else {
            membersModerationBadge.classList.add('hidden');
        }
    }

    function reportCard(r) {
        var card = document.createElement('div');
        card.className = 'rounded-xl border border-slate-200 overflow-hidden';

        var top = document.createElement('div');
        top.className = 'flex items-start gap-2 px-3 pt-3';
        var badge = document.createElement('span');
        badge.className = 'inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wide shrink-0 ' +
            (r.status === 'pending' ? 'bg-amber-50 text-amber-700' : (r.status === 'removed' ? 'bg-red-50 text-red-700' : 'bg-slate-100 text-slate-600'));
        badge.textContent = r.reason_label;
        var who = document.createElement('div');
        who.className = 'min-w-0 flex-1';
        var line = document.createElement('div');
        line.className = 'text-[12px] text-slate-700 truncate';
        line.textContent = r.reported_name;
        var meta = document.createElement('div');
        meta.className = 'text-[11px] text-slate-400 truncate';
        meta.textContent = 'Reported by ' + r.reporter_name + ' · ' + (r.created_at || '');
        who.appendChild(line);
        who.appendChild(meta);
        top.appendChild(badge);
        top.appendChild(who);
        card.appendChild(top);

        var quote = document.createElement('div');
        quote.className = 'mx-3 mt-2 px-3 py-2 rounded-lg bg-slate-50 border border-slate-100 text-[12px] text-slate-600 line-clamp-3';
        quote.textContent = r.message_snapshot || '(message unavailable)';
        card.appendChild(quote);

        if (r.details) {
            var det = document.createElement('div');
            det.className = 'mx-3 mt-1.5 px-3 py-2 rounded-lg bg-indigo-50/60 text-[11px] text-indigo-800';
            det.textContent = r.details;
            card.appendChild(det);
        }

        var foot = document.createElement('div');
        foot.className = 'flex items-center justify-end gap-2 px-3 py-2.5 mt-2';

        if (r.status === 'pending') {
            var dismiss = document.createElement('button');
            dismiss.type = 'button';
            dismiss.className = 'h-8 px-3 rounded-lg text-[12px] font-semibold bg-slate-100 hover:bg-slate-200 text-slate-600 transition-colors';
            dismiss.textContent = 'Dismiss';
            dismiss.addEventListener('click', function () { resolveReport(r, 'dismiss'); });
            foot.appendChild(dismiss);

            var remove = document.createElement('button');
            remove.type = 'button';
            remove.className = 'h-8 px-3 rounded-lg text-[12px] font-semibold bg-red-500 hover:bg-red-600 text-white transition-colors';
            remove.textContent = r.message_exists ? 'Remove message' : 'Mark resolved';
            remove.addEventListener('click', function () { resolveReport(r, 'remove'); });
            foot.appendChild(remove);
        } else {
            var done = document.createElement('span');
            done.className = 'text-[11px] text-slate-400';
            done.textContent = (r.status === 'removed' ? 'Message removed' : 'Dismissed') + (r.reviewed_at ? ' · ' + r.reviewed_at : '');
            foot.appendChild(done);
        }

        card.appendChild(foot);
        return card;
    }

    function resolveReport(r, action) {
        if (!membersCurrentGroupId) return;
        var verb = action === 'remove' ? 'remove the reported message' : 'dismiss this report';
        if (!confirm('Are you sure you want to ' + verb + '?')) return;

        fetch('/member/community/' + membersCurrentGroupId + '/reports/' + r.id + '/' + action, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        })
            .then(function (res) { return res.ok ? res.json() : Promise.reject(); })
            .then(function () {
                if (action === 'remove') removeMessagesByIds([r.message_id]);
                toast(
                    action === 'remove' ? 'Reported message removed.' : 'Report dismissed.',
                    { type: 'success' }
                );
                loadReports();
            })
            .catch(function () { toast('Could not update the report. Please try again.', { type: 'error' }); });
    }

    function loadReports() {
        if (!membersCurrentGroupId) return;
        var status = reportFilterValue || 'pending';
        reportsList.innerHTML = '<div class="text-center text-xs text-slate-400 py-10">Loading reports...</div>';

        fetch('/member/community/' + membersCurrentGroupId + '/reports?status=' + status, { headers: { 'Accept': 'application/json' } })
            .then(function (r) { return r.ok ? r.json() : Promise.reject(); })
            .then(function (data) {
                if (!data) return;
                updateReportsBadge(data.pending_count || 0);
                reportsList.innerHTML = '';
                if (!data.reports || !data.reports.length) {
                    reportsList.innerHTML = '<div class="text-center text-xs text-slate-400 py-10">' +
                        (status === 'pending' ? 'No pending reports. Nice and tidy.' : 'Nothing resolved yet.') + '</div>';
                    return;
                }
                data.reports.forEach(function (r) { reportsList.appendChild(reportCard(r)); });
            })
            .catch(function () {
                reportsList.innerHTML = '<div class="text-center text-xs text-slate-400 py-10">Could not load reports.</div>';
            });
    }

    function memberRow(m) {
        var row = document.createElement('div');
        row.className = 'flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-slate-100/70 transition-colors cursor-pointer';
        row.addEventListener('click', function () { openMemberProfile(m.id); });

        var avatar = document.createElement('div');
        avatar.className = 'w-10 h-10 rounded-full bg-indigo-50 border border-slate-200 overflow-hidden flex items-center justify-center shrink-0';
        var img = document.createElement('img');
        img.src = m.avatar_url || '';
        img.className = 'w-full h-full object-cover';
        img.alt = '';
        img.onerror = function () {
            avatar.innerHTML = '<span class="material-symbols-outlined text-indigo-400 text-[20px]">person</span>';
        };
        avatar.appendChild(img);

        var col = document.createElement('div');
        col.className = 'min-w-0 flex-1';
        var nameRow = document.createElement('div');
        nameRow.className = 'flex items-center gap-1.5 min-w-0';
        var name = document.createElement('span');
        name.className = 'text-[13px] font-semibold text-slate-800 truncate';
        name.textContent = m.name || 'Member';
        nameRow.appendChild(name);
        if (m.is_creator) {
            nameRow.appendChild(memberBadge('Creator', 'bg-indigo-100 text-indigo-700'));
        } else if (m.is_own) {
            nameRow.appendChild(memberBadge('You', 'bg-emerald-100 text-emerald-700'));
        } else if (m.is_admin) {
            nameRow.appendChild(memberBadge('Admin', 'bg-violet-100 text-violet-700'));
        } else if (m.role && m.role !== 'member') {
            nameRow.appendChild(memberBadge(m.role, 'bg-slate-100 text-slate-600'));
        }
        var joined = document.createElement('div');
        joined.className = 'text-[11px] text-slate-400 truncate';
        joined.textContent = m.joined_at ? 'Joined ' + m.joined_at : '';
        col.appendChild(nameRow);
        col.appendChild(joined);

        row.appendChild(avatar);
        row.appendChild(col);

        if (membersCanManage && !m.is_creator && !m.is_own) {
            var actions = document.createElement('div');
            actions.className = 'flex items-center gap-0.5 shrink-0';
            if (m.is_admin) {
                actions.appendChild(groupActionBtn('manage_accounts', 'Demote from admin', function () { groupAction('revoke-admin', m.id); }));
            } else {
                actions.appendChild(groupActionBtn('admin_panel_settings', 'Make admin', function () { groupAction('make-admin', m.id); }));
            }
            actions.appendChild(groupActionBtn('person_remove', 'Remove from group', function () {
                if (confirm('Remove ' + (m.name || 'this member') + ' from ' + membersCurrentGroupName + '?')) {
                    groupAction('remove', m.id);
                }
            }));
            row.appendChild(actions);
        }
        return row;
    }

    function setAdminToggle(on) {
        adminToggleOn = !!on;
        settingAdminToggle.style.backgroundColor = on ? '#4338ca' : '#cbd5e1';
        settingAdminKnob.style.transform = on ? 'translateX(20px)' : 'translateX(0)';
    }

    function renderSettings(s) {
        currentSettings = s || {};
        var show = membersCanManage;
        settingsBlock.classList.toggle('hidden', !show);
        if (!show) return;

        setAdminToggle(!!currentSettings.admin_only_messages);
        settingCooldownCount.value = currentSettings.message_cooldown_count || 0;
        settingCooldownMinutes.value = currentSettings.message_cooldown_minutes || 0;
        settingSavedHint.classList.add('hidden');
    }

    function saveSettings() {
        if (!membersCurrentGroupId) return;
        settingSave.disabled = true;
        fetch('/member/community/' + membersCurrentGroupId + '/settings', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                admin_only_messages: adminToggleOn ? 1 : 0,
                message_cooldown_count: parseInt(settingCooldownCount.value, 10) || 0,
                message_cooldown_minutes: parseInt(settingCooldownMinutes.value, 10) || 0
            })
        })
            .then(function (r) {
                return r.json().then(function (j) {
                    if (!r.ok) return Promise.reject(j);
                    return j;
                });
            })
            .then(function (data) {
                renderSettings(data.settings || {});
                if (data && data.settings) {
                    var entry = (window.__joinedGroups || []).find(function (g) { return String(g.id) === String(membersCurrentGroupId); });
                    if (entry) entry.admin_only_messages = !!data.settings.admin_only_messages;
                }
                updateComposer();
                settingSavedHint.classList.remove('hidden');
                setTimeout(function () { settingSavedHint.classList.add('hidden'); }, 3000);
            })
            .catch(function (j) {
                toast((j && (j.message || j.error)) || 'Could not save settings.', { type: 'error' });
            })
            .finally(function () {
                settingSave.disabled = false;
            });
    }

    function showChatError(text) {
        toast(text || 'Something went wrong.', { type: 'error' });
    }

    function formatCountdown(sec) {
        var s = Math.max(0, sec);
        var m = Math.floor(s / 60);
        var r = s % 60;
        return m + ':' + String(r).padStart(2, '0');
    }

    function renderCooldown(seconds) {
        chatCooldownTimerText.textContent = 'Slow down — wait ' + formatCountdown(seconds) + ' before sending again';
        chatCooldownTimer.classList.remove('hidden');
        chatInput.disabled = true;
        chatSendBtn.disabled = true;
    }

    function stopCooldown() {
        if (cooldownTimerInterval) { clearInterval(cooldownTimerInterval); cooldownTimerInterval = null; }
        cooldownActive = false;
        chatCooldownTimer.classList.add('hidden');
        chatInput.disabled = false;
        chatSendBtn.disabled = false;
    }

    function startCooldown(seconds) {
        if (cooldownTimerInterval) clearInterval(cooldownTimerInterval);
        cooldownActive = true;
        var remaining = Math.max(0, Math.floor(seconds));
        renderCooldown(remaining);
        cooldownTimerInterval = setInterval(function () {
            remaining--;
            if (remaining <= 0) {
                stopCooldown();
            } else {
                renderCooldown(remaining);
            }
        }, 1000);
    }

    function openMembersPanel(groupId) {
        var meta = (window.__joinedGroups || []).find(function (g) { return String(g.id) === String(groupId); });
        if (!meta) return;

        if (membersCloseTimer) { clearTimeout(membersCloseTimer); membersCloseTimer = null; }
        membersPanel.classList.remove('translate-x-full', 'invisible');
        showMembersList();

        membersCanManage = false;
        membersCurrentGroupId = groupId;
        membersCurrentGroupName = meta.name || 'Community Group';
        membersGroupName.textContent = meta.name || 'Community Group';
        membersGroupCount.textContent = 'Loading members...';
        membersCountPill.textContent = '';
        membersList.innerHTML = '';
        setGroupLogo(membersGroupLogo, membersGroupLogoFallback, meta.logo);
        if (meta.description) {
            membersGroupDescription.textContent = meta.description;
            membersGroupDescription.classList.remove('hidden');
        } else {
            membersGroupDescription.textContent = '';
            membersGroupDescription.classList.add('hidden');
        }
        settingsBlock.classList.add('hidden');
        reportFilterValue = 'pending';
        reportsList.innerHTML = '';
        updateReportsBadge(0);

        document.querySelectorAll('.reports-filter-btn').forEach(function (el) {
            var on = el.getAttribute('data-reports-filter') === 'pending';
            el.classList.toggle('bg-white', on);
            el.classList.toggle('shadow-sm', on);
            el.classList.toggle('text-slate-800', on);
            el.classList.toggle('text-slate-500', !on);
        });

        membersBackdrop.classList.remove('hidden');

        fetch('/member/community/' + groupId + '/members', { headers: { 'Accept': 'application/json' } })
            .then(function (r) { return r.ok ? r.json() : Promise.reject(); })
            .then(function (data) {
                if (!(data && data.members)) return;
                membersCanManage = !!data.can_manage;
                membersGroupCount.textContent = data.members.length + (data.members.length === 1 ? ' member' : ' members');
                membersCountPill.textContent = data.members.length + (data.members.length === 1 ? ' member' : ' members');
                membersList.innerHTML = '';
                data.members.forEach(function (m) { membersList.appendChild(memberRow(m)); });
                renderSettings(data.settings);
                membersTabs.classList.toggle('hidden', !membersCanManage);
                if (membersCanManage) updateReportsBadge(data.pending_reports || 0);
            })
            .catch(function () {
                membersGroupCount.textContent = 'Members unavailable';
                membersList.innerHTML = '<div class="text-center text-xs text-slate-400 py-10">Could not load members.</div>';
            });
    }

    function closeMembersPanel() {
        membersPanel.classList.add('translate-x-full');
        if (membersCloseTimer) clearTimeout(membersCloseTimer);
        membersCloseTimer = setTimeout(function () {
            membersPanel.classList.add('invisible');
            membersCloseTimer = null;
        }, 300);
        membersBackdrop.classList.add('hidden');
    }

    window.closeMembersPanel = closeMembersPanel;

    function sendMessage() {
        if (!activeChat || cooldownActive) return;
        var body = chatInput.value.trim();
        if (!body && !pendingImage) return;
        chatSendBtn.disabled = true;

        var fd = new FormData();
        if (body) fd.append('message', body);
        if (pendingImage) fd.append('image', pendingImage);
        if (replyToId) fd.append('reply_to_id', replyToId);

        fetch('/member/community/' + activeChat.id + '/messages', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: fd
        })
            .then(function (r) {
                return r.json().then(function (j) {
                    if (!r.ok) return Promise.reject(j);
                    return j;
                });
            })
            .then(function (data) {
                chatInput.value = '';
                clearPendingImage();
                cancelReply();
                if (data && data.message) {
                    renderMessages([data.message]);
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                }
            })
            .catch(function (j) {
                if (j && j.retry_after) {
                    startCooldown(j.retry_after);
                } else {
                    showChatError((j && (j.message || j.error)) || 'Message could not be sent.');
                }
            })
            .finally(function () {
                if (!cooldownActive) {
                    chatSendBtn.disabled = false;
                }
                chatInput.focus();
            });
    }

    window.communityRailClick = function (groupId) { openChat(groupId); };

    // Lets the notification bell stay quiet for a group the user is already
    // looking at, instead of toasting alongside the in-chat announce.
    // Visibility-aware: opening a private chat hides this panel without clearing
    // activeChat, and a hidden panel is not "on screen" for the user.
    window.communityActiveChatId = function () {
        if (!activeChat) return null;
        if (chatView.classList.contains('hidden') || chatView.style.display === 'none') return null;
        return activeChat.id;
    };

    // Deep link support: /member/community?group=12 opens that conversation.
    // openChat() already suppresses the first announce batch, so arriving here
    // from a notification does not fire a toast for the loaded history.
    (function openChatFromUrl() {
        var search = window.location.search;
        // A direct-message deep link owns the panel; don't open both.
        if (/[?&]dm=\d+/.test(search)) return;
        var match = /[?&]group=(\d+)/.exec(search);
        if (!match) return;
        var target = Number(match[1]);
        if (target) window.communityRailClick(target);
    })();

    window.addEventListener('popstate', function () {
        var search = window.location.search;
        if (/[?&]dm=\d+/.test(search)) return;
        var match = /[?&]group=(\d+)/.exec(search);
        if (!match) {
            if (activeChat) closeChat(true);
        } else {
            var target = Number(match[1]);
            if (!activeChat || activeChat.id !== target) {
                openChat(target, true);
            }
        }
    });

    chatBackBtn.addEventListener('click', closeChat);
    chatGroupInfo.addEventListener('click', function () {
        if (activeChat && !selectMode) openMembersPanel(activeChat.id);
    });
    chatSelectBtn.addEventListener('click', function () { setSelectMode(!selectMode); });
    chatSelectCancel.addEventListener('click', function () { setSelectMode(false); });
    chatSelectDelete.addEventListener('click', function () {
        deleteMessages(Object.keys(selectedIds).map(Number));
    });
    chatCtxDelete.addEventListener('click', function () {
        if (ctxMsgId != null) deleteMessages([ctxMsgId]);
        closeContextMenu();
    });
    chatCtxReply.addEventListener('click', function () {
        var m = ctxMessageData();
        closeContextMenu();
        if (m) startReply(m);
    });
    chatCtxReact.addEventListener('click', function (e) {
        e.stopPropagation();
        var m = ctxMessageData();
        // The menu hides before the picker measures, so keep its position.
        var rect = chatCtxMenu.getBoundingClientRect();
        closeContextMenu();
        if (m) openEmojiPicker(chatCtxReact, m, rect);
    });
    chatCtxPin.addEventListener('click', function () {
        var m = ctxMessageData();
        closeContextMenu();
        if (m) togglePin(m);
    });
    chatCtxReport.addEventListener('click', function () {
        var m = ctxMessageData();
        closeContextMenu();
        if (m && !m.is_own) openReportModal(m);
    });
    chatPinnedToggle.addEventListener('click', function () {
        pinnedExpanded = !pinnedExpanded;
        renderPinned(pinnedMessages);
    });
    chatReplyCancel.addEventListener('click', cancelReply);
    chatReportCancel.addEventListener('click', closeReportModal);
    chatReportSubmit.addEventListener('click', submitReport);
    chatReportModal.addEventListener('click', function (e) {
        if (e.target === chatReportModal) closeReportModal();
    });
    chatPollCancel.addEventListener('click', closePollModal);
    chatPollSubmit.addEventListener('click', submitPoll);
    chatPollAdd.addEventListener('click', function () {
        if (pollOptionCount >= 8) return;
        chatPollOptions.appendChild(pollOptionRow(''));
        pollOptionCount++;
        var inputs = chatPollOptions.querySelectorAll('.poll-option-input');
        if (inputs.length) inputs[inputs.length - 1].focus();
    });
    chatPollModal.addEventListener('click', function (e) {
        if (e.target === chatPollModal) closePollModal();
    });
    document.addEventListener('click', function (e) {
        if (chatCtxMenu.classList.contains('hidden')) return;
        if (chatCtxMenu.contains(e.target)) return;
        closeContextMenu();
    });
    document.addEventListener('click', function (e) {
        if (emojiPicker.classList.contains('hidden')) return;
        if (emojiPicker.contains(e.target)) return;
        closeEmojiPicker();
    });
    // The picker is viewport-positioned, so scrolling would detach it.
    chatMessages.addEventListener('scroll', closeEmojiPicker);
    window.addEventListener('resize', closeEmojiPicker);
    chatAttachBtn.addEventListener('click', function () { chatFileInput.click(); });
    chatPollBtn.addEventListener('click', function () { openPollModal(); });
    chatFileInput.addEventListener('change', function () {
        if (chatFileInput.files && chatFileInput.files[0]) setPendingImage(chatFileInput.files[0]);
        chatFileInput.value = '';
    });
    chatPreviewRemove.addEventListener('click', clearPendingImage);
    chatView.addEventListener('dragenter', function (e) {
        if (!hasFileDrag(e)) return;
        e.preventDefault();
        dragCounter++;
        chatDropOverlay.style.display = 'flex';
    });
    chatView.addEventListener('dragover', function (e) {
        if (hasFileDrag(e)) e.preventDefault();
    });
    chatView.addEventListener('dragleave', function (e) {
        if (!hasFileDrag(e)) return;
        dragCounter = Math.max(0, dragCounter - 1);
        if (dragCounter === 0) chatDropOverlay.style.display = 'none';
    });
    chatView.addEventListener('drop', function (e) {
        if (!hasFileDrag(e)) return;
        e.preventDefault();
        dragCounter = 0;
        chatDropOverlay.style.display = 'none';
        if (e.dataTransfer.files && e.dataTransfer.files[0]) setPendingImage(e.dataTransfer.files[0]);
    });
    settingAdminToggle.addEventListener('click', function () { setAdminToggle(!adminToggleOn); });
    settingSave.addEventListener('click', saveSettings);
    membersClose.addEventListener('click', closeMembersPanel);
    membersProfileBack.addEventListener('click', showMembersList);
    membersTabCommunity.addEventListener('click', function () { setActiveTab('community'); });
    membersTabModeration.addEventListener('click', function () { setActiveTab('moderation'); });
    document.querySelectorAll('.reports-filter-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            reportFilterValue = btn.getAttribute('data-reports-filter') || 'pending';
            document.querySelectorAll('.reports-filter-btn').forEach(function (el) {
                el.classList.toggle('bg-white', el === btn);
                el.classList.toggle('shadow-sm', el === btn);
                el.classList.toggle('text-slate-800', el === btn);
                el.classList.toggle('text-slate-500', el !== btn);
            });
            loadReports();
        });
    });
    membersBackdrop.addEventListener('click', closeMembersPanel);
    chatLightboxClose.addEventListener('click', closeLightbox);
    chatLightbox.addEventListener('click', function (e) {
        if (e.target === chatLightbox) closeLightbox();
    });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && !emojiPicker.classList.contains('hidden')) {
            closeEmojiPicker();
            return;
        }
        if (e.key === 'Escape' && chatLightbox.style.display === 'flex') {
            closeLightbox();
            return;
        }
        if (e.key === 'Escape' && !chatCtxMenu.classList.contains('hidden')) {
            closeContextMenu();
            return;
        }
        if (e.key === 'Escape' && selectMode) {
            setSelectMode(false);
            return;
        }
        if (e.key === 'Escape' && !chatPollModal.classList.contains('hidden')) {
            closePollModal();
            return;
        }
        if (e.key === 'Escape' && !chatReportModal.classList.contains('hidden')) {
            closeReportModal();
            return;
        }
        if (e.key === 'Escape' && !membersPanel.classList.contains('invisible')) closeMembersPanel();
    });
    chatForm.addEventListener('submit', function (e) {
        e.preventDefault();
        sendMessage();
    });
    chatInput.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && replyToId) {
            e.preventDefault();
            cancelReply();
        }
    });
})();
</script>