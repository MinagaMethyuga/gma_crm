<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>GMA — {{ $document->title }}</title>
    <link rel="icon" href="/Global_Mobile_Association_Logo__1_-removebg-preview.png" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0,1&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        *, *::before, *::after { box-sizing: border-box; }
        html, body { margin: 0; padding: 0; height: 100%; overflow: hidden; font-family: 'Inter', sans-serif; }

        @media print {
            body * { display: none !important; visibility: hidden !important; }
            body::after {
                display: block !important;
                visibility: visible !important;
                content: 'This document is protected and cannot be printed.';
                font-size: 24px;
                text-align: center;
                margin-top: 40vh;
            }
        }

        * {
            -webkit-user-select: none !important;
            -moz-user-select:    none !important;
            -ms-user-select:     none !important;
            user-select:         none !important;
        }

        * { -webkit-user-drag: none !important; user-drag: none !important; }

        #viewer-container.blurred #viewer-overlay-blur { opacity: 1; }

        .viewer-shell {
            display: flex;
            flex-direction: column;
            height: 100vh;
            background: #0f172a;
        }

        .viewer-navbar {
            height: 56px;
            background: #1e293b;
            border-bottom: 1px solid rgba(255,255,255,0.06);
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 20px;
            flex-shrink: 0;
            z-index: 10;
        }
        .viewer-navbar .back-btn {
            display: flex; align-items: center; gap: 6px;
            padding: 6px 12px; border-radius: 10px;
            background: rgba(255,255,255,0.07);
            color: #94a3b8; font-size: 13px; font-weight: 500;
            text-decoration: none; transition: all 0.2s;
            border: 1px solid rgba(255,255,255,0.06);
        }
        .viewer-navbar .back-btn:hover { background: rgba(255,255,255,0.12); color: #e2e8f0; }
        .viewer-navbar .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        .doc-title-bar {
            flex: 1;
            display: flex; align-items: center; gap-x: 10px; gap-y: 0;
            overflow: hidden;
        }
        .doc-title-bar .type-pill {
            flex-shrink: 0;
            padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; letter-spacing: 0.04em;
            text-transform: uppercase;
        }
        .doc-title-bar .title-text {
            font-size: 14px; font-weight: 600; color: #e2e8f0;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }

        .protected-badge {
            display: flex; align-items: center; gap: 6px;
            padding: 5px 12px; border-radius: 20px;
            background: rgba(239,68,68,0.12); border: 1px solid rgba(239,68,68,0.2);
            color: #fca5a5; font-size: 11px; font-weight: 600;
            flex-shrink: 0;
        }

        #viewer-container {
            flex: 1;
            position: relative;
            overflow: hidden;
            background: #0f172a;
        }

        #doc-frame {
            width: 100%;
            height: 100%;
            border: none;
            display: block;
        }

        #capture-shield {
            position: absolute;
            inset: 0;
            z-index: 2;
            pointer-events: none;
            background: transparent;
        }

        #viewer-overlay-blur {
            position: absolute;
            inset: 0;
            z-index: 5;
            backdrop-filter: blur(18px) brightness(0.5);
            -webkit-backdrop-filter: blur(18px) brightness(0.5);
            background: rgba(15,23,42,0.6);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 12px;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }
        #viewer-overlay-blur.active {
            opacity: 1;
            pointer-events: auto;
        }
        #viewer-overlay-blur .lock-icon {
            width: 64px; height: 64px;
            border-radius: 20px;
            background: rgba(239,68,68,0.15);
            display: flex; align-items: center; justify-content: center;
        }
        #viewer-overlay-blur p { color: #94a3b8; font-size: 13px; font-weight: 500; margin: 0; text-align: center; }
        #viewer-overlay-blur h3 { color: #e2e8f0; font-size: 18px; font-weight: 700; margin: 0; }

        #watermark-layer {
            position: absolute;
            inset: 0;
            z-index: 3;
            pointer-events: none;
            overflow: hidden;
        }

        .status-bar {
            height: 32px;
            background: #1e293b;
            border-top: 1px solid rgba(255,255,255,0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            flex-shrink: 0;
        }
        .status-bar span { font-size: 11px; color: #475569; font-weight: 500; }
    </style>
</head>
<body>

<div class="viewer-shell">

    <!-- ─── Top Nav Bar ─────────────────────────────────────── -->
    <div class="viewer-navbar">
        <a href="{{ route('research-insights') }}" class="back-btn">
            <span class="material-symbols-outlined" style="font-size:16px;">arrow_back</span>
            Research &amp; Insights
        </a>

        <div class="doc-title-bar gap-x-2.5">
            <span class="type-pill bg-red-500/15 text-red-400" style="margin-right:8px;">PDF</span>
            <span class="title-text">{{ $document->title }}</span>
        </div>

        <div class="protected-badge">
            <span class="material-symbols-outlined" style="font-size:13px;">lock</span>
            Protected
        </div>
    </div>

    <!-- ─── Viewer Container ────────────────────────────────── -->
    <div id="viewer-container" style="flex:1; position:relative; overflow:hidden; display:flex; flex-direction:column;">

        <!-- PDF inline viewer -->
        <iframe id="doc-frame"
            src="{{ route('research-insights.stream', $document) }}#toolbar=0"
            style="flex:1; width:100%; border:none; display:block;">
        </iframe>

        <!-- Capture Shield (right-click blocker) -->
        <div id="capture-shield" oncontextmenu="return false;"></div>

        <!-- GMA Watermark -->
        <svg id="watermark-layer" xmlns="http://www.w3.org/2000/svg" width="100%" height="100%">
            <defs>
                <pattern id="wm-pattern" x="0" y="0" width="440" height="200" patternUnits="userSpaceOnUse" patternTransform="rotate(-30)">
                    <image href="/Global_Mobile_Association_Logo__1_-removebg-preview.png" x="8" y="10" width="44" height="44" opacity="0.45" preserveAspectRatio="xMidYMid meet"/>
                    <text x="62" y="32" font-family="Inter, sans-serif" font-size="16" fill="rgba(148,163,184,0.16)" font-weight="700">
                        GMA CONFIDENTIAL
                    </text>
                    <text x="62" y="52" font-family="Inter, sans-serif" font-size="11" fill="rgba(148,163,184,0.12)" font-weight="400">
                        Public Viewing · {{ now()->format('d M Y H:i') }}
                    </text>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#wm-pattern)"/>
        </svg>

        <!-- Blur overlay (focus lost) -->
        <div id="viewer-overlay-blur">
            <div class="lock-icon">
                <span class="material-symbols-outlined" style="font-size:32px;color:#f87171;font-variation-settings:'FILL' 1,'wght' 400,'GRAD' 0,'opsz' 48;">lock</span>
            </div>
            <h3>Document Paused</h3>
            <p>Click anywhere to resume viewing</p>
        </div>
    </div>

    <!-- ─── Status Bar ──────────────────────────────────────── -->
    <div class="status-bar">
        <span style="display:flex;align-items:center;gap:5px;">
            <span class="material-symbols-outlined" style="font-size:12px;">verified_user</span>
            Public document · Published by GMA
        </span>
        <span style="display:flex;align-items:center;gap:5px;">
            <span class="material-symbols-outlined" style="font-size:12px;color:#ef4444;">shield</span>
            Screen recording protected
        </span>
    </div>

</div><!-- /.viewer-shell -->

<script>
(function () {
    'use strict';

    document.addEventListener('contextmenu', function (e) { e.preventDefault(); return false; });

    document.addEventListener('keydown', function (e) {
        const key = e.key || '';
        const ctrl = e.ctrlKey || e.metaKey;

        if (key === 'PrintScreen' || key === 'F13') {
            e.preventDefault();
            showBlur(true);
            setTimeout(() => showBlur(false), 2000);
            return false;
        }

        if (ctrl && (key === 'p' || key === 'P' || key === 's' || key === 'S')) {
            e.preventDefault(); return false;
        }

        if ((ctrl && e.shiftKey && (key === 'i' || key === 'I' || key === 'j' || key === 'J')) || key === 'F12') {
            e.preventDefault(); return false;
        }
    });

    const blurEl = document.getElementById('viewer-overlay-blur');

    function showBlur(force) {
        if (force || !document.hasFocus()) blurEl.classList.add('active');
    }
    function hideBlur() { blurEl.classList.remove('active'); }

    window.addEventListener('blur', function () { showBlur(true); });
    window.addEventListener('focus', hideBlur);
    document.addEventListener('visibilitychange', function () {
        if (document.visibilityState === 'hidden') showBlur(true);
        else hideBlur();
    });
    blurEl.addEventListener('click', hideBlur);

    document.addEventListener('dragstart', function (e) { e.preventDefault(); return false; });
    document.addEventListener('drop', function (e) { e.preventDefault(); return false; });

    if (navigator.mediaDevices && navigator.mediaDevices.getDisplayMedia) {
        const originalGDM = navigator.mediaDevices.getDisplayMedia.bind(navigator.mediaDevices);
        navigator.mediaDevices.getDisplayMedia = function (constraints) {
            showBlur(true);
            return originalGDM(constraints);
        };
    }

    document.addEventListener('auxclick', function (e) {
        if (e.button === 1) { e.preventDefault(); return false; }
    });

    setInterval(function () {
        if (!document.hasFocus()) showBlur(true);
    }, 3000);

})();
</script>

</body>
</html>
