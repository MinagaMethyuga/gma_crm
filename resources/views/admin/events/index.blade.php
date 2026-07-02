<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GMA - Events Admin</title>
    <link rel="icon" href="/Global_Mobile_Association_Logo__1_-removebg-preview.png" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0,1&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fc;
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .material-symbols-outlined.fill {
            font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .custom-scroll::-webkit-scrollbar {
            width: 6px;
        }
        .custom-scroll::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scroll::-webkit-scrollbar-thumb {
            background-color: #cbd5e1;
            border-radius: 10px;
        }

        /* Slide-over panel */
        .slide-over {
            transform: translateX(100%);
            transition: transform 0.35s cubic-bezier(0.32, 0.72, 0, 1);
        }
        .slide-over.open {
            transform: translateX(0);
        }
        .slide-over-overlay {
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }
        .slide-over-overlay.open {
            opacity: 1;
            pointer-events: auto;
        }

        /* Toggle switch */
        .toggle-switch {
            transition: background-color 0.2s ease;
        }
        .toggle-switch .toggle-knob {
            transition: transform 0.2s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .toggle-switch.active {
            background-color: #4338ca;
        }
        .toggle-switch.active .toggle-knob {
            transform: translateX(24px);
        }

        /* Event card */
        .event-card {
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }
        .event-card::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 0;
            background: #4338ca;
            border-radius: 0 4px 4px 0;
            transition: height 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .event-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px -5px rgba(67, 56, 202, 0.1), 0 4px 10px -5px rgba(0, 0, 0, 0.05);
            border-color: #c7d2fe;
        }
        .event-card.selected {
            border-color: #818cf8;
            background: linear-gradient(135deg, #f5f3ff 0%, #eef2ff 100%);
        }
        .event-card.selected::before {
            height: 60%;
        }

        /* File input */
        .file-input-label {
            transition: all 0.2s ease;
        }
        .file-input-label:hover {
            border-color: #4338ca;
            background-color: #f5f5fc;
        }

        /* Stat card */
        .stat-card {
            position: relative;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.08);
        }
        .stat-card .stat-icon {
            position: absolute;
            right: -8px;
            bottom: -8px;
            font-size: 72px;
            opacity: 0.06;
            transform: rotate(-12deg);
            pointer-events: none;
            user-select: none;
        }

        /* Staggered card entrance */
        @keyframes cardFadeIn {
            from {
                opacity: 0;
                transform: translateY(16px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .card-animate {
            opacity: 0;
            animation: cardFadeIn 0.5s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        /* Stats entrance */
        @keyframes statSlideIn {
            from {
                opacity: 0;
                transform: translateY(12px) scale(0.97);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }
        .stat-animate {
            opacity: 0;
            animation: statSlideIn 0.45s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        /* Circular progress */
        .circular-progress {
            transform: rotate(-90deg);
        }
        .circular-progress circle {
            transition: stroke-dashoffset 1s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Countdown boxes */
        .countdown-box {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border: 1px solid #e2e8f0;
        }

        /* Search input focus glow */
        .search-input:focus {
            box-shadow: 0 0 0 3px rgba(67, 56, 202, 0.12);
        }

        /* Pulse for live dot */
        @keyframes livePulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(1.5); }
        }
        .live-dot {
            animation: livePulse 2s ease-in-out infinite;
        }

        /* Empty state float */
        @keyframes emptyFloat {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
        }
        .empty-float {
            animation: emptyFloat 3s ease-in-out infinite;
        }

        /* Reduced motion */
        @media (prefers-reduced-motion: reduce) {
            .card-animate, .stat-animate {
                animation: none !important;
                opacity: 1 !important;
                transform: none !important;
            }
            .event-card, .stat-card {
                transition: none !important;
            }
            .event-card:hover {
                transform: none !important;
            }
            .stat-card:hover {
                transform: none !important;
            }
            .live-dot {
                animation: none !important;
            }
            .empty-float {
                animation: none !important;
            }
        }
    </style>
</head>
<body class="overflow-hidden text-slate-800">

    <div class="flex h-screen w-full">
        @include('components.admin-sidebar', ['active' => 'events'])

        <!-- Main Content Area -->
        <main class="flex-1 flex flex-col min-w-0 bg-[#fbfcfd]">

            @include('components.admin-header', ['showCreateEvent' => true])

            <!-- Content Body -->
            <div class="flex-1 flex overflow-hidden relative">

                <!-- Left: Events List -->
                <div class="flex-1 overflow-y-auto custom-scroll p-8 lg:p-10 pb-20">

                    <!-- Page Header -->
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <div class="flex items-center gap-3 mb-1.5">
                                <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Events</h2>
                                <span class="bg-indigo-100 text-indigo-700 text-xs font-bold px-2.5 py-1 rounded-full">
                                    {{ $events->count() }} total
                                </span>
                            </div>
                            <p class="text-slate-500 text-sm">Manage and track upcoming organization activities.</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <button onclick="showCreateForm()" class="flex items-center gap-1.5 bg-[#4338ca] hover:bg-[#3730a3] text-white shadow-md shadow-[#4338ca]/20 rounded-lg px-4 py-2 text-sm font-semibold transition-all cursor-pointer">
                                <span class="material-symbols-outlined text-[17px]">add</span>
                                Create Event
                            </button>
                        </div>
                    </div>

                    <!-- Stats Bar -->
                    <div class="grid grid-cols-2 xl:grid-cols-4 gap-4 mb-8">
                        <!-- Total Events -->
                        <div class="stat-card stat-animate bg-white rounded-2xl border border-slate-200/60 p-5 cursor-pointer" style="animation-delay: 0ms">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-indigo-600 text-[22px]">calendar_month</span>
                                </div>
                                <span class="text-[11px] font-bold text-slate-500 uppercase tracking-widest">Total Events</span>
                            </div>
                            <div class="text-[28px] font-extrabold text-slate-900 leading-none" data-count-to="{{ $events->count() }}">0</div>
                            <span class="material-symbols-outlined stat-icon text-indigo-600">calendar_month</span>
                        </div>

                        <!-- Upcoming -->
                        <div class="stat-card stat-animate bg-white rounded-2xl border border-slate-200/60 p-5 cursor-pointer" style="animation-delay: 80ms">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-emerald-600 text-[22px]">event_upcoming</span>
                                </div>
                                <span class="text-[11px] font-bold text-slate-500 uppercase tracking-widest">Upcoming</span>
                            </div>
                            <div class="text-[28px] font-extrabold text-emerald-600 leading-none" data-count-to="{{ $events->filter(fn($e) => $e->start_date->isFuture())->count() }}">0</div>
                            <span class="material-symbols-outlined stat-icon text-emerald-600">event_upcoming</span>
                        </div>

                        <!-- Total Registered -->
                        <div class="stat-card stat-animate bg-white rounded-2xl border border-slate-200/60 p-5 cursor-pointer" style="animation-delay: 160ms">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-amber-600 text-[22px]">group</span>
                                </div>
                                <span class="text-[11px] font-bold text-slate-500 uppercase tracking-widest">Registered</span>
                            </div>
                            <div class="text-[28px] font-extrabold text-slate-900 leading-none" data-count-to="{{ $events->sum('registered_count') }}">0</div>
                            <span class="material-symbols-outlined stat-icon text-amber-600">group</span>
                        </div>

                        <!-- This Month -->
                        <div class="stat-card stat-animate bg-white rounded-2xl border border-slate-200/60 p-5 cursor-pointer" style="animation-delay: 240ms">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-10 h-10 rounded-xl bg-sky-50 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-sky-600 text-[22px]">date_range</span>
                                </div>
                                <span class="text-[11px] font-bold text-slate-500 uppercase tracking-widest">This Month</span>
                            </div>
                            <div class="text-[28px] font-extrabold text-sky-600 leading-none" data-count-to="{{ $events->filter(fn($e) => $e->start_date->isCurrentMonth())->count() }}">0</div>
                            <span class="material-symbols-outlined stat-icon text-sky-600">date_range</span>
                        </div>
                    </div>

                    <!-- Filters & Search Bar -->
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
                        <div class="flex gap-2" id="filterButtons">
                            <button class="filter-btn bg-[#4338ca] text-white text-[13px] font-semibold px-5 py-2 rounded-full shadow-md shadow-[#4338ca]/15 transition-all cursor-pointer" data-filter="all">
                                All Events
                                <span class="ml-1 bg-white/20 text-white text-[11px] font-bold px-1.5 py-0.5 rounded-full inline-block" id="countAll">{{ $events->count() }}</span>
                            </button>
                            <button class="filter-btn bg-white text-slate-600 hover:bg-slate-50 text-[13px] font-semibold px-5 py-2 rounded-full transition-all border border-slate-200 cursor-pointer" data-filter="upcoming">
                                Upcoming
                                <span class="ml-1 bg-emerald-100 text-emerald-700 text-[11px] font-bold px-1.5 py-0.5 rounded-full inline-block" id="countUpcoming">{{ $events->filter(fn($e) => $e->start_date->isFuture())->count() }}</span>
                            </button>
                            <button class="filter-btn bg-white text-slate-600 hover:bg-slate-50 text-[13px] font-semibold px-5 py-2 rounded-full transition-all border border-slate-200 cursor-pointer" data-filter="past">
                                Past
                                <span class="ml-1 bg-slate-100 text-slate-500 text-[11px] font-bold px-1.5 py-0.5 rounded-full inline-block" id="countPast">{{ $events->filter(fn($e) => $e->start_date->isPast())->count() }}</span>
                            </button>
                        </div>
                        <div class="flex items-center gap-3">
                            <!-- Search -->
                            <div class="relative">
                                <span class="material-symbols-outlined text-[18px] text-slate-400 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none">search</span>
                                <input type="text" id="searchInput" placeholder="Search events..."
                                       class="search-input w-52 pl-9 pr-4 py-2 bg-white border border-slate-200 rounded-xl text-sm text-slate-700 placeholder:text-slate-400 focus:outline-none focus:border-[#4338ca] transition-all">
                            </div>
                            <!-- Sort -->
                            <select id="sortSelect" class="bg-white border border-slate-200 rounded-xl px-3 py-2 text-sm text-slate-600 font-medium focus:outline-none focus:border-[#4338ca] cursor-pointer transition-colors">
                                <option value="date_desc">Newest first</option>
                                <option value="date_asc">Oldest first</option>
                                <option value="name_asc">Name A-Z</option>
                                <option value="name_desc">Name Z-A</option>
                            </select>
                        </div>
                    </div>

                    <!-- Grid of Events -->
                    <div class="grid grid-cols-1 xl:grid-cols-2 gap-5" id="eventsGrid">
                        @forelse($events as $index => $event)
                            @php
                                $isUpcoming = $event->start_date->isFuture();
                                $daysAway = now()->diffInDays($event->start_date, false);
                                $capacityPct = ($event->has_seating_capacity && $event->seating_capacity > 0)
                                    ? min(100, round(($event->registered_count / $event->seating_capacity) * 100))
                                    : 0;
                            @endphp
                            <div class="event-card card-animate border border-slate-200/80 rounded-2xl bg-white cursor-pointer shadow-sm overflow-hidden"
                                 data-event-id="{{ $event->id }}"
                                 onclick="selectEvent({{ $event->id }})"
                                 style="animation-delay: {{ ($index * 60) + 300 }}ms">

                                <!-- Card top accent line -->
                                <div class="h-1 w-full {{ $isUpcoming ? 'bg-gradient-to-r from-indigo-500 via-violet-500 to-purple-500' : 'bg-gradient-to-r from-slate-300 to-slate-200' }}"></div>

                                <div class="p-5">
                                    <div class="flex justify-between items-start mb-4">
                                        <div class="flex gap-4">
                                            <!-- Date block -->
                                            <div class="bg-gradient-to-br {{ $isUpcoming ? 'from-indigo-50 to-violet-50 border-indigo-200/50' : 'from-slate-50 to-slate-100 border-slate-200' }} border rounded-xl p-2.5 text-center w-16 shrink-0 flex flex-col justify-center">
                                                <div class="text-[11px] font-bold {{ $isUpcoming ? 'text-indigo-500' : 'text-slate-400' }} uppercase tracking-wider mb-0.5">{{ $event->start_date->format('M') }}</div>
                                                <div class="text-2xl font-extrabold {{ $isUpcoming ? 'text-slate-900' : 'text-slate-500' }} leading-none">{{ $event->start_date->format('d') }}</div>
                                            </div>
                                            <div class="pt-0.5 min-w-0">
                                                <h3 class="font-bold text-[17px] text-slate-900 leading-tight mb-1.5 tracking-tight truncate">{{ $event->title }}</h3>
                                                <div class="flex items-center gap-1.5 text-slate-500 text-xs font-medium">
                                                    <span class="material-symbols-outlined text-[15px]">schedule</span>
                                                    {{ $event->start_date->format('g:i A') }}{{ $event->end_date ? ' - ' . $event->end_date->format('g:i A') : '' }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-2 shrink-0 ml-2">
                                            <!-- Status dot + label -->
                                            @if($isUpcoming)
                                                <span class="flex items-center gap-1.5 bg-emerald-50 text-emerald-700 text-[10px] font-bold uppercase tracking-wider px-2.5 py-1.5 rounded-lg border border-emerald-200/50">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 live-dot"></span>
                                                    Upcoming
                                                </span>
                                            @else
                                                <span class="flex items-center gap-1.5 bg-slate-100 text-slate-500 text-[10px] font-bold uppercase tracking-wider px-2.5 py-1.5 rounded-lg border border-slate-200/50">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                                    Past
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Countdown chip -->
                                    @if($isUpcoming && $daysAway >= 0)
                                        <div class="mb-4">
                                            <span class="inline-flex items-center gap-1.5 bg-indigo-50/70 text-indigo-600 text-[11px] font-semibold px-3 py-1 rounded-full border border-indigo-100">
                                                <span class="material-symbols-outlined text-[14px]">timer</span>
                                                @if($daysAway == 0)
                                                    Today
                                                @elseif($daysAway == 1)
                                                    Tomorrow
                                                @else
                                                    In {{ $daysAway }} days
                                                @endif
                                            </span>
                                        </div>
                                    @elseif(!$isUpcoming)
                                        <div class="mb-4">
                                            <span class="inline-flex items-center gap-1.5 bg-slate-50 text-slate-400 text-[11px] font-semibold px-3 py-1 rounded-full border border-slate-100">
                                                <span class="material-symbols-outlined text-[14px]">history</span>
                                                {{ abs($daysAway) }} {{ abs($daysAway) == 1 ? 'day' : 'days' }} ago
                                            </span>
                                        </div>
                                    @endif

                                    <div class="flex justify-between items-end border-t border-slate-100 pt-4">
                                        <div class="flex items-start gap-1.5 text-slate-500 text-xs font-medium w-2/3 pr-2">
                                            <span class="material-symbols-outlined text-[16px] shrink-0">{{ $event->address ? 'location_on' : 'link' }}</span>
                                            <span class="leading-snug mt-0.5 truncate">{{ $event->address ?? ($event->website_link ?? 'No location') }}</span>
                                        </div>
                                        @if($event->has_seating_capacity)
                                            <div class="text-right shrink-0">
                                                <div class="text-[11px] text-slate-500 uppercase font-semibold tracking-wider mb-1">Registered</div>
                                                <div class="text-sm font-bold text-slate-800">{{ $event->registered_count }} <span class="text-slate-400 font-semibold">/ {{ $event->seating_capacity }}</span></div>
                                                <!-- Mini progress bar -->
                                                <div class="w-20 h-1 bg-slate-100 rounded-full mt-1.5 overflow-hidden">
                                                    <div class="h-full rounded-full transition-all {{ $capacityPct >= 90 ? 'bg-red-400' : ($capacityPct >= 70 ? 'bg-amber-400' : 'bg-indigo-400') }}" style="width: {{ $capacityPct }}%"></div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <!-- Enhanced Empty State -->
                            <div class="col-span-2 flex flex-col items-center justify-center text-center py-24">
                                <div class="empty-float mb-6">
                                    <div class="w-24 h-24 rounded-3xl bg-gradient-to-br from-indigo-100 to-violet-100 flex items-center justify-center shadow-lg shadow-indigo-100/50">
                                        <span class="material-symbols-outlined text-5xl text-indigo-400">event_busy</span>
                                    </div>
                                </div>
                                <h3 class="text-xl font-bold text-slate-700 mb-2">No events yet</h3>
                                <p class="text-sm text-slate-400 mb-6 max-w-xs">Create your first event to start managing registrations and tracking attendees.</p>
                                <button onclick="showCreateForm()" class="bg-[#4338ca] hover:bg-[#3730a3] text-white text-sm font-semibold px-6 py-2.5 rounded-xl transition-colors shadow-md shadow-[#4338ca]/20 flex items-center gap-2 cursor-pointer">
                                    <span class="material-symbols-outlined text-[18px]">add</span>
                                    Create First Event
                                </button>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Overlay -->
                <div class="slide-over-overlay fixed inset-0 bg-black/20 z-30" id="overlay"></div>

                <!-- Right: Slide-over Panel -->
                <div class="slide-over fixed right-0 top-0 h-full w-[520px] bg-white shadow-[-10px_0_30px_-10px_rgba(0,0,0,0.12)] z-50 overflow-y-auto custom-scroll" id="slideOver">
                    <!-- Detail View -->
                    <div id="detailView" class="h-full flex flex-col">
                        <!-- Banner Image -->
                        <div class="relative h-[220px] bg-slate-200 rounded-b-3xl overflow-hidden mx-4 mt-4 shadow-sm shrink-0 hidden" id="detailBanner">
                            <img src="https://images.unsplash.com/photo-1511795409834-ef04bbd61622?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Event Banner" class="w-full h-full object-cover transition-transform duration-500 hover:scale-105" id="detailBannerImg">
                            <div class="absolute inset-0 bg-gradient-to-t from-white via-white/10 to-transparent"></div>
                            <div class="absolute bottom-6 left-6">
                                <span class="bg-[#4338ca] text-white text-[10px] font-bold uppercase tracking-widest px-3.5 py-1.5 rounded-lg shadow-md" id="detailBadge">Upcoming</span>
                            </div>
                            <button onclick="closeSlideOver()" class="absolute top-4 right-4 w-8 h-8 bg-white/80 backdrop-blur-sm rounded-full flex items-center justify-center text-slate-600 hover:bg-white shadow-sm cursor-pointer transition-colors">
                                <span class="material-symbols-outlined text-[18px]">close</span>
                            </button>
                        </div>

                        <div class="px-8 py-6 flex-1 overflow-y-auto custom-scroll hidden" id="detailContent">
                            <h2 class="text-[26px] font-extrabold text-slate-900 mb-2 tracking-tight leading-tight" id="detailTitle">Select an Event</h2>

                            <!-- Countdown Timer -->
                            <div id="detailCountdown" class="hidden mb-6">
                                <div class="flex items-center gap-2 mb-3">
                                    <span class="material-symbols-outlined text-indigo-500 text-[18px]">timer</span>
                                    <span class="text-[11px] font-bold text-slate-500 uppercase tracking-widest">Starts in</span>
                                </div>
                                <div class="flex gap-2">
                                    <div class="countdown-box rounded-xl px-4 py-3 text-center min-w-[60px]">
                                        <div class="text-xl font-extrabold text-slate-900 leading-none" id="cdDays">0</div>
                                        <div class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider mt-1">Days</div>
                                    </div>
                                    <div class="countdown-box rounded-xl px-4 py-3 text-center min-w-[60px]">
                                        <div class="text-xl font-extrabold text-slate-900 leading-none" id="cdHours">0</div>
                                        <div class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider mt-1">Hrs</div>
                                    </div>
                                    <div class="countdown-box rounded-xl px-4 py-3 text-center min-w-[60px]">
                                        <div class="text-xl font-extrabold text-slate-900 leading-none" id="cdMins">0</div>
                                        <div class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider mt-1">Min</div>
                                    </div>
                                    <div class="countdown-box rounded-xl px-4 py-3 text-center min-w-[60px]">
                                        <div class="text-xl font-extrabold text-slate-900 leading-none" id="cdSecs">0</div>
                                        <div class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider mt-1">Sec</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Event Meta -->
                            <div class="space-y-4 mb-8" id="detailMeta">
                                <div class="flex items-start gap-4 p-3 bg-slate-50/50 rounded-xl hover:bg-slate-50 transition-colors">
                                    <div class="w-9 h-9 rounded-lg bg-indigo-50 flex items-center justify-center shrink-0">
                                        <span class="material-symbols-outlined text-[#4338ca] text-[20px]">calendar_today</span>
                                    </div>
                                    <div>
                                        <div class="text-[14px] font-semibold text-slate-800" id="detailDate">—</div>
                                        <div class="text-[13px] font-medium text-slate-500 mt-0.5" id="detailTime">—</div>
                                    </div>
                                </div>
                                <div class="flex items-start gap-4 p-3 bg-slate-50/50 rounded-xl hover:bg-slate-50 transition-colors">
                                    <div class="w-9 h-9 rounded-lg bg-indigo-50 flex items-center justify-center shrink-0">
                                        <span class="material-symbols-outlined text-[#4338ca] text-[20px]">location_on</span>
                                    </div>
                                    <div>
                                        <div class="text-[14px] font-semibold text-slate-800" id="detailLocation">—</div>
                                        <div class="text-[13px] font-medium text-slate-500 mt-0.5" id="detailHall">—</div>
                                    </div>
                                </div>
                                <div class="flex items-start gap-4 p-3 bg-slate-50/50 rounded-xl hover:bg-slate-50 transition-colors hidden" id="detailWebLinkRow">
                                    <div class="w-9 h-9 rounded-lg bg-indigo-50 flex items-center justify-center shrink-0">
                                        <span class="material-symbols-outlined text-[#4338ca] text-[20px]">language</span>
                                    </div>
                                    <div>
                                        <a href="#" target="_blank" class="text-[14px] font-semibold text-[#4338ca] hover:underline" id="detailWebLink">—</a>
                                    </div>
                                </div>
                            </div>

                            <!-- Stats Grid with Circular Progress -->
                            <div class="grid grid-cols-2 gap-4 mb-8" id="detailStats">
                                <div class="bg-gradient-to-br from-indigo-50/50 to-violet-50/50 border border-indigo-100/60 rounded-2xl p-5">
                                    <div class="text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-4">Capacity</div>
                                    <div class="flex items-center gap-4">
                                        <!-- Circular Progress -->
                                        <div class="relative w-16 h-16 shrink-0" id="circularProgressWrap">
                                            <svg class="circular-progress w-16 h-16" viewBox="0 0 64 64">
                                                <circle cx="32" cy="32" r="28" fill="none" stroke="#e2e8f0" stroke-width="5"/>
                                                <circle id="progressCircle" cx="32" cy="32" r="28" fill="none" stroke="#4338ca" stroke-width="5" stroke-linecap="round"
                                                        stroke-dasharray="175.93" stroke-dashoffset="175.93"/>
                                            </svg>
                                            <div class="absolute inset-0 flex items-center justify-center">
                                                <span class="text-sm font-extrabold text-[#4338ca]" id="progressPct">0%</span>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="text-[22px] font-extrabold text-[#4338ca] leading-none mb-1">
                                                <span id="detailRegistered">0</span>
                                            </div>
                                            <div class="text-xs text-slate-500 font-medium">of <span id="detailCapacity" class="font-semibold text-slate-700">—</span></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gradient-to-br from-slate-50 to-slate-100/50 border border-slate-200/60 rounded-2xl p-5 flex flex-col justify-center">
                                    <div class="text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-3">Event Type</div>
                                    <div class="text-[14px] font-bold" id="detailType">—</div>
                                </div>
                            </div>

                            <!-- Attendees Section -->
                            <div class="mb-8">
                                <div class="text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-4">Attendees</div>
                                <div id="detailAttendeesList" class="grid grid-cols-2 gap-2 max-h-48 overflow-y-auto custom-scroll pr-1">
                                    <!-- Dynamic list of attendees -->
                                </div>
                            </div>
                            
                            <!-- Actions -->
                            <div class="pt-2 space-y-3">
                                <div class="flex gap-3">
                                    <button onclick="editEvent()" class="flex-1 bg-[#4338ca] hover:bg-[#3730a3] text-white text-[14px] font-semibold py-3 rounded-xl flex items-center justify-center gap-2 transition-colors shadow-md shadow-[#4338ca]/15 cursor-pointer">
                                        <span class="material-symbols-outlined text-[18px]">edit</span>
                                        Edit Event
                                    </button>
                                    <button onclick="deleteEvent()" class="w-14 bg-white border border-red-200 hover:bg-red-50 text-red-500 rounded-xl flex items-center justify-center transition-colors shadow-sm cursor-pointer" title="Delete event">
                                        <span class="material-symbols-outlined text-[20px]">delete</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div><!-- end detailContent -->

                    <!-- No selection state -->
                    <div id="detailEmpty" class="flex-1 flex flex-col items-center justify-center text-center px-8">
                        <div class="empty-float mb-4">
                            <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-indigo-50 to-violet-50 flex items-center justify-center shadow-sm">
                                <span class="material-symbols-outlined text-5xl text-indigo-300">calendar_month</span>
                            </div>
                        </div>
                        <h3 class="text-lg font-bold text-slate-500 mb-2">No Event Selected</h3>
                        <p class="text-sm text-slate-400 max-w-[220px]">Click on an event card to view details, or create a new event.</p>
                    </div>

                    <!-- Form View (Create/Edit) -->
                    <div id="formView" class="h-full hidden flex flex-col">
                        <!-- Header -->
                        <div class="shrink-0 px-8 pt-8 pb-4 border-b border-slate-100 flex items-center justify-between">
                            <h2 class="text-xl font-bold text-slate-900" id="formTitle">Create Event</h2>
                            <button onclick="closeSlideOver()" class="w-8 h-8 bg-slate-100 rounded-full flex items-center justify-center text-slate-500 hover:bg-slate-200 cursor-pointer transition-colors">
                                <span class="material-symbols-outlined text-[18px]">close</span>
                            </button>
                        </div>

                        <form id="eventForm" class="flex-1 overflow-y-auto custom-scroll px-8 py-6 space-y-6">
                            <input type="hidden" id="eventId" value="">

                            <!-- Cover Image -->
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Cover Image</label>
                                <label class="file-input-label relative block border-2 border-dashed border-slate-300 rounded-xl p-6 text-center cursor-pointer" id="imageUploadLabel">
                                    <input type="file" name="cover_image" accept="image/*" class="hidden" id="coverImageInput">
                                    <div id="imagePlaceholder">
                                        <span class="material-symbols-outlined text-3xl text-slate-400 mb-2">add_photo_alternate</span>
                                        <p class="text-sm text-slate-500 font-medium">Click to upload cover image</p>
                                        <p class="text-xs text-slate-400 mt-1">PNG, JPG up to 2MB</p>
                                    </div>
                                    <img id="imagePreview" class="hidden w-full h-40 object-cover rounded-lg" src="#" alt="Preview">
                                </label>
                            </div>

                            <!-- Title -->
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Event Title</label>
                                <input type="text" name="title" id="inputTitle" required
                                       class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#4338ca]/20 focus:border-[#4338ca] transition-all"
                                       placeholder="Enter event title">
                            </div>

                            <!-- Date & Time -->
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">Start Date & Time</label>
                                    <input type="datetime-local" name="start_date" id="inputStartDate" required
                                           class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#4338ca]/20 focus:border-[#4338ca] transition-all">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">End Date & Time</label>
                                    <input type="datetime-local" name="end_date" id="inputEndDate"
                                           class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#4338ca]/20 focus:border-[#4338ca] transition-all">
                                </div>
                            </div>

                            <!-- Location -->
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Address</label>
                                <input type="text" name="address" id="inputAddress"
                                       class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#4338ca]/20 focus:border-[#4338ca] transition-all"
                                       placeholder="Event address">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Hall Name / Number</label>
                                <input type="text" name="hall_name" id="inputHall"
                                       class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#4338ca]/20 focus:border-[#4338ca] transition-all"
                                       placeholder="e.g. Grand Ballroom, Room 301">
                            </div>

                            <!-- Seating Capacity Toggle -->
                            <div>
                                <div class="flex items-center justify-between mb-3">
                                    <div>
                                        <label class="text-sm font-semibold text-slate-700">Seating Capacity</label>
                                        <p class="text-xs text-slate-500 mt-0.5">Limit the number of attendees</p>
                                    </div>
                                    <div class="toggle-switch w-12 h-6 bg-slate-200 rounded-full relative cursor-pointer border border-slate-300/50 shadow-inner shrink-0" id="capacityToggle" onclick="toggleCapacity()">
                                        <div class="toggle-knob w-4 h-4 bg-white rounded-full absolute left-1 top-1 shadow-sm border border-slate-200"></div>
                                    </div>
                                </div>
                                <div id="capacityInputWrap" class="hidden">
                                    <input type="number" name="seating_capacity" id="inputCapacity" min="1"
                                           class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#4338ca]/20 focus:border-[#4338ca] transition-all"
                                           placeholder="e.g. 150">
                                    <input type="hidden" name="has_seating_capacity" id="inputHasCapacity" value="0">
                                </div>
                            </div>

                            <!-- Event Type -->
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-3">Event Type</label>
                                <div class="flex gap-3">
                                    <label class="flex-1 flex items-center justify-center gap-2 p-3 border-2 border-[#4338ca] bg-[#f5f5fc] rounded-xl cursor-pointer transition-colors" id="typeGmaLabel" onclick="selectType('gma')">
                                        <input type="radio" name="event_type" value="gma" checked class="hidden">
                                        <span class="material-symbols-outlined text-[#4338ca] text-[20px]">stars</span>
                                        <span class="text-sm font-semibold text-[#4338ca]">GMA Event</span>
                                    </label>
                                    <label class="flex-1 flex items-center justify-center gap-2 p-3 border-2 border-slate-200 rounded-xl cursor-pointer transition-colors hover:border-slate-300" id="typeOtherLabel" onclick="selectType('other')">
                                        <input type="radio" name="event_type" value="other" class="hidden">
                                        <span class="material-symbols-outlined text-slate-500 text-[20px]">public</span>
                                        <span class="text-sm font-semibold text-slate-600">Other Event</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Website Link (shown when "Other Event" selected) -->
                            <div id="websiteLinkWrap" class="hidden">
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Website Link</label>
                                <input type="url" name="website_link" id="inputWebsite"
                                       class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#4338ca]/20 focus:border-[#4338ca] transition-all"
                                       placeholder="https://example.com">
                            </div>

                            <!-- Submit -->
                            <div class="flex gap-3 pt-2">
                                <button type="submit" id="formSubmitBtn"
                                        class="flex-1 bg-[#4338ca] hover:bg-[#3730a3] text-white text-sm font-semibold py-3 rounded-xl transition-colors shadow-md shadow-[#4338ca]/20 cursor-pointer">
                                    Save Event
                                </button>
                                <button type="button" onclick="closeSlideOver()"
                                        class="flex-1 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-sm font-semibold py-3 rounded-xl transition-colors shadow-sm cursor-pointer">
                                    Cancel
                                </button>
                            </div>

                            <div id="formError" class="hidden p-3 bg-red-50 border border-red-200 rounded-xl text-sm text-red-700"></div>
                        </form>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <script>
        let events = @json($eventsJson);

        let selectedEventId = null;
        let isFormView = false;
        let countdownInterval = null;

        // ============ COUNT-UP ANIMATION ============
        function animateCountUp() {
            document.querySelectorAll('[data-count-to]').forEach(el => {
                const target = parseInt(el.dataset.countTo) || 0;
                if (target === 0) { el.textContent = '0'; return; }
                const duration = 800;
                const startTime = performance.now();
                function tick(now) {
                    const elapsed = now - startTime;
                    const progress = Math.min(elapsed / duration, 1);
                    const eased = 1 - Math.pow(1 - progress, 3); // ease-out cubic
                    el.textContent = Math.round(target * eased);
                    if (progress < 1) requestAnimationFrame(tick);
                }
                requestAnimationFrame(tick);
            });
        }

        // ============ COUNTDOWN TIMER ============
        function startCountdown(startDateStr) {
            const cdWrap = document.getElementById('detailCountdown');
            if (countdownInterval) clearInterval(countdownInterval);

            const startDate = new Date(startDateStr);
            const now = new Date();

            if (startDate <= now) {
                cdWrap.classList.add('hidden');
                return;
            }

            cdWrap.classList.remove('hidden');

            function updateCountdown() {
                const now = new Date();
                const diff = startDate - now;
                if (diff <= 0) {
                    clearInterval(countdownInterval);
                    cdWrap.classList.add('hidden');
                    return;
                }
                const days = Math.floor(diff / (1000 * 60 * 60 * 24));
                const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const mins = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                const secs = Math.floor((diff % (1000 * 60)) / 1000);
                document.getElementById('cdDays').textContent = days;
                document.getElementById('cdHours').textContent = hours;
                document.getElementById('cdMins').textContent = mins;
                document.getElementById('cdSecs').textContent = secs;
            }

            updateCountdown();
            countdownInterval = setInterval(updateCountdown, 1000);
        }

        // ============ CIRCULAR PROGRESS ============
        function setCircularProgress(pct) {
            const circle = document.getElementById('progressCircle');
            const label = document.getElementById('progressPct');
            const circumference = 2 * Math.PI * 28; // r=28
            const offset = circumference - (pct / 100) * circumference;
            circle.style.strokeDashoffset = offset;
            label.textContent = pct + '%';
        }

        // ============ SELECT EVENT ============
        function selectEvent(id) {
            selectedEventId = id;
            const event = events.find(e => e.id === id);
            if (!event) return;

            // Update cards
            document.querySelectorAll('.event-card').forEach(c => c.classList.remove('selected'));
            const card = document.querySelector(`.event-card[data-event-id="${id}"]`);
            if (card) card.classList.add('selected');

            // Show detail view, hide form
            document.getElementById('formView').classList.add('hidden');
            document.getElementById('detailView').classList.remove('hidden');
            document.getElementById('detailEmpty').classList.add('hidden');
            document.getElementById('detailBanner').classList.remove('hidden');
            document.getElementById('detailContent').classList.remove('hidden');
            isFormView = false;

            // Fill detail
            document.getElementById('detailBannerImg').src = event.cover_image_url || 'https://images.unsplash.com/photo-1511795409834-ef04bbd61622?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80';
            document.getElementById('detailTitle').textContent = event.title;

            const eventDate = new Date(event.start_date);
            const isUpcoming = eventDate > new Date();
            document.getElementById('detailBadge').textContent = isUpcoming ? 'Upcoming' : 'Past';
            document.getElementById('detailBadge').className = isUpcoming
                ? 'bg-[#4338ca] text-white text-[10px] font-bold uppercase tracking-widest px-3.5 py-1.5 rounded-lg shadow-md'
                : 'bg-slate-500 text-white text-[10px] font-bold uppercase tracking-widest px-3.5 py-1.5 rounded-lg shadow-md';

            document.getElementById('detailDate').textContent = event.start_date_formatted;
            document.getElementById('detailTime').textContent = event.start_time_formatted + (event.end_date_formatted ? ' - ' + event.end_date_formatted : '');

            if (event.address) {
                document.getElementById('detailLocation').textContent = event.hall_name ? event.hall_name + ', ' + event.address : event.address;
                document.getElementById('detailHall').textContent = event.hall_name ? event.address : '';
            } else {
                document.getElementById('detailLocation').textContent = 'No location set';
                document.getElementById('detailHall').textContent = '';
            }

            // Website link
            const webRow = document.getElementById('detailWebLinkRow');
            if (event.event_type === 'other' && event.website_link) {
                webRow.classList.remove('hidden');
                document.getElementById('detailWebLink').href = event.website_link;
                document.getElementById('detailWebLink').textContent = event.website_link;
            } else {
                webRow.classList.add('hidden');
            }

            // Stats - Circular Progress
            document.getElementById('detailRegistered').textContent = event.registered_count;
            if (event.has_seating_capacity && event.seating_capacity) {
                document.getElementById('detailCapacity').textContent = event.seating_capacity;
                document.getElementById('circularProgressWrap').style.display = '';
                const pct = Math.min(100, Math.round((event.registered_count / event.seating_capacity) * 100));
                // Animate after a short delay
                setCircularProgress(0);
                setTimeout(() => setCircularProgress(pct), 100);
            } else {
                document.getElementById('detailCapacity').textContent = 'Unlimited';
                document.getElementById('circularProgressWrap').style.display = 'none';
                document.getElementById('progressPct').textContent = '';
            }

            document.getElementById('detailType').textContent = event.event_type === 'gma' ? 'GMA Event' : 'Other Event';
            document.getElementById('detailType').className = event.event_type === 'gma'
                ? 'text-[14px] font-bold text-indigo-600'
                : 'text-[14px] font-bold text-amber-600';

            // Attendees List
            const attendeeWrap = document.getElementById('detailAttendeesList');
            attendeeWrap.innerHTML = '';
            const attendees = event.attendees || [];
            if (attendees.length > 0) {
                attendees.forEach(a => {
                    const row = document.createElement('div');
                    row.className = 'flex items-center gap-2 bg-slate-50 border border-slate-100 rounded-xl p-2';
                    
                    const img = document.createElement('img');
                    img.src = a.avatar || 'https://ui-avatars.com/api/?name=' + encodeURIComponent(a.name) + '&background=4338ca&color=fff';
                    img.className = 'w-6 h-6 rounded-full object-cover shadow-sm border border-white';
                    img.alt = a.name;
                    
                    const name = document.createElement('span');
                    name.className = 'text-xs font-semibold text-slate-700 truncate';
                    name.style.maxWidth = '100px';
                    name.textContent = a.name;
                    name.title = a.name;
                    
                    row.appendChild(img);
                    row.appendChild(name);
                    attendeeWrap.appendChild(row);
                });
            } else {
                attendeeWrap.innerHTML = '<div class="text-xs text-slate-400 italic py-2 col-span-2">No attendees registered yet.</div>';
            }

            // Countdown
            if (isUpcoming) {
                startCountdown(event.start_date);
            } else {
                document.getElementById('detailCountdown').classList.add('hidden');
                if (countdownInterval) clearInterval(countdownInterval);
            }

            openSlideOver();
        }

        function showCreateForm() {
            isFormView = true;
            selectedEventId = null;
            document.getElementById('eventId').value = '';
            document.getElementById('formTitle').textContent = 'Create Event';
            document.getElementById('formSubmitBtn').textContent = 'Save Event';
            document.getElementById('eventForm').reset();
            document.getElementById('imagePreview').classList.add('hidden');
            document.getElementById('imagePlaceholder').classList.remove('hidden');
            document.getElementById('imageUploadLabel').classList.remove('border-[#4338ca]', 'bg-[#f5f5fc]');
            document.getElementById('capacityToggle').classList.remove('active');
            document.getElementById('capacityInputWrap').classList.add('hidden');
            document.getElementById('inputHasCapacity').value = '0';
            document.getElementById('websiteLinkWrap').classList.add('hidden');
            document.getElementById('formError').classList.add('hidden');
            selectType('gma');
            formatDateInputs();

            document.getElementById('detailEmpty').classList.add('hidden');
            document.getElementById('detailView').classList.add('hidden');
            document.getElementById('formView').classList.remove('hidden');
            openSlideOver();
        }

        function editEvent() {
            if (!selectedEventId) return;
            const event = events.find(e => e.id === selectedEventId);
            if (!event) return;

            isFormView = true;
            document.getElementById('eventId').value = event.id;
            document.getElementById('formTitle').textContent = 'Edit Event';
            document.getElementById('formSubmitBtn').textContent = 'Update Event';
            document.getElementById('inputTitle').value = event.title;

            formatDateInputs();
            if (event.start_date) {
                document.getElementById('inputStartDate').value = toDatetimeLocalValue(event.start_date);
            }
            if (event.end_date) {
                document.getElementById('inputEndDate').value = toDatetimeLocalValue(event.end_date);
            }

            document.getElementById('inputAddress').value = event.address || '';
            document.getElementById('inputHall').value = event.hall_name || '';

            if (event.has_seating_capacity) {
                document.getElementById('capacityToggle').classList.add('active');
                document.getElementById('capacityInputWrap').classList.remove('hidden');
                document.getElementById('inputHasCapacity').value = '1';
                document.getElementById('inputCapacity').value = event.seating_capacity || '';
            } else {
                document.getElementById('capacityToggle').classList.remove('active');
                document.getElementById('capacityInputWrap').classList.add('hidden');
                document.getElementById('inputHasCapacity').value = '0';
                document.getElementById('inputCapacity').value = '';
            }

            selectType(event.event_type);
            if (event.event_type === 'other') {
                document.getElementById('websiteLinkWrap').classList.remove('hidden');
                document.getElementById('inputWebsite').value = event.website_link || '';
            }

            if (event.cover_image_url) {
                document.getElementById('imagePreview').src = event.cover_image_url;
                document.getElementById('imagePreview').classList.remove('hidden');
                document.getElementById('imagePlaceholder').classList.add('hidden');
                document.getElementById('imageUploadLabel').classList.add('border-[#4338ca]', 'bg-[#f5f5fc]');
            }

            document.getElementById('formError').classList.add('hidden');

            document.getElementById('detailEmpty').classList.add('hidden');
            document.getElementById('detailView').classList.add('hidden');
            document.getElementById('formView').classList.remove('hidden');
            openSlideOver();
        }

        const destroyUrl = '{{ route("admin.events.destroy", ":id") }}';

        function deleteEvent() {
            if (!selectedEventId) return;
            if (!confirm('Are you sure you want to delete this event?')) return;

            fetch(destroyUrl.replace(':id', selectedEventId), {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                }
            })
            .then(r => r.json())
            .then(data => {
                if (data.message) {
                    const card = document.querySelector(`.event-card[data-event-id="${selectedEventId}"]`);
                    if (card) card.remove();
                    events = events.filter(e => e.id !== selectedEventId);
                    selectedEventId = null;
                    closeSlideOver();
                    location.reload();
                }
            })
            .catch(() => alert('Failed to delete event.'));
        }

        function openSlideOver() {
            document.getElementById('slideOver').classList.add('open');
            document.getElementById('overlay').classList.add('open');
        }

        function closeSlideOver() {
            document.getElementById('slideOver').classList.remove('open');
            document.getElementById('overlay').classList.remove('open');
            document.getElementById('detailView').classList.remove('hidden');
            document.getElementById('formView').classList.add('hidden');
            document.getElementById('detailBanner').classList.add('hidden');
            document.getElementById('detailContent').classList.add('hidden');
            document.getElementById('detailEmpty').classList.remove('hidden');
            document.getElementById('detailCountdown').classList.add('hidden');
            if (countdownInterval) clearInterval(countdownInterval);
            isFormView = false;
            // Deselect card
            document.querySelectorAll('.event-card').forEach(c => c.classList.remove('selected'));
        }

        function showDetailView() {
            document.getElementById('formView').classList.add('hidden');
            document.getElementById('detailView').classList.remove('hidden');
        }

        function toggleCapacity() {
            const toggle = document.getElementById('capacityToggle');
            const wrap = document.getElementById('capacityInputWrap');
            const input = document.getElementById('inputHasCapacity');
            toggle.classList.toggle('active');
            const isActive = toggle.classList.contains('active');
            wrap.classList.toggle('hidden', !isActive);
            input.value = isActive ? '1' : '0';
        }

        function selectType(type) {
            const gmaLabel = document.getElementById('typeGmaLabel');
            const otherLabel = document.getElementById('typeOtherLabel');
            const webWrap = document.getElementById('websiteLinkWrap');
            const gmaRadio = gmaLabel.querySelector('input[value="gma"]');
            const otherRadio = otherLabel.querySelector('input[value="other"]');

            if (type === 'gma') {
                gmaRadio.checked = true;
                gmaLabel.className = 'flex-1 flex items-center justify-center gap-2 p-3 border-2 border-[#4338ca] bg-[#f5f5fc] rounded-xl cursor-pointer transition-colors';
                otherLabel.className = 'flex-1 flex items-center justify-center gap-2 p-3 border-2 border-slate-200 rounded-xl cursor-pointer transition-colors hover:border-slate-300';
                webWrap.classList.add('hidden');
            } else {
                otherRadio.checked = true;
                otherLabel.className = 'flex-1 flex items-center justify-center gap-2 p-3 border-2 border-[#4338ca] bg-[#f5f5fc] rounded-xl cursor-pointer transition-colors';
                gmaLabel.className = 'flex-1 flex items-center justify-center gap-2 p-3 border-2 border-slate-200 rounded-xl cursor-pointer transition-colors hover:border-slate-300';
                webWrap.classList.remove('hidden');
            }
        }

        function formatDateInputs() {
            const now = new Date();
            const offset = now.getTimezoneOffset();
            const local = new Date(now.getTime() - offset * 60000);
            const defaultVal = local.toISOString().slice(0, 16);
            if (!document.getElementById('inputStartDate').value) {
                document.getElementById('inputStartDate').value = defaultVal;
            }
        }

        function toDatetimeLocalValue(isoString) {
            const d = new Date(isoString);
            const offset = d.getTimezoneOffset();
            const local = new Date(d.getTime() - offset * 60000);
            return local.toISOString().slice(0, 16);
        }

        // Image preview
        document.getElementById('coverImageInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(ev) {
                    const preview = document.getElementById('imagePreview');
                    preview.src = ev.target.result;
                    preview.classList.remove('hidden');
                    document.getElementById('imagePlaceholder').classList.add('hidden');
                    document.getElementById('imageUploadLabel').classList.add('border-[#4338ca]', 'bg-[#f5f5fc]');
                };
                reader.readAsDataURL(file);
            }
        });

        const storeUrl = '{{ route("admin.events.store") }}';
        const updateUrl = '{{ route("admin.events.update", ":id") }}';

        // Form submission
        document.getElementById('eventForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            formData.append('_token', '{{ csrf_token() }}');
            const eventId = document.getElementById('eventId').value;
            const isEdit = !!eventId;
            const url = isEdit ? updateUrl.replace(':id', eventId) : storeUrl;

            // Remove empty file input so validation doesn't reject it
            if (!document.getElementById('coverImageInput').files.length) {
                formData.delete('cover_image');
            }

            // Remove seating_capacity when toggle is off
            if (document.getElementById('inputHasCapacity').value === '0') {
                formData.delete('seating_capacity');
            }

            // Remove website_link when event type is gma
            if (document.querySelector('input[name="event_type"]:checked')?.value === 'gma') {
                formData.delete('website_link');
            }

            if (isEdit) {
                formData.append('_method', 'PUT');
            }

            const btn = document.getElementById('formSubmitBtn');
            btn.disabled = true;
            btn.textContent = 'Saving...';

            const errDiv = document.getElementById('formError');
            errDiv.classList.add('hidden');

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: formData,
            })
            .then(async r => {
                let data;
                try { data = await r.json(); } catch { data = null; }
                if (r.ok && data?.event) {
                    location.reload();
                } else {
                    btn.disabled = false;
                    btn.textContent = isEdit ? 'Update Event' : 'Save Event';
                    if (data?.errors) {
                        errDiv.textContent = Object.values(data.errors).flat().join(', ');
                    } else if (data?.message) {
                        errDiv.textContent = data.message;
                    } else {
                        errDiv.textContent = 'Server error (HTTP ' + r.status + '). Please try again.';
                    }
                    errDiv.classList.remove('hidden');
                }
            })
            .catch(() => {
                btn.disabled = false;
                btn.textContent = isEdit ? 'Update Event' : 'Save Event';
                errDiv.textContent = 'Network error. Please check your connection and try again.';
                errDiv.classList.remove('hidden');
            });
        });

        // Filter buttons
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.filter-btn').forEach(b => {
                    b.classList.remove('bg-[#4338ca]', 'text-white', 'shadow-md', 'shadow-[#4338ca]/15');
                    b.classList.add('bg-white', 'text-slate-600', 'border', 'border-slate-200');
                });
                this.classList.remove('bg-white', 'text-slate-600', 'border-slate-200');
                this.classList.add('bg-[#4338ca]', 'text-white', 'shadow-md', 'shadow-[#4338ca]/15');

                const filter = this.dataset.filter;
                const now = new Date();
                document.querySelectorAll('.event-card').forEach(card => {
                    const event = events.find(e => e.id == card.dataset.eventId);
                    if (!event) return;
                    const eventDate = new Date(event.start_date);
                    if (filter === 'all') {
                        card.style.display = '';
                    } else if (filter === 'upcoming') {
                        card.style.display = eventDate >= now ? '' : 'none';
                    } else if (filter === 'past') {
                        card.style.display = eventDate < now ? '' : 'none';
                    }
                });
            });
        });

        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function() {
            const query = this.value.toLowerCase().trim();
            document.querySelectorAll('.event-card').forEach(card => {
                const event = events.find(e => e.id == card.dataset.eventId);
                if (!event) return;
                const match = event.title.toLowerCase().includes(query) ||
                              (event.address || '').toLowerCase().includes(query) ||
                              (event.hall_name || '').toLowerCase().includes(query);
                card.style.display = match ? '' : 'none';
            });
        });

        // Sort functionality
        document.getElementById('sortSelect').addEventListener('change', function() {
            const grid = document.getElementById('eventsGrid');
            const cards = Array.from(grid.querySelectorAll('.event-card'));
            const sort = this.value;

            cards.sort((a, b) => {
                const eventA = events.find(e => e.id == a.dataset.eventId);
                const eventB = events.find(e => e.id == b.dataset.eventId);
                if (!eventA || !eventB) return 0;

                if (sort === 'date_desc') return new Date(eventB.start_date) - new Date(eventA.start_date);
                if (sort === 'date_asc') return new Date(eventA.start_date) - new Date(eventB.start_date);
                if (sort === 'name_asc') return eventA.title.localeCompare(eventB.title);
                if (sort === 'name_desc') return eventB.title.localeCompare(eventA.title);
                return 0;
            });

            cards.forEach(card => grid.appendChild(card));
        });

        // Close on Escape or click outside
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeSlideOver();
        });
        document.getElementById('overlay').addEventListener('click', closeSlideOver);

        // Init animations on page load
        document.addEventListener('DOMContentLoaded', function() {
            animateCountUp();
        });
    </script>

    @include('components.settings-modal')
</body>
</html>
