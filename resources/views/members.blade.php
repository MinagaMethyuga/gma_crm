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
        @include('components.admin-sidebar', ['active' => 'members'])

        <!-- Main Content Area -->
        <main class="flex-1 flex flex-col min-w-0 bg-[#fbfcfd]">
            
            @include('components.admin-header')

            <!-- Content Body -->
            <div class="flex-1 flex flex-col overflow-hidden p-8 px-10">
                
                <!-- Page Header & Actions -->
                <div class="flex justify-between items-end mb-8">
                    <div>
                        <h2 class="text-3xl font-bold text-slate-900 mb-2 tracking-tight">Members</h2>
                        <p class="text-slate-500 text-[14px]">Manage organization directory and member status.</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('members.export') }}" class="flex items-center gap-2 bg-slate-50 hover:bg-slate-100 border border-slate-200 shadow-sm rounded-lg px-4 py-2 text-[13px] font-bold text-slate-700 transition-colors">
                            <span class="material-symbols-outlined text-[18px]">download</span>
                            CSV Export
                        </a>

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
                                <select onchange="window.location='{{ route('members') }}?status='+this.value+'&tier={{ request('tier') }}&sort={{ request('sort') }}'" class="appearance-none bg-slate-50 border border-slate-200 text-slate-700 text-[13px] font-semibold rounded-lg pl-3 pr-8 py-1.5 focus:outline-none focus:ring-1 focus:ring-[#4338ca] focus:border-[#4338ca] cursor-pointer hover:bg-slate-100">
                                    <option value="" {{ !request('status') ? 'selected' : '' }}>Status: All</option>
                                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-500">
                                    <span class="material-symbols-outlined text-[18px]">expand_more</span>
                                </div>
                            </div>
                            
                            <div class="relative">
                                <select onchange="window.location='{{ route('members') }}?status={{ request('status') }}&tier='+this.value+'&sort={{ request('sort') }}'" class="appearance-none bg-slate-50 border border-slate-200 text-slate-700 text-[13px] font-semibold rounded-lg pl-3 pr-8 py-1.5 focus:outline-none focus:ring-1 focus:ring-[#4338ca] focus:border-[#4338ca] cursor-pointer hover:bg-slate-100">
                                    <option value="" {{ !request('tier') ? 'selected' : '' }}>Tier: All</option>
                                    <option value="professional" {{ request('tier') === 'professional' ? 'selected' : '' }}>Professional</option>
                                    <option value="business" {{ request('tier') === 'business' ? 'selected' : '' }}>Business</option>
                                    <option value="strategic" {{ request('tier') === 'strategic' ? 'selected' : '' }}>Strategic</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-500">
                                    <span class="material-symbols-outlined text-[18px]">expand_more</span>
                                </div>
                            </div>

                            <div class="relative">
                                <select onchange="window.location='{{ route('members') }}?status={{ request('status') }}&tier={{ request('tier') }}&sort='+this.value" class="appearance-none bg-slate-50 border border-slate-200 text-slate-700 text-[13px] font-semibold rounded-lg pl-3 pr-8 py-1.5 focus:outline-none focus:ring-1 focus:ring-[#4338ca] focus:border-[#4338ca] cursor-pointer hover:bg-slate-100">
                                    <option value="newest" {{ request('sort') !== 'oldest' ? 'selected' : '' }}>Last Activity: Newest</option>
                                    <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Last Activity: Oldest</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-500">
                                    <span class="material-symbols-outlined text-[18px]">expand_more</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
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
                                @forelse($users as $user)
                                <tr class="hover:bg-slate-50/50 transition-colors group border-b border-slate-100 last:border-b-0">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-4">
                                            <div class="w-10 h-10 rounded-full bg-slate-200 overflow-hidden shrink-0 border border-slate-200 shadow-sm">
                                                <img src="{{ $user->avatarUrl() }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                                            </div>
                                            <div>
                                                <div class="text-[14px] font-bold text-slate-900 leading-tight">{{ $user->name }}</div>
                                                <div class="text-[13px] text-slate-500 mt-0.5">{{ $user->email }}</div>
                                                <div class="text-[12px] text-slate-400">{{ $user->phone }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($user->plan_id)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200/60 uppercase tracking-wide">
                                            <div class="w-1.5 h-1.5 rounded-full bg-emerald-500"></div>
                                            Active
                                        </span>
                                        @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[11px] font-bold bg-amber-50 text-amber-700 border border-amber-200/60 uppercase tracking-wide">
                                            <div class="w-1.5 h-1.5 rounded-full bg-amber-500"></div>
                                            Pending
                                        </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <span class="text-[13px] font-medium text-slate-700">{{ $user->plan?->name ?? 'No Plan' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-[13px] text-slate-600 font-medium">
                                        {{ $user->plan_subscribed_at ? $user->plan_subscribed_at->format('M d, Y') : ($user->created_at ? $user->created_at->format('M d, Y') : 'N/A') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-[13px] text-slate-500">
                                        {{ $user->updated_at ? $user->updated_at->diffForHumans() : 'Recently' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <!-- Actions placeholder -->
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-slate-500 font-medium">
                                        No members found in directory.
                                    </td>
                                </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination / Footer -->
                    <div class="border-t border-slate-200 bg-slate-50/50 px-6 py-4 shrink-0">
                        {{ $users->links('vendor.pagination.custom') }}
                    </div>
                </div>

            </div>
        </main>
    </div>

@include('components.settings-modal')

</body>
</html>
