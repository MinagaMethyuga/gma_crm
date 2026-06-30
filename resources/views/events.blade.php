<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GMA - Events Admin</title>
    <link rel="icon" href="/Global_Mobile_Association_Logo__1_-removebg-preview.png" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
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
        
        /* Custom scrollbar for main area */
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
    </style>
</head>
<body class="overflow-hidden text-slate-800">

    <div class="flex h-screen w-full">
        @include('components.admin-sidebar', ['active' => 'events'])

        <!-- Main Content Area -->
        <main class="flex-1 flex flex-col min-w-0 bg-[#fbfcfd]">
            
            @include('components.admin-header')

            <!-- Content Body -->
            <div class="flex-1 flex overflow-hidden">
                
                <!-- Left: Events List -->
                <div class="flex-1 overflow-y-auto custom-scroll p-10 pb-20">
                    <div class="flex justify-between items-start mb-8">
                        <div>
                            <h2 class="text-3xl font-bold text-slate-900 mb-2 tracking-tight">Events</h2>
                            <p class="text-slate-500 text-sm">Manage and track upcoming organization activities.</p>
                        </div>
                        <div class="flex bg-slate-100/80 p-1.5 rounded-xl border border-slate-200/60 shadow-sm">
                            <button class="flex items-center gap-2 bg-white shadow-sm border border-slate-200/50 rounded-lg px-4 py-2 text-sm font-semibold text-[#4338ca]">
                                <span class="material-symbols-outlined text-[18px]">view_list</span>
                                List
                            </button>
                            <button class="flex items-center gap-2 rounded-lg px-4 py-2 text-sm font-semibold text-slate-500 hover:text-slate-700 transition-colors">
                                <span class="material-symbols-outlined text-[18px]">calendar_month</span>
                                Calendar
                            </button>
                        </div>
                    </div>

                    <!-- Filters -->
                    <div class="flex gap-2.5 mb-10">
                        <button class="bg-[#5649f5] text-white text-sm font-medium px-6 py-2 rounded-full shadow-md shadow-[#5649f5]/20">
                            All Events
                        </button>
                        <button class="bg-slate-100 text-slate-600 hover:bg-slate-200 text-sm font-medium px-6 py-2 rounded-full transition-colors border border-slate-200/50">
                            Upcoming
                        </button>
                        <button class="bg-slate-100 text-slate-600 hover:bg-slate-200 text-sm font-medium px-6 py-2 rounded-full transition-colors border border-slate-200/50">
                            Past
                        </button>
                        <button class="bg-slate-100 text-slate-600 hover:bg-slate-200 text-sm font-medium px-6 py-2 rounded-full transition-colors border border-slate-200/50">
                            Virtual
                        </button>
                    </div>

                    <!-- Grid of Events -->
                    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
                        
                        <!-- Card 1 (Active) -->
                        <div class="border-2 border-[#5649f5] rounded-2xl p-5 bg-[#f5f5fc] shadow-sm relative cursor-pointer group">
                            <!-- Overlay gradient -->
                            <div class="absolute inset-0 bg-gradient-to-br from-white/40 to-transparent rounded-2xl pointer-events-none"></div>
                            <div class="relative z-10">
                                <div class="flex justify-between items-start mb-6">
                                    <div class="flex gap-5">
                                        <div class="bg-white border border-slate-200 rounded-xl p-2.5 text-center w-16 shrink-0 shadow-sm flex flex-col justify-center">
                                            <div class="text-[11px] font-bold text-red-500 uppercase tracking-wider mb-0.5">Oct</div>
                                            <div class="text-2xl font-bold text-slate-900 leading-none">24</div>
                                        </div>
                                        <div class="pt-1">
                                            <h3 class="font-bold text-[19px] text-slate-900 leading-tight mb-2 tracking-tight">Annual Charity Gala</h3>
                                            <div class="flex items-center gap-1.5 text-slate-500 text-xs font-medium">
                                                <span class="material-symbols-outlined text-[15px]">schedule</span>
                                                6:00 PM - 11:00 PM
                                            </div>
                                        </div>
                                    </div>
                                    <span class="bg-[#dbeafe] text-[#1e40af] text-[10px] font-bold uppercase tracking-wider px-2.5 py-1.5 rounded flex items-center justify-center shrink-0">
                                        IN-PERSON
                                    </span>
                                </div>
                                <div class="flex justify-between items-end mt-4 border-t border-slate-200/80 pt-5">
                                    <div class="flex items-start gap-1.5 text-slate-500 text-xs font-medium w-2/3 pr-2">
                                        <span class="material-symbols-outlined text-[16px] shrink-0">location_on</span>
                                        <span class="leading-snug mt-0.5">Grand Ballroom, Hyatt</span>
                                    </div>
                                    <div class="text-right shrink-0">
                                        <div class="text-[11px] text-slate-500 uppercase font-semibold tracking-wider mb-0.5">Registered</div>
                                        <div class="text-sm font-bold text-[#3730a3]">85 <span class="text-slate-400 font-semibold">/ 150</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card 2 -->
                        <div class="border border-slate-200 rounded-2xl p-5 bg-white hover:border-slate-300 hover:shadow-md transition-all cursor-pointer shadow-sm">
                            <div class="flex justify-between items-start mb-6">
                                <div class="flex gap-5">
                                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-center w-16 shrink-0 flex flex-col justify-center">
                                        <div class="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-0.5">Nov</div>
                                        <div class="text-2xl font-bold text-slate-800 leading-none">02</div>
                                    </div>
                                    <div class="pt-1">
                                        <h3 class="font-bold text-[19px] text-slate-900 leading-tight mb-2 tracking-tight">Q4 Board Meeting</h3>
                                        <div class="flex items-center gap-1.5 text-slate-500 text-xs font-medium">
                                            <span class="material-symbols-outlined text-[15px]">schedule</span>
                                            9:00 AM - 12:00 PM
                                        </div>
                                    </div>
                                </div>
                                <span class="bg-[#cffafe] text-[#0f766e] text-[10px] font-bold uppercase tracking-wider px-2.5 py-1.5 rounded flex items-center justify-center shrink-0">
                                    VIRTUAL
                                </span>
                            </div>
                            <div class="flex justify-between items-end mt-4 border-t border-slate-100 pt-5">
                                <div class="flex items-start gap-1.5 text-slate-500 text-xs font-medium w-2/3 pr-2">
                                    <span class="material-symbols-outlined text-[16px] shrink-0">videocam</span>
                                    <span class="leading-snug mt-0.5">Zoom Link Provided</span>
                                </div>
                                <div class="text-right shrink-0">
                                    <div class="text-[11px] text-slate-500 uppercase font-semibold tracking-wider mb-0.5">Confirmed</div>
                                    <div class="text-sm font-bold text-slate-800">12 <span class="text-slate-400 font-semibold">/ 15</span></div>
                                </div>
                            </div>
                        </div>

                        <!-- Card 3 -->
                        <div class="border border-slate-200 rounded-2xl p-5 bg-white hover:border-slate-300 hover:shadow-md transition-all cursor-pointer shadow-sm">
                            <div class="flex justify-between items-start mb-6">
                                <div class="flex gap-5">
                                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-center w-16 shrink-0 flex flex-col justify-center">
                                        <div class="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-0.5">Nov</div>
                                        <div class="text-2xl font-bold text-slate-800 leading-none">15</div>
                                    </div>
                                    <div class="pt-1">
                                        <h3 class="font-bold text-[19px] text-slate-900 leading-tight mb-2 tracking-tight">Member Networking Lunch</h3>
                                        <div class="flex items-center gap-1.5 text-slate-500 text-xs font-medium">
                                            <span class="material-symbols-outlined text-[15px]">schedule</span>
                                            12:30 PM - 2:00 PM
                                        </div>
                                    </div>
                                </div>
                                <span class="bg-[#dbeafe] text-[#1e40af] text-[10px] font-bold uppercase tracking-wider px-2.5 py-1.5 rounded flex items-center justify-center shrink-0">
                                    IN-PERSON
                                </span>
                            </div>
                            <div class="flex justify-between items-end mt-4 border-t border-slate-100 pt-5">
                                <div class="flex items-start gap-1.5 text-slate-500 text-xs font-medium w-2/3 pr-2">
                                    <span class="material-symbols-outlined text-[16px] shrink-0">location_on</span>
                                    <span class="leading-snug mt-0.5">City Club Downtown</span>
                                </div>
                                <div class="text-right shrink-0">
                                    <div class="text-[11px] text-slate-500 uppercase font-semibold tracking-wider mb-0.5">Registered</div>
                                    <div class="text-sm font-bold text-slate-800">42 <span class="text-slate-400 font-semibold">/ 50</span></div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Right: Details Panel -->
                <div class="w-[420px] bg-white border-l border-slate-200 overflow-y-auto custom-scroll shadow-[-10px_0_20px_-10px_rgba(0,0,0,0.05)] z-10 shrink-0">
                    <!-- Banner Image -->
                    <div class="relative h-[220px] bg-slate-200 rounded-b-3xl overflow-hidden mx-4 mt-4 shadow-sm">
                        <!-- Elegant dinner setting placeholder -->
                        <img src="https://images.unsplash.com/photo-1511795409834-ef04bbd61622?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Event Banner" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-white via-white/10 to-transparent"></div>
                        
                        <div class="absolute bottom-6 left-6">
                            <span class="bg-[#4338ca] text-white text-[10px] font-bold uppercase tracking-widest px-3.5 py-1.5 rounded shadow-md">
                                Upcoming
                            </span>
                        </div>
                    </div>

                    <div class="px-8 py-6">
                        <h2 class="text-[26px] font-bold text-slate-900 mb-6 tracking-tight leading-tight">Annual Charity Gala</h2>
                        
                        <div class="space-y-5 mb-10">
                            <div class="flex items-start gap-4">
                                <span class="material-symbols-outlined text-[#4338ca] text-[22px] mt-0.5">calendar_today</span>
                                <div>
                                    <div class="text-[14px] font-semibold text-slate-800">Thursday, October 24, 2024</div>
                                    <div class="text-[13px] font-medium text-slate-500 mt-0.5">6:00 PM - 11:00 PM EST</div>
                                </div>
                            </div>
                            <div class="flex items-start gap-4">
                                <span class="material-symbols-outlined text-[#4338ca] text-[22px] mt-0.5">location_on</span>
                                <div>
                                    <div class="text-[14px] font-semibold text-slate-800">Grand Ballroom, Hyatt Regency</div>
                                    <div class="text-[13px] font-medium text-slate-500 mt-0.5">123 Commerce St, Metro City</div>
                                </div>
                            </div>
                        </div>

                        <!-- Stats Grid -->
                        <div class="grid grid-cols-2 gap-4 mb-10">
                            <div class="bg-slate-100/70 border border-slate-200/60 rounded-xl p-5">
                                <div class="text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-3">Registered</div>
                                <div class="text-[26px] font-bold text-[#4338ca] leading-none mb-1">85 <span class="text-sm text-slate-400 font-semibold">/ 150 cap</span></div>
                                <!-- Progress bar -->
                                <div class="w-full h-1.5 bg-slate-200 rounded-full mt-4 overflow-hidden">
                                    <div class="h-full bg-[#4338ca] w-[56%] rounded-full shadow-sm"></div>
                                </div>
                            </div>
                            <div class="bg-slate-100/70 border border-slate-200/60 rounded-xl p-5">
                                <div class="text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-3">Revenue</div>
                                <div class="text-[26px] font-bold text-slate-900 leading-none mb-1">$12.5k</div>
                                <div class="text-[11px] font-bold text-emerald-600 mt-4 flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px]">trending_up</span>
                                    +15% vs last year
                                </div>
                            </div>
                        </div>

                        <!-- Toggles & Actions -->
                        <div class="pt-2 space-y-6">
                            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                                <div>
                                    <div class="text-[15px] font-bold text-slate-800">Attendance Tracking</div>
                                    <div class="text-xs font-medium text-slate-500 mt-1">Enable check-in mode for staff</div>
                                </div>
                                <!-- Toggle Switch -->
                                <div class="w-12 h-6 bg-slate-200 rounded-full relative cursor-pointer border border-slate-300/50 shadow-inner">
                                    <div class="w-4 h-4 bg-white rounded-full absolute left-1 top-1 shadow-sm border border-slate-200"></div>
                                </div>
                            </div>

                            <button class="w-full bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-[14px] font-semibold py-3 rounded-xl flex items-center justify-center gap-2 transition-colors shadow-sm">
                                <span class="material-symbols-outlined text-[20px]">download</span>
                                Download Attendee List
                            </button>

                            <div class="flex gap-3 pb-8">
                                <button class="flex-1 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-[14px] font-semibold py-3 rounded-xl flex items-center justify-center gap-2 transition-colors shadow-sm">
                                    <span class="material-symbols-outlined text-[18px]">edit</span>
                                    Edit
                                </button>
                                <button class="w-14 bg-white border border-slate-200 hover:bg-slate-50 text-red-500 rounded-xl flex items-center justify-center transition-colors shadow-sm">
                                    <span class="material-symbols-outlined text-[20px]">more_horiz</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>

</body>
</html>
