<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GMA - Members Admin</title>
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
            <div class="pt-6 pb-2 px-6 flex flex-col gap-1.5">
                <a href="{{ route('home') }}" class="block">
                    <img src="/Global_Mobile_Association_Logo__1_-removebg-preview.png" alt="GMA Logo" class="h-14 w-auto object-contain object-left">
                </a>
                <p class="text-[10.5px] font-bold text-slate-500 uppercase tracking-widest pl-1">Admin Console</p>
            </div>

            <div class="px-5 mb-6 mt-2">
                <button class="w-full bg-[#4338ca] hover:bg-[#3730a3] text-white rounded-lg py-2.5 px-4 flex items-center justify-center gap-2 font-semibold text-[13px] transition-colors shadow-md shadow-[#4338ca]/20 tracking-wide">
                    <span class="material-symbols-outlined text-[20px]">add</span>
                    New Entry
                </button>
            </div>

            <!-- Nav Links -->
            <nav class="flex-1 px-3 space-y-1 overflow-y-auto">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 text-slate-600 hover:bg-slate-100 rounded-lg transition-colors">
                    <span class="material-symbols-outlined text-xl">grid_view</span>
                    <span class="text-[13px] font-semibold">Dashboard</span>
                </a>
                
                <!-- Active Members Link -->
                <div class="relative mt-1">
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-[#4338ca] rounded-r-md"></div>
                    <a href="{{ route('members') }}" class="flex items-center gap-3 px-3 py-2.5 text-[#4338ca] bg-indigo-50/70 rounded-lg transition-colors ml-1">
                        <span class="material-symbols-outlined text-xl fill">group</span>
                        <span class="text-[13px] font-bold">Members</span>
                    </a>
                </div>

                <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-slate-600 hover:bg-slate-100 rounded-lg transition-colors mt-1">
                    <span class="material-symbols-outlined text-xl">payments</span>
                    <span class="text-[13px] font-semibold">Financials</span>
                </a>
                <a href="{{ route('events') }}" class="flex items-center gap-3 px-3 py-2.5 text-slate-600 hover:bg-slate-100 rounded-lg transition-colors mt-1">
                    <span class="material-symbols-outlined text-xl">calendar_month</span>
                    <span class="text-[13px] font-semibold">Events</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-slate-600 hover:bg-slate-100 rounded-lg transition-colors mt-1">
                    <span class="material-symbols-outlined text-xl">bar_chart</span>
                    <span class="text-[13px] font-semibold">Reports</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-slate-600 hover:bg-slate-100 rounded-lg transition-colors mt-1">
                    <span class="material-symbols-outlined text-xl">settings</span>
                    <span class="text-[13px] font-semibold">Settings</span>
                </a>
            </nav>

            <!-- Bottom Links -->
            <div class="p-4 border-t border-slate-200">
                <a href="#" class="flex items-center gap-3 px-3 py-2 text-slate-600 hover:bg-slate-100 rounded-lg transition-colors">
                    <span class="material-symbols-outlined text-xl">help</span>
                    <span class="text-[13px] font-semibold">Help</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-3 py-2 text-slate-600 hover:bg-slate-100 rounded-lg transition-colors mt-1">
                    <span class="material-symbols-outlined text-xl text-slate-600">logout</span>
                    <span class="text-[13px] font-semibold">Sign Out</span>
                </a>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 flex flex-col min-w-0 bg-[#fbfcfd]">
            
            <!-- Top Header -->
            <header class="h-20 border-b border-slate-200 flex items-center justify-between px-8 bg-white shrink-0">
                <!-- Search Bar -->
                <div class="relative w-96">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <span class="material-symbols-outlined text-slate-400 text-xl">search</span>
                    </div>
                    <input type="text" class="block w-full pl-11 pr-3 py-2.5 border border-slate-200 rounded-xl leading-5 bg-slate-50/50 text-slate-900 placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-1 focus:ring-[#4338ca] focus:border-[#4338ca] sm:text-sm transition-colors shadow-inner" placeholder="Search members directory...">
                </div>

                <div class="flex items-center gap-8 ml-auto mr-10">
                    <a href="#" class="text-[13px] font-bold text-[#4338ca] border-b-2 border-[#4338ca] py-7">Directory</a>
                    <a href="#" class="text-[13px] font-semibold text-slate-500 hover:text-slate-800 transition-colors py-7">Invoices</a>
                    <a href="#" class="text-[13px] font-semibold text-slate-500 hover:text-slate-800 transition-colors py-7">Support</a>
                </div>
                
                <div class="flex items-center gap-4 pl-6 border-l border-slate-200">
                    <button class="text-slate-400 hover:text-slate-600 transition-colors">
                        <span class="material-symbols-outlined">notifications</span>
                    </button>
                    <button class="text-slate-400 hover:text-slate-600 transition-colors">
                        <span class="material-symbols-outlined">apps</span>
                    </button>
                    
                    <button class="bg-indigo-100/50 hover:bg-indigo-100 text-[#4338ca] text-sm font-semibold px-4 py-2 rounded-lg transition-colors ml-2 tracking-wide hidden md:block border border-indigo-200/50">
                        Create Event
                    </button>
                    <div class="w-8 h-8 rounded-full bg-slate-200 overflow-hidden shadow-sm ml-2 shrink-0 border border-slate-200">
                        <img src="https://ui-avatars.com/api/?name=Admin&background=103C68&color=fff" alt="User" class="w-full h-full object-cover">
                    </div>
                </div>
            </header>

            <!-- Content Body -->
            <div class="flex-1 flex flex-col overflow-hidden p-8 px-10">
                
                <!-- Page Header & Actions -->
                <div class="flex justify-between items-end mb-8">
                    <div>
                        <h2 class="text-3xl font-bold text-slate-900 mb-2 tracking-tight">Members</h2>
                        <p class="text-slate-500 text-[14px]">Manage organization directory and member status.</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <button class="flex items-center gap-2 bg-slate-50 hover:bg-slate-100 border border-slate-200 shadow-sm rounded-lg px-4 py-2 text-[13px] font-bold text-slate-700 transition-colors">
                            <span class="material-symbols-outlined text-[18px]">download</span>
                            CSV Export
                        </button>
                        <button class="flex items-center gap-2 bg-[#4338ca] hover:bg-[#3730a3] shadow-md shadow-[#4338ca]/20 rounded-lg px-5 py-2 text-[13px] font-bold text-white transition-colors">
                            <span class="material-symbols-outlined text-[18px]">person_add</span>
                            Add Member
                        </button>
                    </div>
                </div>

                <!-- Filters Bar -->
                <div class="bg-white border border-slate-200 rounded-xl p-3 mb-6 shadow-sm flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="flex items-center gap-2 pl-2 text-slate-700">
                            <span class="material-symbols-outlined text-lg">filter_list</span>
                            <span class="text-[13px] font-bold">Filter by:</span>
                        </div>
                        
                        <div class="flex items-center gap-3">
                            <div class="relative">
                                <select class="appearance-none bg-slate-50 border border-slate-200 text-slate-700 text-[13px] font-semibold rounded-lg pl-3 pr-8 py-1.5 focus:outline-none focus:ring-1 focus:ring-[#4338ca] focus:border-[#4338ca] cursor-pointer hover:bg-slate-100">
                                    <option>Status: All</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-500">
                                    <span class="material-symbols-outlined text-[18px]">expand_more</span>
                                </div>
                            </div>
                            
                            <div class="relative">
                                <select class="appearance-none bg-slate-50 border border-slate-200 text-slate-700 text-[13px] font-semibold rounded-lg pl-3 pr-8 py-1.5 focus:outline-none focus:ring-1 focus:ring-[#4338ca] focus:border-[#4338ca] cursor-pointer hover:bg-slate-100">
                                    <option>Tag: All Roles</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-500">
                                    <span class="material-symbols-outlined text-[18px]">expand_more</span>
                                </div>
                            </div>

                            <div class="flex items-center gap-2 bg-slate-50 border border-slate-200 text-slate-700 text-[13px] font-semibold rounded-lg px-3 py-1.5 cursor-pointer hover:bg-slate-100">
                                <span class="material-symbols-outlined text-[16px] text-slate-400">calendar_today</span>
                                Jan 1, 2023 - Present
                            </div>
                        </div>
                    </div>
                    
                    <button class="text-[13px] font-bold text-[#4338ca] hover:text-[#3730a3] pr-3 transition-colors">
                        Clear Filters
                    </button>
                </div>

                <!-- Table Container -->
                <div class="flex-1 flex flex-col bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden mb-6">
                    <div class="flex-1 overflow-x-auto custom-scroll">
                        <table class="min-w-full w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50/80 border-b border-slate-200">
                                    <th class="px-6 py-4 text-[11px] font-bold text-slate-500 uppercase tracking-widest">Member</th>
                                    <th class="px-6 py-4 text-[11px] font-bold text-slate-500 uppercase tracking-widest">Status</th>
                                    <th class="px-6 py-4 text-[11px] font-bold text-slate-500 uppercase tracking-widest">Tier</th>
                                    <th class="px-6 py-4 text-[11px] font-bold text-slate-500 uppercase tracking-widest">Joined Date</th>
                                    <th class="px-6 py-4 text-[11px] font-bold text-slate-500 uppercase tracking-widest">Last Activity</th>
                                    <th class="px-6 py-4 text-[11px] font-bold text-slate-500 uppercase tracking-widest text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                <!-- Row 1 -->
                                <tr class="hover:bg-slate-50/50 transition-colors group">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-4">
                                            <div class="w-10 h-10 rounded-full bg-slate-200 overflow-hidden shrink-0 border border-slate-200 shadow-sm">
                                                <img src="https://ui-avatars.com/api/?name=Eleanor+Vance&background=0f172a&color=fff" alt="Eleanor Vance" class="w-full h-full object-cover">
                                            </div>
                                            <div>
                                                <div class="text-[14px] font-bold text-slate-900 leading-tight">Eleanor Vance</div>
                                                <div class="text-[13px] text-slate-500 mt-0.5">eleanor.v@example.com</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200/60 uppercase tracking-wide">
                                            <div class="w-1.5 h-1.5 rounded-full bg-emerald-500"></div>
                                            Active
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <span class="text-[13px] font-medium text-slate-700">Professional</span>
                                            <span class="bg-slate-200/70 text-slate-600 text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded shadow-sm">VIP</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-[13px] text-slate-600 font-medium">
                                        Oct 12, 2021
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-[13px] text-slate-500">
                                        2 hours ago
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <!-- Actions placeholder -->
                                    </td>
                                </tr>

                                <!-- Row 2 -->
                                <tr class="hover:bg-slate-50/50 transition-colors group">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-4">
                                            <div class="w-10 h-10 rounded-full bg-[#0284c7] text-white flex items-center justify-center font-bold text-sm shrink-0 shadow-sm">
                                                MK
                                            </div>
                                            <div>
                                                <div class="text-[14px] font-bold text-slate-900 leading-tight">Marcus Kane</div>
                                                <div class="text-[13px] text-slate-500 mt-0.5">m.kane@corporate.org</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[11px] font-bold bg-amber-50 text-amber-700 border border-amber-200/60 uppercase tracking-wide">
                                            <div class="w-1.5 h-1.5 rounded-full bg-amber-500"></div>
                                            Pending
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <span class="text-[13px] font-medium text-slate-700">Enterprise</span>
                                            <span class="bg-slate-200/70 text-slate-600 text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded shadow-sm">BOARD</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-[13px] text-slate-600 font-medium">
                                        Nov 04, 2023
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-[13px] text-slate-400 font-medium">
                                        Never
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <!-- Actions placeholder -->
                                    </td>
                                </tr>

                                <!-- Row 3 -->
                                <tr class="hover:bg-slate-50/50 transition-colors group">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-4">
                                            <div class="w-10 h-10 rounded-full bg-slate-200 overflow-hidden shrink-0 border border-slate-200 shadow-sm">
                                                <img src="https://ui-avatars.com/api/?name=Sarah+Jenkins&background=0f172a&color=fff" alt="Sarah Jenkins" class="w-full h-full object-cover">
                                            </div>
                                            <div>
                                                <div class="text-[14px] font-bold text-slate-900 leading-tight">Sarah Jenkins</div>
                                                <div class="text-[13px] text-slate-500 mt-0.5">s.jenkins@example.com</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[11px] font-bold bg-rose-50 text-rose-700 border border-rose-200/60 uppercase tracking-wide">
                                            <div class="w-1.5 h-1.5 rounded-full bg-rose-500"></div>
                                            Lapsed
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <span class="text-[13px] font-medium text-slate-700">Basic</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-[13px] text-slate-600 font-medium">
                                        Jan 15, 2020
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-[13px] text-slate-500">
                                        4 mos ago
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <!-- Actions placeholder -->
                                    </td>
                                </tr>

                                <!-- Row 4 -->
                                <tr class="hover:bg-slate-50/50 transition-colors group border-b-0">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-4">
                                            <div class="w-10 h-10 rounded-full bg-indigo-100 text-[#4338ca] flex items-center justify-center font-bold text-sm shrink-0 shadow-sm">
                                                DT
                                            </div>
                                            <div>
                                                <div class="text-[14px] font-bold text-slate-900 leading-tight">David Torres</div>
                                                <div class="text-[13px] text-slate-500 mt-0.5">david.t@logistics.net</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200/60 uppercase tracking-wide">
                                            <div class="w-1.5 h-1.5 rounded-full bg-emerald-500"></div>
                                            Active
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <span class="text-[13px] font-medium text-slate-700">Professional</span>
                                            <span class="bg-slate-200/70 text-slate-600 text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded shadow-sm">VOLUNTEER</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-[13px] text-slate-600 font-medium">
                                        Mar 22, 2022
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-[13px] text-slate-500">
                                        1 day ago
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <!-- Actions placeholder -->
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination / Footer -->
                    <div class="border-t border-slate-200 bg-slate-50/50 px-6 py-4 flex items-center justify-between shrink-0">
                        <div class="text-[13px] text-slate-500 font-medium">
                            Showing <span class="font-bold text-slate-700">1</span> to <span class="font-bold text-slate-700">4</span> of <span class="font-bold text-slate-700">128</span> members
                        </div>
                        <div class="flex items-center gap-1.5">
                            <button class="w-8 h-8 flex items-center justify-center text-slate-400 hover:text-slate-600 rounded-md transition-colors">
                                <span class="material-symbols-outlined text-lg">chevron_left</span>
                            </button>
                            <button class="w-8 h-8 flex items-center justify-center bg-[#4338ca] text-white font-bold text-sm rounded-md shadow-sm">
                                1
                            </button>
                            <button class="w-8 h-8 flex items-center justify-center hover:bg-slate-200 text-slate-600 font-bold text-sm rounded-md transition-colors">
                                2
                            </button>
                            <button class="w-8 h-8 flex items-center justify-center hover:bg-slate-200 text-slate-600 font-bold text-sm rounded-md transition-colors">
                                3
                            </button>
                            <span class="w-8 h-8 flex items-center justify-center text-slate-400 font-bold text-sm">
                                ...
                            </span>
                            <button class="w-8 h-8 flex items-center justify-center hover:bg-slate-200 text-slate-600 font-bold text-sm rounded-md transition-colors">
                                12
                            </button>
                            <button class="w-8 h-8 flex items-center justify-center text-slate-500 hover:text-slate-700 rounded-md transition-colors">
                                <span class="material-symbols-outlined text-lg">chevron_right</span>
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>

</body>
</html>
