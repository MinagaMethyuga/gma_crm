/*
 * Client-side end-to-end encryption for private messages.
 *
 * Design: each member owns an ECDH P-256 key pair. The public key is published
 * to the server (user_chat_keys); the private key never leaves the browser and
 * lives in localStorage. A sender derives a shared secret with the recipient's
 * public key, then encrypts with AES-GCM. The server only ever relays the
 * ciphertext and nonce, so it cannot read message bodies.
 *
 * Not a double-ratchet and no forward secrecy across messages: this is the
 * pragmatic "server never sees plaintext" layer. A future upgrade can swap the
 * derivation without touching the transport columns.
 */
(function () {
    'use strict';

    var STORAGE_KEY = 'gma_chat_privkey_v1';
    var PUBLIC_KEY_STORAGE = 'gma_chat_pubkey_v1';

    function toBase64(buf) {
        var bytes = new Uint8Array(buf);
        var binary = '';
        for (var i = 0; i < bytes.length; i++) binary += String.fromCharCode(bytes[i]);
        return btoa(binary);
    }

    function fromBase64(str) {
        var binary = atob(str);
        var bytes = new Uint8Array(binary.length);
        for (var i = 0; i < binary.length; i++) bytes[i] = binary.charCodeAt(i);
        return bytes;
    }

    function subtle() {
        return (window.crypto && window.crypto.subtle) || null;
    }

    function supported() {
        return !!subtle();
    }

    /* Load the stored private key, generating one on first use. Resolves to a
     * CryptoKey plus the exportable public key (base64 SPKI). */
    function ensureKeyPair() {
        if (!supported()) return Promise.reject(new Error('WebCrypto unavailable'));

        var stored = null;
        try { stored = localStorage.getItem(STORAGE_KEY); } catch (e) { stored = null; }

        if (stored) {
            return subtle().importKey(
                'jwk',
                JSON.parse(stored),
                { name: 'ECDH', namedCurve: 'P-256' },
                false,
                ['deriveKey', 'deriveBits']
            ).then(function (priv) {
                var pub = null;
                try { pub = localStorage.getItem(PUBLIC_KEY_STORAGE); } catch (e) { pub = null; }
                return { privateKey: priv, publicKeyB64: pub };
            });
        }

        return subtle().generateKey({ name: 'ECDH', namedCurve: 'P-256' }, true, ['deriveKey', 'deriveBits'])
            .then(function (pair) {
                return subtle().exportKey('jwk', pair.privateKey).then(function (jwk) {
                    try { localStorage.setItem(STORAGE_KEY, JSON.stringify(jwk)); } catch (e) { /* private mode */ }
                    return subtle().exportKey('spki', pair.publicKey);
                }).then(function (spki) {
                    var b64 = toBase64(spki);
                    try { localStorage.setItem(PUBLIC_KEY_STORAGE, b64); } catch (e) { /* private mode */ }
                    return { privateKey: pair.privateKey, publicKeyB64: b64 };
                });
            });
    }

    /* Publish our public key so friends can wrap messages for us. */
    function publishKey() {
        return ensureKeyPair().then(function (kp) {
            if (!kp.publicKeyB64) return null;
            return fetch('/member/chat/keys', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken()
                },
                body: JSON.stringify({ public_key: kp.publicKeyB64 })
            }).then(function (r) { return r.ok ? r.json() : null; });
        });
    }

    function csrfToken() {
        var meta = document.querySelector('meta[name="csrf-token"]');
        if (meta) return meta.getAttribute('content');
        return window.csrfToken || '';
    }

    function importPeerPublic(b64) {
        return subtle().importKey(
            'spki',
            fromBase64(b64),
            { name: 'ECDH', namedCurve: 'P-256' },
            false,
            []
        );
    }

    function deriveAesKey(privateKey, peerPublicKey) {
        return subtle().deriveKey(
            { name: 'ECDH', public: peerPublicKey },
            privateKey,
            { name: 'AES-GCM', length: 256 },
            false,
            ['encrypt', 'decrypt']
        );
    }

    /* Fetch a peer's published public key, or null if they have none yet. */
    function fetchPeerKey(userId) {
        return fetch('/member/chat/keys/' + userId, {
            headers: { 'Accept': 'application/json' }
        }).then(function (r) { return r.ok ? r.json() : null; })
          .then(function (j) { return j && j.public_key ? j : null; });
    }

    /* Encrypt plaintext for a friend. Resolves { ciphertext, nonce, key_version }
     * or null when the peer has no key (caller falls back to server-readable). */
    function encryptFor(userId, plaintext) {
        return fetchPeerKey(userId).then(function (peer) {
            if (!peer) return null;
            return ensureKeyPair().then(function (kp) {
                return importPeerPublic(peer.public_key).then(function (pub) {
                    return deriveAesKey(kp.privateKey, pub);
                }).then(function (aesKey) {
                    var nonce = window.crypto.getRandomValues(new Uint8Array(12));
                    return subtle().encrypt(
                        { name: 'AES-GCM', iv: nonce },
                        aesKey,
                        new TextEncoder().encode(plaintext)
                    ).then(function (cipherBuf) {
                        return {
                            ciphertext: toBase64(cipherBuf),
                            nonce: toBase64(nonce),
                            key_version: peer.key_version || 1
                        };
                    });
                });
            });
        });
    }

    /* Decrypt an incoming E2E row. Resolves the plaintext string, or null when
     * we cannot (no local key, wrong/rotated key, corrupt payload). */
    function decryptFrom(senderId, ciphertextB64, nonceB64) {
        var stored = null;
        try { stored = localStorage.getItem(STORAGE_KEY); } catch (e) { stored = null; }
        if (!stored) return Promise.resolve(null);

        return fetchPeerKey(senderId).then(function (peer) {
            if (!peer) return null;
            return ensureKeyPair().then(function (kp) {
                return importPeerPublic(peer.public_key).then(function (pub) {
                    return deriveAesKey(kp.privateKey, pub);
                }).then(function (aesKey) {
                    return subtle().decrypt(
                        { name: 'AES-GCM', iv: fromBase64(nonceB64) },
                        aesKey,
                        fromBase64(ciphertextB64)
                    ).then(function (plainBuf) {
                        return new TextDecoder().decode(plainBuf);
                    });
                });
            });
        }).catch(function () { return null; });
    }

    window.ChatCrypto = {
        supported: supported,
        ensureKeyPair: ensureKeyPair,
        publishKey: publishKey,
        encryptFor: encryptFor,
        decryptFrom: decryptFrom
    };
})();