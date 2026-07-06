<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GMA - Member Portal</title>
    <link rel="icon" href="/Global_Mobile_Association_Logo__1_-removebg-preview.png" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0,1&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #fbfcfd;
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .material-symbols-outlined.fill {
            font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        
        /* Custom scrollbar */
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

        .kowalski-spring {
            transition-property: all;
            transition-timing-function: cubic-bezier(0.23,1,0.32,1);
            transition-duration: 400ms;
        }

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
        @include('components.member-sidebar', ['active' => 'home'])

        <!-- Main Content Area -->
        <main class="flex-1 flex flex-col min-w-0 bg-[#fbfcfd]">
            
            <!-- Top Header -->
            @include('components.member-topbar')

            <!-- Content Body -->
            <div class="flex-1 overflow-y-auto custom-scroll p-10">
                
                <!-- Welcome Section -->
                <div class="max-w-7xl 2xl:max-w-[1600px] mx-auto mb-8 animate-on-scroll">
                    <h2 class="text-[28px] font-bold text-slate-900 tracking-tight mb-2">Welcome back, {{ explode(' ', auth()->user()->name)[0] }}!</h2>
                    <p class="text-slate-500 text-[15px]">Here's what's happening with your GMA membership today.</p>
                </div>

                @if(auth()->user()->isNearExpiry())
                <div class="max-w-7xl 2xl:max-w-[1600px] mx-auto mb-6 animate-on-scroll">
                    <div class="bg-amber-50 border border-amber-200 rounded-2xl p-5 flex items-start gap-4 shadow-sm">
                        <div class="w-10 h-10 rounded-full bg-amber-100 text-amber-700 flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-[20px]">warning</span>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-amber-900 text-sm">Membership Renewal Reminder</h4>
                            <p class="text-amber-700 text-xs mt-0.5">Your GMA membership is set to expire in {{ auth()->user()->daysUntilPlanExpiry() }} days (on {{ auth()->user()->plan_subscribed_at->copy()->addYear()->format('M d, Y') }}). Please renew your subscription to maintain uninterrupted access.</p>
                        </div>
                        <a href="{{ route('pricing') }}" class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white font-semibold text-xs rounded-xl shadow-sm emil-btn shrink-0">
                            Renew Now
                        </a>
                    </div>
                </div>
                @endif

                <div class="max-w-7xl 2xl:max-w-[1600px] mx-auto grid grid-cols-1 lg:grid-cols-12 gap-6">
                    
                    <!-- Top Row -->
                    
                    <!-- Membership Status -->
                    @php
                        $user = auth()->user();
                        $isSharedMember = !$user->plan_id && $user->currentTeam;
                        $teamOwner = $isSharedMember ? $user->currentTeam->owner() : null;
                    @endphp
                    <div class="lg:col-span-4 bg-white border border-slate-200 rounded-2xl shadow-[0_4px_20px_-10px_rgba(0,0,0,0.05)] p-6 flex flex-col justify-between animate-on-scroll hover-sheen kowalski-spring hover:-translate-y-1 hover:shadow-[0_8px_24px_rgba(0,0,0,0.08)]">
                        <div>
                            <div class="flex justify-between items-start mb-2">
                                <span class="text-[11px] font-bold text-slate-500 uppercase tracking-widest">Membership Status</span>
                                @if($user->hasActiveMembership())
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                                    <div class="w-1.5 h-1.5 rounded-full bg-emerald-500"></div>
                                    Active
                                </span>
                                @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-amber-50 text-amber-700 border border-amber-200/60">
                                    <div class="w-1.5 h-1.5 rounded-full bg-amber-500"></div>
                                    Pending
                                </span>
                                @endif
                            </div>
                            <h3 class="text-[24px] font-bold text-slate-900 tracking-tight mb-8">{{ $isSharedMember ? 'Shared Membership' : ($user->plan?->name ?? 'No Plan Selected') }}</h3>
                            
                            <div class="flex justify-between items-center py-3 border-b border-slate-100">
                                <span class="text-[13px] text-slate-500 font-medium">{{ $isSharedMember ? 'Under' : 'Member Since' }}</span>
                                <span class="text-[14px] text-slate-900 font-semibold">{{ $isSharedMember ? $teamOwner?->name ?? 'N/A' : ($user->plan_subscribed_at ? $user->plan_subscribed_at->format('M Y') : ($user->created_at ? $user->created_at->format('M Y') : 'N/A')) }}</span>
                            </div>
                            <div class="flex justify-between items-center py-3">
                                <span class="text-[13px] text-slate-500 font-medium">{{ $isSharedMember ? 'Plan' : 'Renewal Date' }}</span>
                                <span class="text-[14px] text-slate-900 font-semibold">{{ $isSharedMember ? ($teamOwner?->plan?->name ?? 'N/A') : ($user->plan_subscribed_at ? $user->plan_subscribed_at->addYear()->format('M d, Y') : 'N/A') }}</span>
                            </div>
                        </div>
                        
                        @if(!$isSharedMember)
                        <a href="{{ route('pricing') }}" class="w-full block text-center mt-6 bg-[#3525cd] hover:bg-[#2d1faf] text-white font-semibold text-[13px] py-2.5 rounded-lg shadow-sm emil-btn">
                            Manage Membership
                        </a>
                        @else
                        <div class="w-full block text-center mt-6 bg-slate-100 text-slate-500 font-semibold text-[13px] py-2.5 rounded-lg cursor-default">
                            Covered by Team
                        </div>
                        @endif
                    </div>

                    <!-- Action Items -->
                    <div class="lg:col-span-8 bg-white border border-slate-200 rounded-2xl shadow-[0_4px_20px_-10px_rgba(0,0,0,0.05)] p-6 animate-on-scroll">
                        <h3 class="text-[18px] font-bold text-slate-900 tracking-tight mb-4">Action Items</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 stagger-children animate-on-scroll">
                            <!-- Action Item 1 -->
                            <div class="border border-slate-200 rounded-xl p-5 flex flex-col bg-slate-50/50 hover:bg-white transition-colors kowalski-spring hover:border-indigo-200 hover:-translate-y-1 hover:shadow-sm">
                                <div class="w-10 h-10 rounded-full bg-indigo-50 text-[#3525cd] flex items-center justify-center mb-4 kowalski-spring group-hover:scale-110">
                                    <span class="material-symbols-outlined text-[20px]">calendar_month</span>
                                </div>
                                <h4 class="text-[13px] font-bold text-slate-900 mb-2 leading-tight">RSVP to Upcoming Meetup</h4>
                                <p class="text-[12px] text-slate-500 leading-relaxed mb-4 flex-1">Regional Tech Leadership Mixer is next week.</p>
                                <a href="{{ route('member.events') }}" class="text-[12px] font-bold text-[#3525cd] flex items-center gap-1 hover:underline mt-auto group emil-btn">
                                    RSVP Now <span class="material-symbols-outlined text-[16px] kowalski-spring group-hover:translate-x-1">arrow_forward</span>
                                </a>
                            </div>

                            <!-- Action Item 2 -->
                            <div class="border border-slate-200 rounded-xl p-5 flex flex-col bg-slate-50/50 hover:bg-white transition-colors kowalski-spring hover:border-indigo-200 hover:-translate-y-1 hover:shadow-sm group">
                                <div class="w-10 h-10 rounded-full bg-cyan-50 text-[#006a8f] flex items-center justify-center mb-4 kowalski-spring group-hover:scale-110 group-hover:bg-[#006a8f] group-hover:text-white transition-colors">
                                    <span class="material-symbols-outlined text-[20px]">folder_special</span>
                                </div>
                                <h4 class="text-[13px] font-bold text-slate-900 mb-2 leading-tight">Member Documents</h4>
                                <p class="text-[12px] text-slate-500 leading-relaxed mb-4 flex-1">Access exclusive research, reports, and resources for your plan.</p>
                                <a href="{{ route('member.documents') }}" class="text-[12px] font-bold text-[#3525cd] flex items-center gap-1 hover:underline mt-auto emil-btn">
                                    Browse Documents <span class="material-symbols-outlined text-[16px] kowalski-spring group-hover:translate-x-1">arrow_forward</span>
                                </a>
                            </div>

                            <!-- Action Item 3 -->
                            <div class="border border-slate-200 rounded-xl p-5 flex flex-col bg-slate-50/50 hover:bg-white transition-colors kowalski-spring hover:border-indigo-200 hover:-translate-y-1 hover:shadow-sm">
                                <div class="w-10 h-10 rounded-full bg-slate-200 text-slate-600 flex items-center justify-center mb-4 kowalski-spring group-hover:scale-110">
                                    <span class="material-symbols-outlined text-[20px]">receipt_long</span>
                                </div>
                                <h4 class="text-[13px] font-bold text-slate-900 mb-2 leading-tight">View Latest Invoice</h4>
                                <p class="text-[12px] text-slate-500 leading-relaxed mb-4 flex-1">Invoice #INV-2024-089 generated.</p>
                                <a href="#" class="text-[12px] font-bold text-[#3525cd] flex items-center gap-1 hover:underline mt-auto group emil-btn">
                                    View Invoice <span class="material-symbols-outlined text-[16px] kowalski-spring group-hover:translate-x-1">arrow_forward</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Bottom Row -->

                    <!-- Upcoming Events -->
                    <div class="lg:col-span-8 bg-white border border-slate-200 rounded-2xl shadow-[0_4px_20px_-10px_rgba(0,0,0,0.05)] p-6 flex flex-col animate-on-scroll">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-[18px] font-bold text-slate-900 tracking-tight">Upcoming Events</h3>
                            <a href="{{ url('/member/events') }}" class="text-[13px] font-bold text-[#3525cd] hover:underline emil-btn">View All</a>
                        </div>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 flex-1 stagger-children animate-on-scroll">
                            @forelse($upcomingEvents as $event)
                                @php
                                    $isRegistered = $event->attendees->contains('user_id', auth()->id());
                                    $isOffline = !empty($event->address);
                                @endphp
                                <a href="{{ url('/member/events') }}" class="border border-slate-200 rounded-xl overflow-hidden flex flex-col kowalski-spring hover:border-indigo-200 hover:-translate-y-1 hover:shadow-[0_8px_24px_rgba(0,0,0,0.08)] cursor-pointer group">
                                    <div class="h-32 bg-slate-800 relative overflow-hidden flex items-center justify-center">
                                        @if($event->cover_image)
                                            <img src="{{ asset('storage/' . $event->cover_image) }}" class="w-full h-full object-cover opacity-60 kowalski-spring group-hover:scale-110 group-hover:opacity-80" alt="{{ $event->title }}">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center bg-indigo-50 text-indigo-500">
                                                <span class="material-symbols-outlined text-[40px] kowalski-spring group-hover:scale-125">event</span>
                                            </div>
                                        @endif
                                        <div class="absolute top-3 right-3 bg-white text-slate-800 text-[10px] font-bold px-2 py-1 rounded shadow-sm">
                                            {{ $isOffline ? 'Offline' : 'Online' }}
                                        </div>
                                    </div>
                                    <div class="p-5 flex flex-col flex-1">
                                        <div class="text-[11px] font-bold text-[#3525cd] tracking-wide mb-1 uppercase">
                                            {{ $event->start_date->format('M d • g:i A') }}
                                        </div>
                                        <h4 class="text-[15px] font-bold text-slate-900 mb-2 leading-snug truncate" title="{{ $event->title }}">
                                            {{ $event->title }}
                                        </h4>
                                        <p class="text-[12.5px] text-slate-500 leading-relaxed mb-5 flex-1 line-clamp-2">
                                            {{ $event->hall_name ?? ($event->address ?? 'No details provided.') }}
                                        </p>
                                        @if($isRegistered)
                                            <button class="w-full bg-slate-100 text-slate-500 font-semibold text-[13px] py-2 rounded-lg cursor-not-allowed border border-slate-200 pointer-events-none">
                                                Going
                                            </button>
                                        @else
                                            <button class="w-full bg-[#3525cd] hover:bg-[#2d1faf] text-white font-semibold text-[13px] py-2 rounded-lg shadow-sm emil-btn">
                                                RSVP
                                            </button>
                                        @endif
                                    </div>
                                </a>
                            @empty
                                <div class="col-span-full py-8 text-center text-slate-400 text-sm flex flex-col items-center justify-center flex-1">
                                    <span class="material-symbols-outlined text-4xl mb-2 text-slate-300 block">event_busy</span>
                                    No upcoming events scheduled.
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="lg:col-span-4 bg-white border border-slate-200 rounded-2xl shadow-[0_4px_20px_-10px_rgba(0,0,0,0.05)] p-6 flex flex-col animate-on-scroll">
                        <h3 class="text-[18px] font-bold text-slate-900 tracking-tight mb-6">Recent Activity</h3>
                        <div class="flex-1 relative">
                            <!-- Vertical Line -->
                            <div class="absolute left-[15px] top-2 bottom-6 w-px bg-slate-200"></div>
                            
                            <ul class="flex flex-col gap-6 relative z-10 stagger-children animate-on-scroll">
                                <li class="flex gap-4 group cursor-pointer">
                                    <div class="w-8 h-8 rounded-full bg-indigo-50 text-[#3525cd] flex items-center justify-center shrink-0 border-[3px] border-white z-10 shadow-sm kowalski-spring group-hover:scale-110 group-hover:bg-[#3525cd] group-hover:text-white">
                                        <span class="material-symbols-outlined text-[15px]">person_add</span>
                                    </div>
                                    <div class="pt-1 kowalski-spring group-hover:translate-x-1">
                                        <p class="text-[13.5px] text-slate-800 font-medium leading-snug">You joined the 'Leadership Workshop'</p>
                                        <span class="text-[11.5px] font-medium text-slate-500 mt-1 block">2 days ago</span>
                                    </div>
                                </li>
                                <li class="flex gap-4 group cursor-pointer">
                                    <div class="w-8 h-8 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center shrink-0 border-[3px] border-white z-10 shadow-sm kowalski-spring group-hover:scale-110 group-hover:bg-slate-200">
                                        <span class="material-symbols-outlined text-[15px]">autorenew</span>
                                    </div>
                                    <div class="pt-1 kowalski-spring group-hover:translate-x-1">
                                        <p class="text-[13.5px] text-slate-800 font-medium leading-snug">Subscription renewed successfully</p>
                                        <span class="text-[11.5px] font-medium text-slate-500 mt-1 block">1 week ago</span>
                                    </div>
                                </li>
                                <li class="flex gap-4 group cursor-pointer">
                                    <div class="w-8 h-8 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center shrink-0 border-[3px] border-white z-10 shadow-sm kowalski-spring group-hover:scale-110 group-hover:bg-slate-200">
                                        <span class="material-symbols-outlined text-[15px]">download</span>
                                    </div>
                                    <div class="pt-1 kowalski-spring group-hover:translate-x-1">
                                        <p class="text-[13.5px] text-slate-800 font-medium leading-snug">Downloaded Q3 Industry Report</p>
                                        <span class="text-[11.5px] font-medium text-slate-500 mt-1 block">2 weeks ago</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <a href="#" class="mt-8 text-[12.5px] font-bold text-[#3525cd] hover:underline text-center block w-full emil-btn">View All Activity</a>
                    </div>

                </div>

            </div>
        </main>
    </div>

    @include('components.settings-modal')
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
    </script>
</body>
</html>
