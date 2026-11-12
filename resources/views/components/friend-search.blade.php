<!-- Friend search + friend requests (shared by desktop panel + mobile drawer) -->
<div class="friend-search shrink-0 px-3 pt-3 border-b border-slate-200/60 bg-[#fbfcfd]" data-friend-search>
    <div class="relative">
        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-[18px] pointer-events-none">search</span>
        <input
            type="text"
            data-friend-search-input
            autocomplete="off"
            spellcheck="false"
            placeholder="Search name or email"
            aria-label="Search members by name or email"
            class="w-full h-10 pl-9 pr-9 rounded-xl border border-slate-200 bg-white text-[13px] text-slate-800 placeholder:text-slate-400 focus:outline-none focus:ring-1 focus:ring-[#4338ca] focus:border-[#4338ca] transition-shadow"
        />
        <button
            type="button"
            data-friend-search-clear
            class="hidden absolute right-2.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-700 transition-colors"
            aria-label="Clear search"
        >
            <span class="material-symbols-outlined text-[16px]">close</span>
        </button>
    </div>

    <p data-friend-search-status class="hidden px-1 pt-2 text-[11px] text-slate-400"></p>

    <div data-friend-search-results class="hidden pt-2 pb-3 max-h-64 overflow-y-auto custom-scroll space-y-1"></div>
</div>

<script>
(function () {
    if (window.__friendSearchBound) return;
    window.__friendSearchBound = true;

    const searchUrl = @json(route('member.friends.search'));

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

    function actionButton(userId, icon, label, classes, handler) {
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'shrink-0 inline-flex items-center gap-1 h-7 px-2.5 rounded-full text-[11px] font-semibold transition-colors ' + classes;
        btn.innerHTML = '<span class="material-symbols-outlined text-[14px]">' + icon + '</span>' + escapeHtml(label);
        btn.addEventListener('click', handler);
        btn.dataset.userId = userId;
        return btn;
    }

    function rowFor(user, scope) {
        const row = document.createElement('div');
        row.className = 'flex items-center gap-2.5 px-2.5 py-2 rounded-xl border border-slate-100 bg-white';
        row.dataset.resultFor = user.id;

        row.innerHTML =
            '<div class="w-8 h-8 shrink-0 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center overflow-hidden border border-slate-100 text-[11px] font-bold">' +
                '<img src="' + escapeHtml(user.avatar_url) + '" alt="" class="w-full h-full object-cover">' +
            '</div>' +
            '<div class="flex-1 min-w-0">' +
                '<div class="font-semibold text-slate-800 text-[12px] truncate">' + escapeHtml(user.name) + '</div>' +
                '<div class="text-[11px] text-slate-400 truncate">' + escapeHtml(user.email) + '</div>' +
            '</div>';

        const actions = document.createElement('div');
        actions.className = 'flex items-center gap-1.5 shrink-0';
        row.appendChild(actions);

        renderActions(actions, user, scope);

        return row;
    }

    function renderActions(container, user, scope) {
        container.innerHTML = '';

        if (user.friend_status === 'friends') {
            const tag = document.createElement('span');
            tag.className = 'inline-flex items-center gap-1 h-7 px-2.5 rounded-full bg-emerald-50 text-emerald-700 text-[11px] font-semibold';
            tag.innerHTML = '<span class="material-symbols-outlined text-[14px]">group</span>Friends';
            container.appendChild(tag);
            return;
        }

        if (user.friend_status === 'pending_sent') {
            container.appendChild(actionButton(user.id, 'close', 'Cancel', 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50', function (e) {
                act(e.currentTarget, user, scope, 'cancel');
            }));
            return;
        }

        if (user.friend_status === 'pending_received') {
            container.appendChild(actionButton(user.id, 'check', 'Accept', 'bg-[#4338ca] text-white hover:bg-[#3730a3]', function (e) {
                act(e.currentTarget, user, scope, 'accept');
            }));
            container.appendChild(actionButton(user.id, 'close', 'Decline', 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50', function (e) {
                act(e.currentTarget, user, scope, 'decline');
            }));
            return;
        }

        container.appendChild(actionButton(user.id, 'person_add', 'Add', 'bg-[#4338ca] text-white hover:bg-[#3730a3]', function (e) {
            act(e.currentTarget, user, scope, 'request');
        }));
    }

    function act(button, user, scope, action) {
        if (button) button.disabled = true;

        post('/member/friends/' + user.id + '/' + action)
            .then(function (r) {
                if (!r.ok) throw new Error('failed');
                return r.json();
            })
            .then(function (data) {
                user.friend_status = data.friend_status || 'none';
                renderActions(button.parentNode, user, scope);
            })
            .catch(function () {
                if (button) button.disabled = false;
                setStatus(scope, 'That action could not be completed. Please try again.', true);
            });
    }

    function setStatus(scope, message, isError) {
        const el = scope.querySelector('[data-friend-search-status]');
        if (!el) return;
        el.textContent = message;
        el.classList.toggle('text-rose-500', !!isError);
        el.classList.toggle('text-slate-400', !isError);
        el.classList.toggle('hidden', !message);
    }

    document.querySelectorAll('[data-friend-search]').forEach(function (scope) {
        const input = scope.querySelector('[data-friend-search-input]');
        const results = scope.querySelector('[data-friend-search-results]');
        const clearBtn = scope.querySelector('[data-friend-search-clear]');
        let timer = null;
        let seq = 0;

        if (!input || !results) return;

        function reset() {
            results.classList.add('hidden');
            results.innerHTML = '';
            setStatus(scope, '', false);
        }

        function run() {
            const term = input.value.trim();
            clearBtn && clearBtn.classList.toggle('hidden', term.length === 0);

            if (term.length < 2) {
                reset();
                return;
            }

            const current = ++seq;
            setStatus(scope, 'Searching…', false);

            fetch(searchUrl + '?q=' + encodeURIComponent(term), {
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            })
                .then(function (r) {
                    if (!r.ok) throw new Error('failed');
                    return r.json();
                })
                .then(function (data) {
                    if (current !== seq) return;

                    results.innerHTML = '';

                    if (data.errors && data.errors.q) {
                        setStatus(scope, data.errors.q[0], true);
                        results.classList.add('hidden');
                        return;
                    }

                    if (!data.results.length) {
                        setStatus(scope, 'No members match “' + term + '”.', false);
                        results.classList.add('hidden');
                        return;
                    }
                    setStatus(scope, data.results.length + (data.results.length === 1 ? ' member found' : ' members found'), false);

                    data.results.forEach(function (user) {
                        results.appendChild(rowFor(user, scope));
                    });

                    results.classList.remove('hidden');
                })
                .catch(function () {
                    if (current !== seq) return;
                    results.classList.add('hidden');
                    results.innerHTML = '';
                    setStatus(scope, 'Search is unavailable right now.', true);
                });
        }

        input.addEventListener('input', function () {
            clearTimeout(timer);
            timer = setTimeout(run, 250);
        });

        input.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                input.value = '';
                clearTimeout(timer);
                reset();
                clearBtn && clearBtn.classList.add('hidden');
            }
        });

        clearBtn && clearBtn.addEventListener('click', function () {
            input.value = '';
            clearTimeout(timer);
            reset();
            clearBtn.classList.add('hidden');
            input.focus();
        });
    });
})();
</script>
