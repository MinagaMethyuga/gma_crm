<div class="relative friend-requests" data-friend-requests>
    <button
        type="button"
        data-fr-btn
        class="text-slate-400 hover:text-slate-600 transition-colors relative emil-btn"
        title="Friend requests"
        aria-label="Friend requests"
    >
        <span class="material-symbols-outlined text-[22px]">person_add</span>
        <span
            data-fr-badge
            class="hidden absolute -top-1.5 -right-1.5 min-w-[18px] h-[18px] px-1 rounded-full bg-red-500 text-white text-[10px] font-bold items-center justify-center"
        >0</span>
    </button>
</div>

<div id="friend-requests-modal" class="fixed inset-0 z-[90] hidden" role="dialog" aria-modal="true" aria-labelledby="friend-requests-title">
    <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm" data-fr-overlay></div>

    <div class="fixed inset-0 flex items-center justify-center p-4" style="pointer-events: none;">
        <div class="bg-white rounded-2xl shadow-2xl w-full overflow-hidden flex flex-col" style="max-width: 460px; max-height: 85vh; pointer-events: auto;">
            <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100 shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-[#4338ca]/10 flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-[20px] text-[#4338ca]">person_add</span>
                    </div>
                    <h3 id="friend-requests-title" class="text-[15px] font-bold text-slate-900">Friend Requests</h3>
                </div>
                <div class="flex items-center gap-1">
                    <button type="button" data-fr-refresh class="text-slate-400 hover:text-slate-600 p-1.5 rounded-lg hover:bg-slate-100 transition-colors" title="Refresh">
                        <span class="material-symbols-outlined text-[18px]">refresh</span>
                    </button>
                    <button type="button" data-fr-close class="text-slate-400 hover:text-slate-600 p-1.5 rounded-lg hover:bg-slate-100 transition-colors" title="Close">
                        <span class="material-symbols-outlined text-[18px]">close</span>
                    </button>
                </div>
            </div>

            <div class="flex items-center gap-1 px-5 pt-3 shrink-0">
                <button type="button" data-fr-tab="incoming" class="fr-tab px-3 h-8 rounded-full text-[12px] font-semibold transition-colors bg-[#4338ca] text-white">Received</button>
                <button type="button" data-fr-tab="outgoing" class="fr-tab px-3 h-8 rounded-full text-[12px] font-semibold transition-colors bg-slate-100 text-slate-600">Sent</button>
            </div>

            <div data-fr-list class="flex-1 overflow-y-auto custom-scroll px-5 py-4 space-y-2 min-h-[180px]"></div>
        </div>
    </div>
</div>

<script>
(function () {
    if (window.__friendRequestsBound) return;
    window.__friendRequestsBound = true;

    const requestsUrl = @json(route('member.friends.requests'));
    const roots = document.querySelectorAll('[data-friend-requests]');
    if (!roots.length) return;

    const modal = document.getElementById('friend-requests-modal');
    const list = modal.querySelector('[data-fr-list]');
    const badge = document.querySelector('[data-fr-badge]');
    const tabs = modal.querySelectorAll('[data-fr-tab]');
    let activeTab = 'incoming';
    let cache = { incoming: [], outgoing: [] };

    function token() {
        return (document.querySelector('meta[name="csrf-token"]') || {}).content || '';
    }

    function escapeHtml(value) {
        return String(value == null ? '' : value)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function relativeTime(iso) {
        if (!iso) return '';
        var then = new Date(iso);
        if (isNaN(then.getTime())) return '';
        var diff = (Date.now() - then.getTime()) / 1000;
        if (diff < 60) return 'just now';
        if (diff < 3600) return Math.floor(diff / 60) + 'm ago';
        if (diff < 86400) return Math.floor(diff / 3600) + 'h ago';
        if (diff < 604800) return Math.floor(diff / 86400) + 'd ago';
        return then.toLocaleDateString(undefined, { month: 'short', day: 'numeric' });
    }

    function post(url) {
        return fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': token(),
            },
        });
    }

    function get() {
        return fetch(requestsUrl, {
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
        }).then(function (r) {
            if (!r.ok) throw new Error('failed');
            return r.json();
        });
    }

    function pill(label, icon, classes, handler) {
        var btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'shrink-0 inline-flex items-center gap-1 h-7 px-2.5 rounded-full text-[11px] font-semibold transition-colors ' + classes;
        btn.innerHTML = '<span class="material-symbols-outlined text-[14px]">' + icon + '</span>' + escapeHtml(label);
        btn.addEventListener('click', function () {
            btn.disabled = true;
            handler(btn);
        });
        return btn;
    }

    function row(item) {
        var user = item.user || {};
        var isIncoming = item.direction === 'incoming';

        var el = document.createElement('div');
        el.className = 'flex items-center gap-3 px-3 py-2.5 rounded-xl border border-slate-100 bg-white';

        el.innerHTML =
            '<div class="w-9 h-9 shrink-0 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center overflow-hidden border border-slate-100 text-[12px] font-bold">' +
                '<img src="' + escapeHtml(user.avatar_url) + '" alt="" class="w-full h-full object-cover">' +
            '</div>' +
            '<div class="flex-1 min-w-0">' +
                '<div class="font-semibold text-slate-800 text-[13px] truncate">' + escapeHtml(user.name || 'Unknown member') + '</div>' +
                '<div class="text-[11px] text-slate-400 truncate">' + escapeHtml(user.email || '') + '</div>' +
            '</div>';

        var meta = document.createElement('div');
        meta.className = 'text-[10px] text-slate-400 shrink-0';
        meta.textContent = relativeTime(item.sent_at);
        el.appendChild(meta);

        var actions = document.createElement('div');
        actions.className = 'flex items-center gap-1.5 shrink-0';
        el.appendChild(actions);

        if (isIncoming) {
            actions.appendChild(pill('Accept', 'check', 'bg-[#4338ca] text-white hover:bg-[#3730a3]', function (btn) {
                act(btn, user.id, 'accept');
            }));
            actions.appendChild(pill('Decline', 'close', 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50', function (btn) {
                act(btn, user.id, 'decline');
            }));
        } else {
            actions.appendChild(pill('Cancel', 'close', 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50', function (btn) {
                act(btn, user.id, 'cancel');
            }));
        }

        return el;
    }

    function act(button, userId, action) {
        post('/member/friends/' + userId + '/' + action)
            .then(function (r) {
                if (!r.ok) throw new Error('failed');
                return load();
            })
            .catch(function () {
                if (button) button.disabled = false;
                list.insertBefore(errorNote('That action could not be completed. Please try again.'), list.firstChild);
            });
    }

    function errorNote(message) {
        var note = document.createElement('div');
        note.className = 'px-3 py-2 rounded-xl bg-rose-50 text-rose-600 text-[12px]';
        note.textContent = message;
        return note;
    }

    function render() {
        var items = cache[activeTab] || [];
        list.innerHTML = '';

        if (!items.length) {
            list.innerHTML = activeTab === 'incoming'
                ? '<div class="py-12 flex flex-col items-center text-center"><span class="material-symbols-outlined text-slate-300 text-[36px]">person_search</span><p class="text-sm font-semibold text-slate-500 mt-2">No pending requests</p><p class="text-xs text-slate-400 mt-1">Use the Friends panel to search for people by name or email.</p></div>'
                : '<div class="py-12 flex flex-col items-center text-center"><span class="material-symbols-outlined text-slate-300 text-[36px]">outgoing_mail</span><p class="text-sm font-semibold text-slate-500 mt-2">No sent requests</p><p class="text-xs text-slate-400 mt-1">Requests you send will appear here until they are accepted.</p></div>';
            return;
        }

        items.forEach(function (item) {
            list.appendChild(row(item));
        });
    }

    function setTab(tab) {
        activeTab = tab;
        tabs.forEach(function (t) {
            var on = t.dataset.frTab === tab;
            t.className = 'fr-tab px-3 h-8 rounded-full text-[12px] font-semibold transition-colors ' +
                (on ? 'bg-[#4338ca] text-white' : 'bg-slate-100 text-slate-600');
        });
        render();
    }

    function updateBadge() {
        if (!badge) return;
        var n = (cache.incoming || []).length;
        badge.textContent = n > 9 ? '9+' : n;
        badge.classList.toggle('hidden', n === 0);
        if (n > 0) badge.classList.add('flex');
    }

    function load() {
        return get().then(function (data) {
            cache = {
                incoming: data.incoming || [],
                outgoing: data.outgoing || [],
            };
            updateBadge();
            render();
        }).catch(function () {
            if (modal && !modal.classList.contains('hidden')) {
                list.innerHTML = '';
                list.appendChild(errorNote('Could not load friend requests.'));
            }
            updateBadge();
        });
    }

    function open() {
        modal.classList.remove('hidden');
        render();
        load();
    }

    function close() {
        modal.classList.add('hidden');
    }

    roots.forEach(function (root) {
        root.querySelector('[data-fr-btn]').addEventListener('click', function (e) {
            e.stopPropagation();
            open();
        });
    });

    tabs.forEach(function (tab) {
        tab.addEventListener('click', function () {
            setTab(tab.dataset.frTab);
        });
    });

    modal.querySelector('[data-fr-close]').addEventListener('click', close);
    modal.querySelector('[data-fr-overlay]').addEventListener('click', close);
    modal.querySelector('[data-fr-refresh]').addEventListener('click', function () {
        load();
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) close();
    });

    load();
    setInterval(load, 30000);
})();
</script>
