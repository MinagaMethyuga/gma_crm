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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                    <div class="grid grid-cols-1 xl:grid-cols-12 gap-8 max-w-[1400px] mx-auto">
                        
                        <!-- Left Main Column (Cards & Events) -->
                        <div class="xl:col-span-8 flex flex-col gap-8">
                            
                            <!-- Capacity Cards -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 stagger-children animate-on-scroll">
                                <!-- Economy Class -->
                                <div class="kowalski-card kowalski-card-hover hover-sheen p-5 flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-sm">
                                        EC
                                    </div>
                                    <div>
                                        <h3 class="text-[15px] font-bold text-slate-800">Economy Class</h3>
                                        <p class="text-[12px] text-slate-500 mt-0.5">Capacity : <span class="text-blue-600 font-bold">128</span>/240 Tickets</p>
                                    </div>
                                </div>
                                <!-- Master Class -->
                                <div class="kowalski-card kowalski-card-hover hover-sheen p-5 flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-full bg-orange-50 text-orange-500 flex items-center justify-center font-bold text-sm">
                                        MC
                                    </div>
                                    <div>
                                        <h3 class="text-[15px] font-bold text-slate-800">Master Class</h3>
                                        <p class="text-[12px] text-slate-500 mt-0.5">Capacity : <span class="text-orange-500 font-bold">80</span>/150 Tickets</p>
                                    </div>
                                </div>
                                <!-- Business Class -->
                                <div class="kowalski-card kowalski-card-hover hover-sheen p-5 flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-full bg-emerald-50 text-emerald-500 flex items-center justify-center font-bold text-sm">
                                        BC
                                    </div>
                                    <div>
                                        <h3 class="text-[15px] font-bold text-slate-800">Business Class</h3>
                                        <p class="text-[12px] text-slate-500 mt-0.5">Capacity : <span class="text-emerald-500 font-bold">64</span>/120 Tickets</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Ongoing Event -->
                            <div class="bg-white border border-slate-100 rounded-[20px] p-6 shadow-[0_4px_20px_-10px_rgba(0,0,0,0.05)] animate-on-scroll">
                                <div class="flex justify-between items-center mb-6">
                                    <h2 class="text-[16px] font-bold text-slate-800">Ongoing Event</h2>
                                    <button class="text-slate-400 hover:text-slate-600 emil-btn"><span class="material-symbols-outlined">more_horiz</span></button>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 stagger-children animate-on-scroll">
                                    <!-- Card 1 -->
                                    <div class="flex flex-col group cursor-pointer kowalski-spring hover:-translate-y-1">
                                        <div class="rounded-[14px] overflow-hidden mb-3.5 h-32 relative">
                                            <img src="https://images.unsplash.com/photo-1459749411175-04bf5292ceea?q=80&w=600&auto=format&fit=crop" alt="Justin Bieber Concert" class="w-full h-full object-cover kowalski-spring group-hover:scale-110 group-hover:rotate-1">
                                        </div>
                                        <h4 class="text-[13px] font-bold text-slate-800 mb-1.5 leading-snug">Justin Bieber Concert</h4>
                                        <div class="flex items-center gap-1.5 text-[11px] text-slate-500 font-medium">
                                            <span class="material-symbols-outlined text-[14px]">schedule</span>
                                            30 Mar 2022, 07:30 PM
                                        </div>
                                    </div>
                                    <!-- Card 2 -->
                                    <div class="flex flex-col group cursor-pointer kowalski-spring hover:-translate-y-1">
                                        <div class="rounded-[14px] overflow-hidden mb-3.5 h-32 relative">
                                            <img src="https://images.unsplash.com/photo-1540039155732-676281a1795c?q=80&w=600&auto=format&fit=crop" alt="Tony Quefara Concert" class="w-full h-full object-cover kowalski-spring group-hover:scale-110 group-hover:rotate-1">
                                        </div>
                                        <h4 class="text-[13px] font-bold text-slate-800 mb-1.5 leading-snug">Tony Quefara Concert</h4>
                                        <div class="flex items-center gap-1.5 text-[11px] text-slate-500 font-medium">
                                            <span class="material-symbols-outlined text-[14px]">schedule</span>
                                            30 Mar 2022, 08:00 PM
                                        </div>
                                    </div>
                                    <!-- Card 3 -->
                                    <div class="flex flex-col group cursor-pointer kowalski-spring hover:-translate-y-1">
                                        <div class="rounded-[14px] overflow-hidden mb-3.5 h-32 relative">
                                            <img src="https://images.unsplash.com/photo-1516450360452-9312f5e86fc7?q=80&w=600&auto=format&fit=crop" alt="Charlie Puth Concert" class="w-full h-full object-cover kowalski-spring group-hover:scale-110 group-hover:rotate-1">
                                        </div>
                                        <h4 class="text-[13px] font-bold text-slate-800 mb-1.5 leading-snug">Charlie Puth Concert</h4>
                                        <div class="flex items-center gap-1.5 text-[11px] text-slate-500 font-medium">
                                            <span class="material-symbols-outlined text-[14px]">schedule</span>
                                            30 Mar 2022, 08:30 PM
                                        </div>
                                    </div>
                                    <!-- Card 4 -->
                                    <div class="flex flex-col group cursor-pointer kowalski-spring hover:-translate-y-1">
                                        <div class="rounded-[14px] overflow-hidden mb-3.5 h-32 relative">
                                            <img src="https://images.unsplash.com/photo-1492684223066-81342ee5ff30?q=80&w=600&auto=format&fit=crop" alt="Firework Concert Fest" class="w-full h-full object-cover kowalski-spring group-hover:scale-110 group-hover:rotate-1">
                                        </div>
                                        <h4 class="text-[13px] font-bold text-slate-800 mb-1.5 leading-snug">Firework Concert Fest</h4>
                                        <div class="flex items-center gap-1.5 text-[11px] text-slate-500 font-medium">
                                            <span class="material-symbols-outlined text-[14px]">schedule</span>
                                            30 Mar 2022, 09:00 PM
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Upcoming Event -->
                            <div class="bg-white border border-slate-100 rounded-[20px] p-6 shadow-[0_4px_20px_-10px_rgba(0,0,0,0.05)] animate-on-scroll">
                                <div class="flex justify-between items-center mb-6">
                                    <h2 class="text-[16px] font-bold text-slate-800">Upcoming Event</h2>
                                    <button class="text-slate-400 hover:text-slate-600 emil-btn"><span class="material-symbols-outlined">more_horiz</span></button>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 stagger-children animate-on-scroll">
                                    <!-- Up Card 1 -->
                                    <div class="border border-slate-100 rounded-[14px] p-4.5 flex flex-col cursor-pointer kowalski-spring hover:border-blue-200 hover:shadow-[0_8px_24px_rgba(0,0,0,0.06)] hover:-translate-y-1 hover-sheen">
                                        <div class="text-[10px] font-bold text-blue-600 bg-blue-50/80 px-2.5 py-1 rounded-full inline-block w-max mb-5 tracking-wide">
                                            27 Apr 2022
                                        </div>
                                        <h4 class="text-[13px] font-bold text-slate-800 mb-2 leading-snug">Doel Sumbang Concert</h4>
                                        <div class="flex items-center gap-1.5 text-[11px] text-slate-500 font-medium mb-5">
                                            <span class="material-symbols-outlined text-[14px]">schedule</span>
                                            10:00 PM - 11:30 PM
                                        </div>
                                        <div class="flex -space-x-2 mt-auto">
                                            <img class="w-6 h-6 rounded-full border-2 border-white object-cover shadow-sm kowalski-spring hover:scale-125 hover:z-10" src="https://i.pravatar.cc/100?img=1" alt="Attendee">
                                            <img class="w-6 h-6 rounded-full border-2 border-white object-cover shadow-sm kowalski-spring hover:scale-125 hover:z-10" src="https://i.pravatar.cc/100?img=2" alt="Attendee">
                                            <img class="w-6 h-6 rounded-full border-2 border-white object-cover shadow-sm kowalski-spring hover:scale-125 hover:z-10" src="https://i.pravatar.cc/100?img=3" alt="Attendee">
                                            <img class="w-6 h-6 rounded-full border-2 border-white object-cover shadow-sm kowalski-spring hover:scale-125 hover:z-10" src="https://i.pravatar.cc/100?img=4" alt="Attendee">
                                        </div>
                                    </div>
                                    <!-- Up Card 2 -->
                                    <div class="border border-slate-100 rounded-[14px] p-4.5 flex flex-col cursor-pointer kowalski-spring hover:border-blue-200 hover:shadow-[0_8px_24px_rgba(0,0,0,0.06)] hover:-translate-y-1 hover-sheen">
                                        <div class="text-[10px] font-bold text-blue-600 bg-blue-50/80 px-2.5 py-1 rounded-full inline-block w-max mb-5 tracking-wide">
                                            28 Apr 2022
                                        </div>
                                        <h4 class="text-[13px] font-bold text-slate-800 mb-2 leading-snug">Air Baloon Festival</h4>
                                        <div class="flex items-center gap-1.5 text-[11px] text-slate-500 font-medium mb-5">
                                            <span class="material-symbols-outlined text-[14px]">schedule</span>
                                            08:00 AM - 10:00 AM
                                        </div>
                                        <div class="flex -space-x-2 mt-auto">
                                            <img class="w-6 h-6 rounded-full border-2 border-white object-cover shadow-sm kowalski-spring hover:scale-125 hover:z-10" src="https://i.pravatar.cc/100?img=5" alt="Attendee">
                                            <img class="w-6 h-6 rounded-full border-2 border-white object-cover shadow-sm kowalski-spring hover:scale-125 hover:z-10" src="https://i.pravatar.cc/100?img=6" alt="Attendee">
                                            <img class="w-6 h-6 rounded-full border-2 border-white object-cover shadow-sm kowalski-spring hover:scale-125 hover:z-10" src="https://i.pravatar.cc/100?img=7" alt="Attendee">
                                            <img class="w-6 h-6 rounded-full border-2 border-white object-cover shadow-sm kowalski-spring hover:scale-125 hover:z-10" src="https://i.pravatar.cc/100?img=8" alt="Attendee">
                                        </div>
                                    </div>
                                    <!-- Up Card 3 -->
                                    <div class="border border-slate-100 rounded-[14px] p-4.5 flex flex-col cursor-pointer kowalski-spring hover:border-blue-200 hover:shadow-[0_8px_24px_rgba(0,0,0,0.06)] hover:-translate-y-1 hover-sheen">
                                        <div class="text-[10px] font-bold text-blue-600 bg-blue-50/80 px-2.5 py-1 rounded-full inline-block w-max mb-5 tracking-wide">
                                            29 Apr 2022
                                        </div>
                                        <h4 class="text-[13px] font-bold text-slate-800 mb-2 leading-snug">Global Firework Fest</h4>
                                        <div class="flex items-center gap-1.5 text-[11px] text-slate-500 font-medium mb-5">
                                            <span class="material-symbols-outlined text-[14px]">schedule</span>
                                            08:30 PM - 11:30 PM
                                        </div>
                                        <div class="flex -space-x-2 mt-auto">
                                            <img class="w-6 h-6 rounded-full border-2 border-white object-cover shadow-sm kowalski-spring hover:scale-125 hover:z-10" src="https://i.pravatar.cc/100?img=9" alt="Attendee">
                                            <img class="w-6 h-6 rounded-full border-2 border-white object-cover shadow-sm kowalski-spring hover:scale-125 hover:z-10" src="https://i.pravatar.cc/100?img=10" alt="Attendee">
                                            <img class="w-6 h-6 rounded-full border-2 border-white object-cover shadow-sm kowalski-spring hover:scale-125 hover:z-10" src="https://i.pravatar.cc/100?img=11" alt="Attendee">
                                            <img class="w-6 h-6 rounded-full border-2 border-white object-cover shadow-sm kowalski-spring hover:scale-125 hover:z-10" src="https://i.pravatar.cc/100?img=12" alt="Attendee">
                                        </div>
                                    </div>
                                    <!-- Up Card 4 -->
                                    <div class="border border-slate-100 rounded-[14px] p-4.5 flex flex-col cursor-pointer kowalski-spring hover:border-blue-200 hover:shadow-[0_8px_24px_rgba(0,0,0,0.06)] hover:-translate-y-1 hover-sheen">
                                        <div class="text-[10px] font-bold text-blue-600 bg-blue-50/80 px-2.5 py-1 rounded-full inline-block w-max mb-5 tracking-wide">
                                            30 Apr 2022
                                        </div>
                                        <h4 class="text-[13px] font-bold text-slate-800 mb-2 leading-snug">Selena Gomez Concert</h4>
                                        <div class="flex items-center gap-1.5 text-[11px] text-slate-500 font-medium mb-5">
                                            <span class="material-symbols-outlined text-[14px]">schedule</span>
                                            09:00 PM - 10:30 PM
                                        </div>
                                        <div class="flex -space-x-2 mt-auto">
                                            <img class="w-6 h-6 rounded-full border-2 border-white object-cover shadow-sm kowalski-spring hover:scale-125 hover:z-10" src="https://i.pravatar.cc/100?img=13" alt="Attendee">
                                            <img class="w-6 h-6 rounded-full border-2 border-white object-cover shadow-sm kowalski-spring hover:scale-125 hover:z-10" src="https://i.pravatar.cc/100?img=14" alt="Attendee">
                                            <img class="w-6 h-6 rounded-full border-2 border-white object-cover shadow-sm kowalski-spring hover:scale-125 hover:z-10" src="https://i.pravatar.cc/100?img=15" alt="Attendee">
                                            <img class="w-6 h-6 rounded-full border-2 border-white object-cover shadow-sm kowalski-spring hover:scale-125 hover:z-10" src="https://i.pravatar.cc/100?img=16" alt="Attendee">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Right Sidebar (Notifications & Chart) -->
                        <div class="xl:col-span-4 flex flex-col gap-8">
                            
                            <!-- Notifications -->
                            <div class="bg-white border border-slate-100 rounded-[20px] p-6 shadow-[0_4px_20px_-10px_rgba(0,0,0,0.05)] animate-on-scroll">
                                <div class="flex justify-between items-center mb-6">
                                    <h2 class="text-[16px] font-bold text-slate-800">Notification</h2>
                                    <button class="text-slate-400 hover:text-slate-600 emil-btn"><span class="material-symbols-outlined">more_horiz</span></button>
                                </div>
                                
                                <div class="space-y-6 stagger-children animate-on-scroll">
                                    <!-- Notif 1 -->
                                    <div class="flex gap-3.5 group cursor-pointer">
                                        <img src="https://i.pravatar.cc/100?img=33" alt="Roberto" class="w-9 h-9 rounded-full object-cover mt-0.5 kowalski-spring group-hover:scale-110">
                                        <div>
                                            <p class="text-[13px] text-slate-500 leading-relaxed kowalski-spring group-hover:text-slate-700">
                                                <span class="font-bold text-slate-800">Roberto Ahman Person</span> has bought <span class="font-bold text-blue-600">3 economy class</span> on your event
                                            </p>
                                            <p class="text-[11px] font-medium text-slate-400 mt-1">2 minute ago</p>
                                        </div>
                                    </div>
                                    <!-- Notif 2 -->
                                    <div class="flex gap-3.5 group cursor-pointer">
                                        <img src="https://i.pravatar.cc/100?img=5" alt="Greysia" class="w-9 h-9 rounded-full object-cover mt-0.5 kowalski-spring group-hover:scale-110">
                                        <div>
                                            <p class="text-[13px] text-slate-500 leading-relaxed kowalski-spring group-hover:text-slate-700">
                                                <span class="font-bold text-slate-800">Greysia Polii</span> has bought <span class="font-bold text-orange-500">2 master class</span> on your event
                                            </p>
                                            <p class="text-[11px] font-medium text-slate-400 mt-1">3 minute ago</p>
                                        </div>
                                    </div>
                                    <!-- Notif 3 -->
                                    <div class="flex gap-3.5 group cursor-pointer">
                                        <img src="https://i.pravatar.cc/100?img=43" alt="Stephanie" class="w-9 h-9 rounded-full object-cover mt-0.5 kowalski-spring group-hover:scale-110">
                                        <div>
                                            <p class="text-[13px] text-slate-500 leading-relaxed kowalski-spring group-hover:text-slate-700">
                                                <span class="font-bold text-slate-800">Stephanie Angelina</span> has bought <span class="font-bold text-emerald-500">2 business class</span> on your event
                                            </p>
                                            <p class="text-[11px] font-medium text-slate-400 mt-1">3 minute ago</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Ticket Selling Graph -->
                            <div class="bg-white border border-slate-100 rounded-[20px] p-6 shadow-[0_4px_20px_-10px_rgba(0,0,0,0.05)] animate-on-scroll">
                                <div class="flex justify-between items-center mb-6">
                                    <h2 class="text-[16px] font-bold text-slate-800">Ticket Selling</h2>
                                    <button class="text-slate-400 hover:text-slate-600 emil-btn"><span class="material-symbols-outlined">more_horiz</span></button>
                                </div>
                                <div class="h-44 w-full relative">
                                    <canvas id="ticketChart"></canvas>
                                </div>
                                <div class="text-center mt-5">
                                    <button class="text-[12px] font-bold text-orange-500 hover:text-orange-600 inline-flex items-center gap-1 emil-btn">
                                        Show More <span class="material-symbols-outlined text-[16px] translate-y-[1px]">chevron_right</span>
                                    </button>
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

            // Chart initialization
            const ctx = document.getElementById('ticketChart').getContext('2d');
            
            // Create gradient
            let gradient = ctx.createLinearGradient(0, 0, 0, 180);
            gradient.addColorStop(0, 'rgba(249, 115, 22, 0.15)'); // Orange fade
            gradient.addColorStop(1, 'rgba(249, 115, 22, 0)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['06.00', '07.00', '08.00', '09.00', '10.00', '11.00'],
                    datasets: [{
                        label: 'Sales',
                        data: [30, 45, 35, 60, 50, 75], 
                        borderColor: '#f97316', // Orange-500
                        borderWidth: 2,
                        backgroundColor: gradient,
                        fill: true,
                        tension: 0.4, // Smooth curves
                        pointRadius: 0, // Hide points
                        pointHoverRadius: 4,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        duration: 1500,
                        easing: 'easeOutQuart'
                    },
                    plugins: {
                        legend: { display: false },
                        tooltip: { enabled: false }
                    },
                    scales: {
                        x: {
                            grid: { display: false, drawBorder: false },
                            ticks: { 
                                font: { family: 'Inter', size: 10, weight: '500' }, 
                                color: '#94a3b8',
                                maxTicksLimit: 4 
                            }
                        },
                        y: {
                            display: false, // Hide y axis
                            min: 0,
                            max: 100
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index',
                    },
                }
            });
        });
    </script>
    
    @include('components.settings-modal')
</body>
</html>
