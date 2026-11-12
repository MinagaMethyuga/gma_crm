@php
    $friendMeta = ($friends ?? collect())->map(fn ($f) => [
        'id' => $f->id,
        'name' => $f->name,
        'avatar' => $f->avatarUrl(),
    ])->values();
@endphp
<div id="dm-chat-view" class="hidden fixed inset-0 z-50 md:absolute md:inset-x-0 md:bottom-0 md:top-20 md:z-30 h-[100dvh] md:h-auto flex flex-col bg-[#eef2f6]">
    <div class="shrink-0 bg-white border-b border-slate-200/70 px-3 sm:px-4 md:px-6 h-14 md:h-16 flex items-center gap-2 sm:gap-3 shadow-sm">
        <button id="dm-chat-back" class="w-10 h-10 flex items-center justify-center text-slate-500 hover:text-slate-800 -ml-1 sm:-ml-1.5 rounded-lg hover:bg-slate-100 transition-colors shrink-0" title="Close chat">
            <span class="material-symbols-outlined text-[22px]">arrow_back</span>
        </button>
        <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-indigo-50 border border-slate-200 overflow-hidden flex items-center justify-center shrink-0">
            <img id="dm-chat-avatar" class="w-full h-full object-cover hidden" alt="">
            <span id="dm-chat-avatar-fallback" class="material-symbols-outlined text-indigo-500 text-[20px] sm:text-[22px]">person</span>
        </div>
        <div class="min-w-0 flex-1">
            <div id="dm-chat-name" class="font-bold text-slate-900 text-[13px] sm:text-[14px] truncate leading-tight"></div>
            <div id="dm-chat-meta" class="text-[11px] text-slate-400 truncate flex items-center gap-1">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>Friend
            </div>
        </div>
        <button id="dm-chat-select-btn" class="w-10 h-10 flex items-center justify-center text-slate-500 hover:text-slate-800 rounded-lg hover:bg-slate-100 transition-colors shrink-0" title="Select messages">
            <span class="material-symbols-outlined text-[22px]">check_box</span>
        </button>
    </div>

    <div id="dm-chat-messages" class="flex-1 overflow-y-auto custom-scroll px-3 sm:px-6 md:px-8 py-3 sm:py-5"></div>

    <div id="dm-chat-drop-overlay" class="hidden absolute inset-0 z-40 bg-slate-900/35 backdrop-blur-[1px] items-center justify-center pointer-events-none">
        <div class="bg-white rounded-2xl px-7 py-5 shadow-2xl flex items-center gap-3 text-slate-700 font-bold text-[15px]">
            <span class="material-symbols-outlined text-indigo-500 text-[28px]">image</span>
            Drop image to attach
        </div>
    </div>
    <div id="dm-chat-select-bar" class="hidden shrink-0 bg-white border-t border-slate-200/70 px-3 md:px-6 py-3 flex items-center justify-between gap-3">
        <div class="flex items-center gap-2 max-w-3xl mx-auto w-full">
            <span class="material-symbols-outlined text-slate-400 text-[20px]">check_circle</span>
            <span id="dm-chat-select-count" class="text-[13px] font-semibold text-slate-700">No messages selected</span>
            <div class="flex-1"></div>
            <button id="dm-chat-select-cancel" class="h-9 px-3.5 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold text-[13px] transition-colors">Cancel</button>
            <button id="dm-chat-select-delete" class="h-9 px-3.5 rounded-full bg-red-500 hover:bg-red-600 text-white font-semibold text-[13px] transition-colors flex items-center gap-1.5 opacity-40 pointer-events-none">
                <span class="material-symbols-outlined text-[16px]">delete</span> Delete
            </button>
        </div>
    </div>
    <div id="dm-composer" class="shrink-0 bg-white border-t border-slate-200/70 p-2.5 sm:p-3 pb-[max(0.625rem,env(safe-area-inset-bottom))] md:px-6 md:py-4">
        <div id="dm-chat-send-error" class="hidden max-w-3xl mx-auto text-left text-[12px] text-red-600 font-medium mb-2 px-1"></div>
        <div id="dm-chat-preview" class="hidden max-w-3xl mx-auto mb-2">
            <div class="relative inline-block">
                <img id="dm-chat-preview-img" class="h-24 w-auto max-w-[180px] object-cover rounded-xl border border-slate-200 shadow-sm" alt="Attachment preview">
                <button type="button" id="dm-chat-preview-remove" class="absolute -top-2 -right-2 w-6 h-6 rounded-full bg-slate-900/75 hover:bg-slate-900 text-white flex items-center justify-center transition-colors" title="Remove image">
                    <span class="material-symbols-outlined text-[14px]">close</span>
                </button>
            </div>
        </div>
        <form id="dm-chat-form" class="flex items-center gap-1.5 sm:gap-2 max-w-3xl mx-auto">
            <button type="button" id="dm-chat-attach-btn" class="w-10 h-10 sm:w-11 sm:h-11 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-800 flex items-center justify-center transition-colors shrink-0" title="Attach image">
                <span class="material-symbols-outlined text-[20px]">add_photo_alternate</span>
            </button>
            <input id="dm-chat-input" type="text" autocomplete="off" placeholder="Type a message or a caption..." maxlength="2000"
                class="flex-1 h-10 sm:h-11 px-3.5 sm:px-4 rounded-full border border-slate-200 bg-slate-50 text-base sm:text-sm text-slate-800 placeholder:text-slate-400 focus:outline-none focus:border-indigo-400 focus:bg-white transition">
            <button type="submit" id="dm-send-btn" class="w-10 h-10 sm:w-11 sm:h-11 rounded-full bg-[#4338ca] hover:bg-[#3730a3] active:scale-95 transition-all text-white flex items-center justify-center shadow-sm shrink-0">
                <span class="material-symbols-outlined text-[20px]">send</span>
            </button>
        </form>
        <input id="dm-file-input" type="file" accept="image/jpeg,image/png,image/gif,image/webp" class="hidden">
    </div>
</div>

<div id="dm-lightbox" class="hidden fixed inset-0 z-50 bg-slate-950/80 backdrop-blur-sm items-center justify-center p-4 md:p-8">
    <button type="button" id="dm-lightbox-close" class="absolute top-4 right-4 w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-colors" title="Close">
        <span class="material-symbols-outlined text-[22px]">close</span>
    </button>
    <img id="dm-lightbox-img" class="max-h-full max-w-full object-contain rounded-lg shadow-2xl" alt="">
</div>

<div id="dm-ctx-menu" class="hidden fixed z-[70] w-44 bg-white rounded-xl shadow-2xl border border-slate-200/70 py-1.5">
    <button type="button" id="dm-ctx-react" class="w-full flex items-center gap-2.5 px-3.5 py-2 text-[13px] font-semibold text-slate-700 hover:bg-slate-50 transition-colors">
        <span class="material-symbols-outlined text-[17px]">mood</span> React
    </button>
    <button type="button" id="dm-ctx-delete" class="w-full flex items-center gap-2.5 px-3.5 py-2 text-[13px] font-semibold text-red-600 hover:bg-red-50 transition-colors">
        <span class="material-symbols-outlined text-[17px]">delete</span> Delete message
    </button>
</div>

<div id="dm-emoji-picker" class="hidden fixed z-[80] w-[272px] p-2 bg-white rounded-2xl shadow-2xl border border-slate-200/80">
    <div class="px-1.5 pb-1.5 pt-0.5 text-[10px] font-bold uppercase tracking-wide text-slate-400">React</div>
    <div id="dm-emoji-grid" class="grid grid-cols-8 gap-0.5"></div>
</div>

<script>
(function () {
    var chatView = document.getElementById('dm-chat-view');
    var chatMessages = document.getElementById('dm-chat-messages');
    var chatInput = document.getElementById('dm-chat-input');
    var chatForm = document.getElementById('dm-chat-form');
    var sendBtn = document.getElementById('dm-send-btn');
    var backBtn = document.getElementById('dm-chat-back');
    var chatName = document.getElementById('dm-chat-name');
    var chatAvatar = document.getElementById('dm-chat-avatar');
    var chatAvatarFallback = document.getElementById('dm-chat-avatar-fallback');
    var chatSendError = document.getElementById('dm-chat-send-error');
    var chatFileInput = document.getElementById('dm-file-input');
    var chatAttachBtn = document.getElementById('dm-chat-attach-btn');
    var chatPreview = document.getElementById('dm-chat-preview');
    var chatPreviewImg = document.getElementById('dm-chat-preview-img');
    var chatPreviewRemove = document.getElementById('dm-chat-preview-remove');
    var chatDropOverlay = document.getElementById('dm-chat-drop-overlay');
    var lightbox = document.getElementById('dm-lightbox');
    var lightboxImg = document.getElementById('dm-lightbox-img');
    var lightboxClose = document.getElementById('dm-lightbox-close');
    var selectBtn = document.getElementById('dm-chat-select-btn');
    var selectBar = document.getElementById('dm-chat-select-bar');
    var selectCount = document.getElementById('dm-chat-select-count');
    var selectCancel = document.getElementById('dm-chat-select-cancel');
    var selectDelete = document.getElementById('dm-chat-select-delete');
    var ctxMenu = document.getElementById('dm-ctx-menu');
    var ctxDelete = document.getElementById('dm-ctx-delete');
    var ctxReact = document.getElementById('dm-ctx-react');
    var emojiPicker = document.getElementById('dm-emoji-picker');
var emojiGrid = document.getElementById('dm-emoji-grid');
var emojiPickerMsg = null;
var emojiGridBuilt = false;
    var composerWrap = document.getElementById('dm-composer');
    var lightboxAnim = null;
    var lightboxImgAnim = null;

    if (!chatView) return;

    var csrfToken = (document.querySelector('meta[name="csrf-token"]') || {}).content || '';
    var activeChat = null;
    var lastMessageId = 0;
    var pollTimer = null;

    // Publish our public E2E key once so friends can wrap messages for us.
    if (window.ChatCrypto && window.ChatCrypto.supported()) {
        window.ChatCrypto.publishKey().catch(function () { /* offline or unsupported */ });
    }

    /* Encrypt the outgoing body for the active friend. Resolves null on any
     * failure so the caller can fall back to plaintext rather than block send. */
    function encryptIfPossible(body) {
        if (!body) return Promise.resolve(null);
        if (!activeChat || !window.ChatCrypto || !window.ChatCrypto.supported()) {
            return Promise.resolve(null);
        }
        return window.ChatCrypto.encryptFor(activeChat.id, body).catch(function () { return null; });
    }
    var pendingImage = null;
    var pendingImageUrl = null;
    var dragCounter = 0;
    var sendErrorTimer = null;
    var selectMode = false;
    var selectedIds = {};
    var ctxMsgId = null;

    window.__friendMeta = @json($friendMeta);

    function escapeHtml(str) {
        return String(str == null ? '' : str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }

    function setAvatar(img, fallback, url) {
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

    function showChatError(text) {
        if (sendErrorTimer) clearTimeout(sendErrorTimer);
        chatSendError.textContent = text || '';
        chatSendError.classList.remove('hidden');
        sendErrorTimer = setTimeout(function () {
            chatSendError.classList.add('hidden');
        }, 6000);
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

        lightboxImg.src = url;
        lightbox.style.display = 'flex';
        lightbox.style.opacity = '';
        lightboxImg.style.opacity = '0';
        lightboxImg.style.transform = 'scale(0.92)';

        var spring = 'cubic-bezier(0.22, 1, 0.36, 1)';
        lightboxAnim = lightbox.animate(
            [{ opacity: 0 }, { opacity: 1 }],
            { duration: 200, easing: 'ease-out', fill: 'forwards' }
        );
        lightboxImgAnim = lightboxImg.animate(
            [
                { transform: 'scale(0.92)', opacity: 0 },
                { transform: 'scale(1.02)', opacity: 1 }
            ],
            { duration: 340, easing: spring, fill: 'forwards' }
        );
        lightboxImgAnim.onfinish = function () {
            lightboxImgAnim = lightboxImg.animate(
                [
                    { transform: 'scale(1.02)' },
                    { transform: 'scale(1)' }
                ],
                { duration: 120, easing: spring, fill: 'forwards' }
            );
        };
    }

    function closeLightbox() {
        if (lightbox.style.display === 'none') return;
        if (lightboxAnim) lightboxAnim.cancel();
        if (lightboxImgAnim) lightboxImgAnim.cancel();

        var spring = 'cubic-bezier(0.22, 1, 0.36, 1)';
        lightboxImgAnim = lightboxImg.animate(
            [
                { transform: 'scale(1)', opacity: 1 },
                { transform: 'scale(0.92)', opacity: 0 }
            ],
            { duration: 200, easing: spring, fill: 'forwards' }
        );
        lightboxAnim = lightbox.animate(
            [{ opacity: 1 }, { opacity: 0 }],
            { duration: 160, easing: 'ease-in', fill: 'forwards' }
        );
        lightboxAnim.onfinish = function () {
            lightbox.style.display = 'none';
            lightboxImg.removeAttribute('src');
            lightboxImg.style.transform = '';
            lightboxImg.style.opacity = '';
        };
    }

    function closeContextMenu() {
        ctxMenu.classList.add('hidden');
        ctxMsgId = null;
    }

    function openContextMenu(e, msgId) {
        if (selectMode) return;
        ctxMsgId = msgId;
        var m = messageData(msgId);
        ctxReact.style.display = m ? '' : 'none';
        ctxDelete.style.display = m && m.is_own ? '' : 'none';
        ctxMenu.classList.remove('hidden');

        var clientX = e.clientX != null ? e.clientX : (e.touches && e.touches[0] ? e.touches[0].clientX : 20);
        var clientY = e.clientY != null ? e.clientY : (e.touches && e.touches[0] ? e.touches[0].clientY : 100);
        ctxMenu.style.left = Math.max(12, Math.min(clientX, window.innerWidth - 190)) + 'px';
        ctxMenu.style.top = Math.max(12, Math.min(clientY, window.innerHeight - 90)) + 'px';
    }

    function updateSelectBar() {
        var count = Object.keys(selectedIds).length;
        selectCount.textContent = count === 0
            ? 'No messages selected'
            : count + (count === 1 ? ' message' : ' messages') + ' selected';
        selectDelete.disabled = count === 0;
        selectDelete.classList.toggle('opacity-40', count === 0);
        selectDelete.classList.toggle('pointer-events-none', count === 0);
    }

    function clearSelection() {
        selectedIds = {};
        chatMessages.querySelectorAll('.msg-selected').forEach(function (el) { el.classList.remove('msg-selected'); });
        updateSelectBar();
    }

    function setSelectMode(on) {
        selectMode = on;
        selectBtn.querySelector('.material-symbols-outlined').textContent = on ? 'close' : 'check_box';
        selectBtn.title = on ? 'Exit selection' : 'Select messages';
        if (on) {
            if (composerWrap) composerWrap.style.display = 'none';
            updateSelectBar();
            selectBar.style.display = 'flex';
        } else {
            clearSelection();
            closeContextMenu();
            selectBar.style.display = 'none';
            if (composerWrap) composerWrap.style.display = '';
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
        ids.forEach(function (id) { idSet[String(id)] = true; });
        chatMessages.querySelectorAll('[data-msg-id]').forEach(function (el) {
            if (idSet[el.getAttribute('data-msg-id')]) el.remove();
        });
    }

    function deleteMessages(ids) {
        if (!activeChat || !ids.length) return;
        fetch('/member/friends/' + activeChat.id + '/messages/bulk-delete', {
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
            })
            .catch(function () { showChatError('Could not delete message(s). Please try again.'); });
    }

    /* ── Emoji reactions ─────────────────────────────────────────────────────
       The pill strip under a bubble doubles as the toggle, so a member can
       add or take back a reaction without opening the picker again. */

var reactionEmoji = @json(\App\Models\MessageReaction::EMOJI);

var messageStore = {};

function rememberMessage(m) {
        messageStore[m.id] = m;
    }

function messageData(msgId) {
        return messageStore[msgId] || null;
    }

function bubbleEl(msgId) {
        return chatMessages.querySelector('[data-msg-id="' + msgId + '"]');
    }

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
        fetch('/member/friends/' + activeChat.id + '/messages/' + m.id + '/reaction', {
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

function messageBubble(m) {
        rememberMessage(m);

        var wrap = document.createElement('div');
        var isOwn = !!m.is_own;
        wrap.className = 'group flex items-end gap-2.5 mb-3 px-1 w-full ' + (isOwn ? 'justify-end' : 'justify-start');
        wrap.dataset.msgId = m.id;

        var hasImage = !!m.image_url;
        var hasText = !!((m.message && String(m.message).trim()) || m.encrypted);
        var isMediaOnly = hasImage && !hasText;

        var bubble = document.createElement('div');
        bubble.className = 'w-fit max-w-full rounded-2xl text-[14px] leading-relaxed break-words transition-all duration-200 ' +
            (isMediaOnly ? 'p-2 ' : 'px-4 py-2.5 ') +
            (isOwn
                ? 'bg-[#4338ca] text-white rounded-br-xs shadow-[0_4px_14px_-4px_rgba(67,56,202,0.45)]'
                : 'bg-white text-slate-800 border border-slate-200/80 rounded-bl-xs shadow-sm');

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

        if (isMediaOnly) {
            bubble.appendChild(time);
        } else {
            var msgContent = document.createElement('div');
            msgContent.className = 'flex flex-wrap items-baseline justify-between gap-x-3 gap-y-1 min-w-0';

            var text = document.createElement('span');
            text.className = 'break-words whitespace-pre-wrap min-w-0 flex-1';
            text.textContent = m.encrypted ? 'Decrypting...' : (m.message || '');

            // E2E rows arrive as ciphertext the server cannot read. Decrypt
            // locally and swap the placeholder in once we have plaintext.
            if (m.encrypted && m.ciphertext && m.nonce && window.ChatCrypto) {
                var peerId = m.encrypted_peer_id;
                window.ChatCrypto.decryptFrom(peerId, m.ciphertext, m.nonce).then(function (plain) {
                    if (plain == null) {
                        text.textContent = 'Unable to decrypt this message';
                        text.classList.add('italic', 'opacity-70');
                    } else {
                        text.textContent = plain;
                        m.message = plain;
                    }
                });
            }

            msgContent.appendChild(text);
            msgContent.appendChild(time);
            bubble.appendChild(msgContent);
        }

        wrap.addEventListener('click', function (e) {
            if (selectMode) toggleSelect(m.id, wrap);
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

        var actions = document.createElement('div');
        actions.className = 'flex items-center gap-0.5 opacity-0 group-hover:opacity-100 transition-opacity shrink-0 mb-0.5';

        var reactBtn = document.createElement('button');
        reactBtn.type = 'button';
        reactBtn.title = 'React';
        reactBtn.setAttribute('aria-label', 'React to this message');
        reactBtn.className = 'w-6 h-6 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-800 flex items-center justify-center transition-colors';
        var reactIcon = document.createElement('span');
        reactIcon.className = 'material-symbols-outlined text-[13px]';
        reactIcon.textContent = 'mood';
        reactBtn.appendChild(reactIcon);
        reactBtn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            openEmojiPicker(reactBtn, m);
        });
        actions.appendChild(reactBtn);

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
        col.className = 'flex flex-col min-w-0 max-w-[85%] sm:max-w-[70%] md:max-w-[65%] ' + (isOwn ? 'items-end' : 'items-start');
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

    function renderMessages(messages) {
        if (!messages || !messages.length) return;
        var fresh = messages.filter(function (m) { return m.id > lastMessageId; });
        if (!fresh.length) return;
        var box = chatMessages;
        var stick = box.scrollHeight - box.scrollTop - box.clientHeight < 140;
        fresh.forEach(function (m) {
            rememberMessage(m);
            box.appendChild(messageBubble(m));
        });
        lastMessageId = fresh[fresh.length - 1].id;
        if (stick || fresh.some(function (m) { return m.is_own; })) {
            box.scrollTop = box.scrollHeight;
        }
    }

    function loadMessages() {
        if (!activeChat) return;
        fetch('/member/friends/' + activeChat.id + '/messages', { headers: { 'Accept': 'application/json' } })
            .then(function (r) { return r.ok ? r.json() : Promise.reject(); })
            .then(function (data) { renderMessages(data && data.messages); })
            .catch(function () {});
    }

    function openChat(friendId, skipHistory) {
        var meta = (window.__friendMeta || []).find(function (g) { return String(g.id) === String(friendId); });
        if (!meta) return;

        activeChat = { id: meta.id };
        lastMessageId = 0;
        messageStore = {};
        chatMessages.innerHTML = '';
        clearPendingImage();
        setSelectMode(false);
        closeContextMenu();
        closeEmojiPicker();

        chatName.textContent = meta.name || 'Friend';
        setAvatar(chatAvatar, chatAvatarFallback, meta.avatar);

        chatView.classList.remove('hidden');
        chatView.style.display = 'flex';

        var otherChat = document.getElementById('chat-view');
        if (otherChat) {
            otherChat.style.display = 'none';
            otherChat.classList.add('hidden');
            if (typeof window.closeMembersPanel === 'function') window.closeMembersPanel();
        }

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
            if (!cur.includes('dm=' + meta.id)) {
                if (window.history.pushState) window.history.pushState({ dm: meta.id }, '', '/member/community?dm=' + meta.id);
            } else if (window.history.replaceState) {
                window.history.replaceState({ dm: meta.id }, '', '/member/community?dm=' + meta.id);
            }
        }

        loadMessages();
        if (pollTimer) clearInterval(pollTimer);
        pollTimer = setInterval(loadMessages, 4000);
        setTimeout(function () { chatInput.focus(); }, 100);
    }

    function closeChat(skipHistory) {
        if (pollTimer) { clearInterval(pollTimer); pollTimer = null; }
        activeChat = null;
        lastMessageId = 0;
        messageStore = {};
        chatMessages.innerHTML = '';
        clearPendingImage();
        setSelectMode(false);
        closeContextMenu();
        closeEmojiPicker();
        chatView.style.display = 'none';
        chatView.classList.add('hidden');

        var commToggle = document.getElementById('communities-mobile-toggle');
        var friendToggle = document.getElementById('friends-mobile-toggle');
        if (commToggle) commToggle.style.display = '';
        if (friendToggle) friendToggle.style.display = '';

        if (!skipHistory && window.history && window.history.pushState && window.location.search.includes('dm=')) {
            window.history.pushState(null, '', '/member/community');
        }
    }

    function sendMessage() {
        if (!activeChat) return;
        var body = chatInput.value.trim();
        if (!body && !pendingImage) return;
        sendBtn.disabled = true;

        // Encrypt before hitting the network when we can, so the server only
        // ever sees ciphertext. Falls back to plaintext if WebCrypto or the
        // peer key is unavailable.
        encryptIfPossible(body).then(function (e2e) {
            var fd = new FormData();
            if (e2e) {
                fd.append('ciphertext', e2e.ciphertext);
                fd.append('nonce', e2e.nonce);
                fd.append('key_version', e2e.key_version);
            } else if (body) {
                fd.append('message', body);
            }
            if (pendingImage) fd.append('image', pendingImage);

            return fetch('/member/friends/' + activeChat.id + '/messages', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: fd
            });
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
                if (data && data.message) {
                    renderMessages([data.message]);
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                }
            })
            .catch(function (j) {
                showChatError((j && (j.message || j.error)) || 'Message could not be sent.');
            })
            .finally(function () {
                sendBtn.disabled = false;
                chatInput.focus();
            });
    }

    window.friendRailClick = function (friendId) { openChat(friendId); };

    // Lets the notification bell stay quiet for the DM the user is already
    // looking at, instead of toasting alongside the in-chat announce.
    // Visibility-aware: opening a community chat hides this panel without
    // clearing activeChat, and a hidden panel is not "on screen" for the user.
    window.dmActiveChatId = function () {
        if (!activeChat) return null;
        if (chatView.classList.contains('hidden') || chatView.style.display === 'none') return null;
        return activeChat.id;
    };

    // Deep link support: /member/community?dm=12 opens that private chat.
    // No guard against ?group= here on purpose: community-chat already stands
    // down when a dm= is present, so deferring in both directions would let
    // "?group=7&dm=21" open neither panel. This direction gives dm= priority.
    (function openDmFromUrl() {
        var match = /[?&]dm=(\d+)/.exec(window.location.search);
        if (!match) return;
        var target = Number(match[1]);
        if (target) window.friendRailClick(target);
    })();

    window.addEventListener('popstate', function () {
        var match = /[?&]dm=(\d+)/.exec(window.location.search);
        if (!match) {
            if (activeChat) closeChat(true);
        } else {
            var target = Number(match[1]);
            if (!activeChat || activeChat.id !== target) {
                openChat(target, true);
            }
        }
    });

    backBtn.addEventListener('click', closeChat);
    selectBtn.addEventListener('click', function () { setSelectMode(!selectMode); });
    selectCancel.addEventListener('click', function () { setSelectMode(false); });
    selectDelete.addEventListener('click', function () {
        deleteMessages(Object.keys(selectedIds).map(Number));
    });
    ctxDelete.addEventListener('click', function () {
        if (ctxMsgId != null) deleteMessages([ctxMsgId]);
        closeContextMenu();
    });
    ctxReact.addEventListener('click', function (e) {
        e.stopPropagation();
        var m = ctxMsgId != null ? messageData(ctxMsgId) : null;
        // The menu hides before the picker measures, so keep its position.
        var rect = ctxMenu.getBoundingClientRect();
        closeContextMenu();
        if (m) openEmojiPicker(ctxReact, m, rect);
    });
    document.addEventListener('click', function (e) {
        if (ctxMenu.classList.contains('hidden')) return;
        if (ctxMenu.contains(e.target)) return;
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
    lightboxClose.addEventListener('click', closeLightbox);
    lightbox.addEventListener('click', function (e) {
        if (e.target === lightbox) closeLightbox();
    });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && !emojiPicker.classList.contains('hidden')) {
            closeEmojiPicker();
            return;
        }
        if (e.key === 'Escape' && lightbox.style.display === 'flex') {
            closeLightbox();
            return;
        }
        if (e.key === 'Escape' && !ctxMenu.classList.contains('hidden')) {
            closeContextMenu();
            return;
        }
        if (e.key === 'Escape' && selectMode) {
            setSelectMode(false);
            return;
        }
    });
    chatForm.addEventListener('submit', function (e) {
        e.preventDefault();
        sendMessage();
    });
})();
</script>