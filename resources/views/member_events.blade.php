<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GMA - Events Dashboard</title>
    <link rel="icon" href="/Global_Mobile_Association_Logo__1_-removebg-preview.png" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0,1&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f7fa;
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .material-symbols-outlined.fill {
            font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        
        .custom-scroll::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        .custom-scroll::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scroll::-webkit-scrollbar-thumb {
            background-color: #cbd5e1;
            border-radius: 10px;
        }

        /* Emil Kowalski & UI/UX Pro Max Variables */
        :root {
            --ease-out: cubic-bezier(0.23, 1, 0.32, 1);
            --ease-elastic: cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        /* Hover Sheen Sweep Effect */
        .hover-sheen {
            position: relative;
            overflow: hidden;
        }
        .hover-sheen::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -100%;
            width: 50%;
            height: 200%;
            background: linear-gradient(
                to right,
                rgba(255, 255, 255, 0) 0%,
                rgba(255, 255, 255, 0.3) 50%,
                rgba(255, 255, 255, 0) 100%
            );
            transform: rotate(30deg);
            transition: none;
            pointer-events: none;
            opacity: 0;
            z-index: 10;
        }
        .hover-sheen:hover::after {
            transition: left 900ms var(--ease-out);
            left: 150%;
            opacity: 1;
        }

        /* Smooth buttons */
        .emil-btn {
            transition: transform 180ms var(--ease-out), filter 200ms ease, opacity 200ms ease, box-shadow 200ms ease !important;
        }
        .emil-btn:active {
            transform: scale(0.96) !important;
        }

        /* Scroll Animations */
        .animate-on-scroll {
            opacity: 0;
            transform: translateY(35px) scale(0.97);
            transition: opacity 800ms var(--ease-out), transform 800ms var(--ease-out);
        }
        .animate-on-scroll.is-visible {
            opacity: 1;
            transform: translateY(0) scale(1);
        }

        /* Staggered Children Animations */
        .stagger-children > * {
            opacity: 0;
            transform: translateY(25px) scale(0.97);
            transition: opacity 700ms var(--ease-out), transform 700ms var(--ease-out);
        }
        .stagger-children.is-visible > *:nth-child(1) { transition-delay: 0ms; opacity: 1; transform: translateY(0) scale(1); }
        .stagger-children.is-visible > *:nth-child(2) { transition-delay: 75ms; opacity: 1; transform: translateY(0) scale(1); }
        .stagger-children.is-visible > *:nth-child(3) { transition-delay: 150ms; opacity: 1; transform: translateY(0) scale(1); }
        .stagger-children.is-visible > *:nth-child(4) { transition-delay: 225ms; opacity: 1; transform: translateY(0) scale(1); }
        .stagger-children.is-visible > *:nth-child(5) { transition-delay: 300ms; opacity: 1; transform: translateY(0) scale(1); }
        .stagger-children.is-visible > *:nth-child(6) { transition-delay: 375ms; opacity: 1; transform: translateY(0) scale(1); }

        @keyframes header-spring-in {
            0% { transform: translateY(-100%); opacity: 0; }
            100% { transform: translateY(0); opacity: 1; }
        }
        .animate-header-spring {
            animation: header-spring-in 800ms cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        }

    </style>
</head>
<body class="overflow-hidden text-slate-800">

    <div class="flex h-screen w-full">
        <!-- Sidebar -->
        @include('components.member-sidebar', ['active' => 'events'])

        <!-- Main Content Area -->
        <main class="flex-1 flex flex-col min-w-0 bg-[#f3f7fa]">
            <!-- Top Header (Simplified) -->
            <header class="h-16 border-b border-slate-200 flex items-center justify-end px-8 bg-white shrink-0 animate-header-spring z-10">
                <div class="flex items-center gap-5 h-full stagger-children animate-on-scroll is-visible" style="transition-delay: 100ms;">
                    <button class="text-slate-400 hover:text-slate-600 emil-btn">
                        <span class="material-symbols-outlined text-[22px]">notifications</span>
                    </button>
                    <button class="text-slate-400 hover:text-slate-600 emil-btn">
                        <span class="material-symbols-outlined text-[22px]">apps</span>
                    </button>
                    
                    <div class="w-8 h-8 rounded-full overflow-hidden shadow-sm shrink-0 border border-slate-200 emil-btn cursor-pointer">
                        <img src="{{ auth()->check() ? auth()->user()->avatarUrl() : 'https://ui-avatars.com/api/?name=Member+User&background=103C68&color=fff' }}" alt="User" class="w-full h-full object-cover">
                    </div>
                </div>
            </header>
            
            <div class="flex-1 flex flex-col min-h-0 p-4 lg:p-6 xl:p-8">
                <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 flex-1 flex flex-col overflow-hidden animate-on-scroll is-visible">
                    <!-- Content Body -->
                <div class="flex-1 overflow-y-auto custom-scroll p-8 bg-[#fbfcfd]">
                    <div class="grid grid-cols-1 xl:grid-cols-12 gap-8 max-w-7xl 2xl:max-w-[1600px] mx-auto">
                        
                        <!-- Left Main Column (Cards & Events) -->
                        <div class="xl:col-span-8 flex flex-col gap-8">
                            
                            <!-- Capacity Cards -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 stagger-children animate-on-scroll">
                                <!-- GMA Events -->
                                <div class="kowalski-card kowalski-card-hover hover-sheen p-5 flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-sm">
                                        GE
                                    </div>
                                    <div>
                                        <h3 class="text-[15px] 2xl:text-[18px] font-bold text-slate-800">GMA Events</h3>
                                        <p class="text-[12px] 2xl:text-[14px] text-slate-500 mt-0.5">Total : <span class="text-blue-600 font-bold">{{ $gmaEventsCount }}</span> Events</p>
                                    </div>
                                </div>
                                <!-- Other Events -->
                                <div class="kowalski-card kowalski-card-hover hover-sheen p-5 flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-full bg-orange-50 text-orange-500 flex items-center justify-center font-bold text-sm">
                                        OE
                                    </div>
                                    <div>
                                        <h3 class="text-[15px] 2xl:text-[18px] font-bold text-slate-800">Other Events</h3>
                                        <p class="text-[12px] 2xl:text-[14px] text-slate-500 mt-0.5">Total : <span class="text-orange-500 font-bold">{{ $otherEventsCount }}</span> Events</p>
                                    </div>
                                </div>
                                <!-- My Registrations -->
                                <div class="kowalski-card kowalski-card-hover hover-sheen p-5 flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-full bg-emerald-50 text-emerald-500 flex items-center justify-center font-bold text-sm">
                                        MR
                                    </div>
                                    <div>
                                        <h3 class="text-[15px] 2xl:text-[18px] font-bold text-slate-800">My Registrations</h3>
                                        <p class="text-[12px] 2xl:text-[14px] text-slate-500 mt-0.5">Registered : <span class="text-emerald-500 font-bold">{{ $myRegistrationsCount }}</span> Events</p>
                                    </div>
                                </div>
                            </div>

                            <!-- GMA Events -->
                            <div class="bg-white border border-slate-100 rounded-[20px] p-6 shadow-[0_4px_20px_-10px_rgba(0,0,0,0.05)] animate-on-scroll">
                                <div class="flex justify-between items-center mb-6">
                                    <h2 class="text-[16px] 2xl:text-[22px] font-bold text-slate-800">GMA Events</h2>
                                    <button class="text-slate-400 hover:text-slate-600 emil-btn"><span class="material-symbols-outlined">more_horiz</span></button>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 stagger-children animate-on-scroll">
                                    @forelse($gmaEvents as $event)
                                        <div onclick="openEventDetails(this)" 
                                             class="flex flex-col group cursor-pointer kowalski-spring hover:-translate-y-1"
                                             data-event-id="{{ $event->id }}"
                                             data-title="{{ $event->title }}"
                                             data-cover="{{ $event->cover_image ? asset('storage/' . $event->cover_image) : '' }}"
                                             data-start="{{ $event->start_date->format('M d, Y \a\t g:i A') }}"
                                             data-end="{{ $event->end_date ? $event->end_date->format('M d, Y \a\t g:i A') : 'N/A' }}"
                                             data-address="{{ $event->address ?? 'N/A' }}"
                                             data-hall="{{ $event->hall_name ?? 'N/A' }}"
                                             data-type="{{ $event->event_type }}"
                                             data-website="{{ $event->website_link ?? '' }}"
                                             data-capacity="{{ $event->seating_capacity ?? 'Unlimited' }}"
                                             data-registered="{{ $event->registered_count }}"
                                             data-attendees="{{ json_encode($event->attendees->map(fn($a) => ['id' => $a->user_id, 'name' => $a->user->name ?? 'Member', 'avatar' => $a->user ? $a->user->avatarUrl() : ''])) }}">
                                            <div class="rounded-[14px] overflow-hidden mb-3.5 h-32 relative bg-slate-100">
                                                @if($event->cover_image)
                                                    <img src="{{ asset('storage/' . $event->cover_image) }}" alt="{{ $event->title }}" class="w-full h-full object-cover kowalski-spring group-hover:scale-110 group-hover:rotate-1">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center bg-indigo-50 text-indigo-500">
                                                        <span class="material-symbols-outlined text-[32px]">event</span>
                                                    </div>
                                                @endif
                                            </div>
                                            <h4 class="text-[13px] font-bold text-slate-800 mb-1.5 leading-snug truncate" title="{{ $event->title }}">{{ $event->title }}</h4>
                                            <div class="flex items-center gap-1.5 text-[11px] text-slate-500 font-medium mb-0.5">
                                                <span class="material-symbols-outlined text-[14px]">schedule</span>
                                                {{ $event->start_date->format('d M Y, h:i A') }}
                                            </div>
                                            @if($event->address)
                                            <div class="flex items-center gap-1.5 text-[10px] text-slate-400 font-medium truncate">
                                                <span class="material-symbols-outlined text-[12px]">location_on</span>
                                                {{ $event->address }}
                                            </div>
                                            @endif
                                            <div class="flex items-center gap-2 mt-2">
                                                <div class="flex -space-x-1.5">
                                                    @foreach($event->attendees->take(3) as $attendee)
                                                        @if($attendee->user)
                                                        <img class="w-5 h-5 rounded-full border-2 border-white object-cover" src="{{ $attendee->user->avatarUrl() }}" alt="{{ $attendee->user->name }}" title="{{ $attendee->user->name }}">
                                                        @endif
                                                    @endforeach
                                                </div>
                                                <span class="text-[10px] font-semibold text-slate-400">{{ $event->registered_count }}/{{ $event->seating_capacity ?? '∞' }}</span>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-span-full py-8 text-center text-slate-400 text-sm">
                                            <span class="material-symbols-outlined text-4xl mb-2 text-slate-300 block">event_busy</span>
                                            No GMA events at the moment.
                                        </div>
                                    @endforelse
                                </div>
                            </div>

                            <!-- Other Events -->
                            <div class="bg-white border border-slate-100 rounded-[20px] p-6 shadow-[0_4px_20px_-10px_rgba(0,0,0,0.05)] animate-on-scroll">
                                <div class="flex justify-between items-center mb-6">
                                    <h2 class="text-[16px] 2xl:text-[22px] font-bold text-slate-800">Other Events</h2>
                                    <button class="text-slate-400 hover:text-slate-600 emil-btn"><span class="material-symbols-outlined">more_horiz</span></button>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 stagger-children animate-on-scroll">
                                    @forelse($otherEvents as $event)
                                        <div onclick="openEventDetails(this)" 
                                             class="border border-slate-100 rounded-[14px] p-4.5 flex flex-col cursor-pointer kowalski-spring hover:border-blue-200 hover:shadow-[0_8px_24px_rgba(0,0,0,0.06)] hover:-translate-y-1 hover-sheen"
                                             data-event-id="{{ $event->id }}"
                                             data-title="{{ $event->title }}"
                                             data-cover="{{ $event->cover_image ? asset('storage/' . $event->cover_image) : '' }}"
                                             data-start="{{ $event->start_date->format('M d, Y \a\t g:i A') }}"
                                             data-end="{{ $event->end_date ? $event->end_date->format('M d, Y \a\t g:i A') : 'N/A' }}"
                                             data-address="{{ $event->address ?? 'N/A' }}"
                                             data-hall="{{ $event->hall_name ?? 'N/A' }}"
                                             data-type="{{ $event->event_type }}"
                                             data-website="{{ $event->website_link ?? '' }}"
                                             data-capacity="{{ $event->seating_capacity ?? 'Unlimited' }}"
                                             data-registered="{{ $event->registered_count }}"
                                             data-attendees="{{ json_encode($event->attendees->map(fn($a) => ['id' => $a->user_id, 'name' => $a->user->name ?? 'Member', 'avatar' => $a->user ? $a->user->avatarUrl() : ''])) }}">
                                            <div class="text-[10px] font-bold text-blue-600 bg-blue-50/80 px-2.5 py-1 rounded-full inline-block w-max mb-5 tracking-wide">
                                                {{ $event->start_date->format('d M Y') }}
                                            </div>
                                            <h4 class="text-[13px] font-bold text-slate-800 mb-1.5 leading-snug truncate" title="{{ $event->title }}">{{ $event->title }}</h4>
                                            <div class="flex items-center gap-1.5 text-[11px] text-slate-500 font-medium mb-0.5">
                                                <span class="material-symbols-outlined text-[14px]">schedule</span>
                                                {{ $event->start_date->format('h:i A') }}{{ $event->end_date ? ' - ' . $event->end_date->format('h:i A') : '' }}
                                            </div>
                                            @if($event->address)
                                            <div class="flex items-center gap-1.5 text-[10px] text-slate-400 font-medium truncate mb-2">
                                                <span class="material-symbols-outlined text-[12px]">location_on</span>
                                                {{ $event->address }}
                                            </div>
                                            @endif
                                            <div class="flex -space-x-2 mt-auto">
                                                @foreach($event->attendees->take(4) as $attendee)
                                                    @if($attendee->user)
                                                        <img class="w-6 h-6 rounded-full border-2 border-white object-cover shadow-sm kowalski-spring hover:scale-125 hover:z-10" 
                                                             src="{{ $attendee->user->avatarUrl() }}" 
                                                             alt="{{ $attendee->user->name }}" 
                                                             title="{{ $attendee->user->name }}">
                                                    @endif
                                                @endforeach
                                                @if($event->attendees->count() > 4)
                                                    <div class="w-6 h-6 rounded-full border-2 border-white bg-slate-100 flex items-center justify-center text-[9px] font-bold text-slate-500 shadow-sm z-10">
                                                        +{{ $event->attendees->count() - 4 }}
                                                    </div>
                                                @endif
                                                @if($event->attendees->count() > 0)
                                                <div class="ml-2 self-center text-[10px] font-semibold text-slate-400">
                                                    {{ $event->registered_count }}/{{ $event->seating_capacity ?? '∞' }}
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-span-full py-8 text-center text-slate-400 text-sm">
                                            <span class="material-symbols-outlined text-4xl mb-2 text-slate-300 block">calendar_today</span>
                                            No other events scheduled.
                                        </div>
                                    @endforelse
                                </div>
                            </div>

                        </div>

                        <!-- Right Sidebar (Notifications & Chart) -->
                        <div class="xl:col-span-4 flex flex-col gap-8">
                            
                            <!-- Upcoming Events Overview -->
                            <div class="bg-white border border-slate-100 rounded-[20px] p-6 shadow-[0_4px_20px_-10px_rgba(0,0,0,0.05)] animate-on-scroll">
                                <div class="flex justify-between items-center mb-4">
                                    <h2 class="text-[16px] 2xl:text-[22px] font-bold text-slate-800">Upcoming Events</h2>
                                    <span class="text-[11px] font-bold text-blue-600 bg-blue-50 px-2.5 py-1 rounded-full">{{ $upcomingCount }} events</span>
                                </div>
                                @if($nextEvent)
                                <div class="bg-gradient-to-br from-blue-50 to-indigo-50/50 rounded-2xl p-4 border border-blue-100/60">
                                    <div class="text-[10px] font-bold text-blue-600 uppercase tracking-wider mb-2">Next Event</div>
                                    <h3 class="text-[15px] font-bold text-slate-800 leading-snug">{{ $nextEvent->title }}</h3>
                                    <div class="flex items-center gap-1.5 text-[12px] text-slate-500 mt-2">
                                        <span class="material-symbols-outlined text-[16px]">schedule</span>
                                        {{ $nextEvent->start_date->format('d M Y, h:i A') }}
                                    </div>
                                    @if($nextEvent->address)
                                    <div class="flex items-center gap-1.5 text-[12px] text-slate-500 mt-1">
                                        <span class="material-symbols-outlined text-[16px]">location_on</span>
                                        {{ $nextEvent->address }}
                                    </div>
                                    @endif
                                    <div class="mt-3 flex items-center gap-2 text-[12px] text-slate-500">
                                        <span class="font-semibold text-blue-600">{{ $nextEvent->registered_count }}</span> registered
                                        @if($nextEvent->seating_capacity)
                                        <span class="text-slate-300">·</span>
                                        <span>Capacity: {{ $nextEvent->seating_capacity }}</span>
                                        @endif
                                    </div>
                                </div>
                                @else
                                <div class="text-center py-6 text-slate-400 text-sm">
                                    <span class="material-symbols-outlined text-3xl mb-2 block text-slate-300">event_busy</span>
                                    No upcoming events scheduled.
                                </div>
                                @endif
                            </div>

                            <!-- My Registrations -->
                            <div class="bg-white border border-slate-100 rounded-[20px] p-6 shadow-[0_4px_20px_-10px_rgba(0,0,0,0.05)] animate-on-scroll">
                                <div class="flex justify-between items-center mb-4">
                                    <h2 class="text-[16px] 2xl:text-[22px] font-bold text-slate-800">My Events</h2>
                                    <span class="text-[11px] font-bold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full">{{ $myRegistrationsCount }} registered</span>
                                </div>
                                @forelse($myRegistrations->take(4) as $reg)
                                <div class="flex items-center gap-3 py-2.5 border-b border-slate-50 last:border-b-0">
                                    <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center shrink-0">
                                        <span class="material-symbols-outlined text-[16px] text-blue-600">event</span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-[13px] font-semibold text-slate-800 truncate">{{ $reg->event->title }}</p>
                                        <p class="text-[11px] text-slate-400">{{ $reg->event->start_date->format('d M Y, h:i A') }}</p>
                                    </div>
                                    <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full shrink-0">Registered</span>
                                </div>
                                @empty
                                <div class="text-center py-6 text-slate-400 text-sm">
                                    <span class="material-symbols-outlined text-3xl mb-2 block text-slate-300">event_busy</span>
                                    You haven't registered for any events yet.
                                </div>
                                @endforelse
                            </div>

                            <!-- Recent Registrations Feed -->
                            <div class="bg-white border border-slate-100 rounded-[20px] p-6 shadow-[0_4px_20px_-10px_rgba(0,0,0,0.05)] animate-on-scroll">
                                <div class="flex justify-between items-center mb-4">
                                    <h2 class="text-[16px] 2xl:text-[22px] font-bold text-slate-800">Recent Activity</h2>
                                    <button class="text-slate-400 hover:text-slate-600 emil-btn"><span class="material-symbols-outlined">more_horiz</span></button>
                                </div>
                                <div class="space-y-4 stagger-children animate-on-scroll">
                                    @forelse($recentRegistrations as $reg)
                                    <div class="flex gap-3 group cursor-pointer">
                                        <img src="{{ $reg->user?->avatarUrl() ?? 'https://ui-avatars.com/api/?name=Member&background=103C68&color=fff' }}" alt="{{ $reg->user?->name ?? 'Member' }}" class="w-8 h-8 rounded-full object-cover mt-0.5 kowalski-spring group-hover:scale-110">
                                        <div>
                                            <p class="text-[13px] text-slate-600 leading-relaxed kowalski-spring group-hover:text-slate-800">
                                                <span class="font-bold text-slate-800">{{ $reg->user?->name ?? 'A member' }}</span> registered for <span class="font-bold text-blue-600">{{ $reg->event?->title ?? 'an event' }}</span>
                                            </p>
                                            <p class="text-[11px] font-medium text-slate-400 mt-0.5">{{ $reg->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                    @empty
                                    <div class="text-center py-4 text-slate-400 text-sm">
                                        No recent registrations.
                                    </div>
                                    @endforelse
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Intersection Observer for Emil Kowalski Animations
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.05,
                rootMargin: "-20px"
            });

            document.querySelectorAll('.animate-on-scroll, .stagger-children').forEach(el => {
                observer.observe(el);
            });


        });

        let selectedEventId = null;
        let selectedEventCard = null;
        const currentUserId = {{ auth()->id() }};

        function openEventDetails(element) {
            selectedEventCard = element;
            selectedEventId = element.getAttribute('data-event-id');
            const title = element.getAttribute('data-title');
            const cover = element.getAttribute('data-cover') || 'https://images.unsplash.com/photo-1511795409834-ef04bbd61622?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80';
            const start = element.getAttribute('data-start');
            const end = element.getAttribute('data-end');
            const address = element.getAttribute('data-address');
            const hall = element.getAttribute('data-hall');
            const type = element.getAttribute('data-type');
            const website = element.getAttribute('data-website');
            const capacity = element.getAttribute('data-capacity');
            const registered = element.getAttribute('data-registered');
            const attendees = JSON.parse(element.getAttribute('data-attendees') || '[]');

            document.getElementById('modalEventTitle').innerText = title;
            document.getElementById('modalCoverImage').src = cover;
            document.getElementById('modalEventStartDate').innerText = start;
            document.getElementById('modalEventTimeRange').innerText = (end && end !== 'N/A') ? start + ' - ' + end : start;
            document.getElementById('modalEventHall').innerText = hall || 'N/A';
            document.getElementById('modalEventAddress').innerText = address || 'N/A';
            
            const typeBadge = document.getElementById('modalEventTypeBadge');
            if (type === 'gma') {
                typeBadge.innerText = 'GMA EVENT';
                typeBadge.className = 'bg-blue-600 text-white text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-full';
            } else {
                typeBadge.innerText = 'OTHER EVENT';
                typeBadge.className = 'bg-orange-500 text-white text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-full';
            }

            // Website link
            const webSection = document.getElementById('modalWebsiteLinkSection');
            if (website) {
                webSection.classList.remove('hidden');
                document.getElementById('modalWebsiteLink').href = website;
            } else {
                webSection.classList.add('hidden');
            }

            // Capacity progress
            const capSection = document.getElementById('modalCapacitySection');
            if (capacity && capacity !== 'Unlimited' && parseInt(capacity) > 0) {
                capSection.classList.remove('hidden');
                const ratio = document.getElementById('modalRegistrationRatio');
                ratio.innerText = registered + ' / ' + capacity + ' Registered';
                const pct = Math.min(100, Math.round((parseInt(registered) / parseInt(capacity)) * 100));
                document.getElementById('modalCapacityProgressBar').style.width = pct + '%';
            } else {
                capSection.classList.add('hidden');
            }

            // Update RSVP Button State
            updateRsvpButtonState(attendees, capacity, registered);

            // Attendees
            renderAttendees(attendees);

            const modal = document.getElementById('eventDetailsModal');
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.querySelector('.transform').classList.remove('scale-95', 'opacity-0');
                modal.querySelector('.transform').classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function updateRsvpButtonState(attendees, capacity, registered) {
            const rsvpBtn = document.getElementById('modalRsvpBtn');
            const isUserRegistered = attendees.some(a => parseInt(a.id) === currentUserId);
            const isFull = capacity !== 'Unlimited' && parseInt(registered) >= parseInt(capacity);

            rsvpBtn.removeAttribute('disabled');
            rsvpBtn.className = 'px-5 py-2.5 text-xs font-bold rounded-xl transition-all focus:outline-none';

            if (isUserRegistered) {
                rsvpBtn.innerText = 'Cancel RSVP';
                rsvpBtn.className += ' bg-rose-50 border border-rose-200 hover:bg-rose-100 text-rose-600 shadow-sm';
            } else if (isFull) {
                rsvpBtn.innerText = 'Fully Booked';
                rsvpBtn.className += ' bg-slate-100 text-slate-400 cursor-not-allowed border border-slate-200';
                rsvpBtn.setAttribute('disabled', 'true');
            } else {
                rsvpBtn.innerText = 'Join Event';
                rsvpBtn.className += ' bg-blue-600 hover:bg-blue-700 text-white shadow-md shadow-blue-500/10';
            }
        }

        function renderAttendees(attendees) {
            const attendeeList = document.getElementById('modalAttendeeList');
            attendeeList.innerHTML = '';
            if (attendees.length > 0) {
                attendees.forEach(a => {
                    const wrapper = document.createElement('div');
                    wrapper.className = 'flex items-center gap-2 bg-slate-50 border border-slate-100 rounded-full pl-1.5 pr-3 py-1 text-xs text-slate-700 shadow-sm';
                    
                    const img = document.createElement('img');
                    img.src = a.avatar || 'https://ui-avatars.com/api/?name=' + encodeURIComponent(a.name) + '&background=103C68&color=fff';
                    img.className = 'w-6 h-6 rounded-full object-cover';
                    img.alt = a.name;
                    
                    const nameSpan = document.createElement('span');
                    nameSpan.className = 'font-semibold';
                    nameSpan.innerText = a.name;
                    
                    wrapper.appendChild(img);
                    wrapper.appendChild(nameSpan);
                    attendeeList.appendChild(wrapper);
                });
            } else {
                attendeeList.innerHTML = '<span class="text-xs text-slate-400">No registrations yet.</span>';
            }
        }

        function toggleRsvp() {
            if (!selectedEventId) return;

            const rsvpBtn = document.getElementById('modalRsvpBtn');
            rsvpBtn.setAttribute('disabled', 'true');
            rsvpBtn.innerText = 'Processing...';

            fetch(`/member/events/${selectedEventId}/rsvp`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(res => {
                if (!res.ok) {
                    return res.json().then(data => { throw new Error(data.error || 'Something went wrong'); });
                }
                return res.json();
            })
            .then(data => {
                // Update elements data-attributes on the active event card
                if (selectedEventCard) {
                    selectedEventCard.setAttribute('data-registered', data.registered_count);
                    selectedEventCard.setAttribute('data-attendees', JSON.stringify(data.attendees));

                    // Dynamically update card register display if present
                    const countEl = selectedEventCard.querySelector('.registered-count');
                    if (countEl) {
                        countEl.innerText = data.registered_count;
                    }
                }

                // Update modal details
                const capacity = selectedEventCard.getAttribute('data-capacity');
                const capSection = document.getElementById('modalCapacitySection');
                if (capacity && capacity !== 'Unlimited' && parseInt(capacity) > 0) {
                    const ratio = document.getElementById('modalRegistrationRatio');
                    ratio.innerText = data.registered_count + ' / ' + capacity + ' Registered';
                    const pct = Math.min(100, Math.round((parseInt(data.registered_count) / parseInt(capacity)) * 100));
                    document.getElementById('modalCapacityProgressBar').style.width = pct + '%';
                }

                updateRsvpButtonState(data.attendees, capacity, data.registered_count);
                renderAttendees(data.attendees);
            })
            .catch(err => {
                alert(err.message);
                // Reset button state
                const attendees = JSON.parse(selectedEventCard.getAttribute('data-attendees') || '[]');
                const capacity = selectedEventCard.getAttribute('data-capacity');
                const registered = selectedEventCard.getAttribute('data-registered');
                updateRsvpButtonState(attendees, capacity, registered);
            });
        }

        function closeEventDetailsModal() {
            const modal = document.getElementById('eventDetailsModal');
            modal.querySelector('.transform').classList.add('scale-95', 'opacity-0');
            modal.querySelector('.transform').classList.remove('scale-100', 'opacity-100');
            setTimeout(() => {
                modal.classList.add('hidden');
                selectedEventId = null;
                selectedEventCard = null;
            }, 300);
        }
    </script>
    
    <!-- Event Details Modal -->
    <div id="eventDetailsModal" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4 transition-all duration-300">
        <div class="bg-white w-full max-w-2xl rounded-3xl overflow-hidden shadow-2xl transform scale-95 opacity-0 transition-all duration-300 flex flex-col max-h-[90vh]">
            <!-- Header Image Banner -->
            <div class="relative h-56 bg-slate-100 shrink-0">
                <img id="modalCoverImage" src="" alt="Event Cover" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/60 via-slate-950/10 to-transparent"></div>
                <button onclick="closeEventDetailsModal()" class="absolute top-4 right-4 bg-white/20 hover:bg-white/30 hover:text-white rounded-full p-2 backdrop-blur-md transition-colors emil-btn text-white flex items-center justify-center">
                    <span class="material-symbols-outlined text-lg">close</span>
                </button>
                <div class="absolute bottom-4 left-6 right-6">
                    <span id="modalEventTypeBadge" class="bg-blue-600 text-white text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-full">GMA EVENT</span>
                    <h2 id="modalEventTitle" class="text-2xl font-bold text-white mt-2 drop-shadow-sm truncate">Event Title</h2>
                </div>
            </div>
            
            <!-- Modal Body (Scrollable) -->
            <div class="flex-1 overflow-y-auto p-6 space-y-6 custom-scroll">
                <!-- Info Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-blue-600 mt-0.5">calendar_today</span>
                        <div>
                            <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Date & Time</div>
                            <div id="modalEventStartDate" class="text-sm font-bold text-slate-800">Thursday, Oct 24, 2026</div>
                            <div id="modalEventTimeRange" class="text-xs text-slate-500 mt-0.5">6:00 PM - 11:00 PM</div>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-blue-600 mt-0.5">location_on</span>
                        <div>
                            <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Location</div>
                            <div id="modalEventHall" class="text-sm font-bold text-slate-800">Grand Ballroom</div>
                            <div id="modalEventAddress" class="text-xs text-slate-500 mt-0.5">123 Commerce St</div>
                        </div>
                    </div>
                </div>

                <!-- Registration Capacity Status -->
                <div id="modalCapacitySection" class="bg-slate-50 rounded-2xl p-4 border border-slate-100">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-bold text-slate-800">Event Capacity</span>
                        <span id="modalRegistrationRatio" class="text-sm font-bold text-blue-600">85 / 150 Registered</span>
                    </div>
                    <!-- Progress Bar -->
                    <div class="w-full h-2.5 bg-slate-200 rounded-full overflow-hidden">
                        <div id="modalCapacityProgressBar" class="h-full bg-blue-600 rounded-full transition-all duration-500" style="width: 50%"></div>
                    </div>
                </div>

                <!-- Website Link (if any) -->
                <div id="modalWebsiteLinkSection" class="hidden">
                    <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Website Link</div>
                    <a id="modalWebsiteLink" href="#" target="_blank" class="inline-flex items-center gap-2 text-sm font-bold text-blue-600 hover:text-blue-700 transition-colors">
                        Visit Event Page
                        <span class="material-symbols-outlined text-[16px]">open_in_new</span>
                    </a>
                </div>

                <!-- Attendee List -->
                <div>
                    <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3">Attendees</div>
                    <div id="modalAttendeeList" class="flex flex-wrap gap-2">
                        <!-- Dynamic attendee avatars and badges -->
                    </div>
                </div>
            </div>
            
            <!-- Footer Actions -->
            <div class="p-5 border-t border-slate-100 flex justify-end gap-3 bg-slate-50/50 shrink-0">
                <button id="modalRsvpBtn" onclick="toggleRsvp()" class="px-5 py-2.5 text-xs font-bold rounded-xl transition-all emil-btn focus:outline-none">
                    RSVP
                </button>
                <button onclick="closeEventDetailsModal()" class="px-5 py-2 text-sm font-bold text-slate-600 hover:text-slate-800 transition-colors emil-btn">
                    Close
                </button>
            </div>
        </div>
    </div>

    @include('components.settings-modal')
</body>
</html>
