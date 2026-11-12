<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>GMA - Community</title>
    <link rel="icon" href="/Global_Mobile_Association_Logo__1_-removebg-preview.png" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0,1&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/chat-crypto.js'])
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

        /* Smooth Landing Page Entrance */
        .page-enter-progress {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2.5px;
            background: linear-gradient(90deg, #4338ca 0%, #6366f1 50%, #818cf8 100%);
            box-shadow: 0 0 10px rgba(99, 102, 241, 0.4);
            z-index: 50;
            transform-origin: 0% 50%;
            animation: pageProgressGlide 0.65s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            pointer-events: none;
        }
        @keyframes pageProgressGlide {
            0% { transform: scaleX(0); opacity: 1; }
            65% { transform: scaleX(0.88); opacity: 1; }
            95% { transform: scaleX(1); opacity: 1; }
            100% { transform: scaleX(1); opacity: 0; }
        }

        .landing-page-enter {
            animation: pageLandingFadeUp 0.52s cubic-bezier(0.16, 1, 0.3, 1) both;
            will-change: opacity, transform;
        }
        @keyframes pageLandingFadeUp {
            0% { opacity: 0; transform: translateY(14px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        .stagger-item {
            opacity: 0;
            transform: translateY(16px);
            animation: landingItemSlide 0.52s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            will-change: opacity, transform;
        }
        @keyframes landingItemSlide {
            0% { opacity: 0; transform: translateY(16px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        .table-row-stagger {
            opacity: 0;
            transform: translateY(8px);
            animation: tableRowFade 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            will-change: opacity, transform;
        }
        @keyframes tableRowFade {
            0% { opacity: 0; transform: translateY(8px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        /* Page Exit Transition */
        .page-exit-active {
            opacity: 0 !important;
            transform: translateY(-8px) scale(0.995) !important;
            transition: opacity 0.18s cubic-bezier(0.4, 0, 1, 1), transform 0.18s cubic-bezier(0.4, 0, 1, 1) !important;
            pointer-events: none;
        }
    </style>
</head>
<body class="overflow-hidden text-slate-800">
    <div class="flex h-screen w-full">
        @include('components.admin-sidebar', ['active' => 'community'])
        @include('components.community-rail', ['joinedGroups' => $joinedGroups ?? collect()])
        @include('components.friend-rail', ['friends' => $friends ?? collect()])

        <main class="flex-1 flex flex-col min-w-0 bg-[#fbfcfd] relative">
            <div class="page-enter-progress"></div>
            @include('components.admin-header')

            <div class="flex-1 overflow-y-auto custom-scroll p-8 landing-page-enter">
                <div class="flex flex-col gap-6 max-w-7xl mx-auto">
                    <!-- Header -->
                    <div class="stagger-item flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4 mb-2" style="animation-delay: 40ms;">
                        <div>
                            <h2 class="text-3xl font-bold text-slate-900 tracking-tight mb-2">Community Groups</h2>
                            <p class="text-slate-500 text-[14px]">Create and manage community groups</p>
                        </div>
                        <button onclick="document.getElementById('createGroupModal').classList.remove('hidden')" class="bg-[#4338ca] hover:bg-[#3730a3] text-white text-xs md:text-sm font-semibold px-3 md:px-4 py-1.5 md:py-2 rounded-lg transition-colors shadow-sm flex items-center gap-2">
                            <span class="material-symbols-outlined text-[18px]">add</span>
                            Create Group
                        </button>
                    </div>

                    @if(session('success'))
                        <div id="flash-message" class="stagger-item bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-lg text-sm" style="animation-delay: 80ms;">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(count($pendingGroups))
                        <!-- Member-created communities awaiting review -->
                        <div class="stagger-item bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden" style="animation-delay: 90ms;">
                            <div class="p-6 border-b border-slate-100 flex items-center justify-between gap-4">
                                <div>
                                    <h3 class="text-[18px] font-bold text-slate-900 tracking-tight">Community Submissions</h3>
                                    <p class="text-xs text-slate-400 mt-0.5">Started by members. Publish to make them visible in member discovery.</p>
                                </div>
                                <span class="shrink-0 inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-amber-50 text-amber-700 border border-amber-200/60">
                                    <span class="material-symbols-outlined text-[14px]">hourglass_top</span>
                                    {{ count($pendingGroups) }}
                                </span>
                            </div>
                            <ul class="divide-y divide-slate-100">
                                @foreach($pendingGroups as $group)
                                    <li class="p-5 flex flex-col sm:flex-row sm:items-center gap-4 hover:bg-slate-50/50 transition-colors">
                                        <div class="flex items-center gap-3 flex-1 min-w-0">
                                            @if($group->logoUrl())
                                                <img src="{{ $group->logoUrl() }}" alt="{{ $group->name }}" class="w-12 h-12 rounded-xl object-cover shrink-0 bg-slate-50 border border-slate-100">
                                            @else
                                                <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0 border border-indigo-100">
                                                    <span class="material-symbols-outlined text-[20px]">groups</span>
                                                </div>
                                            @endif
                                            <div class="min-w-0">
                                                <div class="flex items-center gap-2 flex-wrap">
                                                    <span class="font-bold text-slate-900 text-sm">{{ $group->name }}</span>
                                                    <span class="inline-block px-2 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wide bg-indigo-50 text-indigo-700 border border-indigo-200/60">{{ $group->categoryLabel() }}</span>
                                                </div>
                                                <p class="text-xs text-slate-500 mt-1 line-clamp-2">{{ $group->description ?: 'No description provided.' }}</p>
                                                <p class="text-[11px] text-slate-400 mt-1">
                                                    Started by <span class="font-semibold text-slate-500">{{ $group->creator?->name ?? 'Unknown' }}</span>
                                                    &middot; {{ $group->created_at?->diffForHumans() }}
                                                    &middot; {{ $group->members_count ?? 0 }} {{ \Illuminate\Support\Str::plural('member', $group->members_count ?? 0) }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-2 shrink-0">
                                            <form action="{{ route('admin.community.groups.decline', $group) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center gap-1 text-slate-600 text-xs font-bold px-3 py-1.5 rounded-lg border border-slate-200 hover:bg-slate-50 transition-colors">
                                                    Decline
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.community.groups.approve', $group) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center gap-1 text-white text-xs font-bold px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 transition-colors">
                                                    <span class="material-symbols-outlined text-[14px]">check</span>
                                                    Publish
                                                </button>
                                            </form>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(count($pendingRequests))
                        <!-- Pending Join Requests -->
                        <div class="stagger-item bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden" style="animation-delay: 110ms;">
                            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                                <h3 class="text-[18px] font-bold text-slate-900 tracking-tight">Pending Join Requests</h3>
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-amber-50 text-amber-700 border border-amber-200/60">
                                    <span class="material-symbols-outlined text-[14px]">hourglass_top</span>
                                    {{ count($pendingRequests) }}
                                </span>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="w-full text-left border-collapse">
                                    <thead>
                                        <tr class="bg-slate-50/80 border-b border-slate-200">
                                            <th class="p-4 text-[11px] uppercase tracking-widest font-bold text-slate-500">Member</th>
                                            <th class="p-4 text-[11px] uppercase tracking-widest font-bold text-slate-500">Group</th>
                                            <th class="p-4 text-[11px] uppercase tracking-widest font-bold text-slate-500">Requested</th>
                                            <th class="p-4 text-[11px] uppercase tracking-widest font-bold text-slate-500 text-right">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-[13px] text-slate-800">
                                        @foreach($pendingRequests as $request)
                                            <tr class="border-b border-slate-100 last:border-b-0 hover:bg-slate-50/50 transition-colors">
                                                <td class="p-4 font-bold">
                                                    <div class="flex items-center gap-3">
                                                        <div class="w-8 h-8 rounded-full {{ $request->user?->avatar ? '' : 'bg-indigo-100 text-indigo-700' }} flex items-center justify-center text-xs font-bold overflow-hidden shrink-0">
                                                            @if($request->user?->avatar)
                                                                <img src="{{ $request->user->avatarUrl() }}" class="w-full h-full object-cover" alt="">
                                                            @else
                                                                {{ strtoupper(substr($request->user?->name ?? '?', 0, 1)) }}
                                                            @endif
                                                        </div>
                                                        <div>
                                                            <div>{{ $request->user?->name ?? 'Unknown' }}</div>
                                                            <div class="text-xs text-slate-400 font-medium">{{ $request->user?->email ?? '' }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="p-4 text-slate-500 font-medium">{{ $request->communityGroup?->name ?? '—' }}</td>
                                                <td class="p-4 text-slate-500 font-medium">{{ $request->created_at->format('M d, Y H:i') }}</td>
                                                <td class="p-4 text-right">
                                                    <div class="flex items-center justify-end gap-2">
                                                        <form action="{{ route('admin.community.requests.approve', $request) }}" method="POST">
                                                            @csrf
                                                            <button type="submit" class="inline-flex items-center gap-1 text-white text-xs font-bold px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 transition-colors">
                                                                Approve
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('admin.community.requests.decline', $request) }}" method="POST">
                                                            @csrf
                                                            <button type="submit" class="inline-flex items-center gap-1 text-slate-600 text-xs font-bold px-3 py-1.5 rounded-lg border border-slate-200 hover:bg-slate-50 transition-colors">
                                                                Decline
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif

                    <!-- Groups List -->
                    <div class="stagger-item bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden" style="animation-delay: 150ms;">
                        <div class="p-6 border-b border-slate-100">
                            <h3 class="text-[18px] font-bold text-slate-900 tracking-tight">Existing Communities</h3>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-slate-50/80 border-b border-slate-200">
                                        <th class="p-4 text-[11px] uppercase tracking-widest font-bold text-slate-500">Group Name</th>
                                        <th class="p-4 text-[11px] uppercase tracking-widest font-bold text-slate-500">Category</th>
                                        <th class="p-4 text-[11px] uppercase tracking-widest font-bold text-slate-500">Description</th>
                                        <th class="p-4 text-[11px] uppercase tracking-widest font-bold text-slate-500">Status</th>
                                        <th class="p-4 text-[11px] uppercase tracking-widest font-bold text-slate-500">Members</th>
                                        <th class="p-4 text-[11px] uppercase tracking-widest font-bold text-slate-500">Join Method</th>
                                        <th class="p-4 text-[11px] uppercase tracking-widest font-bold text-slate-500">Requests</th>
                                        <th class="p-4 text-[11px] uppercase tracking-widest font-bold text-slate-500">Created By</th>
                                        <th class="p-4 text-[11px] uppercase tracking-widest font-bold text-slate-500 text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="text-[13px] text-slate-800">
                                    @forelse($groups ?? [] as $group)
                                        <tr class="table-row-stagger border-b border-slate-100 last:border-b-0 hover:bg-slate-50/50 transition-colors" style="animation-delay: {{ 180 + $loop->index * 35 }}ms;" data-group-id="{{ $group->id }}">
                                            <td class="p-4">
                                                <div class="flex items-center gap-3">
                                                    @if($group->logoUrl())
                                                        <img src="{{ $group->logoUrl() }}" alt="{{ $group->name }}" class="w-10 h-10 rounded-xl object-cover shrink-0 bg-slate-50 border border-slate-100">
                                                    @else
                                                        <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0 border border-indigo-100">
                                                            <span class="material-symbols-outlined text-[18px]">groups</span>
                                                        </div>
                                                    @endif
                                                    <span class="font-bold">{{ $group->name }}</span>
                                                </div>
                                            </td>
                                            <td class="p-4">
                                                <span class="inline-block px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wide border {{ $group->category ? 'bg-indigo-50 text-indigo-700 border-indigo-200/60' : 'bg-slate-50 text-slate-400 border-slate-200' }}">{{ $group->categoryLabel() }}</span>
                                            </td>
                                            <td class="p-4 text-slate-500 font-medium max-w-xs truncate">{{ $group->description ?? '—' }}</td>
                                            <td class="p-4">
                                                @if($group->status === \App\Models\CommunityGroup::STATUS_PENDING)
                                                    <span class="inline-block px-3 py-1 font-bold rounded-md text-[10px] uppercase tracking-wide border bg-amber-50 text-amber-700 border-amber-200/60">Pending</span>
                                                @elseif($group->status === \App\Models\CommunityGroup::STATUS_REJECTED)
                                                    <span class="inline-block px-3 py-1 font-bold rounded-md text-[10px] uppercase tracking-wide border bg-red-50 text-red-700 border-red-200/60">Declined</span>
                                                @else
                                                    <span class="inline-block px-3 py-1 font-bold rounded-md text-[10px] uppercase tracking-wide border bg-emerald-50 text-emerald-700 border-emerald-200/60">Published</span>
                                                @endif
                                            </td>
                                            <td class="p-4 text-slate-500 font-medium">{{ $group->members_count ?? 0 }}</td>
                                            <td class="p-4">
                                                @if($group->join_method === \App\Models\CommunityGroup::JOIN_REQUEST)
                                                    <span class="inline-block px-3 py-1 font-bold rounded-md text-[10px] uppercase tracking-wide border bg-amber-50 text-amber-700 border-amber-200/60">Request to Join</span>
                                                @elseif($group->join_method === \App\Models\CommunityGroup::JOIN_PRIVATE)
                                                    <span class="inline-block px-3 py-1 font-bold rounded-md text-[10px] uppercase tracking-wide border bg-blue-50 text-blue-700 border-blue-200/60">Private</span>
                                                @else
                                                    <span class="inline-block px-3 py-1 font-bold rounded-md text-[10px] uppercase tracking-wide border bg-emerald-50 text-emerald-700 border-emerald-200/60">Public</span>
                                                @endif
                                            </td>
                                            <td class="p-4 text-slate-500 font-medium">
                                                @if(($group->pending_join_requests_count ?? 0) > 0)
                                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[11px] font-bold bg-amber-50 text-amber-700 border border-amber-200/60">
                                                        {{ $group->pending_join_requests_count }}
                                                    </span>
                                                @else
                                                    —
                                                @endif
                                            </td>
                                            <td class="p-4 text-slate-500 font-medium">{{ $group->creator?->name ?? '—' }}</td>
                                            <td class="p-4 text-right">
                                                <div class="flex items-center justify-end gap-2">
                                                    <button onclick="editGroup(this)" data-group="{{ json_encode(['id' => $group->id, 'name' => $group->name, 'category' => $group->categorySlug(), 'description' => $group->description, 'join_method' => $group->join_method, 'logo' => $group->logoUrl()]) }}" class="text-slate-500 hover:text-slate-700 p-1.5 rounded-lg hover:bg-slate-100 transition-colors">
                                                        <span class="material-symbols-outlined text-[18px]">edit</span>
                                                    </button>
                                                    <form action="{{ route('admin.community.destroy', $group) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this group?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-slate-500 hover:text-red-600 p-1.5 rounded-lg hover:bg-red-50 transition-colors">
                                                            <span class="material-symbols-outlined text-[18px]">delete</span>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="p-8 text-center text-slate-400 text-sm">No community groups created yet.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Create Group Modal -->
            <div id="createGroupModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
                <div class="bg-white rounded-xl shadow-lg w-full max-w-lg max-h-[90vh] overflow-y-auto">
                    <form action="{{ route('admin.community.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                            <h3 class="text-lg font-bold text-slate-900">Create Community Group</h3>
                            <button type="button" onclick="document.getElementById('createGroupModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">
                                <span class="material-symbols-outlined">close</span>
                            </button>
                        </div>
                        <div class="p-6 space-y-5">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Group Logo</label>
                                <label for="createLogoPicker" class="flex items-center gap-4 cursor-pointer border-2 border-dashed border-slate-200 rounded-xl p-4 hover:border-indigo-300 hover:bg-indigo-50/40 transition-colors">
                                    <div class="w-16 h-16 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0 border border-slate-100 overflow-hidden relative">
                                        <img id="createLogoPreview" class="w-full h-full object-cover" style="display: none;" alt="Group logo preview">
                                        <span id="createLogoPlaceholder" class="material-symbols-outlined text-[28px] suppress-transition">groups</span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="text-sm font-semibold text-slate-700 flex items-center gap-1.5">
                                            <span class="material-symbols-outlined text-[16px] text-indigo-600">upload</span>
                                            Upload Logo
                                        </div>
                                        <div id="createLogoFileName" class="text-xs text-slate-400 mt-0.5 truncate">Pick an image to crop &amp; zoom</div>
                                        <div class="text-[11px] text-slate-400 mt-1">JPEG, PNG, GIF, SVG or WebP (max 2MB)</div>
                                    </div>
                                </label>
                                <input type="file" id="createLogoPicker" accept="image/*" class="hidden">
                                <input type="file" name="logo" id="createLogoFile" accept="image/*" class="hidden">
                            </div>
                            <div>
                                <label for="create_name" class="block text-sm font-semibold text-slate-700 mb-1.5">Group Name</label>
                                <input type="text" name="name" id="create_name" required class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#4338ca]/20 focus:border-[#4338ca] text-sm" placeholder="e.g. Startup Founders">
                            </div>
                            <div>
                                <label for="create_category" class="block text-sm font-semibold text-slate-700 mb-1.5">Category</label>
                                <select name="category" id="create_category" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#4338ca]/20 focus:border-[#4338ca] text-sm bg-white">
                                    <option value="">Uncategorised</option>
                                    @foreach(\App\Models\CommunityGroup::CATEGORIES as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                                <p class="text-xs text-slate-400 mt-1.5">Members browse and filter the discover page by category.</p>
                            </div>
                            <div>
                                <label for="create_description" class="block text-sm font-semibold text-slate-700 mb-1.5">Description</label>
                                <textarea name="description" id="create_description" rows="3" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#4338ca]/20 focus:border-[#4338ca] text-sm" placeholder="What is this group about?"></textarea>
                            </div>
                            <div>
                                <label for="create_join_method" class="block text-sm font-semibold text-slate-700 mb-1.5">Join Method</label>
                                <select name="join_method" id="create_join_method" required class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#4338ca]/20 focus:border-[#4338ca] text-sm bg-white">
                                    @foreach(\App\Models\CommunityGroup::JOIN_METHODS as $value => $label)
                                        <option value="{{ $value }}" {{ $value === \App\Models\CommunityGroup::JOIN_OPEN ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                                <p class="text-xs text-slate-400 mt-1.5">Request to Join groups are visible to members; private groups are hidden.</p>
                            </div>
                        </div>
                        <div class="p-6 border-t border-slate-100 flex justify-end gap-3">
                            <button type="button" onclick="document.getElementById('createGroupModal').classList.add('hidden')" class="px-5 py-2.5 text-sm font-semibold text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 hover:border-slate-400 transition-colors shadow-sm">Cancel</button>
                            <button type="submit" class="px-5 py-2.5 bg-[#4338ca] hover:bg-[#3730a3] text-white text-sm font-bold rounded-lg transition-colors shadow-sm hover:shadow-md inline-flex items-center gap-2">
                                <span class="material-symbols-outlined text-[18px]">save</span>
                                Create Group
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Edit Group Modal -->
            <div id="editGroupModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
                <div class="bg-white rounded-xl shadow-lg w-full max-w-lg max-h-[90vh] overflow-y-auto">
                    <form id="editGroupForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                            <h3 class="text-lg font-bold text-slate-900">Edit Community Group</h3>
                            <button type="button" onclick="document.getElementById('editGroupModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">
                                <span class="material-symbols-outlined">close</span>
                            </button>
                        </div>
                        <div class="p-6 space-y-5">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Group Logo</label>
                                <label for="editLogoPicker" class="flex items-center gap-4 cursor-pointer border-2 border-dashed border-slate-200 rounded-xl p-4 hover:border-indigo-300 hover:bg-indigo-50/40 transition-colors">
                                    <div class="w-16 h-16 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0 border border-slate-100 overflow-hidden relative">
                                        <img id="editLogoPreview" class="w-full h-full object-cover" style="display: none;" alt="Group logo preview">
                                        <span id="editLogoPlaceholder" class="material-symbols-outlined text-[28px]">groups</span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="text-sm font-semibold text-slate-700 flex items-center gap-1.5">
                                            <span class="material-symbols-outlined text-[16px] text-indigo-600">upload</span>
                                            Upload Logo
                                        </div>
                                        <div id="editLogoFileName" class="text-xs text-slate-400 mt-0.5 truncate">Current logo shown. Click to crop a new one.</div>
                                        <div class="text-[11px] text-slate-400 mt-1">JPEG, PNG, GIF, SVG or WebP (max 2MB)</div>
                                    </div>
                                </label>
                                <input type="file" id="editLogoPicker" accept="image/*" class="hidden">
                                <input type="file" name="logo" id="editLogoFile" accept="image/*" class="hidden">
                            </div>
                            <div>
                                <label for="edit_name" class="block text-sm font-semibold text-slate-700 mb-1.5">Group Name</label>
                                <input type="text" name="name" id="edit_name" required class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#4338ca]/20 focus:border-[#4338ca] text-sm">
                            </div>
                            <div>
                                <label for="edit_category" class="block text-sm font-semibold text-slate-700 mb-1.5">Category</label>
                                <select name="category" id="edit_category" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#4338ca]/20 focus:border-[#4338ca] text-sm bg-white">
                                    <option value="">Uncategorised</option>
                                    @foreach(\App\Models\CommunityGroup::CATEGORIES as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                                <p class="text-xs text-slate-400 mt-1.5">Members browse and filter the discover page by category.</p>
                            </div>
                            <div>
                                <label for="edit_description" class="block text-sm font-semibold text-slate-700 mb-1.5">Description</label>
                                <textarea name="description" id="edit_description" rows="3" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#4338ca]/20 focus:border-[#4338ca] text-sm"></textarea>
                            </div>
                            <div>
                                <label for="edit_join_method" class="block text-sm font-semibold text-slate-700 mb-1.5">Join Method</label>
                                <select name="join_method" id="edit_join_method" required class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#4338ca]/20 focus:border-[#4338ca] text-sm bg-white">
                                    @foreach(\App\Models\CommunityGroup::JOIN_METHODS as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                                <p class="text-xs text-slate-400 mt-1.5">Request to Join groups are visible to members; private groups are hidden.</p>
                            </div>
                        </div>
                        <div class="p-6 border-t border-slate-100 flex justify-end gap-3">
                            <button type="button" onclick="document.getElementById('editGroupModal').classList.add('hidden')" class="px-5 py-2.5 text-sm font-semibold text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 hover:border-slate-400 transition-colors shadow-sm">Cancel</button>
                            <button type="submit" class="px-5 py-2.5 bg-[#4338ca] hover:bg-[#3730a3] text-white text-sm font-bold rounded-lg transition-colors shadow-sm hover:shadow-md inline-flex items-center gap-2">
                                <span class="material-symbols-outlined text-[18px]">save</span>
                                Update Group
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Crop Zoom Modal -->
            <div id="cropModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
                <div class="bg-white rounded-xl shadow-lg w-full max-w-3xl max-h-[90vh] overflow-y-auto custom-scroll">
                    <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-bold text-slate-900">Crop &amp; Zoom Logo</h3>
                            <p class="text-sm text-slate-400 mt-0.5">Zoom, drag and rotate to frame your logo.</p>
                        </div>
                        <button type="button" onclick="document.getElementById('cropModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">
                            <span class="material-symbols-outlined">close</span>
                        </button>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="md:col-span-2">
                            <div class="bg-slate-900 rounded-xl p-2">
                                <img id="cropImage" class="max-w-full h-auto block" alt="Logo to crop">
                            </div>
                        </div>
                        <div class="flex flex-col gap-4">
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm font-semibold text-slate-700">Preview</span>
                                    <span class="text-[11px] text-slate-400">How it will look</span>
                                </div>
                                <div class="w-full aspect-square rounded-2xl bg-slate-50 border-2 border-dashed border-slate-200 overflow-hidden flex items-center justify-center">
                                    <img id="cropPreview" class="w-full h-full object-cover hidden" alt="Cropped logo preview">
                                    <span id="cropPreviewPlaceholder" class="material-symbols-outlined text-slate-300 text-[40px]">image</span>
                                </div>
                            </div>
                            <div>
                                <label class="flex items-center justify-between text-sm font-semibold text-slate-700 mb-2">
                                    <span class="flex items-center gap-1.5">
                                        <span class="material-symbols-outlined text-[16px]">zoom_in</span>
                                        Zoom
                                    </span>
                                    <span id="cropZoomValue" class="text-xs text-slate-400 font-medium">100%</span>
                                </label>
                                <input type="range" id="cropZoomSlider" min="10" max="400" value="100" class="w-full accent-[#4338ca] cursor-pointer">
                            </div>
                            <div>
                                <span class="text-sm font-semibold text-slate-700 flex items-center gap-1.5 mb-2">
                                    <span class="material-symbols-outlined text-[16px]">crop_rotate</span>
                                    Rotate
                                </span>
                                <div class="flex gap-2">
                                    <button type="button" onclick="rotateCropImage(-90)" class="flex-1 inline-flex items-center justify-center gap-1 px-3 py-2 text-sm font-semibold text-slate-600 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 transition-colors">
                                        <span class="material-symbols-outlined text-[16px]">rotate_left</span>
                                        -90°
                                    </button>
                                    <button type="button" onclick="rotateCropImage(90)" class="flex-1 inline-flex items-center justify-center gap-1 px-3 py-2 text-sm font-semibold text-slate-600 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 transition-colors">
                                        <span class="material-symbols-outlined text-[16px]">rotate_right</span>
                                        +90°
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 border-t border-slate-100 flex justify-end gap-3">
                        <button type="button" onclick="cancelCrop()" class="px-5 py-2.5 text-sm font-semibold text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 hover:border-slate-400 transition-colors shadow-sm">Cancel</button>
                        <button type="button" onclick="applyCrop()" class="px-5 py-2.5 bg-[#4338ca] hover:bg-[#3730a3] text-white text-sm font-bold rounded-lg transition-colors shadow-sm hover:shadow-md inline-flex items-center gap-2">
                            <span class="material-symbols-outlined text-[18px]">check</span>
                            Apply Crop
                        </button>
                    </div>
                </div>
            </div>

            <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>
            <script>
                // ─── Auto-dismiss flash message after 3s ───────────────────────────────────
                const flashMsg = document.getElementById('flash-message');
                if (flashMsg) {
                    setTimeout(() => {
                        flashMsg.style.transition = 'opacity 0.4s ease';
                        flashMsg.style.opacity = '0';
                        setTimeout(() => flashMsg.remove(), 400);
                    }, 3000);
                }

                // ─── Logo Crop & Zoom ───────────────────────────────────────────────────
                let cropper = null;
                let cropTarget = null; // 'createLogoFile' | 'editLogoFile'
                let cropPreviewSlot = null; // { preview, placeholder, fileName }

                function cropPreviewSlotFor(prefix) {
                    return {
                        preview: document.getElementById(prefix + 'LogoPreview'),
                        placeholder: document.getElementById(prefix + 'LogoPlaceholder'),
                        fileName: document.getElementById(prefix + 'LogoFileName'),
                    };
                }

                function setThumbnailImage(slot, showImage) {
                    if (showImage) {
                        slot.preview.style.display = 'block';
                        slot.placeholder.style.display = 'none';
                    } else {
                        slot.preview.style.display = 'none';
                        slot.placeholder.style.display = 'block';
                    }
                }

                function openCropModal(prefix, file) {
                    if (!file || !/^image\//.test(file.type)) {
                        alert('Please select an image file.');
                        return;
                    }
                    if (file.size > 2 * 1024 * 1024) {
                        alert('Image must be 2MB or smaller.');
                        return;
                    }

                    cropTarget = prefix + 'LogoFile';
                    cropPreviewSlot = cropPreviewSlotFor(prefix);

                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const image = document.getElementById('cropImage');
                        image.onload = function () {
                            if (cropper) cropper.destroy();
                            cropper = new Cropper(image, {
                                aspectRatio: 1,
                                viewMode: 1,
                                dragMode: 'move',
                                autoCropArea: 0.9,
                                background: false,
                                responsive: true,
                                checkCrossOrigin: false,
                                ready: () => {
                                    syncZoomControls();
                                    updateLivePreview();
                                },
                                zoom: () => syncZoomControls(),
                                crop: updateLivePreview,
                            });
                            document.getElementById('cropZoomSlider').value = 100;
                        };
                        image.src = e.target.result;
                        document.getElementById('cropPreview').style.display = 'none';
                        document.getElementById('cropPreviewPlaceholder').style.display = 'block';
                        document.getElementById('cropModal').classList.remove('hidden');
                    };
                    reader.readAsDataURL(file);
                }

                let cropPreviewRaf = null;
                function updateLivePreview() {
                    if (!cropper) return;
                    if (cropPreviewRaf) return;
                    cropPreviewRaf = requestAnimationFrame(function () {
                        cropPreviewRaf = null;
                        const canvas = cropper.getCroppedCanvas({ width: 200, height: 200 });
                        if (!canvas) return;
                        const preview = document.getElementById('cropPreview');
                        const placeholder = document.getElementById('cropPreviewPlaceholder');
                        preview.src = canvas.toDataURL('image/png');
                        preview.style.display = 'block';
                        placeholder.style.display = 'none';
                    });
                }

                function getCurrentZoom() {
                    const image = document.getElementById('cropImage');
                    if (!cropper || !image.naturalWidth) return 1;
                    return cropper.getCanvasData().width / image.naturalWidth;
                }

                function syncZoomControls() {
                    const slider = document.getElementById('cropZoomSlider');
                    const label = document.getElementById('cropZoomValue');
                    const pct = Math.round(getCurrentZoom() * 100);
                    slider.value = Math.min(Math.max(pct, 10), 400);
                    label.textContent = pct + '%';
                }

                document.getElementById('cropZoomSlider').addEventListener('input', function () {
                    if (!cropper) return;
                    cropper.zoomTo(this.value / 100);
                    const label = document.getElementById('cropZoomValue');
                    label.textContent = this.value + '%';
                });

                function rotateCropImage(degrees) {
                    if (!cropper) return;
                    cropper.rotate(degrees);
                }

                function cancelCrop() {
                    if (cropper) { cropper.destroy(); cropper = null; }
                    document.getElementById('cropImage').removeAttribute('src');
                    document.getElementById('cropModal').classList.add('hidden');
                    cropTarget = null;
                    cropPreviewSlot = null;
                }

                function applyCrop() {
                    if (!cropper || !cropTarget) return;
                    const canvas = cropper.getCroppedCanvas({ width: 512, height: 512 });
                    canvas.toBlob(function (blob) {
                        if (!blob) return;
                        const fileName = 'group-logo-' + Date.now() + '.png';
                        const file = new File([blob], fileName, { type: 'image/png' });
                        const dt = new DataTransfer();
                        dt.items.add(file);
                        const input = document.getElementById(cropTarget);
                        input.files = dt.files;

                        // Update dropzone preview
                        cropPreviewSlot.preview.src = canvas.toDataURL('image/png');
                        setThumbnailImage(cropPreviewSlot, true);
                        cropPreviewSlot.fileName.textContent = fileName + ' · ' + (file.size / 1024).toFixed(0) + ' KB';

                        document.getElementById('cropModal').classList.add('hidden');
                        if (cropper) { cropper.destroy(); cropper = null; }
                        cropTarget = null;
                        cropPreviewSlot = null;
                    }, 'image/png');
                }

                // Wire up pickers
                document.getElementById('createLogoPicker')?.addEventListener('change', function () {
                    openCropModal('create', this.files[0]);
                    this.value = '';
                });
                document.getElementById('editLogoPicker')?.addEventListener('change', function () {
                    openCropModal('edit', this.files[0]);
                    this.value = '';
                });

                function editGroup(button) {
                    const group = JSON.parse(button.dataset.group || '{}');
                    const form = document.getElementById('editGroupForm');
                    form.action = '/admin/community/' + group.id;
                    document.getElementById('edit_name').value = group.name || '';
                    document.getElementById('edit_description').value = group.description || '';
                    document.getElementById('edit_category').value = group.category || '';
                    document.getElementById('edit_join_method').value = group.join_method || 'open';
                    const slot = cropPreviewSlotFor('edit');
                    document.getElementById('editLogoFile').value = '';
                    if (group.logo) {
                        slot.preview.src = group.logo;
                        setThumbnailImage(slot, true);
                        slot.fileName.textContent = 'Current logo shown. Click to crop a new one.';
                    } else {
                        setThumbnailImage(slot, false);
                        slot.fileName.textContent = 'No logo set. Click to upload & crop.';
                    }
                    document.getElementById('editGroupModal').classList.remove('hidden');
                }

                // ─── Smooth Page Exit Transition on Link Navigation ────────────────────────
                (function() {
                    document.addEventListener('click', function(e) {
                        const link = e.target.closest('a');
                        if (!link) return;
                        const href = link.getAttribute('href');
                        if (!href || href.startsWith('#') || href.startsWith('javascript:') || link.target === '_blank' || link.hasAttribute('download')) return;
                        if (e.metaKey || e.ctrlKey || e.shiftKey || e.altKey || e.button !== 0) return;
                        
                        try {
                            const targetUrl = new URL(href, window.location.href);
                            if (targetUrl.origin === window.location.origin && (targetUrl.pathname !== window.location.pathname || targetUrl.search !== window.location.search)) {
                                const mainContent = document.querySelector('.landing-page-enter');
                                if (mainContent) {
                                    e.preventDefault();
                                    mainContent.classList.add('page-exit-active');
                                    setTimeout(() => {
                                        window.location.href = href;
                                    }, 170);
                                }
                            }
                        } catch (err) {}
                    });

                    window.addEventListener('pageshow', function(event) {
                        const mainContent = document.querySelector('.landing-page-enter');
                        if (mainContent) {
                            mainContent.classList.remove('page-exit-active');
                        }
                    });
                })();
            </script>
            @include('components.community-chat')
            @include('components.private-chat', ['friends' => $friends ?? collect()])
        </main>
    </div>

    @include('components.settings-modal')
</body>
</html>