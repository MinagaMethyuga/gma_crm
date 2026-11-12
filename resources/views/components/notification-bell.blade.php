<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="relative notification-bell">
    <button id="notification-bell-btn" class="text-slate-400 hover:text-slate-600 transition-colors relative emil-btn" title="Notifications">
        <span class="material-symbols-outlined text-[22px]">notifications</span>
        <span id="notification-badge" class="hidden absolute -top-1.5 -right-1.5 min-w-[18px] h-[18px] px-1 rounded-full bg-red-500 text-white text-[10px] font-bold items-center justify-center">0</span>
    </button>

    <div id="notification-dropdown" class="hidden absolute right-0 top-full mt-2 w-80 md:w-96 bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">
<div class="flex items-center justify-between px-4 py-3 border-b border-slate-100">
            <div class="font-bold text-slate-900 text-[14px]">Notifications</div>
            <div class="flex items-center gap-1">
                <button id="notification-mark-read" class="inline-flex text-slate-400 hover:text-slate-600 p-1.5 rounded-lg hover:bg-slate-100 transition-colors items-center gap-1 text-[11px] font-semibold disabled:opacity-40 disabled:pointer-events-none" title="Mark all as read">
                    <span class="material-symbols-outlined text-[16px]">done_all</span>
                    Mark all read
                </button>
                <button id="notification-refresh" class="text-slate-400 hover:text-slate-600 p-1.5 rounded-lg hover:bg-slate-100 transition-colors" title="Refresh">
                    <span class="material-symbols-outlined text-[18px]">refresh</span>
                </button>
            </div>
        </div>
        <div id="notification-list" class="max-h-96 overflow-y-auto custom-scroll"></div>
    </div>
</div>

<script>
(function () {
    var btn = document.getElementById('notification-bell-btn');
    var dropdown = document.getElementById('notification-dropdown');
    var badge = document.getElementById('notification-badge');
    var list = document.getElementById('notification-list');
    var refreshBtn = document.getElementById('notification-refresh');
    var markReadBtn = document.getElementById('notification-mark-read');
    if (!btn) return;

    var csrfToken = (document.querySelector('meta[name="csrf-token"]') || {}).content || '';

    /* ── Message delivery toasts ─────────────────────────────────────────────
       Raised when a message actually lands, not when you click the row.
       The host is built in JS and appended to <body> so no header/overflow
       ancestor can clip it. */
    var NAV_TOAST_MS = 3000;
    var NAV_POLL_MS = 5000;
    var NAV_OVERLAP_MS = 1000;
    var NAV_SEEN_LIMIT = 300;
    var navToastHost = null;
    var navToastTimer = null;
    var latestSeenAt = null;
    var arrivalPrimed = false;
    var announcedIds = [];
    var arrivalPollFailures = 0;

    /* "Mark all read" empties the list, but the rows still exist server side as
       read history. Remembering where the user cleared to keeps them gone when
       the panel is reopened, while anything newer still shows up. */
    var CLEARED_KEY = 'notif-cleared-at';

    function clearedAt() {
        try {
            var raw = parseInt(window.sessionStorage.getItem(CLEARED_KEY), 10);
            return isNaN(raw) ? 0 : raw;
        } catch (e) {
            return 0;
        }
    }

    function markCleared() {
        var at = Date.now();
        try { window.sessionStorage.setItem(CLEARED_KEY, String(at)); } catch (e) {}
        return at;
    }

    function isCleared(n) {
        var cut = clearedAt();
        if (!cut || !n || !n.created_at) return false;
        var t = new Date(n.created_at).getTime();
        return !isNaN(t) && t <= cut;
    }

    function navToastHostEl() {
        if (navToastHost && navToastHost.isConnected) return navToastHost;
        navToastHost = document.createElement('div');
        navToastHost.id = 'nav-toast-host';
        navToastHost.className = 'fixed top-0 left-0 right-0 z-[95] flex justify-center pointer-events-none px-3 pt-3 sm:pt-5';
        document.body.appendChild(navToastHost);
        return navToastHost;
    }

    function navToastNode(payload) {
        var host = navToastHostEl();
        var icon = payload.icon || 'forum';
        var clickable = !!(payload.data && chatTarget(payload.data));

        var el = document.createElement('div');
        el.className = 'nt-toast flex items-center gap-3 rounded-2xl bg-white border border-slate-200 shadow-lg shadow-slate-900/10 py-2.5 pl-2.5 pr-3.5'
            + (clickable ? ' cursor-pointer hover:bg-slate-50' : '');
        el.setAttribute('role', 'status');
        el.setAttribute('aria-live', 'polite');

        /* The toast itself stays a status message so it is still announced. The
           click lives on an inner control, which keeps it keyboard reachable. */
        var hit = document.createElement(clickable ? 'button' : 'div');
        if (clickable) {
            hit.type = 'button';
            hit.className = 'w-full flex items-center gap-3 bg-transparent border-0 p-0 text-left rounded-xl cursor-pointer focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500/60';
            hit.setAttribute('title', followLabel(payload.data) || 'Open conversation');
            hit.addEventListener('click', function () {
                dismissNavToast();
                followNotification(payload.data, payload.notifId);
            });
        } else {
            hit.className = 'w-full flex items-center gap-3';
        }

        var av = document.createElement('div');
        av.className = 'w-9 h-9 rounded-full bg-indigo-50 border border-slate-200 overflow-hidden flex items-center justify-center shrink-0';
        if (payload.avatar) {
            var img = document.createElement('img');
            img.src = payload.avatar;
            img.className = 'w-full h-full object-cover';
            img.alt = '';
            img.onerror = function () {
                av.textContent = '';
                av.innerHTML = '<span class="material-symbols-outlined text-indigo-400 text-[18px]"></span>';
                av.firstChild.textContent = icon;
            };
            av.appendChild(img);
        } else {
            av.innerHTML = '<span class="material-symbols-outlined text-indigo-400 text-[18px]"></span>';
            av.firstChild.textContent = icon;
        }

        var body = document.createElement('div');
        body.className = 'min-w-0 flex-1';

        var top = document.createElement('div');
        top.className = 'text-[12.5px] font-semibold text-slate-900 leading-tight truncate';
        top.textContent = payload.name || 'Someone';
        if (payload.group) {
            var sep = document.createElement('span');
            sep.className = 'font-normal text-slate-400';
            sep.textContent = ' · ';
            top.appendChild(sep);
            var group = document.createElement('span');
            group.className = 'font-medium text-slate-500';
            group.textContent = payload.group;
            top.appendChild(group);
        }
        body.appendChild(top);

        if (payload.preview) {
            var prev = document.createElement('div');
            prev.className = 'text-[11.5px] text-slate-500 leading-snug mt-0.5 truncate';
            prev.textContent = '“' + payload.preview + '”';
            body.appendChild(prev);
        }

        var ic = document.createElement('span');
        ic.className = 'material-symbols-outlined text-indigo-400 text-[18px] shrink-0';
        ic.textContent = icon;
        ic.setAttribute('aria-hidden', 'true');

        hit.appendChild(av);
        hit.appendChild(body);
        hit.appendChild(ic);
        el.appendChild(hit);
        host.appendChild(el);
        return el;
    }

    function isToastableType(d) {
        return d && (d.type === 'group_message' || d.type === 'direct_message');
    }

    /* If that conversation is already on screen the chat's own announce logic
       has it covered, so stay quiet here. This also keeps the delivery toast and
       the in-chat toast from firing for the same message. */
    function conversationIsOpen(d) {
        try {
            if (d.type === 'group_message' && d.group_id && typeof window.communityActiveChatId === 'function') {
                return String(window.communityActiveChatId()) === String(d.group_id);
            }
            if (d.type === 'direct_message' && d.sender_id && typeof window.dmActiveChatId === 'function') {
                return String(window.dmActiveChatId()) === String(d.sender_id);
            }
        } catch (e) {}
        return false;
    }

    function announceArrival(n) {
        var d = (n && n.data) || {};
        if (!isToastableType(d)) return;
        if (n.read) return;                  // already dealt with elsewhere
        if (conversationIsOpen(d)) return;

        var target = chatTarget(d) || {};
        showNavToast({
            name: d.sender_name || 'Someone',
            avatar: d.sender_avatar || '',
            preview: d.preview || '',
            group: target.label || '',
            icon: target.icon || 'forum',
            // Carried so clicking the toast opens the same chat the row would.
            data: d,
            notifId: n.id
        });
    }

    function applyBadge(n) {
        badge.textContent = n > 9 ? '9+' : n;
        badge.classList.toggle('hidden', n === 0);
        if (n > 0) badge.classList.add('flex');
    }

    function rememberSeen(id) {
        if (announcedIds.indexOf(id) !== -1) return false;
        announcedIds.push(id);
        if (announcedIds.length > NAV_SEEN_LIMIT) announcedIds.shift();
        return true;
    }

    function noteSeenAt(res, items) {
        items.forEach(function (n) {
            if (n && n.created_at && (!latestSeenAt || n.created_at > latestSeenAt)) latestSeenAt = n.created_at;
        });

        // Only trust the server's newest row when this page came back empty.
        // Using it unconditionally would let one oddly formatted timestamp push
        // the cursor past messages that have not been announced yet.
        if (!items.length) {
            var at = res && res.latest_created_at;
            if (at && (!latestSeenAt || at > latestSeenAt)) latestSeenAt = at;
        }
    }

    /* Notifications can share a timestamp with the cursor (the column has no
       sub-second precision), so ask from a second earlier and drop the repeats
       by id. Otherwise a message sent in the same second as the previous poll
       would never be seen. */
    function arrivalUrl() {
        if (!latestSeenAt) return '/member/notifications';

        var from = new Date(latestSeenAt);
        if (isNaN(from.getTime())) { latestSeenAt = null; return '/member/notifications'; }

        // A cursor ahead of real time would hide every future message, so drop
        // it and re-prime from the full list instead of polling blind forever.
        if (from.getTime() > Date.now() + 60000) { latestSeenAt = null; return '/member/notifications'; }

        from.setTime(from.getTime() - NAV_OVERLAP_MS);
        return '/member/notifications?since=' + encodeURIComponent(from.toISOString());
    }

    /* Polls only what arrived since the last check, so a delivery is picked up
       within NAV_POLL_MS without re-sending the whole history. */
    function pollForArrivals() {
        http('GET', arrivalUrl())
            .then(function (res) {
                arrivalPollFailures = 0;

                var items = (res && res.notifications) || [];
                if (typeof res.unread_count === 'number') applyBadge(res.unread_count);

                var priming = !arrivalPrimed;
                arrivalPrimed = true;
                noteSeenAt(res, items);

                if (priming) {
                    // Baseline run: record what is already there so loading a
                    // page never fires a burst of toasts for the old backlog.
                    items.forEach(function (n) { rememberSeen(n.id); });
                    return;
                }

                items.forEach(function (n) {
                    if (!rememberSeen(n.id)) return;
                    announceArrival(n);
                });
            })
            .catch(function (err) {
                // Never swallow silently: a failing poll is exactly why the badge
                // can update while no toast appears.
                arrivalPollFailures++;
                if (arrivalPollFailures === 1 || arrivalPollFailures % 12 === 0) {
                    console.warn('[notifications] delivery poll failed (#' + arrivalPollFailures + '):',
                        err && err.message ? err.message : err);
                }
            });
    }

    function dismissNavToast() {
        if (navToastTimer) { clearTimeout(navToastTimer); navToastTimer = null; }
        if (navToastHost) {
            navToastHost.innerHTML = '';
            if (!navToastHost.children.length) navToastHost.remove();
            navToastHost = null;
        }
    }

    function showNavToast(payload) {
        var host = navToastHostEl();
        if (navToastTimer) { clearTimeout(navToastTimer); navToastTimer = null; }
        host.innerHTML = '';
        var el = navToastNode(payload);

        // Fades out 3s after it lands, per the notification-toast behaviour.
        navToastTimer = setTimeout(function () {
            el.classList.add('is-out');
            navToastTimer = setTimeout(function () {
                if (el.parentNode) el.parentNode.removeChild(el);
                if (host && !host.children.length) host.remove();
                navToastHost = null;
            }, 360);
        }, NAV_TOAST_MS);
    }

    function onCommunityPage() {
        return window.location.pathname.replace(/\/+$/, '') === '/member/community';
    }

    /* Maps a notification to the conversation it should open.
       group_message -> community panel (?group=), direct_message -> DM panel (?dm=).
       Returns null for anything that has no destination. */
    function chatTarget(d) {
        if (!d) return null;

        if (d.type === 'group_message') {
            return {
                id: d.group_id || null,
                // Notifications predating group_id still land on the community
                // page, just without a specific group selected.
                url: d.group_id
                    ? '/member/community?group=' + encodeURIComponent(d.group_id)
                    : '/member/community',
                opener: 'communityRailClick',
                label: d.group_name || '',
                icon: 'forum'
            };
        }

        if (d.type === 'direct_message') {
            return {
                id: d.sender_id || null,
                url: d.sender_id
                    ? '/member/community?dm=' + encodeURIComponent(d.sender_id)
                    : '/member/community',
                opener: 'friendRailClick',
                label: '',
                icon: 'chat'
            };
        }

        return null;
    }

    function followLabel(d) {
        if (d.type === 'group_message') return d.group_name ? 'Open ' + d.group_name : 'Open community chat';
        if (d.type === 'direct_message') return d.sender_name ? 'Open conversation with ' + d.sender_name : 'Open conversation';
        return '';
    }

    /* Clicking a row only navigates. The toast already fired when the message was
       delivered, so repeating it here would just be noise. */
    function followNotification(d, notifId) {
        var target = chatTarget(d);
        if (!target) return;

        if (notifId) http('POST', '/member/notifications/' + notifId + '/read').catch(function () {});
        dropdown.classList.add('hidden');
        updateBadge();

        // Already on the community page: open the right panel in place, no reload.
        if (target.id && onCommunityPage() && typeof window[target.opener] === 'function') {
            window[target.opener](target.id);
            loadList();
            return;
        }

        window.location.href = target.url;
    }

    function http(method, url, body) {
        return fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: body ? JSON.stringify(body) : undefined
        }).then(function (r) {
            if (r.ok) return r.json();

            // Carry the status so a failing poll is diagnosable instead of
            // silently disappearing into a rejected promise.
            return Promise.reject(new Error('HTTP ' + r.status + ' for ' + url));
        });
    }

    function relativeTime(iso) {
        if (!iso) return '';
        var t = new Date(iso);
        if (isNaN(t.getTime())) return '';
        var diff = (Date.now() - t.getTime()) / 1000;
        if (diff < 60) return 'just now';
        if (diff < 3600) return Math.floor(diff / 60) + 'm ago';
        if (diff < 86400) return Math.floor(diff / 3600) + 'h ago';
        if (diff < 604800) return Math.floor(diff / 86400) + 'd ago';
        return t.toLocaleDateString(undefined, { month: 'short', day: 'numeric' });
    }

    function escapeHtml(str) {
        return String(str == null ? '' : str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }

    function notifIcon(type) {
        if (type === 'group_message') return 'forum';
        if (type === 'direct_message') return 'chat';
        return 'person';
    }

    function updateBadge() {
        http('GET', '/member/notifications/unread-count').then(function (d) {
            applyBadge((d && d.count) || 0);
        }).catch(function () {});
    }

    function friendNotifAction(action, userId, notifId) {
        http('POST', '/member/friends/' + userId + '/' + action)
            .then(function () {
                if (notifId) http('POST', '/member/notifications/' + notifId + '/read').catch(function () {});
                loadList();
                updateBadge();
            })
            .catch(function () { alert('Action failed. Please try again.'); });
    }

    function render(items) {
        list.innerHTML = '';

        // Anything at or before the point the user cleared is dropped.
        var rows = (items || []).filter(function (n) { return !isCleared(n); });

        var hasUnread = rows.some(function (n) { return !n.read; });
        markReadBtn.disabled = !hasUnread;
        if (!rows.length) {
            list.innerHTML = '<div class="px-4 py-10 text-center text-slate-400 text-sm">No notifications</div>';
            return;
        }
        rows.forEach(function (n) {
            var d = n.data || {};
            var isGroupMessage = d.type === 'group_message';
            var isDirectMessage = d.type === 'direct_message';
            var isChatLink = isGroupMessage || isDirectMessage;
            var row = document.createElement('div');
            row.className = 'flex items-start gap-3 px-4 py-3 border-b border-slate-50'
                + (isChatLink ? ' cursor-pointer transition-colors hover:bg-indigo-50/60 focus:outline-none focus-visible:bg-indigo-50/70' : '')
                + (n.read ? '' : ' bg-indigo-50/40');

            var av = document.createElement('div');
            av.className = 'w-9 h-9 rounded-full bg-indigo-50 border border-slate-200 overflow-hidden flex items-center justify-center shrink-0';
            if (d.sender_avatar && d.type !== 'group_message') {
                var img = document.createElement('img');
                img.src = d.sender_avatar;
                img.className = 'w-full h-full object-cover';
                img.alt = '';
                img.onerror = function () { av.innerHTML = '<span class="material-symbols-outlined text-indigo-400 text-[18px]">' + notifIcon(d.type) + '</span>'; };
                av.appendChild(img);
            } else {
                av.innerHTML = '<span class="material-symbols-outlined text-indigo-400 text-[18px]">' + notifIcon(d.type) + '</span>';
            }

            var body = document.createElement('div');
            body.className = 'flex-1 min-w-0';
            var text = document.createElement('div');
            text.className = 'text-[12.5px] text-slate-700 leading-snug';
            text.innerHTML = '<strong>' + escapeHtml(d.sender_name || 'Someone') + '</strong> ' + escapeHtml(d.message || 'sent you a notification');

            if (d.preview) {
                var prev = document.createElement('div');
                prev.className = 'text-[11.5px] text-slate-400 mt-0.5 truncate';
                prev.textContent = '“' + d.preview + '”';
                text.appendChild(prev);
            }

            var tm = document.createElement('div');
            tm.className = 'text-[10px] text-slate-400 mt-0.5';
            tm.textContent = relativeTime(n.created_at);
            text.appendChild(tm);
            body.appendChild(text);

            if (d.type === 'friend_request' && !n.read) {
                var acts = document.createElement('div');
                acts.className = 'mt-1.5 flex items-center gap-2';
                var accept = document.createElement('button');
                accept.className = 'px-3 h-7 rounded-full bg-[#4338ca] hover:bg-[#3730a3] text-white text-[11px] font-semibold transition-colors';
                accept.textContent = 'Accept';
                accept.addEventListener('click', function (e) { e.stopPropagation(); friendNotifAction('accept', d.sender_id, n.id); });
                var decline = document.createElement('button');
                decline.className = 'px-3 h-7 rounded-full border border-slate-200 text-slate-500 hover:bg-slate-50 text-[11px] font-semibold transition-colors';
                decline.textContent = 'Decline';
                decline.addEventListener('click', function (e) { e.stopPropagation(); friendNotifAction('decline', d.sender_id, n.id); });
                acts.appendChild(accept);
                acts.appendChild(decline);
                body.appendChild(acts);
            }

            row.appendChild(av);
            row.appendChild(body);
            list.appendChild(row);

            if (isChatLink) {
                row.setAttribute('role', 'button');
                row.setAttribute('tabindex', '0');
                row.setAttribute('title', followLabel(d));
                row.addEventListener('click', function () { followNotification(d, n.id); });
                row.addEventListener('keydown', function (e) {
                    if (e.key === 'Enter' || e.key === ' ' || e.key === 'Spacebar') {
                        e.preventDefault();
                        followNotification(d, n.id);
                    }
                });
            }
        });
    }

    function loadList() {
        http('GET', '/member/notifications').then(function (d) {
            render((d && d.notifications) || []);
        }).catch(function () {
            list.innerHTML = '<div class="px-4 py-10 text-center text-slate-400 text-sm">Could not load notifications.</div>';
        });
    }

    btn.addEventListener('click', function () {
        var isOpen = !dropdown.classList.contains('hidden');
        dropdown.classList.toggle('hidden');
        if (!isOpen) loadList();
    });
    refreshBtn.addEventListener('click', function (e) {
        e.stopPropagation();
        loadList();
    });
    markReadBtn.addEventListener('click', function (e) {
        e.stopPropagation();
        http('POST', '/member/notifications/read-all')
            .then(function () {
                // Drop the rows as well as the badge, otherwise clearing only
                // ever changes the counter and the list looks untouched.
                markCleared();
                loadList();
                updateBadge();
            })
            .catch(function () { alert('Could not mark notifications as read.'); });
    });
    document.addEventListener('click', function (e) {
        if (!btn.contains(e.target)) dropdown.classList.add('hidden');
    });

    updateBadge();
    setInterval(updateBadge, 20000);

    // Delivery toasts. The first poll only records the current high-water mark,
    // so loading a page never toasts the existing backlog.
    pollForArrivals();
    setInterval(pollForArrivals, NAV_POLL_MS);
})();
</script>