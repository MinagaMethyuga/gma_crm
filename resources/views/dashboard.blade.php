<x-layouts::app :title="__('Dashboard')">
    <!-- Canvas -->
    <div class="p-8 flex-1 flex flex-col gap-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4 mb-4">
            <div>
                <h2 class="text-headline-xl font-headline-xl text-zinc-900 font-bold tracking-tight mb-1">Dashboard Overview</h2>
                <p class="text-body-md font-body-md text-zinc-600">Here's what's happening today.</p>
            </div>
            <div class="flex gap-2">
                <button class="bg-white border border-zinc-200 hover:bg-zinc-50 text-zinc-700 px-4 py-2 rounded-lg font-label-md transition-colors shadow-sm flex items-center gap-2 kowalski-spring">
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
                <div class="kowalski-card p-6 flex flex-col justify-between h-40">
                    <div class="flex justify-between items-start">
                        <span class="text-label-sm font-label-sm text-zinc-500 uppercase tracking-wider font-semibold">Total Revenue</span>
                        <span class="material-symbols-outlined text-secondary text-opacity-50">payments</span>
                    </div>
                    <div>
                        <div class="flex items-baseline gap-2">
                            <span class="text-headline-xl font-headline-xl tracking-tight text-zinc-900 font-bold">$42.5k</span>
                            <span class="text-label-sm font-label-sm text-[#3525cd] bg-[#3525cd]/10 px-2 py-0.5 rounded-full flex items-center gap-1 font-semibold">
                                <span class="material-symbols-outlined text-[14px]">trending_up</span>
                                +12%
                            </span>
                        </div>
                        <p class="text-body-sm font-body-sm text-zinc-500 mt-1">vs last month</p>
                    </div>
                </div>
                <!-- Stat Card 2 -->
                <div class="kowalski-card p-6 flex flex-col justify-between h-40">
                    <div class="flex justify-between items-start">
                        <span class="text-label-sm font-label-sm text-zinc-500 uppercase tracking-wider font-semibold">Active Members</span>
                        <span class="material-symbols-outlined text-secondary text-opacity-50">group</span>
                    </div>
                    <div>
                        <div class="flex items-baseline gap-2">
                            <span class="text-headline-xl font-headline-xl tracking-tight text-zinc-900 font-bold">1,240</span>
                            <span class="text-label-sm font-label-sm text-[#3525cd] bg-[#3525cd]/10 px-2 py-0.5 rounded-full flex items-center gap-1 font-semibold">
                                <span class="material-symbols-outlined text-[14px]">trending_up</span>
                                +5%
                            </span>
                        </div>
                        <p class="text-body-sm font-body-sm text-zinc-500 mt-1">vs last month</p>
                    </div>
                </div>
                <!-- Stat Card 3 -->
                <div class="kowalski-card p-6 flex flex-col justify-between h-40">
                    <div class="flex justify-between items-start">
                        <span class="text-label-sm font-label-sm text-zinc-500 uppercase tracking-wider font-semibold">New Signups</span>
                        <span class="material-symbols-outlined text-secondary text-opacity-50">person_add</span>
                    </div>
                    <div>
                        <div class="flex items-baseline gap-2">
                            <span class="text-headline-xl font-headline-xl tracking-tight text-zinc-900 font-bold">42</span>
                        </div>
                        <p class="text-body-sm font-body-sm text-zinc-500 mt-1">this week</p>
                    </div>
                </div>
                <!-- Stat Card 4 -->
                <div class="kowalski-card p-6 flex flex-col justify-between h-40">
                    <div class="flex justify-between items-start">
                        <span class="text-label-sm font-label-sm text-zinc-500 uppercase tracking-wider font-semibold">Event RSVP Rate</span>
                        <span class="material-symbols-outlined text-secondary text-opacity-50">how_to_reg</span>
                    </div>
                    <div>
                        <div class="flex items-baseline gap-2">
                            <span class="text-headline-xl font-headline-xl tracking-tight text-zinc-900 font-bold">88%</span>
                        </div>
                        <!-- Mini Sparkline placeholder (CSS) -->
                        <div class="w-full h-1 bg-zinc-100 mt-3 rounded-full overflow-hidden">
                            <div class="h-full bg-[#3525cd] w-[88%] rounded-full"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions & Upcoming Events (Cols 9-12) -->
            <div class="col-span-1 md:col-span-12 lg:col-span-4 flex flex-col gap-6">
                <!-- Quick Actions -->
                <div class="kowalski-card p-6">
                    <h3 class="text-label-sm font-label-sm text-zinc-500 uppercase tracking-wider font-semibold mb-4">Quick Actions</h3>
                    <div class="flex flex-col gap-2">
                        <button class="w-full flex items-center justify-between p-3 rounded-lg hover:bg-zinc-50 transition-colors border border-transparent hover:border-zinc-200 group kowalski-spring">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded bg-[#3525cd]/10 text-[#3525cd] flex items-center justify-center transition-colors">
                                    <span class="material-symbols-outlined text-[18px]">person_add</span>
                                </div>
                                <span class="text-label-md font-label-md text-zinc-800">Add Member</span>
                            </div>
                            <span class="material-symbols-outlined text-zinc-400 opacity-0 group-hover:opacity-100 kowalski-spring">chevron_right</span>
                        </button>
                        <button class="w-full flex items-center justify-between p-3 rounded-lg hover:bg-zinc-50 transition-colors border border-transparent hover:border-zinc-200 group kowalski-spring">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded bg-slate-100 text-slate-600 flex items-center justify-center transition-colors">
                                    <span class="material-symbols-outlined text-[18px]">event</span>
                                </div>
                                <span class="text-label-md font-label-md text-zinc-800">Create Event</span>
                            </div>
                            <span class="material-symbols-outlined text-zinc-400 opacity-0 group-hover:opacity-100 kowalski-spring">chevron_right</span>
                        </button>
                        <button class="w-full flex items-center justify-between p-3 rounded-lg hover:bg-zinc-50 transition-colors border border-transparent hover:border-zinc-200 group kowalski-spring">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded bg-slate-100 text-slate-600 flex items-center justify-center transition-colors">
                                    <span class="material-symbols-outlined text-[18px]">summarize</span>
                                </div>
                                <span class="text-label-md font-label-md text-zinc-800">Generate Report</span>
                            </div>
                            <span class="material-symbols-outlined text-zinc-400 opacity-0 group-hover:opacity-100 kowalski-spring">chevron_right</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lower Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-4">
            <!-- Revenue Chart Area -->
            <div class="col-span-1 lg:col-span-2 kowalski-card p-6 flex flex-col min-h-[300px]">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-headline-md font-headline-md text-zinc-900 font-bold tracking-tight">Revenue Growth</h3>
                    <select class="bg-zinc-100 border-none text-label-sm font-label-sm rounded-md py-1 px-3 focus:ring-2 focus:ring-zinc-300 text-zinc-700 font-semibold cursor-pointer">
                        <option>Last 6 Months</option>
                        <option>YTD</option>
                    </select>
                </div>
                <div class="flex-1 w-full bg-zinc-50 flex items-end p-4 rounded-lg relative overflow-hidden group">
                    <div class="w-full flex justify-between items-end h-full gap-2 relative z-10">
                        <div class="w-full bg-[#d0cbf3] rounded-t-sm h-[30%]"></div>
                        <div class="w-full bg-[#b5aef0] rounded-t-sm h-[45%]"></div>
                        <div class="w-full bg-[#9f94eb] rounded-t-sm h-[40%]"></div>
                        <div class="w-full bg-[#8778e7] rounded-t-sm h-[60%]"></div>
                        <div class="w-full bg-[#6d5ae2] rounded-t-sm h-[85%]"></div>
                        <div class="w-full bg-[#3525cd] rounded-t-sm h-[100%] relative group"><div class="absolute -top-10 left-1/2 -translate-x-1/2 bg-zinc-800 text-white px-2 py-1 rounded text-xs opacity-0 group-hover:opacity-100 transition-opacity shadow-sm whitespace-nowrap">$12.4k</div></div>
                    </div>
                </div>
            </div>
            
            <!-- Activity Feed -->
            <div class="col-span-1 kowalski-card p-6 flex flex-col">
                <h3 class="text-headline-md font-headline-md text-zinc-900 font-bold tracking-tight mb-6">Recent Activity</h3>
                <div class="flex-1 overflow-hidden relative">
                    <!-- Vertical Line -->
                    <div class="absolute left-[15px] top-2 bottom-0 w-px bg-zinc-200"></div>
                    <ul class="flex flex-col gap-6 relative z-10">
                        <li class="flex gap-4">
                            <div class="w-8 h-8 rounded-full bg-[#c0f0f5] text-[#008f9c] flex items-center justify-center shrink-0 border border-white z-10">
                                <span class="material-symbols-outlined text-[16px]">person</span>
                            </div>
                            <div>
                                <p class="text-body-sm font-body-sm text-zinc-900"><span class="font-medium text-zinc-800">New member joined:</span> Sarah Chen</p>
                                <span class="text-label-sm font-label-sm text-zinc-500">2 hours ago</span>
                            </div>
                        </li>
                        <li class="flex gap-4">
                            <div class="w-8 h-8 rounded-full bg-[#eaddff] text-[#6750a4] flex items-center justify-center shrink-0 border border-white z-10">
                                <span class="material-symbols-outlined text-[16px]">attach_money</span>
                            </div>
                            <div>
                                <p class="text-body-sm font-body-sm text-zinc-900"><span class="font-medium text-zinc-800">Payment received</span> from Tech Corp</p>
                                <span class="text-label-sm font-label-sm text-zinc-500">5 hours ago</span>
                            </div>
                        </li>
                        <li class="flex gap-4">
                            <div class="w-8 h-8 rounded-full bg-zinc-200 text-zinc-600 flex items-center justify-center shrink-0 border border-white z-10">
                                <span class="material-symbols-outlined text-[16px]">campaign</span>
                            </div>
                            <div>
                                <p class="text-body-sm font-body-sm text-zinc-900"><span class="font-medium text-zinc-800">Event created:</span> 'Annual Gala'</p>
                                <span class="text-label-sm font-label-sm text-zinc-500">1 day ago</span>
                            </div>
                        </li>
                    </ul>
                </div>
                <button class="mt-4 text-label-sm font-label-sm text-[#3525cd] font-semibold hover:underline text-center w-full">View All Activity</button>
            </div>
        </div>

        <!-- Data Table Section -->
        <div class="mt-4 bg-white rounded-xl shadow-sm border border-zinc-200 overflow-hidden">
            <div class="p-6 border-b border-zinc-100 flex justify-between items-center bg-white">
                <h3 class="text-headline-md font-headline-md text-zinc-900 font-bold tracking-tight">Upcoming Events</h3>
                <button class="text-label-sm font-label-sm text-[#3525cd] font-semibold hover:underline">View Calendar</button>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-zinc-50 text-zinc-500 border-b border-zinc-200">
                            <th class="p-4 text-label-sm font-label-sm uppercase tracking-wider font-semibold">Event Name</th>
                            <th class="p-4 text-label-sm font-label-sm uppercase tracking-wider font-semibold">Date</th>
                            <th class="p-4 text-label-sm font-label-sm uppercase tracking-wider font-semibold">Location</th>
                            <th class="p-4 text-label-sm font-label-sm uppercase tracking-wider font-semibold text-right">RSVPs</th>
                            <th class="p-4 text-label-sm font-label-sm uppercase tracking-wider font-semibold text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-body-sm font-body-sm text-zinc-800">
                        <tr class="border-b border-zinc-100 hover:bg-zinc-50/50 transition-colors">
                            <td class="p-4 font-medium">Q3 Strategy Summit</td>
                            <td class="p-4 text-zinc-500">Oct 15, 2024</td>
                            <td class="p-4 text-zinc-500">Main Hall</td>
                            <td class="p-4 font-mono-sm text-right font-medium">142/150</td>
                            <td class="p-4 text-center">
                                <span class="inline-block px-3 py-1 bg-blue-100 text-[#006a8f] font-label-sm rounded-full text-xs font-semibold">Filling Fast</span>
                            </td>
                        </tr>
                        <tr class="border-b border-zinc-100 hover:bg-zinc-50/50 transition-colors">
                            <td class="p-4 font-medium">Networking Mixer</td>
                            <td class="p-4 text-zinc-500">Oct 22, 2024</td>
                            <td class="p-4 text-zinc-500">Rooftop Lounge</td>
                            <td class="p-4 font-mono-sm text-right font-medium">85/100</td>
                            <td class="p-4 text-center">
                                <span class="inline-block px-3 py-1 bg-zinc-100 text-zinc-600 font-label-sm rounded-full text-xs font-semibold">Open</span>
                            </td>
                        </tr>
                        <tr class="hover:bg-zinc-50/50 transition-colors">
                            <td class="p-4 font-medium">Annual Gala</td>
                            <td class="p-4 text-zinc-500">Nov 05, 2024</td>
                            <td class="p-4 text-zinc-500">Grand Ballroom</td>
                            <td class="p-4 font-mono-sm text-right font-medium">210/500</td>
                            <td class="p-4 text-center">
                                <span class="inline-block px-3 py-1 bg-zinc-100 text-zinc-600 font-label-sm rounded-full text-xs font-semibold">Open</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts::app>
