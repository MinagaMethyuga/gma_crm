<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>GMA - Discover Communities</title>
    <link rel="icon" href="/Global_Mobile_Association_Logo__1_-removebg-preview.png" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0,1&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @font-face {
            font-family: 'Material Symbols Outlined';
            font-style: normal;
            font-weight: 100 700;
            font-display: block;
            src: url(https://fonts.gstatic.com/s/materialsymbolsoutlined/v378/kJESBvYX7BgnkSrUwT8OhrdQw4oELdPIeeII9v6oDMzByHX9rA6RzaxHMO1W.woff2) format('woff2');
        }
        body { font-family: 'Inter', sans-serif; background-color: #f3f7fa; -webkit-tap-highlight-color: transparent; }
        .material-symbols-outlined {
            font-family: 'Material Symbols Outlined' !important;
            font-weight: normal;
            font-style: normal;
            font-size: 24px;
            line-height: 1;
            letter-spacing: normal;
            text-transform: none;
            display: inline-block;
            white-space: nowrap;
            word-wrap: normal;
            direction: ltr;
            -webkit-font-feature-settings: 'liga';
            font-feature-settings: 'liga';
            -webkit-font-smoothing: antialiased;
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .material-symbols-outlined.fill { font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        .custom-scroll::-webkit-scrollbar { width: 6px; }
        .custom-scroll::-webkit-scrollbar-track { background: transparent; }
        .custom-scroll::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 10px; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        /* Smooth Landing Page Entrance */
        .page-enter-progress {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2.5px;
            background: linear-gradient(90deg, #4338ca 0%, #6366f1 50%, #818cf8 100%);
            box-shadow: 0 0 10px rgba(99, 102, 241, 0.4);
            z-index: 50;
            transform-origin: 0% 50%;
            animation: pageProgressGlide 0.65s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            pointer-events: none;
        }
        @keyframes pageProgressGlide {
            0% { transform: scaleX(0); opacity: 1; }
            65% { transform: scaleX(0.88); opacity: 1; }
            95% { transform: scaleX(1); opacity: 1; }
            100% { transform: scaleX(1); opacity: 0; }
        }

        .landing-page-enter {
            animation: pageLandingFadeUp 0.52s cubic-bezier(0.16, 1, 0.3, 1) both;
            will-change: opacity, transform;
        }
        @keyframes pageLandingFadeUp {
            0% { opacity: 0; transform: translateY(14px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        .stagger-item {
            opacity: 0;
            transform: translateY(16px);
            animation: landingItemSlide 0.52s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            will-change: opacity, transform;
        }
        @keyframes landingItemSlide {
            0% { opacity: 0; transform: translateY(16px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        .group-card {
            transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.25s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.2s ease !important;
            position: relative;
            overflow: hidden;
        }
        .group-card:hover {
            transform: translateY(-4px) !important;
            box-shadow: 0 20px 40px -12px rgba(15, 23, 42, 0.12), 0 0 0 1px rgba(99, 102, 241, 0.15) !important;
        }

        .search-input { transition: all 0.2s ease; }
        .search-input:focus { box-shadow: 0 0 0 3px rgba(67, 56, 202, 0.12); }

        .filter-pill { transition: all 0.2s ease; cursor: pointer; }
        .filter-pill.active { background: #1a1a1a; color: #fff; }
        .filter-pill:not(.active):hover { background: #f1f5f9; }

        .topic-chip { transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1); cursor: pointer; }
        .topic-chip.active {
            background: var(--chip, #4338ca);
            color: #fff;
            border-color: var(--chip, #4338ca);
            box-shadow: 0 8px 18px -8px color-mix(in srgb, var(--chip, #4338ca) 70%, transparent);
        }
        .topic-chip:not(.active):hover { background: #eef2ff; border-color: #c7d2fe; color: #3730a3; }

        /* Horizontal popular rails */
        .discover-rail {
            display: flex;
            gap: 1rem;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            padding-bottom: 0.5rem;
            margin: 0 -0.25rem;
            padding-left: 0.25rem;
            padding-right: 0.25rem;
        }
        .discover-rail::-webkit-scrollbar { height: 6px; }
        .discover-rail::-webkit-scrollbar-track { background: transparent; }
        .discover-rail::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 10px; }
        .discover-rail > * { scroll-snap-align: start; flex: 0 0 auto; }

        .rank-badge {
            background: linear-gradient(135deg, #f59e0b, #f97316);
            box-shadow: 0 6px 14px -6px rgba(249, 115, 22, 0.8);
        }

        .live-dot { position: relative; }
        .live-dot::after {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 9999px;
            background: inherit;
            animation: livePulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        @keyframes livePulse {
            0% { transform: scale(1); opacity: 0.7; }
            70%, 100% { transform: scale(2.4); opacity: 0; }
        }

        /* Page Exit Transition */
        .page-exit-active {
            opacity: 0 !important;
            transform: translateY(-8px) scale(0.995) !important;
            transition: opacity 0.18s cubic-bezier(0.4, 0, 1, 1), transform 0.18s cubic-bezier(0.4, 0, 1, 1) !important;
            pointer-events: none;
        }

        /* ─── Create community modal ─────────────────────────────────────────── */
        .modal-scrim {
            animation: scrimFade 0.2s ease both;
            backdrop-filter: blur(6px);
        }
        @keyframes scrimFade {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .modal-panel {
            animation: modalPop 0.26s cubic-bezier(0.16, 1, 0.3, 1) both;
        }
        @keyframes modalPop {
            from { opacity: 0; transform: translateY(14px) scale(0.975); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* Field affordances: resting, hover, focus, error */
        .field {
            transition: border-color 0.16s ease, box-shadow 0.16s ease, background-color 0.16s ease;
        }
        .field:hover:not(:disabled) { border-color: #cbd5e1; }
        .field:focus {
            outline: none;
            border-color: #4338ca;
            box-shadow: 0 0 0 3px rgba(67, 56, 202, 0.14);
        }
        .field[aria-invalid="true"] { border-color: #fca5a5; background-color: #fffbfb; }
        .field[aria-invalid="true"]:focus {
            border-color: #ef4444;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.14);
        }

        /* Native select chevron replaced with a Material Symbol */
        .select-chevron {
            background-image: none;
            -webkit-appearance: none;
            appearance: none;
            padding-right: 2.5rem;
        }

        .dropzone {
            transition: border-color 0.18s ease, background-color 0.18s ease, box-shadow 0.18s ease;
        }
        .dropzone:hover,
        .dropzone:focus-within {
            border-color: #a5b4fc;
            background-color: #f5f7ff;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        .btn-press:active:not(:disabled) { transform: scale(0.985); }

        /* ─── Ambient page colour ─────────────────────────────────────────────
           Only applied once JS confirms the browser can animate, so the page
           never renders blank if scripting is unavailable. */
        .has-js .reveal { opacity: 0; transform: translateY(20px); }
        .has-js .reveal.is-in {
            opacity: 1;
            transform: none;
            transition: opacity 0.6s cubic-bezier(0.16, 1, 0.3, 1), transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
            transition-delay: var(--reveal-delay, 0ms);
        }

        .page-aurora {
            position: absolute;
            inset: 0;
            overflow: hidden;
            pointer-events: none;
            z-index: 0;
        }
        .page-aurora span {
            position: absolute;
            border-radius: 9999px;
            filter: blur(90px);
            opacity: 0.55;
        }
        .aurora-1 { width: 34rem; height: 34rem; top: -10rem; right: -8rem; background: radial-gradient(circle, rgba(99,102,241,0.30), transparent 70%); animation: auroraDrift 26s ease-in-out infinite; }
        .aurora-2 { width: 28rem; height: 28rem; top: 22rem; left: -10rem; background: radial-gradient(circle, rgba(56,189,248,0.22), transparent 70%); animation: auroraDrift 32s ease-in-out infinite reverse; }
        .aurora-3 { width: 26rem; height: 26rem; top: 62rem; right: 4rem; background: radial-gradient(circle, rgba(244,114,182,0.18), transparent 70%); animation: auroraDrift 38s ease-in-out infinite; }
        @keyframes auroraDrift {
            0%, 100% { transform: translate3d(0, 0, 0) scale(1); }
            33% { transform: translate3d(2.5rem, 2rem, 0) scale(1.08); }
            66% { transform: translate3d(-2rem, -1.5rem, 0) scale(0.95); }
        }

        /* ─── Hero ──────────────────────────────────────────────────────── */
        .hero-surface {
            background: linear-gradient(135deg, #1e1b4b 0%, #312e81 32%, #4338ca 58%, #6d28d9 100%);
            background-size: 220% 220%;
            animation: heroDrift 18s ease-in-out infinite;
        }
        @keyframes heroDrift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        .hero-sheen {
            position: absolute;
            top: -50%;
            bottom: -50%;
            width: 45%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.13), transparent);
            transform: skewX(-18deg);
            animation: heroSheen 9s ease-in-out infinite;
            pointer-events: none;
        }
        @keyframes heroSheen {
            0%, 62% { left: -60%; }
            100% { left: 130%; }
        }

        .stat-tile {
            transition: transform 0.22s cubic-bezier(0.16, 1, 0.3, 1), background-color 0.22s ease, border-color 0.22s ease;
        }
        .stat-tile:hover {
            transform: translateY(-3px);
            background-color: rgba(255, 255, 255, 0.16);
            border-color: rgba(255, 255, 255, 0.3);
        }

        .cta-glow {
            transition: transform 0.22s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.22s ease;
            box-shadow: 0 10px 30px -8px rgba(0, 0, 0, 0.45);
        }
        .cta-glow:hover {
            transform: translateY(-2px);
            box-shadow: 0 18px 40px -10px rgba(0, 0, 0, 0.5);
        }

        /* ─── Section accent ─────────────────────────────────────────────── */
        .section-accent {
            height: 4px;
            width: 34px;
            border-radius: 9999px;
            margin-bottom: 10px;
            transform-origin: left center;
            transition: width 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .reveal.is-in .section-accent, section:hover > div > .section-accent { width: 56px; }

        /* ─── Cards ──────────────────────────────────────────────────────── */
        .card-accent {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            opacity: 0;
            transition: opacity 0.24s ease;
        }
        .group-card { position: relative; overflow: hidden; }
        .group-card:hover .card-accent { opacity: 1; }

        .avatar-tile {
            transition: transform 0.24s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.24s ease;
        }
        .group-card:hover .avatar-tile {
            transform: scale(1.06) rotate(-2deg);
            box-shadow: 0 8px 18px -8px rgba(15, 23, 42, 0.3);
        }

        .rank-badge { animation: rankPop 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) both; }
        @keyframes rankPop {
            from { opacity: 0; transform: scale(0.4) rotate(-25deg); }
            to { opacity: 1; transform: scale(1) rotate(0); }
        }

        .rail-btn { transition: transform 0.18s ease, background-color 0.18s ease, color 0.18s ease; }
        .rail-btn:hover { transform: translateY(-1px); }

        @media (prefers-reduced-motion: reduce) {
            .modal-scrim, .modal-panel { animation: none !important; }
            .stagger-item, .landing-page-enter, .page-enter-progress, .live-dot::after { animation: none !important; }
            .group-card, .field, .dropzone, .topic-chip, .filter-pill { transition: none !important; }
            .group-card:hover { transform: none !important; }
            .hero-surface, .hero-sheen, .page-aurora span, .rank-badge { animation: none !important; }
            .has-js .reveal { opacity: 1 !important; transform: none !important; }
            .stat-tile:hover, .cta-glow:hover, .group-card:hover .avatar-tile, .rail-btn:hover { transform: none !important; }
        }
    </style>
    <script>document.documentElement.classList.add('has-js');</script>
</head>
<body class="overflow-hidden text-slate-800">

@php
    use App\Models\CommunityGroup;

    $faces = $memberFaces ?? [];
    $totalMembers = $groups->sum('members_count');

    // Per-category accent colours, used for chips, tiles and card strips.
    $categoryAccents = [
        'general' => ['from-indigo-400 to-indigo-600', 'text-indigo-600', 'bg-indigo-50', 'text-indigo-700', 'border-indigo-100', 'bg-indigo-500'],
        'networking' => ['from-rose-400 to-rose-600', 'text-rose-600', 'bg-rose-50', 'text-rose-700', 'border-rose-100', 'bg-rose-500'],
        'startups' => ['from-orange-400 to-orange-600', 'text-orange-600', 'bg-orange-50', 'text-orange-700', 'border-orange-100', 'bg-orange-500'],
        'technology' => ['from-sky-400 to-sky-600', 'text-sky-600', 'bg-sky-50', 'text-sky-700', 'border-sky-100', 'bg-sky-500'],
        'marketing' => ['from-fuchsia-400 to-fuchsia-600', 'text-fuchsia-600', 'bg-fuchsia-50', 'text-fuchsia-700', 'border-fuchsia-100', 'bg-fuchsia-500'],
        'investments' => ['from-emerald-400 to-emerald-600', 'text-emerald-600', 'bg-emerald-50', 'text-emerald-700', 'border-emerald-100', 'bg-emerald-500'],
        'events' => ['from-violet-400 to-violet-600', 'text-violet-600', 'bg-violet-50', 'text-violet-700', 'border-violet-100', 'bg-violet-500'],
        'partners' => ['from-teal-400 to-teal-600', 'text-teal-600', 'bg-teal-50', 'text-teal-700', 'border-teal-100', 'bg-teal-500'],
        'support' => ['from-amber-400 to-amber-600', 'text-amber-600', 'bg-amber-50', 'text-amber-700', 'border-amber-100', 'bg-amber-500'],
    ];
    $defaultAccent = $categoryAccents['general'];

    $categoryHex = [
        'general' => '#6366f1',
        'networking' => '#f43f5e',
        'startups' => '#f97316',
        'technology' => '#0ea5e9',
        'marketing' => '#d946ef',
        'investments' => '#10b981',
        'events' => '#8b5cf6',
        'partners' => '#14b8a6',
        'support' => '#f59e0b',
    ];
@endphp

<div class="flex h-screen h-[100dvh] w-full overflow-hidden">
    @include('components.member-sidebar', ['active' => 'community'])
    @include('components.community-rail', ['joinedGroups' => $joinedGroups ?? collect()])
    @include('components.friend-rail', ['friends' => $friends ?? collect()])

    <main class="flex-1 flex flex-col min-w-0 relative h-full">
        <div class="absolute inset-0 bg-[#f6f8fc]"></div>
        <div class="page-aurora" aria-hidden="true">
            <span class="aurora-1"></span>
            <span class="aurora-2"></span>
            <span class="aurora-3"></span>
        </div>
        <div class="page-enter-progress"></div>
        @include('components.admin-header')

        <div class="relative z-10 flex-1 overflow-y-auto custom-scroll p-4 sm:p-6 md:p-8 landing-page-enter">
            <div class="max-w-7xl 2xl:max-w-[1600px] mx-auto flex flex-col gap-6 sm:gap-8 pt-10 md:pt-0">

                <!-- ═══ Discover Hero ═══ -->
                <div class="reveal hero-surface rounded-2xl sm:rounded-3xl p-5 sm:p-8 md:p-10 text-white relative overflow-hidden shadow-2xl shadow-indigo-900/20" style="--reveal-delay: 0ms;">
                    <div class="absolute -top-24 -right-16 w-72 h-72 bg-fuchsia-500/25 rounded-full blur-3xl pointer-events-none"></div>
                    <div class="absolute -bottom-28 left-24 w-72 h-72 bg-sky-400/20 rounded-full blur-3xl pointer-events-none"></div>
                    <div class="hero-sheen"></div>

                    <div class="relative z-10 flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6 sm:gap-8">

                        {{-- Left column --}}
                        <div class="flex-1 min-w-0 flex flex-col">
                            <div class="flex items-center gap-2 flex-wrap mb-4 sm:mb-5">
                                <div class="inline-flex items-center gap-1.5 sm:gap-2 px-2.5 sm:px-3 py-1 sm:py-1.5 rounded-full bg-white/15 border border-white/25 backdrop-blur-sm">
                                    <span class="material-symbols-outlined text-[15px] sm:text-[16px] text-indigo-200">explore</span>
                                    <span class="text-[10px] sm:text-[11px] font-semibold uppercase tracking-[0.12em] sm:tracking-[0.15em] text-white/90">Community Discovery</span>
                                </div>
                                <button type="button" onclick="startCommunityTour(true)" class="inline-flex items-center gap-1.5 px-2.5 sm:px-3 py-1 sm:py-1.5 rounded-full bg-white/15 hover:bg-white/25 border border-white/25 backdrop-blur-sm text-white text-[10px] sm:text-[11px] font-semibold transition-colors cursor-pointer" title="Replay Community Tour">
                                    <span class="material-symbols-outlined text-[14px] sm:text-[15px] text-amber-300">help</span>
                                    Community Guide
                                </button>
                            </div>
                            <h1 class="text-2xl sm:text-4xl font-extrabold tracking-tight mb-2 sm:mb-3 leading-tight">Find your people</h1>
                            <p class="text-white/70 text-xs sm:text-sm leading-relaxed max-w-md mb-4 sm:mb-6">
                                Browse the {{ $publicCount }} open {{ Str::plural('community', $publicCount) }} on GMA, ranked by real member
                                count and conversation activity. Join the ones that are buzzing.
                            </p>

                            <div class="relative max-w-md">
                                <span class="material-symbols-outlined absolute left-3.5 sm:left-4 top-1/2 -translate-y-1/2 text-white/50 text-[18px] sm:text-[20px]">search</span>
                                <input type="text" id="hero-search-input" placeholder="Search communities, topics or keywords..."
                                    class="search-input w-full h-11 sm:h-12 pl-10 sm:pl-12 pr-4 rounded-xl sm:rounded-2xl bg-white/15 border border-white/25 text-white text-base sm:text-sm placeholder-white/50 focus:outline-none focus:bg-white/25 focus:border-white/50 focus:ring-0 backdrop-blur-sm">
                            </div>
                        </div>

                        {{-- Right column --}}
                        <div class="flex flex-col lg:items-end gap-4 sm:gap-5 shrink-0 w-full lg:w-auto">
                            <div class="grid grid-cols-3 gap-2 sm:gap-3 lg:gap-4 w-full lg:w-auto">
                                <div class="stat-tile bg-white/10 border border-white/15 rounded-xl sm:rounded-2xl px-2.5 sm:px-4 py-2.5 sm:py-3.5 backdrop-blur-sm min-w-0 text-center sm:text-left">
                                    <div class="text-lg sm:text-2xl font-extrabold tracking-tight text-sky-300 tabular-nums truncate" data-count-to="{{ $publicCount }}">{{ $publicCount }}</div>
                                    <div class="text-[9px] sm:text-[10px] uppercase tracking-wider text-white/60 font-semibold mt-0.5 truncate">Open</div>
                                </div>
                                <div class="stat-tile bg-white/10 border border-white/15 rounded-xl sm:rounded-2xl px-2.5 sm:px-4 py-2.5 sm:py-3.5 backdrop-blur-sm min-w-0 text-center sm:text-left">
                                    <div class="text-lg sm:text-2xl font-extrabold tracking-tight text-emerald-300 tabular-nums truncate" data-count-to="{{ $totalMembers }}">{{ number_format($totalMembers) }}</div>
                                    <div class="text-[9px] sm:text-[10px] uppercase tracking-wider text-white/60 font-semibold mt-0.5 truncate">Members</div>
                                </div>
                                <div class="stat-tile bg-white/10 border border-white/15 rounded-xl sm:rounded-2xl px-2.5 sm:px-4 py-2.5 sm:py-3.5 backdrop-blur-sm min-w-0 text-center sm:text-left">
                                    <div class="text-lg sm:text-2xl font-extrabold tracking-tight text-violet-200 tabular-nums truncate" data-count-to="{{ $myGroupsCount }}">{{ $myGroupsCount }}</div>
                                    <div class="text-[9px] sm:text-[10px] uppercase tracking-wider text-white/60 font-semibold mt-0.5 truncate">Joined</div>
                                </div>
                            </div>

                            @if($groupSlotsLeft > 0)
                                <button type="button" onclick="openCreateCommunityModal()" class="cta-glow w-full lg:w-auto inline-flex items-center justify-center gap-2 h-11 sm:h-12 px-5 sm:px-6 rounded-xl sm:rounded-2xl bg-white text-slate-900 text-sm font-bold active:scale-[0.98]">
                                    <span class="material-symbols-outlined text-[19px] sm:text-[20px] text-[#4338ca]">add_circle</span>
                                    Start a community
                                </button>
                                <p class="text-[11px] text-white/55 text-center lg:text-right">
                                    {{ $groupSlotsLeft }} of {{ $groupLimit }} slots left &middot; reviewed by the GMA team
                                </p>
                            @else
                                <div class="w-full lg:w-auto inline-flex items-center justify-center gap-2 h-11 sm:h-12 px-5 rounded-xl sm:rounded-2xl bg-white/10 border border-white/20 backdrop-blur-sm text-white/75 text-sm font-semibold">
                                    <span class="material-symbols-outlined text-[18px]">lock</span>
                                    Community limit reached
                                </div>
                                <p class="text-[11px] text-white/55 text-center lg:text-right">Contact the GMA team to create more.</p>
                            @endif
                        </div>
                    </div>
                </div>

                @if(session('success'))
                    <div id="flash-message" class="stagger-item bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl text-sm" style="animation-delay: 50ms;">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div id="flash-message" class="stagger-item bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl text-sm" style="animation-delay: 50ms;">
                        {{ session('error') }}
                    </div>
                @endif

                @if($errors->any() && old('_token'))
                    <div class="stagger-item bg-amber-50 border border-amber-200 text-amber-800 px-4 py-3 rounded-xl text-sm" style="animation-delay: 50ms;">
                        <ul class="list-disc list-inside space-y-0.5">
                            @foreach($errors->all() as $message)
                                <li>{{ $message }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- ═══ Communities awaiting approval ═══ -->
                @if($pendingGroups->isNotEmpty())
                    <section class="reveal bg-white rounded-2xl border border-amber-200/70 shadow-sm p-5" style="--reveal-delay: 40ms;">
                        <span class="section-accent bg-gradient-to-r from-amber-400 to-orange-500"></span>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="material-symbols-outlined text-[20px] text-amber-500">hourglass_top</span>
                            <h2 class="text-sm font-extrabold text-slate-900 tracking-tight">Awaiting approval</h2>
                        </div>
                        <p class="text-xs text-slate-500 mb-4">These communities are only visible to you until the GMA team publishes them.</p>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                            @foreach($pendingGroups as $group)
                                <div class="flex items-center gap-3 p-3 rounded-xl bg-amber-50/60 border border-amber-100">
                                    <div class="w-10 h-10 rounded-xl bg-white border border-amber-100 flex items-center justify-center overflow-hidden shrink-0">
                                        @if($group->logoUrl())
                                            <img src="{{ $group->logoUrl() }}" alt="{{ $group->name }}" class="w-full h-full object-cover">
                                        @else
                                            <span class="material-symbols-outlined text-amber-500 text-[20px]">groups</span>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <div class="text-[13px] font-bold text-slate-800 truncate">{{ $group->name }}</div>
                                        <div class="text-[11px] text-amber-700 font-semibold">
                                            @if($group->status === \App\Models\CommunityGroup::STATUS_PENDING)
                                                Awaiting approval
                                            @elseif($group->status === \App\Models\CommunityGroup::STATUS_REJECTED)
                                                Declined by admin
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif

                <!-- ═══ Popular right now ═══ -->
                @if($popularGroups->isNotEmpty())
                    <section class="reveal" style="--reveal-delay: 70ms;">
                        <span class="section-accent bg-gradient-to-r from-orange-400 to-rose-500"></span>
                        <div class="flex items-end justify-between gap-4 mb-4">
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="material-symbols-outlined text-[20px] text-amber-500 fill">local_fire_department</span>
                                    <h2 class="text-lg font-extrabold text-slate-900 tracking-tight">Popular right now</h2>
                                </div>
                                <p class="text-xs text-slate-400">Ranked by member count and messages posted this week</p>
                            </div>
                            <button onclick="scrollDiscoverRail('popular-rail', 320)" class="rail-btn shrink-0 w-9 h-9 rounded-xl border border-slate-200 bg-white text-slate-500 hover:text-slate-900 hover:bg-slate-900 hover:border-slate-900 flex items-center justify-center" aria-label="Scroll popular communities right">
                                <span class="material-symbols-outlined text-[18px]">chevron_right</span>
                            </button>
                        </div>

                        <div id="popular-rail" class="discover-rail">
                            @foreach($popularGroups as $group)
                                @php $groupFaces = $faces[$group->id] ?? collect(); @endphp
                                <article class="group-card w-[268px] sm:w-[290px] bg-white rounded-2xl border border-slate-100 shadow-sm p-4 sm:p-5 flex flex-col" data-group-id="{{ $group->id }}">
                                    <span class="card-accent bg-gradient-to-r from-orange-400 to-rose-500"></span>
                                    <div class="flex items-start gap-3.5 mb-4">
                                        <div class="relative shrink-0">
                                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-50 to-indigo-100/80 flex items-center justify-center overflow-hidden shadow-sm">
                                                @if($group->logoUrl())
                                                    <img src="{{ $group->logoUrl() }}" alt="{{ $group->name }}" class="w-full h-full object-cover">
                                                @else
                                                    <span class="material-symbols-outlined text-indigo-600 text-[28px]">groups</span>
                                                @endif
                                            </div>
                                            @if($loop->iteration <= 3)
                                                <span class="rank-badge absolute -top-2 -left-2 w-6 h-6 rounded-full text-white text-[11px] font-extrabold flex items-center justify-center ring-2 ring-white">#{{ $loop->iteration }}</span>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center gap-1.5 mb-1.5">
                                                <span class="inline-block px-2 py-0.5 rounded-md text-[9px] font-bold uppercase tracking-wider bg-indigo-50 text-indigo-700 border border-indigo-100">{{ $group->categoryLabel() }}</span>
                                                @if($group->join_method === CommunityGroup::JOIN_REQUEST)
                                                    <span class="inline-block px-2 py-0.5 rounded-md text-[9px] font-bold uppercase tracking-wider bg-amber-50 text-amber-700 border border-amber-200/60">Approval</span>
                                                @endif
                                            </div>
                                            <h3 class="font-bold text-slate-900 text-[15px] leading-snug line-clamp-2">{{ $group->name }}</h3>
                                        </div>
                                    </div>

                                    <p class="text-xs text-slate-500 leading-relaxed mb-4 line-clamp-2">{{ $group->description ?: 'No description provided.' }}</p>

                                    <div class="flex items-center gap-2 mb-4">
                                        <div class="flex -space-x-2">
                                            @foreach($groupFaces as $face)
                                                <span class="w-6 h-6 rounded-full ring-2 ring-white overflow-hidden bg-indigo-500 flex items-center justify-center" title="{{ $face['name'] }}">
                                                    @if($face['avatar_url'])
                                                        <img src="{{ $face['avatar_url'] }}" alt="{{ $face['name'] }}" class="w-full h-full object-cover">
                                                    @else
                                                        <span class="text-[9px] font-bold text-white leading-none">{{ $face['initials'] }}</span>
                                                    @endif
                                                </span>
                                            @endforeach
                                        </div>
                                        <span class="text-[11px] font-semibold text-slate-600">{{ $group->members_count }} {{ Str::plural('member', $group->members_count) }}</span>
                                    </div>

                                    <div class="mt-auto">
                                        <x-community-join-action :group="$group" />
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </section>
                @endif

                <!-- ═══ Recommended for you ═══ -->
                @if($recommendedGroups->isNotEmpty())
                    <section class="reveal" style="--reveal-delay: 100ms;">
                        <span class="section-accent bg-gradient-to-r from-emerald-400 to-teal-500"></span>
                        <div class="flex items-end justify-between gap-4 mb-4">
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="material-symbols-outlined text-[20px] text-emerald-500 fill">group_recommend</span>
                                    <h2 class="text-lg font-extrabold text-slate-900 tracking-tight">Friends are in these</h2>
                                </div>
                                <p class="text-xs text-slate-400">Communities your network has already joined</p>
                            </div>
                            <button onclick="scrollDiscoverRail('recommended-rail', 320)" class="rail-btn shrink-0 w-8 h-8 sm:w-9 sm:h-9 rounded-xl border border-slate-200 bg-white text-slate-500 hover:text-slate-900 hover:bg-slate-900 hover:border-slate-900 flex items-center justify-center" aria-label="Scroll recommended communities right">
                                <span class="material-symbols-outlined text-[18px]">chevron_right</span>
                            </button>
                        </div>

                        <div id="recommended-rail" class="discover-rail">
                            @foreach($recommendedGroups as $group)
                                <article class="group-card w-[268px] sm:w-[290px] bg-white rounded-2xl border border-slate-100 shadow-sm p-4 sm:p-5 flex flex-col" data-group-id="{{ $group->id }}">
                                    <span class="card-accent bg-gradient-to-r from-emerald-400 to-teal-500"></span>
                                    <div class="flex items-center gap-3.5 mb-4">
                                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-50 to-emerald-100/80 flex items-center justify-center overflow-hidden shadow-sm shrink-0">
                                            @if($group->logoUrl())
                                                <img src="{{ $group->logoUrl() }}" alt="{{ $group->name }}" class="w-full h-full object-cover">
                                            @else
                                                <span class="material-symbols-outlined text-emerald-600 text-[28px]">groups</span>
                                            @endif
                                        </div>
                                        <div class="min-w-0">
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[9px] font-bold uppercase tracking-wider bg-emerald-50 text-emerald-700 border border-emerald-200/60 mb-1.5">
                                                <span class="material-symbols-outlined text-[11px]">group</span>
                                                {{ $group->friend_members_count }} {{ Str::plural('friend', $group->friend_members_count) }}
                                            </span>
                                            <h3 class="font-bold text-slate-900 text-[15px] leading-snug line-clamp-2">{{ $group->name }}</h3>
                                        </div>
                                    </div>

                                    <p class="text-xs text-slate-500 leading-relaxed mb-4 line-clamp-2">{{ $group->description ?: 'No description provided.' }}</p>

                                    <div class="flex items-center gap-3 mb-4 text-[11px] text-slate-400">
                                        <span class="flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[13px]">diversity_3</span>
                                            {{ $group->members_count }} {{ Str::plural('member', $group->members_count) }}
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[13px]">category</span>
                                            {{ $group->categoryLabel() }}
                                        </span>
                                    </div>

                                    <div class="mt-auto">
                                        <x-community-join-action :group="$group" />
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </section>
                @endif

                <!-- ═══ Browse: topic filters + full grid ═══ -->
                <section class="reveal flex flex-col gap-5" style="--reveal-delay: 160ms;">
                    <span class="section-accent bg-gradient-to-r from-indigo-400 to-violet-500"></span>
                    <div class="flex flex-col gap-4">
                        <div class="flex items-end justify-between gap-4 flex-wrap">
                            <div>
                                <h2 class="text-lg font-extrabold text-slate-900 tracking-tight mb-1">Browse all communities</h2>
                                <p class="text-xs text-slate-400"><span id="results-count">{{ $groups->count() }}</span> {{ Str::plural('community', $groups->count()) }} available to you</p>
                            </div>
                            <div class="relative w-full sm:w-72">
                                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-[18px]">search</span>
                                <input type="text" id="search-input" placeholder="Search communities..."
                                    class="search-input w-full h-11 pl-10 pr-9 rounded-xl border border-slate-200 bg-white text-base sm:text-sm text-slate-800 focus:outline-none focus:border-indigo-400 transition">
                                <button type="button" id="search-clear" class="hidden absolute right-3 top-1/2 -translate-y-1/2 text-slate-300 hover:text-slate-600 transition-colors">
                                    <span class="material-symbols-outlined text-[16px]">close</span>
                                </button>
                            </div>
                        </div>

                        @if(count($categories))
                            <div class="flex items-center gap-2 overflow-x-auto custom-scroll pb-1">
                                <button class="topic-chip active shrink-0 h-9 px-3.5 rounded-xl border border-slate-200 bg-white text-xs font-semibold text-slate-700" data-topic="all">
                                    All topics
                                </button>
                                @foreach($categories as $category)
                                    <button class="topic-chip group shrink-0 h-9 px-3.5 rounded-xl border border-slate-200 bg-white text-xs font-semibold text-slate-700 flex items-center gap-1.5"
                                            data-topic="{{ $category['slug'] }}"
                                            style="--chip: {{ $categoryHex[$category['slug']] ?? '#4338ca' }}">
                                        {{ $category['label'] }}
                                        <span class="text-[10px] font-bold text-slate-400 transition-colors group-[.active]:text-white/75">{{ $category['count'] }}</span>
                                    </button>
                                @endforeach
                            </div>
                        @endif

                        <div class="flex items-center justify-between gap-3 flex-wrap">
                            <div class="flex gap-2">
                                <button class="filter-pill active h-10 px-4 rounded-xl border border-slate-200 bg-white text-sm font-medium text-slate-700" data-filter="all">All</button>
                                <button class="filter-pill h-10 px-4 rounded-xl border border-slate-200 bg-white text-sm font-medium text-slate-700" data-filter="joined">Joined</button>
                                <button class="filter-pill h-10 px-4 rounded-xl border border-slate-200 bg-white text-sm font-medium text-slate-700" data-filter="not-joined">Not joined</button>
                            </div>
                            <button id="reset-filters" class="hidden items-center gap-1 text-xs font-semibold text-slate-400 hover:text-slate-700 transition-colors">
                                <span class="material-symbols-outlined text-[14px]">filter_alt_off</span>
                                Reset filters
                            </button>
                        </div>
                    </div>

                    @if($groups->isEmpty())
                        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm py-20 flex flex-col items-center text-center px-6">
                            <div class="w-20 h-20 rounded-3xl bg-slate-100 flex items-center justify-center mb-5">
                                <span class="material-symbols-outlined text-slate-400 text-[36px]">group_off</span>
                            </div>
                            <h3 class="text-xl font-bold text-slate-800 mb-2">No community groups yet</h3>
                            <p class="text-slate-500 text-sm max-w-sm">
                                There are no community groups available right now. Check back later.
                            </p>
                        </div>
                    @else
                        <div id="groups-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($groups as $group)
                                @php $accent = $categoryAccents[$group->categorySlug()] ?? $defaultAccent; @endphp
                                <div class="group-card bg-white rounded-2xl border border-slate-100 shadow-sm p-5 flex flex-col"
                                    data-group-id="{{ $group->id }}"
                                    data-status="{{ $group->is_member ? 'joined' : 'not-joined' }}"
                                    data-topic="{{ $group->categorySlug() }}"
                                    data-name="{{ strtolower($group->name) }} {{ strtolower($group->description ?? '') }}">

                                    <span class="card-accent bg-gradient-to-r {{ $accent[0] }}"></span>

                                    <div class="flex items-start gap-4 mb-4">
                                        <div class="avatar-tile w-14 h-14 rounded-2xl {{ $accent[2] }} ring-1 ring-inset ring-slate-900/5 flex items-center justify-center shrink-0 overflow-hidden">
                                            @if($group->logoUrl())
                                                <img src="{{ $group->logoUrl() }}" alt="{{ $group->name }}" class="w-full h-full object-cover">
                                            @else
                                                <span class="material-symbols-outlined {{ $accent[1] }} text-[28px]">groups</span>
                                            @endif
                                        </div>
                                        <div class="flex-1 flex flex-col items-end gap-1.5">
                                            <span class="inline-block px-2.5 py-1 font-bold rounded-full text-[10px] uppercase tracking-wide border {{ $accent[2] }} {{ $accent[3] }} {{ $accent[4] }}">{{ $group->categoryLabel() }}</span>
                                            <div class="flex items-center gap-1.5">
                                                @if($group->join_method === CommunityGroup::JOIN_REQUEST)
                                                    <span class="inline-block px-2.5 py-1 font-bold rounded-full text-[10px] uppercase tracking-wide border bg-amber-50 text-amber-700 border-amber-200/60">Approval</span>
                                                @elseif($group->join_method === CommunityGroup::JOIN_PRIVATE)
                                                    <span class="inline-block px-2.5 py-1 font-bold rounded-full text-[10px] uppercase tracking-wide border bg-blue-50 text-blue-700 border-blue-200/60">Private</span>
                                                @else
                                                    <span class="inline-block px-2.5 py-1 font-bold rounded-full text-[10px] uppercase tracking-wide border bg-emerald-50 text-emerald-700 border-emerald-200/60">Public</span>
                                                @endif
                                                @if($group->is_member)
                                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide bg-indigo-50 text-indigo-700">
                                                        <span class="material-symbols-outlined text-[12px] fill">check</span>
                                                        Joined
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <h3 class="font-bold text-slate-900 text-base leading-snug mb-1.5 line-clamp-2">{{ $group->name }}</h3>
                                    <p class="text-xs text-slate-500 leading-relaxed mb-4 line-clamp-2">{{ $group->description ?: 'No description provided.' }}</p>

                                    <div class="flex items-center gap-3 mb-4 text-xs text-slate-400">
                                        <span class="flex items-center gap-1 min-w-0">
                                            <span class="material-symbols-outlined text-[14px] shrink-0">person</span>
                                            <span class="truncate">{{ $group->creator?->name ?? 'GMA' }}</span>
                                        </span>
                                        <span class="flex items-center gap-1 shrink-0">
                                            <span class="material-symbols-outlined text-[14px]">diversity_3</span>
                                            {{ $group->members_count ?? 0 }} {{ Str::plural('Member', $group->members_count ?? 0) }}
                                        </span>
                                    </div>

                                    <div class="mt-auto flex items-center gap-2">
                                        <x-community-join-action :group="$group" />
                                        @if($group->weekly_messages > 0)
                                            <span class="shrink-0 inline-flex items-center gap-1.5 px-2.5 py-2 rounded-xl bg-emerald-50 text-emerald-700 text-[11px] font-bold" title="{{ $group->weekly_messages }} messages this week">
                                                <span class="live-dot w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                Active
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div id="empty-results" class="hidden bg-white rounded-3xl border border-slate-100 shadow-sm py-16 flex flex-col items-center text-center px-6">
                            <div class="w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center mb-4">
                                <span class="material-symbols-outlined text-slate-400 text-[30px]">search_off</span>
                            </div>
                            <h3 class="text-base font-bold text-slate-800 mb-1">No communities match your search</h3>
                            <p class="text-slate-500 text-sm max-w-xs mb-4">Try a different keyword or reset the filters to see everything.</p>
                            <button onclick="resetDiscoverFilters()" class="inline-flex items-center gap-1.5 text-xs font-bold text-white px-4 py-2.5 rounded-xl transition-all duration-200 shadow-sm hover:shadow-md" style="background-color: #0f172a;">
                                <span class="material-symbols-outlined text-[14px]">filter_alt_off</span>
                                Reset filters
                            </button>
                        </div>
                    @endif
                </section>

                <!-- ═══ New & growing ═══ -->
                @if($newGroups->isNotEmpty())
                    <section class="reveal" style="--reveal-delay: 130ms;">
                        <span class="section-accent bg-gradient-to-r from-sky-400 to-indigo-500"></span>
                        <div class="flex items-end justify-between gap-4 mb-4">
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="material-symbols-outlined text-[20px] text-sky-500 fill">new_releases</span>
                                    <h2 class="text-lg font-extrabold text-slate-900 tracking-tight">New &amp; growing</h2>
                                </div>
                                <p class="text-xs text-slate-400">Recently launched communities looking for their first members</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($newGroups as $group)
                                <article class="group-card bg-white rounded-2xl border border-slate-100 shadow-sm p-5 flex flex-col" data-group-id="{{ $group->id }}">
                                    <span class="card-accent bg-gradient-to-r from-sky-400 to-indigo-500"></span>
                                    <div class="flex items-center gap-3.5 mb-3.5">
                                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-sky-50 to-sky-100/80 flex items-center justify-center shrink-0 overflow-hidden shadow-sm">
                                            @if($group->logoUrl())
                                                <img src="{{ $group->logoUrl() }}" alt="{{ $group->name }}" class="w-full h-full object-cover">
                                            @else
                                                <span class="material-symbols-outlined text-sky-600 text-[24px]">groups</span>
                                            @endif
                                        </div>
                                        <div class="min-w-0">
                                            <span class="inline-block px-2 py-0.5 rounded-md text-[9px] font-bold uppercase tracking-wider bg-sky-50 text-sky-700 border border-sky-100 mb-1">{{ $group->categoryLabel() }}</span>
                                            <h3 class="font-bold text-slate-900 text-sm leading-snug line-clamp-1">{{ $group->name }}</h3>
                                        </div>
                                    </div>

                                    <p class="text-xs text-slate-500 leading-relaxed mb-4 line-clamp-2 flex-1">{{ $group->description ?: 'No description provided.' }}</p>

                                    <div class="flex items-center justify-between gap-3 mb-4 text-[11px] text-slate-400">
                                        <span class="flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[13px]">diversity_3</span>
                                            {{ $group->members_count }} {{ Str::plural('member', $group->members_count) }}
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[13px]">schedule</span>
                                            {{ $group->created_at?->diffForHumans(short: true) ?? 'Just now' }}
                                        </span>
                                    </div>

                                    <div class="mt-auto">
                                        <x-community-join-action :group="$group" />
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </section>
                @endif

            </div>
        </div>
        @include('components.community-chat')
        @include('components.private-chat', ['friends' => $friends ?? collect()])

        <!-- ═══ Create Community Modal ═══ -->
        <div id="createCommunityModal" class="fixed inset-0 modal-scrim bg-slate-900/60 z-[90] hidden items-center justify-center p-3 sm:p-6"
             role="dialog" aria-modal="true" aria-labelledby="createCommunityTitle" aria-describedby="createCommunitySubtitle">
            <div class="modal-panel bg-white rounded-2xl sm:rounded-3xl shadow-2xl ring-1 ring-slate-900/5 w-full max-w-xl max-h-[95vh] sm:max-h-[92vh] min-h-0 flex flex-col overflow-hidden">
                <form action="{{ route('member.community.store') }}" method="POST" enctype="multipart/form-data" id="createCommunityForm" novalidate class="flex flex-col min-h-0 flex-1">
                    @csrf

                    <!-- Header -->
                    <div class="px-4 sm:px-6 py-4 sm:py-5 border-b border-slate-100 flex items-start justify-between gap-3 sm:gap-4 shrink-0">
                        <div class="flex items-start gap-2.5 sm:gap-3 min-w-0">
                            <span class="material-symbols-outlined text-[20px] sm:text-[22px] text-[#4338ca] mt-0.5 shrink-0">groups</span>
                            <div class="min-w-0">
                                <h3 id="createCommunityTitle" class="text-base sm:text-lg font-extrabold text-slate-900 tracking-tight leading-tight">Start a community</h3>
                                <p id="createCommunitySubtitle" class="text-xs sm:text-[13px] text-slate-500 mt-0.5 leading-snug">Goes live after a quick review by the GMA team.</p>
                            </div>
                        </div>
                        <button type="button" onclick="closeCreateCommunityModal()" aria-label="Close dialog"
                                class="-mr-1.5 -mt-1.5 w-10 h-10 grid place-items-center rounded-xl text-slate-400 hover:text-slate-700 hover:bg-slate-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#4338ca]/40 transition-colors shrink-0">
                            <span class="material-symbols-outlined text-[20px] sm:text-[22px]">close</span>
                        </button>
                    </div>

                    <!-- Body -->
                    <div class="px-4 sm:px-6 py-4 sm:py-6 space-y-4 sm:space-y-6 overflow-y-auto overscroll-contain custom-scroll flex-1 min-h-0">

                        @if($errors->any())
                            <div role="alert" class="flex items-start gap-3 p-3.5 sm:p-4 rounded-xl sm:rounded-2xl bg-red-50 border border-red-200">
                                <span class="material-symbols-outlined text-[18px] sm:text-[20px] text-red-600 mt-px shrink-0">error</span>
                                <div class="text-xs sm:text-[13px] text-red-800 leading-relaxed">
                                    @foreach($errors->all() as $message)
                                        <p>{{ $message }}</p>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Logo -->
                        <div>
                            <div class="flex items-center justify-between gap-3 mb-2">
                                <label for="community-logo-input" class="text-xs sm:text-[13px] font-semibold text-slate-700">Community logo</label>
                                <span class="text-[11px] font-medium text-slate-400">Optional</span>
                            </div>

                            <div class="relative">
                                <label for="community-logo-input" class="dropzone flex items-center gap-3 sm:gap-4 cursor-pointer rounded-xl sm:rounded-2xl border-2 border-dashed border-slate-200 p-3 sm:p-4">
                                    <div class="relative w-14 h-14 sm:w-[68px] sm:h-[68px] rounded-xl sm:rounded-2xl bg-indigo-50 text-indigo-600 grid place-items-center shrink-0 ring-1 ring-inset ring-slate-900/5 overflow-hidden">
                                        <img id="community-logo-preview" class="w-full h-full object-cover hidden" alt="Community logo preview">
                                        <span id="community-logo-placeholder" class="material-symbols-outlined text-[26px] sm:text-[30px]">groups</span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <span class="text-xs sm:text-[13px] font-semibold text-slate-700 flex items-center gap-1.5">
                                            <span class="material-symbols-outlined text-[16px] sm:text-[18px] text-[#4338ca]">upload</span>
                                            Upload a logo
                                        </span>
                                        <span id="community-logo-filename" class="block text-[11px] sm:text-xs text-slate-400 mt-1 truncate">Square images work best</span>
                                        <span class="block text-[10px] sm:text-[11px] text-slate-400 mt-0.5">JPEG, PNG, GIF or WebP &middot; max 2MB</span>
                                    </div>
                                </label>

                                <button type="button" id="community-logo-remove" aria-label="Remove logo"
                                        class="hidden absolute left-14 sm:left-[68px] top-14 sm:top-[68px] -translate-x-1/2 -translate-y-1/2 w-10 h-10 sm:w-11 sm:h-11 grid place-items-center rounded-full focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white/80">
                                    <span class="w-7 h-7 grid place-items-center rounded-full bg-slate-900/60 text-white hover:bg-slate-900/85 transition-colors">
                                        <span class="material-symbols-outlined text-[16px]">close</span>
                                    </span>
                                </button>
                            </div>

                            <p id="community-logo-error" role="alert" class="hidden items-center gap-1.5 text-xs text-red-600 font-medium mt-2">
                                <span class="material-symbols-outlined text-[14px]">error</span>
                                <span data-logo-error-text></span>
                            </p>

                            <input type="file" id="community-logo-input" accept="image/jpeg,image/png,image/gif,image/webp" class="sr-only">
                            <input type="file" name="logo" id="community-logo-file" accept="image/jpeg,image/png,image/gif,image/webp" class="sr-only">
                        </div>

                        <!-- Name + Topic -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                            <div>
                                <label for="community-name" class="block text-xs sm:text-[13px] font-semibold text-slate-700 mb-1.5 sm:mb-2">
                                    Community name
                                    <span class="text-red-500" aria-hidden="true">*</span>
                                </label>
                                <input type="text" name="name" id="community-name" required maxlength="255" value="{{ old('name') }}"
                                    autocomplete="off"
                                    @error('name') aria-invalid="true" aria-describedby="community-name-error" @enderror
                                    class="field w-full px-3.5 py-2.5 border border-slate-200 rounded-xl text-base sm:text-sm text-slate-900 placeholder:text-slate-400"
                                    placeholder="e.g. Payments Founders">
                                @error('name')
                                    <p id="community-name-error" role="alert" class="flex items-center gap-1.5 text-xs text-red-600 font-medium mt-2">
                                        <span class="material-symbols-outlined text-[14px]">error</span>{{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="community-category" class="block text-xs sm:text-[13px] font-semibold text-slate-700 mb-1.5 sm:mb-2">Topic</label>
                                <div class="relative">
                                    <select name="category" id="community-category" @error('category') aria-invalid="true" aria-describedby="community-category-error" @enderror class="field select-chevron w-full px-3.5 py-2.5 border border-slate-200 rounded-xl text-base sm:text-sm text-slate-900 bg-white cursor-pointer">
                                        @foreach(\App\Models\CommunityGroup::CATEGORIES as $value => $label)
                                            <option value="{{ $value }}" {{ old('category') === $value ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    <span class="material-symbols-outlined text-[20px] text-slate-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none">expand_more</span>
                                </div>
                                @error('category')
                                    <p id="community-category-error" role="alert" class="flex items-center gap-1.5 text-xs text-red-600 font-medium mt-2">
                                        <span class="material-symbols-outlined text-[14px]">error</span>{{ $message }}
                                    </p>
                                @else
                                    <p class="text-[11px] text-slate-400 mt-1.5 leading-snug">How members find you in Discover.</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Description -->
                        <div>
                            <div class="flex items-center justify-between gap-3 mb-1.5 sm:mb-2">
                                <label for="community-description" class="text-xs sm:text-[13px] font-semibold text-slate-700">Description</label>
                                <span id="community-description-count" class="text-[11px] text-slate-400 tabular-nums">0 / 2000</span>
                            </div>
                            <textarea name="description" id="community-description" rows="3" sm:rows="4" maxlength="2000"
                                @error('description') aria-invalid="true" aria-describedby="community-description-error" @enderror
                                class="field w-full px-3.5 py-2.5 border border-slate-200 rounded-xl text-base sm:text-sm text-slate-900 placeholder:text-slate-400 resize-y leading-relaxed"
                                placeholder="What is this community about, and who is it for?">{{ old('description') }}</textarea>
                            @error('description')
                                <p id="community-description-error" role="alert" class="flex items-center gap-1.5 text-xs text-red-600 font-medium mt-2">
                                    <span class="material-symbols-outlined text-[14px]">error</span>{{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- What happens next -->
                        <div class="rounded-xl sm:rounded-2xl bg-indigo-50/70 border border-indigo-100 p-3.5 sm:p-4">
                            <p class="flex items-center gap-1.5 text-[11px] sm:text-[12px] font-bold text-indigo-900 uppercase tracking-wider mb-2.5 sm:mb-3">
                                <span class="material-symbols-outlined text-[15px] sm:text-[16px]">verified_user</span>
                                What happens next
                            </p>
                            <ol class="space-y-2 sm:space-y-2.5">
                                <li class="flex items-start gap-2.5 text-xs sm:text-[12.5px] text-indigo-900/75 leading-relaxed">
                                    <span class="grid place-items-center w-[18px] h-[18px] rounded-full bg-indigo-200/70 text-indigo-700 text-[10px] font-bold shrink-0 mt-px">1</span>
                                    The GMA team reviews your submission.
                                </li>
                                <li class="flex items-start gap-2.5 text-xs sm:text-[12.5px] text-indigo-900/75 leading-relaxed">
                                    <span class="grid place-items-center w-[18px] h-[18px] rounded-full bg-indigo-200/70 text-indigo-700 text-[10px] font-bold shrink-0 mt-px">2</span>
                                    Once approved it goes live as <strong class="font-bold text-indigo-900">public and open-join</strong>.
                                </li>
                                <li class="flex items-start gap-2.5 text-xs sm:text-[12.5px] text-indigo-900/75 leading-relaxed">
                                    <span class="grid place-items-center w-[18px] h-[18px] rounded-full bg-indigo-200/70 text-indigo-700 text-[10px] font-bold shrink-0 mt-px">3</span>
                                    You stay its admin — approve members, assign co-admins and manage chat settings.
                                </li>
                            </ol>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="px-4 sm:px-6 py-3.5 sm:py-4 border-t border-slate-100 bg-slate-50/80 flex flex-col-reverse sm:flex-row sm:items-center sm:justify-between gap-2.5 sm:gap-3 shrink-0">
                        <p class="hidden sm:block text-[11px] text-slate-400">You have {{ $groupSlotsLeft }} of {{ $groupLimit }} slots left.</p>
                        <div class="flex flex-col-reverse sm:flex-row gap-2 sm:gap-2.5 sm:ml-auto w-full sm:w-auto">
                            <button type="button" onclick="closeCreateCommunityModal()"
                                    class="btn-press w-full sm:w-auto h-11 px-5 text-sm font-semibold text-slate-700 bg-white border border-slate-300 rounded-xl hover:bg-slate-50 transition-colors shadow-sm">
                                Cancel
                            </button>
                            <button type="submit" id="createCommunitySubmit"
                                    class="btn-press w-full sm:w-auto h-11 px-5 bg-[#4338ca] hover:bg-[#3730a3] disabled:opacity-60 disabled:cursor-not-allowed text-white text-sm font-bold rounded-xl transition-colors shadow-sm hover:shadow-md inline-flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined text-[18px]">send</span>
                                Submit for review
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>

<script>
// ─── Reveal sections as they scroll into view (runs first, so a later script
//     error can never leave content hidden) ─────────────────────────────────
(function initReveal() {
    const items = Array.from(document.querySelectorAll('.reveal'));
    if (!items.length) return;

    const show = (el) => el.classList.add('is-in');

    if (!('IntersectionObserver' in window)) {
        items.forEach(show);
        return;
    }

    const observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                show(entry.target);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.08, rootMargin: '0px 0px -40px 0px' });

    items.forEach((el) => observer.observe(el));

    // Safety net: content must never stay hidden if the observer misbehaves.
    window.setTimeout(() => items.forEach(show), 3000);
})();

// ─── Auto-dismiss flash message after 3s ──────────────────────────────────────
const flashMessage = document.getElementById('flash-message');
if (flashMessage) {
    setTimeout(() => {
        flashMessage.style.transition = 'opacity 0.4s ease';
        flashMessage.style.opacity = '0';
        setTimeout(() => flashMessage.remove(), 400);
    }, 3000);
}

// ─── Count hero stats up on first paint ───────────────────────────────────────
(function initCountUp() {
    const counters = Array.from(document.querySelectorAll('[data-count-to]'));
    if (!counters.length) return;
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

    const format = (n) => n.toLocaleString();

    counters.forEach(function (el) {
        const target = Number(el.dataset.countTo || 0);
        if (!Number.isFinite(target) || target <= 0) return;

        const duration = 900;
        const start = performance.now();

        function step(now) {
            const progress = Math.min((now - start) / duration, 1);
            const eased = 1 - Math.pow(1 - progress, 3);
            el.textContent = format(Math.round(target * eased));
            if (progress < 1) {
                requestAnimationFrame(step);
            } else {
                el.textContent = format(target);
            }
        }

        el.textContent = '0';
        requestAnimationFrame(step);
    });
})();

// ─── Discover rail scrolling ───────────────────────────────────────────────────
function scrollDiscoverRail(railId, amount) {
    const rail = document.getElementById(railId);
    if (rail) rail.scrollBy({ left: amount, behavior: 'smooth' });
}

// ─── Create community modal ────────────────────────────────────────────────────
const createCommunityModal = document.getElementById('createCommunityModal');
const createCommunityForm = document.getElementById('createCommunityForm');
const communityNameInput = document.getElementById('community-name');
const communityDescription = document.getElementById('community-description');
const communityDescriptionCount = document.getElementById('community-description-count');
const logoInput = document.getElementById('community-logo-input');
const logoFileInput = document.getElementById('community-logo-file');
const logoPreview = document.getElementById('community-logo-preview');
const logoPlaceholder = document.getElementById('community-logo-placeholder');
const logoFilename = document.getElementById('community-logo-filename');
const logoRemove = document.getElementById('community-logo-remove');
const logoError = document.getElementById('community-logo-error');
const LOGO_TYPES = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
const LOGO_MAX_BYTES = 2 * 1024 * 1024;
let lastFocusedElement = null;

function openCreateCommunityModal() {
    if (!createCommunityModal) return;
    lastFocusedElement = document.activeElement;
    createCommunityModal.classList.remove('hidden');
    createCommunityModal.classList.add('flex');
    document.body.style.overflow = 'hidden';
    setTimeout(() => communityNameInput?.focus(), 60);
}

function closeCreateCommunityModal() {
    if (!createCommunityModal) return;
    createCommunityModal.classList.add('hidden');
    createCommunityModal.classList.remove('flex');
    document.body.style.overflow = '';
    lastFocusedElement?.focus?.();
}

createCommunityModal?.addEventListener('click', function (e) {
    if (e.target === createCommunityModal) closeCreateCommunityModal();
});

// Keep Tab focus inside the dialog while it is open.
createCommunityModal?.addEventListener('keydown', function (e) {
    if (e.key !== 'Tab') return;

    const focusable = createCommunityModal.querySelectorAll(
        'a[href], button:not([disabled]), input:not([disabled]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])'
    );
    if (!focusable.length) return;

    const first = focusable[0];
    const last = focusable[focusable.length - 1];

    if (e.shiftKey && document.activeElement === first) {
        e.preventDefault();
        last.focus();
    } else if (!e.shiftKey && document.activeElement === last) {
        e.preventDefault();
        first.focus();
    }
});

createCommunityForm?.addEventListener('submit', function () {
    const submit = document.getElementById('createCommunitySubmit');
    if (!submit || submit.disabled) return;
    submit.disabled = true;
    submit.innerHTML = '<span class="material-symbols-outlined text-[18px]">hourglass_top</span> Submitting...';
});

function syncDescriptionCount() {
    if (!communityDescription || !communityDescriptionCount) return;
    communityDescriptionCount.textContent = communityDescription.value.length + ' / 2000';
}

communityDescription?.addEventListener('input', syncDescriptionCount);
syncDescriptionCount();

function showLogoError(message) {
    if (!logoError) return;
    if (!message) {
        logoError.classList.add('hidden');
        logoError.classList.remove('flex');
        return;
    }
    logoError.querySelector('[data-logo-error-text]').textContent = message;
    logoError.classList.remove('hidden');
    logoError.classList.add('flex');
}

function setLogo(file) {
    const reset = () => {
        if (logoInput) logoInput.value = '';
        if (logoFileInput) logoFileInput.value = '';
        if (logoPreview) {
            logoPreview.classList.add('hidden');
            logoPreview.removeAttribute('src');
        }
        logoPlaceholder?.classList.remove('hidden');
        if (logoRemove) {
            logoRemove.classList.add('hidden');
            logoRemove.classList.remove('grid');
        }
        if (logoFilename) logoFilename.textContent = 'Square images work best';
        showLogoError('');
    };

    if (!file) {
        reset();
        return;
    }

    if (!LOGO_TYPES.includes(file.type)) {
        showLogoError('Choose a JPEG, PNG, GIF or WebP image.');
        reset();
        return;
    }
    if (file.size > LOGO_MAX_BYTES) {
        showLogoError('That image is ' + (file.size / 1024 / 1024).toFixed(1) + 'MB. The limit is 2MB.');
        reset();
        return;
    }

    // Mirror the chosen file onto the real, named upload input.
    try {
        const transfer = new DataTransfer();
        transfer.items.add(file);
        logoFileInput.files = transfer.files;
    } catch (e) {
        showLogoError('This browser could not attach the image. Try another file.');
        reset();
        return;
    }

    showLogoError('');
    logoPreview.src = URL.createObjectURL(file);
    logoPreview.classList.remove('hidden');
    logoPlaceholder?.classList.add('hidden');
    if (logoRemove) {
        logoRemove.classList.remove('hidden');
        logoRemove.classList.add('grid');
    }
    logoFilename.textContent = file.name + ' · ' + (file.size / 1024).toFixed(0) + ' KB';
}

logoInput?.addEventListener('change', function () {
    setLogo(this.files[0]);
});

logoRemove?.addEventListener('click', function () {
    setLogo(null);
    logoInput?.focus();
});

document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && createCommunityModal && !createCommunityModal.classList.contains('hidden')) {
        closeCreateCommunityModal();
    }
});

// Reopen the modal after a validation failure so the member does not lose their input.
@if($errors->any() && old('_token'))
    openCreateCommunityModal();
@endif

// ─── Search, topic & status filters ────────────────────────────────────────────
const searchInput   = document.getElementById('search-input');
const heroSearch    = document.getElementById('hero-search-input');
const searchClear   = document.getElementById('search-clear');
const groupsGrid    = document.getElementById('groups-grid');
const emptyResults  = document.getElementById('empty-results');
const resultsCount  = document.getElementById('results-count');
const resetButton   = document.getElementById('reset-filters');
const filterPills   = document.querySelectorAll('.filter-pill');
const topicChips    = document.querySelectorAll('.topic-chip');

let activeFilter = 'all';
let activeTopic  = 'all';
let activeQuery  = '';

function applyFilters() {
    if (!groupsGrid) return;

    const cards = Array.from(groupsGrid.querySelectorAll('.group-card'));
    let visible = 0;

    cards.forEach(card => {
        const matchesStatus = activeFilter === 'all' || card.dataset.status === activeFilter;
        const matchesTopic  = activeTopic === 'all' || card.dataset.topic === activeTopic;
        const matchesQuery  = (card.dataset.name || '').includes(activeQuery);
        const show = matchesStatus && matchesTopic && matchesQuery;
        card.style.display = show ? '' : 'none';
        if (show) visible++;
    });

    if (resultsCount) resultsCount.textContent = visible;
    if (emptyResults) emptyResults.classList.toggle('hidden', visible > 0);
    if (groupsGrid) groupsGrid.classList.toggle('hidden', visible === 0);

    const hasFilters = activeFilter !== 'all' || activeTopic !== 'all' || activeQuery !== '';
    if (resetButton) resetButton.classList.toggle('hidden', !hasFilters);
    if (resetButton) resetButton.classList.toggle('flex', hasFilters);
    if (searchClear) searchClear.classList.toggle('hidden', activeQuery === '');
}

function setQuery(value) {
    activeQuery = value.trim().toLowerCase();
    if (searchInput) searchInput.value = value;
    if (heroSearch) heroSearch.value = value;
    applyFilters();
}

function resetDiscoverFilters() {
    activeFilter = 'all';
    activeTopic  = 'all';
    filterPills.forEach(p => p.classList.toggle('active', p.dataset.filter === 'all'));
    topicChips.forEach(c => c.classList.toggle('active', c.dataset.topic === 'all'));
    setQuery('');
}

searchInput?.addEventListener('input', e => setQuery(e.target.value));
heroSearch?.addEventListener('input', e => setQuery(e.target.value));
searchClear?.addEventListener('click', () => setQuery(''));

filterPills.forEach(pill => {
    pill.addEventListener('click', () => {
        filterPills.forEach(p => p.classList.remove('active'));
        pill.classList.add('active');
        activeFilter = pill.dataset.filter;
        applyFilters();
    });
});

topicChips.forEach(chip => {
    chip.addEventListener('click', () => {
        topicChips.forEach(c => c.classList.remove('active'));
        chip.classList.add('active');
        activeTopic = chip.dataset.topic;
        applyFilters();
    });
});

resetButton?.addEventListener('click', resetDiscoverFilters);
window.addEventListener('keydown', e => {
    if (e.key === 'Escape' && (activeQuery || activeTopic !== 'all' || activeFilter !== 'all')) {
        resetDiscoverFilters();
    }
});

// ─── Smooth Page Exit Transition on Link Navigation ────────────────────────────
(function() {
    document.addEventListener('click', function(e) {
        const link = e.target.closest('a');
        if (!link) return;
        const href = link.getAttribute('href');
        if (!href || href.startsWith('#') || href.startsWith('javascript:') || link.target === '_blank' || link.hasAttribute('download')) return;
        if (e.metaKey || e.ctrlKey || e.shiftKey || e.altKey || e.button !== 0) return;

        try {
            const targetUrl = new URL(href, window.location.href);
            if (targetUrl.origin === window.location.origin && (targetUrl.pathname !== window.location.pathname || targetUrl.search !== window.location.search)) {
                const mainContent = document.querySelector('.landing-page-enter');
                if (mainContent) {
                    e.preventDefault();
                    mainContent.classList.add('page-exit-active');
                    setTimeout(() => {
                        window.location.href = href;
                    }, 170);
                }
            }
        } catch (err) {}
    });

    window.addEventListener('pageshow', function(event) {
        const mainContent = document.querySelector('.landing-page-enter');
        if (mainContent) {
            mainContent.classList.remove('page-exit-active');
        }
    });
})();
</script>

<!-- Community Tour Styles -->
<style>
.community-tour-overlay {
    position: fixed;
    inset: 0;
    background: rgba(15, 23, 42, 0.45);
    z-index: 10001;
    pointer-events: none;
    animation: tourFadeIn 0.25s ease forwards;
}
@keyframes tourFadeIn { from { opacity: 0; } to { opacity: 1; } }

.tour-spotlight {
    position: fixed;
    box-shadow: 0 0 0 9999px rgba(15, 23, 42, 0.7), 0 0 0 4px rgba(99, 102, 241, 0.85);
    border-radius: 16px;
    z-index: 10002;
    pointer-events: none;
    transition: left 0.15s ease-out, top 0.15s ease-out, width 0.15s ease-out, height 0.15s ease-out;
}

.tour-target-active {
    position: relative !important;
    z-index: 10005 !important;
    pointer-events: auto !important;
    backdrop-filter: none !important;
    filter: none !important;
    -webkit-backdrop-filter: none !important;
}

.tour-target-active * {
    backdrop-filter: none !important;
    filter: none !important;
    -webkit-backdrop-filter: none !important;
}

body.tour-active #settingsModal .backdrop-blur-sm,
body.tour-active .backdrop-blur-sm,
body.tour-active .modal-scrim {
    backdrop-filter: none !important;
    -webkit-backdrop-filter: none !important;
}

.tour-save-btn-highlight {
    position: relative !important;
    z-index: 10006 !important;
    animation: tourSavePulse 1.2s infinite alternate !important;
    background: #10b981 !important;
    color: #ffffff !important;
    border-radius: 9999px !important;
    padding: 3px !important;
    box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.4), 0 0 15px rgba(16, 185, 129, 0.6) !important;
}
@keyframes tourSavePulse {
    0% { transform: scale(1); box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.5); }
    100% { transform: scale(1.25); box-shadow: 0 0 0 8px rgba(16, 185, 129, 0.15); }
}

.tour-tooltip {
    position: fixed;
    z-index: 10006;
    width: 330px;
    max-width: calc(100vw - 32px);
    background: #ffffff;
    border-radius: 20px;
    box-shadow: 0 25px 60px -15px rgba(15, 23, 42, 0.5), 0 0 0 1px rgba(148, 163, 184, 0.25);
    transition: left 0.3s cubic-bezier(0.16, 1, 0.3, 1), top 0.3s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.2s ease;
}

.tour-tooltip-arrow {
    position: absolute;
    width: 12px;
    height: 12px;
    background: #ffffff;
    transform: rotate(45deg);
    border-left: 1px solid rgba(148, 163, 184, 0.25);
    border-top: 1px solid rgba(148, 163, 184, 0.25);
    pointer-events: none;
}
.tour-tooltip-arrow.bottom { bottom: -6px; left: 28px; border-left: none; border-top: none; border-right: 1px solid rgba(148, 163, 184, 0.25); border-bottom: 1px solid rgba(148, 163, 184, 0.25); }
.tour-tooltip-arrow.top { top: -6px; left: 28px; }
.tour-tooltip-arrow.right { right: -6px; top: 24px; border-left: none; border-bottom: none; border-right: 1px solid rgba(148, 163, 184, 0.25); border-top: 1px solid rgba(148, 163, 184, 0.25); }
.tour-tooltip-arrow.left { left: -6px; top: 24px; border-right: none; border-top: none; border-left: 1px solid rgba(148, 163, 184, 0.25); border-bottom: 1px solid rgba(148, 163, 184, 0.25); }
</style>

<!-- Community Tour JS -->
<script>
(function() {
    const userId = '{{ auth()->id() }}';
    const tourKey = 'community_tour_seen_' + userId;

    const tourSteps = [
        {
            title: 'Welcome to Community!',
            content: 'This is your GMA Community hub. Discover new communities, connect with members, and join live group chat rooms.',
            selector: null,
            position: 'center'
        },
        {
            title: 'Joined Communities',
            content: 'All your joined communities are listed in the quick rail. Click any group icon to open its live chat room instantly!',
            selector: '[data-tour="joined-communities"], #communities-desktop-rail, #communities-desktop-toggle',
            position: 'right'
        },
        {
            title: 'Friends & Direct Messages',
            content: 'Connect 1-on-1 with members! Access your friends list, accept friend requests, and start direct messaging right next to communities.',
            selector: '[data-tour="friends-rail"], #friends-desktop-rail, #friends-desktop-toggle, #friends-mobile-toggle',
            position: 'right'
        },
        {
            title: 'Open Settings',
            content: 'Click the Settings icon in the sidebar to open your settings modal.',
            selector: '[data-tour="settings"], a[onclick*="openSettingsModal"]',
            position: 'right',
            requireSettingsClick: true
        },
        {
            title: 'Set Your Native Language',
            content: 'In Settings > Profile, choose your Native Language to enable personalized experience and real-time chat translation across GMA communities!',
            selector: '#tour-language-section, [data-tour="language-section"]',
            position: 'bottom',
            requireLanguageSelect: true
        }
    ];

    let currentStep = 0;
    let tourOverlay = null;
    let tourSpotlight = null;
    let tourTooltip = null;

    function findElement(selectorString) {
        if (!selectorString) return null;
        const parts = selectorString.split(',');
        for (let p of parts) {
            const sel = p.trim();
            if (!sel) continue;
            try {
                const el = document.querySelector(sel);
                if (el && (el.offsetWidth > 0 || el.offsetHeight > 0 || el.getClientRects().length > 0)) {
                    return el;
                }
            } catch (err) {}
        }
        return null;
    }

    function createTourElements() {
        if (!tourOverlay) {
            tourOverlay = document.createElement('div');
            tourOverlay.className = 'community-tour-overlay';
            tourOverlay.addEventListener('click', function(e) {
                if (e.target === tourOverlay && !tourSteps[currentStep]?.requireSettingsClick && !tourSteps[currentStep]?.requireLanguageSelect) {
                    endTour();
                }
            });
            document.body.appendChild(tourOverlay);
        }

        if (!tourSpotlight) {
            tourSpotlight = document.createElement('div');
            tourSpotlight.className = 'tour-spotlight';
            document.body.appendChild(tourSpotlight);
        }

        if (!tourTooltip) {
            tourTooltip = document.createElement('div');
            tourTooltip.className = 'tour-tooltip';
            document.body.appendChild(tourTooltip);
        }
    }

    function positionTooltip(element, position) {
        tourTooltip.style.transform = '';
        tourTooltip.style.left = '';
        tourTooltip.style.top = '';

        const arrow = tourTooltip.querySelector('.tour-tooltip-arrow');
        if (arrow) arrow.className = 'tour-tooltip-arrow';

        if (!element || position === 'center') {
            tourTooltip.style.left = '50%';
            tourTooltip.style.top = '50%';
            tourTooltip.style.transform = 'translate(-50%, -50%)';
            if (arrow) arrow.className = 'tour-tooltip-arrow hidden';
            return;
        }

        const rect = element.getBoundingClientRect();
        const tooltipRect = tourTooltip.getBoundingClientRect();
        const margin = 14;

        let left = 0;
        let top = 0;
        let arrowClass = '';

        switch (position) {
            case 'right':
                left = rect.right + margin;
                top = rect.top + (rect.height - tooltipRect.height) / 2;
                arrowClass = 'left';
                break;
            case 'left':
                left = rect.left - tooltipRect.width - margin;
                top = rect.top + (rect.height - tooltipRect.height) / 2;
                arrowClass = 'right';
                break;
            case 'bottom':
                left = rect.left + (rect.width - tooltipRect.width) / 2;
                top = rect.bottom + margin;
                arrowClass = 'top';
                break;
            case 'top':
                left = rect.left + (rect.width - tooltipRect.width) / 2;
                top = rect.top - tooltipRect.height - margin;
                arrowClass = 'bottom';
                break;
            default:
                tourTooltip.style.left = '50%';
                tourTooltip.style.top = '50%';
                tourTooltip.style.transform = 'translate(-50%, -50%)';
                if (arrow) arrow.className = 'tour-tooltip-arrow hidden';
                return;
        }

        const maxLeft = window.innerWidth - tooltipRect.width - 16;
        const maxTop = window.innerHeight - tooltipRect.height - 16;
        left = Math.max(16, Math.min(left, maxLeft));
        top = Math.max(16, Math.min(top, maxTop));

        tourTooltip.style.left = left + 'px';
        tourTooltip.style.top = top + 'px';
        if (arrow) arrow.className = 'tour-tooltip-arrow ' + arrowClass;
    }

    let activeTargetElement = null;
    let spotlightRafId = null;
    let currentTargetPosition = null;

    function updateActiveSpotlight() {
        if (!activeTargetElement || !tourSpotlight) {
            if (spotlightRafId) {
                cancelAnimationFrame(spotlightRafId);
                spotlightRafId = null;
            }
            return;
        }

        const rect = activeTargetElement.getBoundingClientRect();
        const newLeft = Math.max(0, rect.left - 6);
        const newTop = Math.max(0, rect.top - 6);
        const newWidth = rect.width + 12;
        const newHeight = rect.height + 12;

        if (!currentTargetPosition || 
            Math.abs(currentTargetPosition.left - newLeft) > 0.5 ||
            Math.abs(currentTargetPosition.top - newTop) > 0.5 ||
            Math.abs(currentTargetPosition.width - newWidth) > 0.5 ||
            Math.abs(currentTargetPosition.height - newHeight) > 0.5) {

            currentTargetPosition = { left: newLeft, top: newTop, width: newWidth, height: newHeight };
            tourSpotlight.style.display = 'block';
            tourSpotlight.style.left = newLeft + 'px';
            tourSpotlight.style.top = newTop + 'px';
            tourSpotlight.style.width = newWidth + 'px';
            tourSpotlight.style.height = newHeight + 'px';

            const preferredPos = tourSteps[currentStep]?.position || 'right';
            positionTooltip(activeTargetElement, preferredPos);
        }

        spotlightRafId = requestAnimationFrame(updateActiveSpotlight);
    }

    function clearActiveTarget() {
        if (spotlightRafId) {
            cancelAnimationFrame(spotlightRafId);
            spotlightRafId = null;
        }
        currentTargetPosition = null;
        if (activeTargetElement) {
            activeTargetElement.classList.remove('tour-target-active');
            activeTargetElement = null;
        }
        document.querySelectorAll('.tour-save-btn-highlight').forEach(el => el.classList.remove('tour-save-btn-highlight'));
    }

    function highlightElement(selector, position) {
        clearActiveTarget();
        const element = findElement(selector);
        if (element) {
            activeTargetElement = element;
            element.classList.add('tour-target-active');

            try {
                element.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            } catch(e) {}

            updateActiveSpotlight();
        } else {
            if (tourSpotlight) tourSpotlight.style.display = 'none';
            positionTooltip(null, 'center');
        }
    }

    window.addEventListener('language-saved', function() {
        endTour();
    });

    document.addEventListener('click', function(e) {
        if (e.target.closest('#tour-save-language-btn') || e.target.closest('[wire\\:click*="saveLanguage"]')) {
            setTimeout(endTour, 100);
        }
    });

    function prepareLanguageStep() {
        // Immediately hide the old spotlight & tooltip so there's no stale
        // "Settings icon" spotlight hanging around during the modal open animation.
        clearActiveTarget();
        if (tourSpotlight) {
            tourSpotlight.style.display = 'none';
        }
        if (tourTooltip) {
            tourTooltip.style.opacity = '0';
            tourTooltip.style.transition = 'opacity 0.15s ease';
        }

        if (typeof window.openSettingsModal === 'function') {
            window.openSettingsModal();
        }

        // Wait for modal open animation (300ms transition + some buffer for Livewire render)
        // then auto-click the edit pencil, wait for Livewire re-render, then highlight.
        setTimeout(() => {
            const editBtn = document.querySelector('#tour-edit-language-btn');
            if (editBtn) {
                editBtn.click();
            }

            // Wait for Livewire to swap in the select + save btn after editing is toggled
            setTimeout(() => {
                if (tourTooltip) {
                    tourTooltip.style.opacity = '1';
                }

                const langSelect = document.querySelector('#tour-language-select');
                highlightElement(langSelect ? '#tour-language-select' : '#tour-language-section', 'bottom');

                const highlightSaveCheckmark = function() {
                    const saveTarget = document.querySelector('#tour-save-language-btn');
                    if (saveTarget) {
                        saveTarget.classList.add('tour-save-btn-highlight');
                        highlightElement('#tour-save-language-btn', 'bottom');

                        const badge = tourTooltip ? tourTooltip.querySelector('.tour-action-badge') : null;
                        if (badge) {
                            badge.className = 'tour-action-badge inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-300 text-[11px] font-bold animate-pulse';
                            badge.innerHTML = '<span class="material-symbols-outlined text-[14px]">check_circle</span> Click the check mark to save';
                        }
                    }
                };

                if (langSelect) {
                    langSelect.addEventListener('change', highlightSaveCheckmark);
                    langSelect.addEventListener('input', highlightSaveCheckmark);
                }
            }, 250);
        }, 420); // 300ms modal CSS transition + 120ms breathing room
    }

    function showStep(stepIndex) {
        currentStep = stepIndex;
        if (stepIndex < 0 || stepIndex >= tourSteps.length) {
            endTour();
            return;
        }
        // Always restore tooltip visibility in case a previous step hid it
        if (tourTooltip) {
            tourTooltip.style.opacity = '1';
        }
        const step = tourSteps[stepIndex];

        let actionControls = '';
        if (step.requireSettingsClick) {
            actionControls = `
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-50 text-amber-700 border border-amber-200 text-[11px] font-bold animate-pulse">
                        <span class="material-symbols-outlined text-[14px]">touch_app</span> Click Settings icon
                    </span>
                    ${stepIndex > 0 ? '<button class="tour-prev h-8 px-3 rounded-xl border border-slate-200 bg-white text-xs font-bold text-slate-700 hover:bg-slate-50 transition-colors">Back</button>' : ''}
                </div>
            `;
        } else if (step.requireLanguageSelect) {
            actionControls = `
                <div class="flex items-center gap-2">
                    <span class="tour-action-badge inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-indigo-50 text-indigo-700 border border-indigo-200 text-[11px] font-bold">
                        <span class="material-symbols-outlined text-[14px]">language</span> Select your native language
                    </span>
                </div>
            `;
        } else {
            actionControls = `
                <div class="flex items-center gap-2">
                    <button class="tour-skip text-xs font-semibold text-slate-500 hover:text-slate-800 px-2 py-1.5 transition-colors">Skip</button>
                    ${stepIndex > 0 ? '<button class="tour-prev h-8 px-3 rounded-xl border border-slate-200 bg-white text-xs font-bold text-slate-700 hover:bg-slate-50 transition-colors">Back</button>' : ''}
                    <button class="tour-next h-8 px-4 rounded-xl bg-[#4338ca] hover:bg-[#3730a3] text-white text-xs font-bold shadow-sm transition-colors">${stepIndex === tourSteps.length - 1 ? 'Finish' : 'Next'}</button>
                </div>
            `;
        }

        tourTooltip.innerHTML = `
            <div class="p-5">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-base font-bold text-slate-900">${step.title}</h3>
                    <button class="tour-skip text-slate-400 hover:text-slate-600 p-1 -mr-1 rounded-lg transition-colors" title="Close tour">
                        <span class="material-symbols-outlined text-[18px]">close</span>
                    </button>
                </div>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-5">${step.content}</p>
                <div class="flex items-center justify-between gap-2 pt-2 border-t border-slate-100">
                    <div class="flex items-center gap-1 text-[11px] font-bold text-slate-400">
                        <span>${stepIndex + 1}</span> / <span>${tourSteps.length}</span>
                    </div>
                    ${actionControls}
                </div>
            </div>
            <div class="tour-tooltip-arrow"></div>
        `;

        if (step.requireLanguageSelect) {
            prepareLanguageStep();
        } else {
            highlightElement(step.selector, step.position);
        }

        if (step.requireSettingsClick) {
            const settingsTarget = findElement(step.selector);
            if (settingsTarget) {
                const onSettingsClick = function() {
                    settingsTarget.removeEventListener('click', onSettingsClick);
                    setTimeout(() => {
                        showStep(4);
                    }, 300);
                };
                settingsTarget.addEventListener('click', onSettingsClick, { once: true });
            }
        }

        tourTooltip.querySelector('.tour-next')?.addEventListener('click', () => showStep(stepIndex + 1));
        tourTooltip.querySelector('.tour-prev')?.addEventListener('click', () => showStep(stepIndex - 1));
        tourTooltip.querySelectorAll('.tour-skip').forEach(btn => btn.addEventListener('click', endTour));
    }

    function startTour() {
        document.body.classList.add('tour-active');
        createTourElements();
        showStep(0);
    }

    function endTour() {
        localStorage.setItem(tourKey, 'true');
        document.body.classList.remove('tour-active');
        clearActiveTarget();
        tourOverlay?.remove();
        tourSpotlight?.remove();
        tourTooltip?.remove();
        tourOverlay = null;
        tourSpotlight = null;
        tourTooltip = null;
    }

    const origOpenSettings = window.openSettingsModal;
    window.openSettingsModal = function() {
        if (typeof origOpenSettings === 'function') origOpenSettings();
        if (currentStep === 3) {
            setTimeout(() => {
                showStep(4);
            }, 300);
        }
    };

    window.startCommunityTour = function(force) {
        if (force) {
            localStorage.removeItem(tourKey);
        }
        startTour();
    };

    if (localStorage.getItem(tourKey) !== 'true') {
        setTimeout(startTour, 600);
    }
})();
</script>

@include('components.settings-modal')
</body>
</html>
