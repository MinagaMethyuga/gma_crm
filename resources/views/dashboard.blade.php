<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GMA - Dashboard</title>
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
                <!-- Active Dashboard Link -->
                <div class="relative mt-1">
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-[#4338ca] rounded-r-md"></div>
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 text-[#4338ca] bg-indigo-50/70 rounded-lg transition-colors ml-1">
                        <span class="material-symbols-outlined text-xl fill">grid_view</span>
                        <span class="text-[13px] font-bold">Dashboard</span>
                    </a>
                </div>

                <a href="{{ route('members') }}" class="flex items-center gap-3 px-3 py-2.5 text-slate-600 hover:bg-slate-100 rounded-lg transition-colors mt-1">
                    <span class="material-symbols-outlined text-xl">group</span>
                    <span class="text-[13px] font-semibold">Members</span>
                </a>
                
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
                    <input type="text" class="block w-full pl-11 pr-3 py-2.5 border border-slate-200 rounded-xl leading-5 bg-slate-50/50 text-slate-900 placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-1 focus:ring-[#4338ca] focus:border-[#4338ca] sm:text-sm transition-colors shadow-inner" placeholder="Search...">
                </div>

                <div class="flex items-center gap-8 ml-auto mr-10 h-full">
                    <a href="#" class="text-[13px] font-bold text-[#4338ca] border-b-2 border-[#4338ca] h-full flex items-center">Directory</a>
                    <a href="#" class="text-[13px] font-semibold text-slate-500 hover:text-slate-800 transition-colors h-full flex items-center">Invoices</a>
                    <a href="#" class="text-[13px] font-semibold text-slate-500 hover:text-slate-800 transition-colors h-full flex items-center">Support</a>
                </div>
                
                <div class="flex items-center gap-4 pl-6 border-l border-slate-200 h-full">
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

            <!-- Content Body (Scrollable Dashboard Content) -->
            <div class="flex-1 overflow-y-auto custom-scroll p-8">
                
                <!-- Dashboard Content Here -->
                <div class="flex flex-col gap-6 max-w-7xl mx-auto">
                    <!-- Header -->
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4 mb-2">
                        <div>
                            <h2 class="text-3xl font-bold text-slate-900 tracking-tight mb-2">Dashboard Overview</h2>
                            <p class="text-slate-500 text-[14px]">Here's what's happening today.</p>
                        </div>
                        <div class="flex gap-2">
                            <button class="flex items-center gap-2 bg-white hover:bg-slate-50 border border-slate-200 shadow-sm rounded-lg px-4 py-2 text-[13px] font-bold text-slate-700 transition-colors">
                                <span class="material-symbols-outlined text-[18px]">download</span>
                                Export
                            </button>
                        </div>
                    </div>

                    <!-- Bento Grid Layout -->
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                        <!-- Stat Grid (Cols 1-8) -->
                        <div class="col-span-1 md:col-span-12 lg:col-span-8 grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <!-- Stat Card 1 -->
                            <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-6 flex flex-col justify-between h-40">
                                <div class="flex justify-between items-start">
                                    <span class="text-[11px] font-bold text-slate-500 uppercase tracking-widest">Total Revenue</span>
                                    <span class="material-symbols-outlined text-slate-400">payments</span>
                                </div>
                                <div>
                                    <div class="flex items-baseline gap-2">
                                        <span class="text-3xl tracking-tight text-slate-900 font-bold">$42.5k</span>
                                        <span class="text-[11px] text-[#4338ca] bg-indigo-50 px-2 py-0.5 rounded-md flex items-center gap-1 font-bold">
                                            <span class="material-symbols-outlined text-[14px]">trending_up</span>
                                            +12%
                                        </span>
                                    </div>
                                    <p class="text-[12px] font-semibold text-slate-400 mt-1">vs last month</p>
                                </div>
                            </div>
                            <!-- Stat Card 2 -->
                            <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-6 flex flex-col justify-between h-40">
                                <div class="flex justify-between items-start">
                                    <span class="text-[11px] font-bold text-slate-500 uppercase tracking-widest">Active Members</span>
                                    <span class="material-symbols-outlined text-slate-400">group</span>
                                </div>
                                <div>
                                    <div class="flex items-baseline gap-2">
                                        <span class="text-3xl tracking-tight text-slate-900 font-bold">1,240</span>
                                        <span class="text-[11px] text-[#4338ca] bg-indigo-50 px-2 py-0.5 rounded-md flex items-center gap-1 font-bold">
                                            <span class="material-symbols-outlined text-[14px]">trending_up</span>
                                            +5%
                                        </span>
                                    </div>
                                    <p class="text-[12px] font-semibold text-slate-400 mt-1">vs last month</p>
                                </div>
                            </div>
                            <!-- Stat Card 3 -->
                            <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-6 flex flex-col justify-between h-40">
                                <div class="flex justify-between items-start">
                                    <span class="text-[11px] font-bold text-slate-500 uppercase tracking-widest">New Signups</span>
                                    <span class="material-symbols-outlined text-slate-400">person_add</span>
                                </div>
                                <div>
                                    <div class="flex items-baseline gap-2">
                                        <span class="text-3xl tracking-tight text-slate-900 font-bold">42</span>
                                    </div>
                                    <p class="text-[12px] font-semibold text-slate-400 mt-1">this week</p>
                                </div>
                            </div>
                            <!-- Stat Card 4 -->
                            <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-6 flex flex-col justify-between h-40">
                                <div class="flex justify-between items-start">
                                    <span class="text-[11px] font-bold text-slate-500 uppercase tracking-widest">Event RSVP Rate</span>
                                    <span class="material-symbols-outlined text-slate-400">how_to_reg</span>
                                </div>
                                <div>
                                    <div class="flex items-baseline gap-2">
                                        <span class="text-3xl tracking-tight text-slate-900 font-bold">88%</span>
                                    </div>
                                    <div class="w-full h-1.5 bg-slate-100 mt-3 rounded-full overflow-hidden">
                                        <div class="h-full bg-[#4338ca] w-[88%] rounded-full"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="col-span-1 md:col-span-12 lg:col-span-4 flex flex-col gap-6">
                            <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-6">
                                <h3 class="text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-4">Quick Actions</h3>
                                <div class="flex flex-col gap-2">
                                    <a href="{{ route('members') }}" class="w-full flex items-center justify-between p-3 rounded-lg hover:bg-slate-50 transition-colors border border-transparent hover:border-slate-200 group">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-lg bg-indigo-50 text-[#4338ca] flex items-center justify-center transition-colors">
                                                <span class="material-symbols-outlined text-[18px]">person_add</span>
                                            </div>
                                            <span class="text-[13px] font-semibold text-slate-800">Add Member</span>
                                        </div>
                                        <span class="material-symbols-outlined text-slate-400 opacity-0 group-hover:opacity-100 transition-opacity">chevron_right</span>
                                    </a>
                                    <a href="{{ route('events') }}" class="w-full flex items-center justify-between p-3 rounded-lg hover:bg-slate-50 transition-colors border border-transparent hover:border-slate-200 group">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center transition-colors">
                                                <span class="material-symbols-outlined text-[18px]">event</span>
                                            </div>
                                            <span class="text-[13px] font-semibold text-slate-800">Create Event</span>
                                        </div>
                                        <span class="material-symbols-outlined text-slate-400 opacity-0 group-hover:opacity-100 transition-opacity">chevron_right</span>
                                    </a>
                                    <button class="w-full flex items-center justify-between p-3 rounded-lg hover:bg-slate-50 transition-colors border border-transparent hover:border-slate-200 group">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center transition-colors">
                                                <span class="material-symbols-outlined text-[18px]">summarize</span>
                                            </div>
                                            <span class="text-[13px] font-semibold text-slate-800">Generate Report</span>
                                        </div>
                                        <span class="material-symbols-outlined text-slate-400 opacity-0 group-hover:opacity-100 transition-opacity">chevron_right</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Lower Section -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-2">
                        <!-- Revenue Chart Area -->
                        <div class="col-span-1 lg:col-span-2 bg-white border border-slate-200 rounded-xl shadow-sm p-6 flex flex-col min-h-[300px]">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-[18px] font-bold text-slate-900 tracking-tight">Revenue Growth</h3>
                                <select class="bg-slate-50 border border-slate-200 text-[12px] rounded-lg py-1.5 px-3 focus:outline-none focus:ring-1 focus:ring-[#4338ca] text-slate-700 font-semibold cursor-pointer">
                                    <option>Last 6 Months</option>
                                    <option>YTD</option>
                                </select>
                            </div>
                            <div class="flex-1 w-full bg-slate-50 flex items-end p-4 rounded-xl relative overflow-hidden group border border-slate-100">
                                <div class="w-full flex justify-between items-end h-full gap-2 relative z-10">
                                    <div class="w-full bg-indigo-200 rounded-t-sm h-[30%]"></div>
                                    <div class="w-full bg-indigo-300 rounded-t-sm h-[45%]"></div>
                                    <div class="w-full bg-indigo-400 rounded-t-sm h-[40%]"></div>
                                    <div class="w-full bg-[#6366f1] rounded-t-sm h-[60%]"></div>
                                    <div class="w-full bg-[#4f46e5] rounded-t-sm h-[85%]"></div>
                                    <div class="w-full bg-[#4338ca] rounded-t-sm h-[100%] relative group"><div class="absolute -top-10 left-1/2 -translate-x-1/2 bg-slate-800 text-white px-2 py-1 rounded text-xs opacity-0 group-hover:opacity-100 transition-opacity shadow-sm whitespace-nowrap">$12.4k</div></div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Activity Feed -->
                        <div class="col-span-1 bg-white border border-slate-200 rounded-xl shadow-sm p-6 flex flex-col">
                            <h3 class="text-[18px] font-bold text-slate-900 tracking-tight mb-6">Recent Activity</h3>
                            <div class="flex-1 overflow-hidden relative">
                                <!-- Vertical Line -->
                                <div class="absolute left-[15px] top-2 bottom-0 w-px bg-slate-200"></div>
                                <ul class="flex flex-col gap-6 relative z-10">
                                    <li class="flex gap-4">
                                        <div class="w-8 h-8 rounded-full bg-cyan-50 text-cyan-600 flex items-center justify-center shrink-0 border border-white z-10 shadow-sm">
                                            <span class="material-symbols-outlined text-[16px]">person</span>
                                        </div>
                                        <div>
                                            <p class="text-[13px] text-slate-800"><span class="font-bold text-slate-900">New member joined:</span> Sarah Chen</p>
                                            <span class="text-[11px] font-medium text-slate-500">2 hours ago</span>
                                        </div>
                                    </li>
                                    <li class="flex gap-4">
                                        <div class="w-8 h-8 rounded-full bg-indigo-50 text-[#4338ca] flex items-center justify-center shrink-0 border border-white z-10 shadow-sm">
                                            <span class="material-symbols-outlined text-[16px]">attach_money</span>
                                        </div>
                                        <div>
                                            <p class="text-[13px] text-slate-800"><span class="font-bold text-slate-900">Payment received</span> from Tech Corp</p>
                                            <span class="text-[11px] font-medium text-slate-500">5 hours ago</span>
                                        </div>
                                    </li>
                                    <li class="flex gap-4">
                                        <div class="w-8 h-8 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center shrink-0 border border-white z-10 shadow-sm">
                                            <span class="material-symbols-outlined text-[16px]">campaign</span>
                                        </div>
                                        <div>
                                            <p class="text-[13px] text-slate-800"><span class="font-bold text-slate-900">Event created:</span> 'Annual Gala'</p>
                                            <span class="text-[11px] font-medium text-slate-500">1 day ago</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <button class="mt-6 text-[12px] text-[#4338ca] font-bold hover:underline text-center w-full">View All Activity</button>
                        </div>
                    </div>

                    <!-- Data Table Section -->
                    <div class="mt-2 bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                        <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-white">
                            <h3 class="text-[18px] font-bold text-slate-900 tracking-tight">Upcoming Events</h3>
                            <a href="{{ route('events') }}" class="text-[12px] text-[#4338ca] font-bold hover:underline">View All Events</a>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-slate-50/80 border-b border-slate-200">
                                        <th class="p-4 text-[11px] uppercase tracking-widest font-bold text-slate-500">Event Name</th>
                                        <th class="p-4 text-[11px] uppercase tracking-widest font-bold text-slate-500">Date</th>
                                        <th class="p-4 text-[11px] uppercase tracking-widest font-bold text-slate-500">Location</th>
                                        <th class="p-4 text-[11px] uppercase tracking-widest font-bold text-slate-500 text-right">RSVPs</th>
                                        <th class="p-4 text-[11px] uppercase tracking-widest font-bold text-slate-500 text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="text-[13px] text-slate-800">
                                    <tr class="border-b border-slate-100 hover:bg-slate-50/50 transition-colors">
                                        <td class="p-4 font-bold">Q3 Strategy Summit</td>
                                        <td class="p-4 text-slate-500 font-medium">Oct 15, 2024</td>
                                        <td class="p-4 text-slate-500 font-medium">Main Hall</td>
                                        <td class="p-4 font-mono text-right font-semibold text-[#4338ca]">142/150</td>
                                        <td class="p-4 text-center">
                                            <span class="inline-block px-3 py-1 bg-amber-50 text-amber-700 font-bold rounded-md text-[10px] uppercase tracking-wide border border-amber-200/60">Filling Fast</span>
                                        </td>
                                    </tr>
                                    <tr class="border-b border-slate-100 hover:bg-slate-50/50 transition-colors">
                                        <td class="p-4 font-bold">Networking Mixer</td>
                                        <td class="p-4 text-slate-500 font-medium">Oct 22, 2024</td>
                                        <td class="p-4 text-slate-500 font-medium">Rooftop Lounge</td>
                                        <td class="p-4 font-mono text-right font-semibold text-[#4338ca]">85/100</td>
                                        <td class="p-4 text-center">
                                            <span class="inline-block px-3 py-1 bg-emerald-50 text-emerald-700 font-bold rounded-md text-[10px] uppercase tracking-wide border border-emerald-200/60">Open</span>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="p-4 font-bold">Annual Gala</td>
                                        <td class="p-4 text-slate-500 font-medium">Nov 05, 2024</td>
                                        <td class="p-4 text-slate-500 font-medium">Grand Ballroom</td>
                                        <td class="p-4 font-mono text-right font-semibold text-[#4338ca]">210/500</td>
                                        <td class="p-4 text-center">
                                            <span class="inline-block px-3 py-1 bg-emerald-50 text-emerald-700 font-bold rounded-md text-[10px] uppercase tracking-wide border border-emerald-200/60">Open</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </main>
    </div>

</body>
</html>
