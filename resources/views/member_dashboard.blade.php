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
    </style>
</head>
<body class="overflow-hidden text-slate-800">

    <div class="flex h-screen w-full">
        <!-- Sidebar -->
        <aside class="w-64 bg-[#f8f9fc] border-r border-slate-200 flex flex-col flex-shrink-0">
            <!-- Branding -->
            <div class="pt-6 pb-6 px-6 flex flex-col gap-1.5 border-b border-slate-200/50 mb-4">
                <a href="{{ route('home') }}" class="block">
                    <img src="/Global_Mobile_Association_Logo__1_-removebg-preview.png" alt="GMA Logo" class="h-14 w-auto object-contain object-left">
                </a>
                <p class="text-[11px] font-bold text-slate-600 tracking-wide pl-1 mt-1">Member Portal</p>
            </div>

            <!-- Nav Links -->
            <nav class="flex-1 px-3 space-y-1.5 overflow-y-auto">
                <!-- Active Home Link -->
                <div class="relative">
                    <div class="absolute left-0 top-0 bottom-0 w-[3px] bg-[#3525cd] rounded-r-md"></div>
                    <a href="{{ route('member-dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 text-[#3525cd] bg-indigo-50/50 rounded-lg transition-colors ml-1">
                        <span class="material-symbols-outlined text-[22px]">home</span>
                        <span class="text-[13px] font-bold">Home</span>
                    </a>
                </div>

                <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-slate-600 hover:bg-slate-100 rounded-lg transition-colors ml-1">
                    <span class="material-symbols-outlined text-[22px]">event</span>
                    <span class="text-[13px] font-semibold">Events</span>
                </a>
                
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-slate-600 hover:bg-slate-100 rounded-lg transition-colors ml-1">
                    <span class="material-symbols-outlined text-[22px]">payments</span>
                    <span class="text-[13px] font-semibold">Payments</span>
                </a>

                <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-slate-600 hover:bg-slate-100 rounded-lg transition-colors ml-1">
                    <span class="material-symbols-outlined text-[22px]">person</span>
                    <span class="text-[13px] font-semibold">Profile</span>
                </a>
            </nav>

            <!-- Bottom Links -->
            <div class="p-4 border-t border-slate-200">
                <a href="#" class="flex items-center gap-3 px-3 py-2 text-slate-600 hover:bg-slate-100 rounded-lg transition-colors ml-1">
                    <span class="material-symbols-outlined text-[22px]">help</span>
                    <span class="text-[13px] font-semibold">Help</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-3 py-2 text-slate-600 hover:bg-slate-100 rounded-lg transition-colors mt-1 ml-1">
                    <span class="material-symbols-outlined text-[22px]">logout</span>
                    <span class="text-[13px] font-semibold">Sign Out</span>
                </a>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 flex flex-col min-w-0 bg-[#fbfcfd]">
            
            <!-- Top Header (Simplified) -->
            <header class="h-16 border-b border-slate-200 flex items-center justify-end px-8 bg-white shrink-0">
                <div class="flex items-center gap-5 h-full">
                    <button class="text-slate-400 hover:text-slate-600 transition-colors">
                        <span class="material-symbols-outlined text-[22px]">notifications</span>
                    </button>
                    <button class="text-slate-400 hover:text-slate-600 transition-colors">
                        <span class="material-symbols-outlined text-[22px]">apps</span>
                    </button>
                    
                    <div class="w-8 h-8 rounded-full overflow-hidden shadow-sm shrink-0 border border-slate-200">
                        <img src="https://ui-avatars.com/api/?name=Sarah+Jenkins&background=103C68&color=fff" alt="User" class="w-full h-full object-cover">
                    </div>
                </div>
            </header>

            <!-- Content Body -->
            <div class="flex-1 overflow-y-auto custom-scroll p-10">
                
                <!-- Welcome Section -->
                <div class="max-w-6xl mx-auto mb-8">
                    <h2 class="text-[28px] font-bold text-slate-900 tracking-tight mb-2">Welcome back, Sarah!</h2>
                    <p class="text-slate-500 text-[15px]">Here's what's happening with your GMA membership today.</p>
                </div>

                <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-6">
                    
                    <!-- Top Row -->
                    
                    <!-- Membership Status -->
                    <div class="lg:col-span-4 bg-white border border-slate-200 rounded-2xl shadow-sm p-6 flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-start mb-2">
                                <span class="text-[11px] font-bold text-slate-500 uppercase tracking-widest">Membership Status</span>
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                                    <div class="w-1.5 h-1.5 rounded-full bg-emerald-500"></div>
                                    Active
                                </span>
                            </div>
                            <h3 class="text-[24px] font-bold text-slate-900 tracking-tight mb-8">Premium Tier</h3>
                            
                            <div class="flex justify-between items-center py-3 border-b border-slate-100">
                                <span class="text-[13px] text-slate-500 font-medium">Member Since</span>
                                <span class="text-[14px] text-slate-900 font-semibold">Jan 2022</span>
                            </div>
                            <div class="flex justify-between items-center py-3">
                                <span class="text-[13px] text-slate-500 font-medium">Renewal Date</span>
                                <span class="text-[14px] text-slate-900 font-semibold">Oct 24, 2024</span>
                            </div>
                        </div>
                        
                        <button class="w-full mt-6 bg-[#3525cd] hover:bg-[#2d1faf] text-white font-semibold text-[13px] py-2.5 rounded-lg transition-colors shadow-sm">
                            Manage Membership
                        </button>
                    </div>

                    <!-- Action Items -->
                    <div class="lg:col-span-8 bg-white border border-slate-200 rounded-2xl shadow-sm p-6">
                        <h3 class="text-[18px] font-bold text-slate-900 tracking-tight mb-4">Action Items</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <!-- Action Item 1 -->
                            <div class="border border-slate-200 rounded-xl p-5 flex flex-col bg-slate-50/50 hover:bg-slate-50 transition-colors">
                                <div class="w-10 h-10 rounded-full bg-indigo-50 text-[#3525cd] flex items-center justify-center mb-4">
                                    <span class="material-symbols-outlined text-[20px]">calendar_month</span>
                                </div>
                                <h4 class="text-[13px] font-bold text-slate-900 mb-2 leading-tight">RSVP to Upcoming Meetup</h4>
                                <p class="text-[12px] text-slate-500 leading-relaxed mb-4 flex-1">Regional Tech Leadership Mixer is next week.</p>
                                <a href="#" class="text-[12px] font-bold text-[#3525cd] flex items-center gap-1 hover:underline mt-auto">
                                    RSVP Now <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                                </a>
                            </div>

                            <!-- Action Item 2 (Active/Highlighted) -->
                            <div class="border border-slate-200 rounded-xl p-5 flex flex-col bg-white relative overflow-hidden shadow-sm">
                                <div class="absolute bottom-0 left-0 right-0 h-1 bg-[#3525cd]"></div>
                                <div class="w-10 h-10 rounded-full bg-[#006a8f] text-white flex items-center justify-center mb-4 shadow-sm">
                                    <span class="material-symbols-outlined text-[20px]">person_edit</span>
                                </div>
                                <h4 class="text-[13px] font-bold text-slate-900 mb-2 leading-tight">Complete Profile</h4>
                                <p class="text-[12px] text-slate-500 leading-relaxed mb-4 flex-1">Your profile is 85% complete. Add your bio.</p>
                                <a href="#" class="text-[12px] font-bold text-[#3525cd] flex items-center gap-1 hover:underline mt-auto">
                                    Update Profile <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                                </a>
                            </div>

                            <!-- Action Item 3 -->
                            <div class="border border-slate-200 rounded-xl p-5 flex flex-col bg-slate-50/50 hover:bg-slate-50 transition-colors">
                                <div class="w-10 h-10 rounded-full bg-slate-200 text-slate-600 flex items-center justify-center mb-4">
                                    <span class="material-symbols-outlined text-[20px]">receipt_long</span>
                                </div>
                                <h4 class="text-[13px] font-bold text-slate-900 mb-2 leading-tight">View Latest Invoice</h4>
                                <p class="text-[12px] text-slate-500 leading-relaxed mb-4 flex-1">Invoice #INV-2024-089 generated.</p>
                                <a href="#" class="text-[12px] font-bold text-[#3525cd] flex items-center gap-1 hover:underline mt-auto">
                                    View Invoice <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Bottom Row -->

                    <!-- Upcoming Events -->
                    <div class="lg:col-span-8 bg-white border border-slate-200 rounded-2xl shadow-sm p-6 flex flex-col">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-[18px] font-bold text-slate-900 tracking-tight">Upcoming Events</h3>
                            <a href="#" class="text-[13px] font-bold text-[#3525cd] hover:underline">View All</a>
                        </div>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 flex-1">
                            <!-- Event 1 (Offline) -->
                            <div class="border border-slate-200 rounded-xl overflow-hidden flex flex-col">
                                <div class="h-32 bg-slate-800 relative">
                                    <img src="/gma_hero_bg.png" class="w-full h-full object-cover opacity-60" alt="Event">
                                    <div class="absolute top-3 right-3 bg-white text-slate-800 text-[10px] font-bold px-2 py-1 rounded shadow-sm">
                                        Offline
                                    </div>
                                </div>
                                <div class="p-5 flex flex-col flex-1">
                                    <div class="text-[11px] font-bold text-[#3525cd] tracking-wide mb-1 uppercase">Oct 15 • 9:00 AM</div>
                                    <h4 class="text-[15px] font-bold text-slate-900 mb-2 leading-snug">Q4 Strategic Planning Summit</h4>
                                    <p class="text-[12.5px] text-slate-500 leading-relaxed mb-5 flex-1">Join us for the annual strategic planning session focusing on growth...</p>
                                    <button class="w-full bg-slate-200/70 text-slate-500 font-semibold text-[13px] py-2 rounded-lg cursor-not-allowed">
                                        Going
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Event 2 (Online) -->
                            <div class="border border-slate-200 rounded-xl overflow-hidden flex flex-col">
                                <div class="h-32 bg-indigo-50/80 flex items-center justify-center relative">
                                    <span class="material-symbols-outlined text-[40px] text-indigo-300">videocam</span>
                                    <div class="absolute top-3 right-3 bg-white text-slate-800 text-[10px] font-bold px-2 py-1 rounded shadow-sm">
                                        Online
                                    </div>
                                </div>
                                <div class="p-5 flex flex-col flex-1">
                                    <div class="text-[11px] font-bold text-[#3525cd] tracking-wide mb-1 uppercase">Oct 20 • 2:00 PM</div>
                                    <h4 class="text-[15px] font-bold text-slate-900 mb-2 leading-snug">Webinar: Future of Finance</h4>
                                    <p class="text-[12.5px] text-slate-500 leading-relaxed mb-5 flex-1">Expert panel discussion on decentralized ledger technologies.</p>
                                    <button class="w-full bg-[#3525cd] hover:bg-[#2d1faf] text-white font-semibold text-[13px] py-2 rounded-lg transition-colors shadow-sm">
                                        RSVP
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="lg:col-span-4 bg-white border border-slate-200 rounded-2xl shadow-sm p-6 flex flex-col">
                        <h3 class="text-[18px] font-bold text-slate-900 tracking-tight mb-6">Recent Activity</h3>
                        <div class="flex-1 relative">
                            <!-- Vertical Line -->
                            <div class="absolute left-[15px] top-2 bottom-6 w-px bg-slate-200"></div>
                            
                            <ul class="flex flex-col gap-6 relative z-10">
                                <li class="flex gap-4">
                                    <div class="w-8 h-8 rounded-full bg-indigo-50 text-[#3525cd] flex items-center justify-center shrink-0 border-[3px] border-white z-10 shadow-sm">
                                        <span class="material-symbols-outlined text-[15px]">person_add</span>
                                    </div>
                                    <div class="pt-1">
                                        <p class="text-[13.5px] text-slate-800 font-medium leading-snug">You joined the 'Leadership Workshop'</p>
                                        <span class="text-[11.5px] font-medium text-slate-500 mt-1 block">2 days ago</span>
                                    </div>
                                </li>
                                <li class="flex gap-4">
                                    <div class="w-8 h-8 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center shrink-0 border-[3px] border-white z-10 shadow-sm">
                                        <span class="material-symbols-outlined text-[15px]">autorenew</span>
                                    </div>
                                    <div class="pt-1">
                                        <p class="text-[13.5px] text-slate-800 font-medium leading-snug">Subscription renewed successfully</p>
                                        <span class="text-[11.5px] font-medium text-slate-500 mt-1 block">1 week ago</span>
                                    </div>
                                </li>
                                <li class="flex gap-4">
                                    <div class="w-8 h-8 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center shrink-0 border-[3px] border-white z-10 shadow-sm">
                                        <span class="material-symbols-outlined text-[15px]">download</span>
                                    </div>
                                    <div class="pt-1">
                                        <p class="text-[13.5px] text-slate-800 font-medium leading-snug">Downloaded Q3 Industry Report</p>
                                        <span class="text-[11.5px] font-medium text-slate-500 mt-1 block">2 weeks ago</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <a href="#" class="mt-8 text-[12.5px] font-bold text-[#3525cd] hover:underline text-center block w-full">View All Activity</a>
                    </div>

                </div>

            </div>
        </main>
    </div>

</body>
</html>
