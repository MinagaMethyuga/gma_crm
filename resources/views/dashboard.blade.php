<x-layouts::app :title="__('Dashboard')">
    <!-- Canvas -->
    <div class="p-8 flex-1 flex flex-col gap-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4 mb-4">
            <div>
                <h2 class="text-headline-xl font-headline-xl text-on-surface mb-1">Dashboard Overview</h2>
                <p class="text-body-md font-body-md text-on-surface-variant">Here's what's happening today.</p>
            </div>
            <div class="flex gap-2">
                <button class="bg-surface border border-outline-variant hover:bg-surface-container text-on-surface px-4 py-2 rounded-lg font-label-md transition-colors shadow-sm flex items-center gap-2">
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
                <div class="bg-surface-container-lowest rounded-xl p-6 shadow-md flex flex-col justify-between h-40 border border-outline-variant/30">
                    <div class="flex justify-between items-start">
                        <span class="text-label-sm font-label-sm text-on-surface-variant uppercase tracking-wider">Total Revenue</span>
                        <span class="material-symbols-outlined text-secondary text-opacity-50">payments</span>
                    </div>
                    <div>
                        <div class="flex items-baseline gap-2">
                            <span class="text-headline-xl font-headline-xl text-on-surface">$42.5k</span>
                            <span class="text-label-sm font-label-sm text-tertiary-container bg-tertiary-container/10 px-2 py-0.5 rounded-full flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">trending_up</span>
                                +12%
                            </span>
                        </div>
                        <p class="text-body-sm font-body-sm text-on-surface-variant mt-1">vs last month</p>
                    </div>
                </div>
                <!-- Stat Card 2 -->
                <div class="bg-surface-container-lowest rounded-xl p-6 shadow-md flex flex-col justify-between h-40 border border-outline-variant/30">
                    <div class="flex justify-between items-start">
                        <span class="text-label-sm font-label-sm text-on-surface-variant uppercase tracking-wider">Active Members</span>
                        <span class="material-symbols-outlined text-secondary text-opacity-50">group</span>
                    </div>
                    <div>
                        <div class="flex items-baseline gap-2">
                            <span class="text-headline-xl font-headline-xl text-on-surface">1,240</span>
                            <span class="text-label-sm font-label-sm text-tertiary-container bg-tertiary-container/10 px-2 py-0.5 rounded-full flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">trending_up</span>
                                +5%
                            </span>
                        </div>
                        <p class="text-body-sm font-body-sm text-on-surface-variant mt-1">vs last month</p>
                    </div>
                </div>
                <!-- Stat Card 3 -->
                <div class="bg-surface-container-lowest rounded-xl p-6 shadow-md flex flex-col justify-between h-40 border border-outline-variant/30">
                    <div class="flex justify-between items-start">
                        <span class="text-label-sm font-label-sm text-on-surface-variant uppercase tracking-wider">New Signups</span>
                        <span class="material-symbols-outlined text-secondary text-opacity-50">person_add</span>
                    </div>
                    <div>
                        <div class="flex items-baseline gap-2">
                            <span class="text-headline-xl font-headline-xl text-on-surface">42</span>
                        </div>
                        <p class="text-body-sm font-body-sm text-on-surface-variant mt-1">this week</p>
                    </div>
                </div>
                <!-- Stat Card 4 -->
                <div class="bg-surface-container-lowest rounded-xl p-6 shadow-md flex flex-col justify-between h-40 border border-outline-variant/30">
                    <div class="flex justify-between items-start">
                        <span class="text-label-sm font-label-sm text-on-surface-variant uppercase tracking-wider">Event RSVP Rate</span>
                        <span class="material-symbols-outlined text-secondary text-opacity-50">how_to_reg</span>
                    </div>
                    <div>
                        <div class="flex items-baseline gap-2">
                            <span class="text-headline-xl font-headline-xl text-on-surface">88%</span>
                        </div>
                        <!-- Mini Sparkline placeholder (CSS) -->
                        <div class="w-full h-1 bg-surface-container mt-3 rounded-full overflow-hidden">
                            <div class="h-full bg-primary w-[88%] rounded-full"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions & Upcoming Events (Cols 9-12) -->
            <div class="col-span-1 md:col-span-12 lg:col-span-4 flex flex-col gap-6">
                <!-- Quick Actions -->
                <div class="bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/30">
                    <h3 class="text-label-sm font-label-sm text-on-surface-variant uppercase tracking-wider mb-4">Quick Actions</h3>
                    <div class="flex flex-col gap-2">
                        <button class="w-full flex items-center justify-between p-3 rounded-lg hover:bg-surface-container-low transition-colors border border-transparent hover:border-outline-variant/50 group">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded bg-primary/10 text-primary flex items-center justify-center group-hover:bg-primary group-hover:text-on-primary transition-colors">
                                    <span class="material-symbols-outlined text-[18px]">person_add</span>
                                </div>
                                <span class="text-label-md font-label-md text-on-surface">Add Member</span>
                            </div>
                            <span class="material-symbols-outlined text-on-surface-variant opacity-0 group-hover:opacity-100 transition-opacity">chevron_right</span>
                        </button>
                        <button class="w-full flex items-center justify-between p-3 rounded-lg hover:bg-surface-container-low transition-colors border border-transparent hover:border-outline-variant/50 group">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded bg-tertiary/10 text-tertiary flex items-center justify-center group-hover:bg-tertiary group-hover:text-on-tertiary transition-colors">
                                    <span class="material-symbols-outlined text-[18px]">event</span>
                                </div>
                                <span class="text-label-md font-label-md text-on-surface">Create Event</span>
                            </div>
                            <span class="material-symbols-outlined text-on-surface-variant opacity-0 group-hover:opacity-100 transition-opacity">chevron_right</span>
                        </button>
                        <button class="w-full flex items-center justify-between p-3 rounded-lg hover:bg-surface-container-low transition-colors border border-transparent hover:border-outline-variant/50 group">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded bg-secondary/10 text-secondary flex items-center justify-center group-hover:bg-secondary group-hover:text-on-secondary transition-colors">
                                    <span class="material-symbols-outlined text-[18px]">summarize</span>
                                </div>
                                <span class="text-label-md font-label-md text-on-surface">Generate Report</span>
                            </div>
                            <span class="material-symbols-outlined text-on-surface-variant opacity-0 group-hover:opacity-100 transition-opacity">chevron_right</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lower Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-4">
            <!-- Revenue Chart Area -->
            <div class="col-span-1 lg:col-span-2 bg-surface-container-lowest rounded-xl p-6 shadow-md border border-outline-variant/30 flex flex-col min-h-[300px]">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-headline-md font-headline-md text-on-surface">Revenue Growth</h3>
                    <select class="bg-surface-container border-none text-label-sm font-label-sm rounded-md py-1 px-2 focus:ring-1 focus:ring-primary">
                        <option>Last 6 Months</option>
                        <option>YTD</option>
                    </select>
                </div>
                <div class="flex-1 w-full bg-surface flex items-end p-4 rounded-lg relative overflow-hidden group">
                    <!-- Abstract placeholder for chart -->
                    <div class="absolute inset-0 bg-gradient-to-t from-primary/10 to-transparent opacity-50"></div>
                    <div class="w-full flex justify-between items-end h-full gap-2 relative z-10">
                        <div class="w-full bg-primary/20 hover:bg-primary/40 transition-colors rounded-t-sm h-[30%]"></div>
                        <div class="w-full bg-primary/30 hover:bg-primary/50 transition-colors rounded-t-sm h-[45%]"></div>
                        <div class="w-full bg-primary/40 hover:bg-primary/60 transition-colors rounded-t-sm h-[40%]"></div>
                        <div class="w-full bg-primary/50 hover:bg-primary/70 transition-colors rounded-t-sm h-[60%]"></div>
                        <div class="w-full bg-primary/70 hover:bg-primary/90 transition-colors rounded-t-sm h-[85%]"></div>
                        <div class="w-full bg-primary hover:bg-primary transition-colors rounded-t-sm h-[100%] shadow-[0_0_15px_rgba(53,37,205,0.3)]"></div>
                    </div>
                </div>
            </div>
            
            <!-- Activity Feed -->
            <div class="col-span-1 bg-surface-container-lowest rounded-xl p-6 shadow-md border border-outline-variant/30 flex flex-col">
                <h3 class="text-headline-md font-headline-md text-on-surface mb-6">Recent Activity</h3>
                <div class="flex-1 overflow-hidden relative">
                    <!-- Vertical Line -->
                    <div class="absolute left-[15px] top-2 bottom-0 w-px bg-outline-variant/50"></div>
                    <ul class="flex flex-col gap-6 relative z-10">
                        <li class="flex gap-4">
                            <div class="w-8 h-8 rounded-full bg-tertiary-container/20 text-tertiary-container flex items-center justify-center shrink-0 border border-surface-container-lowest z-10">
                                <span class="material-symbols-outlined text-[16px]">person</span>
                            </div>
                            <div>
                                <p class="text-body-sm font-body-sm text-on-surface"><span class="font-medium">New member joined:</span> Sarah Chen</p>
                                <span class="text-label-sm font-label-sm text-on-surface-variant">2 hours ago</span>
                            </div>
                        </li>
                        <li class="flex gap-4">
                            <div class="w-8 h-8 rounded-full bg-primary/20 text-primary flex items-center justify-center shrink-0 border border-surface-container-lowest z-10">
                                <span class="material-symbols-outlined text-[16px]">attach_money</span>
                            </div>
                            <div>
                                <p class="text-body-sm font-body-sm text-on-surface"><span class="font-medium">Payment received</span> from Tech Corp</p>
                                <span class="text-label-sm font-label-sm text-on-surface-variant">5 hours ago</span>
                            </div>
                        </li>
                        <li class="flex gap-4">
                            <div class="w-8 h-8 rounded-full bg-secondary/20 text-secondary flex items-center justify-center shrink-0 border border-surface-container-lowest z-10">
                                <span class="material-symbols-outlined text-[16px]">celebration</span>
                            </div>
                            <div>
                                <p class="text-body-sm font-body-sm text-on-surface"><span class="font-medium">Event created:</span> 'Annual Gala'</p>
                                <span class="text-label-sm font-label-sm text-on-surface-variant">1 day ago</span>
                            </div>
                        </li>
                    </ul>
                </div>
                <button class="mt-4 text-label-sm font-label-sm text-primary hover:underline text-center w-full">View All Activity</button>
            </div>
        </div>

        <!-- Data Table Section -->
        <div class="mt-4 bg-surface-container-lowest rounded-xl shadow-md border border-outline-variant/30 overflow-hidden">
            <div class="p-6 border-b border-outline-variant/30 flex justify-between items-center bg-surface-bright">
                <h3 class="text-headline-md font-headline-md text-on-surface">Upcoming Events</h3>
                <button class="text-label-sm font-label-sm text-primary hover:underline">View Calendar</button>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-surface-container-low text-on-surface-variant border-b border-outline-variant/50">
                            <th class="p-4 text-label-sm font-label-sm uppercase tracking-wider font-semibold">Event Name</th>
                            <th class="p-4 text-label-sm font-label-sm uppercase tracking-wider font-semibold">Date</th>
                            <th class="p-4 text-label-sm font-label-sm uppercase tracking-wider font-semibold">Location</th>
                            <th class="p-4 text-label-sm font-label-sm uppercase tracking-wider font-semibold text-right">RSVPs</th>
                            <th class="p-4 text-label-sm font-label-sm uppercase tracking-wider font-semibold text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-body-sm font-body-sm text-on-surface">
                        <tr class="border-b border-outline-variant/30 hover:bg-primary/5 transition-colors">
                            <td class="p-4 font-medium">Q3 Strategy Summit</td>
                            <td class="p-4 text-on-surface-variant">Oct 15, 2024</td>
                            <td class="p-4 text-on-surface-variant">Main Hall</td>
                            <td class="p-4 font-mono-sm text-right">142/150</td>
                            <td class="p-4 text-center">
                                <span class="inline-block px-2 py-1 bg-tertiary-container/20 text-tertiary font-label-sm rounded-full text-xs">Filling Fast</span>
                            </td>
                        </tr>
                        <tr class="border-b border-outline-variant/30 hover:bg-primary/5 transition-colors">
                            <td class="p-4 font-medium">Networking Mixer</td>
                            <td class="p-4 text-on-surface-variant">Oct 22, 2024</td>
                            <td class="p-4 text-on-surface-variant">Rooftop Lounge</td>
                            <td class="p-4 font-mono-sm text-right">85/100</td>
                            <td class="p-4 text-center">
                                <span class="inline-block px-2 py-1 bg-surface-container-high text-on-surface-variant font-label-sm rounded-full text-xs">Open</span>
                            </td>
                        </tr>
                        <tr class="hover:bg-primary/5 transition-colors">
                            <td class="p-4 font-medium">Annual Gala</td>
                            <td class="p-4 text-on-surface-variant">Nov 05, 2024</td>
                            <td class="p-4 text-on-surface-variant">Grand Ballroom</td>
                            <td class="p-4 font-mono-sm text-right">210/500</td>
                            <td class="p-4 text-center">
                                <span class="inline-block px-2 py-1 bg-surface-container-high text-on-surface-variant font-label-sm rounded-full text-xs">Open</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts::app>
