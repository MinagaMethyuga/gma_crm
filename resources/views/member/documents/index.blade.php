<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GMA - My Documents</title>
    <link rel="icon" href="/Global_Mobile_Association_Logo__1_-removebg-preview.png" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0,1&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f3f7fa; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        .material-symbols-outlined.fill { font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        .custom-scroll::-webkit-scrollbar { width: 6px; }
        .custom-scroll::-webkit-scrollbar-track { background: transparent; }
        .custom-scroll::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 10px; }

        /* Document card */
        .doc-card {
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        .doc-card::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.15) 0%, transparent 60%);
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.2s ease;
        }
        .doc-card:hover { transform: translateY(-3px); box-shadow: 0 20px 40px -12px rgba(0,0,0,0.12); }
        .doc-card:hover::after { opacity: 1; }

        /* Search input */
        .search-input { transition: all 0.2s ease; }
        .search-input:focus { box-shadow: 0 0 0 3px rgba(67, 56, 202, 0.12); }

        /* Filter pill */
        .filter-pill {
            transition: all 0.2s ease;
            cursor: pointer;
        }
        .filter-pill.active { background: #1a1a1a; color: #fff; }
        .filter-pill:not(.active):hover { background: #f1f5f9; }

        /* Fade-in stagger */
        .stagger-item {
            opacity: 0;
            transform: translateY(16px);
            animation: slideUp 0.5s cubic-bezier(0.23, 1, 0.32, 1) forwards;
        }
        @keyframes slideUp {
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="overflow-hidden text-slate-800">

<div class="flex h-screen w-full">
    @include('components.member-sidebar', ['active' => 'documents'])

    <main class="flex-1 flex flex-col min-w-0 bg-[#f3f7fa]">
        @include('components.admin-header')

        <div class="flex-1 overflow-y-auto custom-scroll p-6 sm:p-8">
            <div class="max-w-6xl mx-auto flex flex-col gap-6">

                <!-- Page Header -->
                <div class="stagger-item" style="animation-delay: 0ms;">
                    <div class="rounded-3xl p-8 text-white relative overflow-hidden" style="background: linear-gradient(135deg, #0f172a, #1e293b, #0f172a);">
                        <!-- Background decoration -->
                        <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                        <div class="absolute bottom-0 left-20 w-40 h-40 bg-white/5 rounded-full translate-y-1/2"></div>
                        <div class="relative z-10">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-10 h-10 rounded-xl bg-white/15 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-[22px]">folder_special</span>
                                </div>
                                <span class="text-white/60 text-sm font-medium uppercase tracking-wider">Member Documents</span>
                            </div>
                            <h2 class="text-3xl font-extrabold tracking-tight mb-2">My Documents</h2>
                            <p class="text-white/60 text-sm max-w-md">
                                Documents available to your
                                <span class="font-semibold text-white">{{ auth()->user()->plan?->name ?? 'current' }}</span>
                                membership plan.
                            </p>
                            <div class="flex items-center gap-4 mt-5">
                                <div class="bg-white/10 rounded-xl px-4 py-2 flex items-center gap-2">
                                    <span class="material-symbols-outlined text-[16px] text-white/70">description</span>
                                    <span class="text-sm font-semibold">{{ $documents->count() }} {{ Str::plural('Document', $documents->count()) }}</span>
                                </div>
                                @if(auth()->user()->plan)
                                    <div class="bg-white/10 rounded-xl px-4 py-2 flex items-center gap-2">
                                        <span class="material-symbols-outlined text-[16px] text-white/70">verified</span>
                                        <span class="text-sm font-semibold">{{ auth()->user()->plan->name }} Access</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                @if($documents->isEmpty())
                    <!-- Empty state -->
                    <div class="stagger-item" style="animation-delay: 100ms;">
                        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm py-20 flex flex-col items-center text-center px-6">
                            <div class="w-20 h-20 rounded-3xl bg-slate-100 flex items-center justify-center mb-5">
                                <span class="material-symbols-outlined text-slate-400 text-[36px]">folder_open</span>
                            </div>
                            <h3 class="text-xl font-bold text-slate-800 mb-2">No documents available</h3>
                            <p class="text-slate-500 text-sm max-w-sm">
                                There are no documents available for your current membership plan yet. Check back later.
                            </p>
                        </div>
                    </div>
                @else
                    <!-- Search & Filter -->
                    <div class="stagger-item flex flex-col sm:flex-row gap-3" style="animation-delay: 80ms;">
                        <div class="relative flex-1">
                            <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-[18px]">search</span>
                            <input type="text" id="search-input" placeholder="Search documents..."
                                class="search-input w-full h-11 pl-10 pr-4 rounded-xl border border-slate-200 bg-white text-sm text-slate-800 focus:outline-none focus:border-indigo-400 transition">
                        </div>
                        <div class="flex gap-2">
                            <button class="filter-pill active h-11 px-4 rounded-xl border border-slate-200 bg-white text-sm font-medium text-slate-700" data-filter="all">All Documents</button>
                        </div>
                    </div>

                    <!-- Documents Grid -->
                    <div id="documents-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($documents as $doc)
                            <div class="doc-card stagger-item bg-white rounded-2xl border border-slate-100 shadow-sm p-5 flex flex-col"
                                style="animation-delay: {{ 120 + $loop->index * 60 }}ms;"
                                data-type="{{ $doc->isPdf() ? 'pdf' : 'word' }}"
                                data-title="{{ strtolower($doc->title) }}">

                                <!-- Card Top -->
                                <div class="flex items-start gap-4 mb-4">
                                    <!-- Icon -->
                                    <div class="w-14 h-14 rounded-2xl {{ $doc->isPdf() ? 'bg-gradient-to-br from-red-50 to-red-100/80' : 'bg-gradient-to-br from-blue-50 to-blue-100/80' }} flex items-center justify-center shrink-0 shadow-sm">
                                        <span class="material-symbols-outlined {{ $doc->getIconColor() }} text-[28px] fill">{{ $doc->getIconClass() }}</span>
                                    </div>
                                    <!-- Type Badge -->
                                    <div class="flex-1 flex justify-end">
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider {{ $doc->isPdf() ? 'bg-red-50 text-red-600' : 'bg-blue-50 text-blue-600' }}">
                                            {{ $doc->isPdf() ? 'PDF' : 'DOCX' }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Title -->
                                <h3 class="font-bold text-slate-900 text-base leading-snug mb-1.5 line-clamp-2">{{ $doc->title }}</h3>
                                <p class="text-xs text-slate-400 mb-4 truncate">{{ $doc->original_filename }}</p>

                                <!-- Plan tags -->
                                <div class="flex flex-wrap gap-1 mb-4">
                                    @foreach($doc->plans as $plan)
                                        @php
                                            $tagColors = ['bg-indigo-50 text-indigo-700', 'bg-emerald-50 text-emerald-700', 'bg-amber-50 text-amber-700', 'bg-purple-50 text-purple-700'];
                                            $tc = $tagColors[$loop->index % count($tagColors)];
                                        @endphp
                                        <span class="px-2 py-0.5 rounded-full text-[11px] font-semibold {{ $tc }}">{{ $plan->name }}</span>
                                    @endforeach
                                </div>

                                <!-- Date + Action -->
                                <div class="mt-auto flex items-center justify-between">
                                    <span class="text-xs text-slate-400 flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[14px]">schedule</span>
                                        {{ $doc->created_at->format('M d, Y') }}
                                    </span>
                                    <a href="{{ route('member.documents.show', $doc) }}"
                                        class="inline-flex items-center gap-1.5 text-white text-xs font-bold px-4 py-2 rounded-xl transition-all duration-200 shadow-sm hover:shadow-md"
                                        style="background-color: #0f172a;">
                                        <span class="material-symbols-outlined text-[14px]">open_in_new</span>
                                        Open Document
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

            </div>
        </div>
    </main>
</div>

<script>
// ─── Search ──────────────────────────────────────────────────────────────────
const searchInput  = document.getElementById('search-input');
const filterPills  = document.querySelectorAll('.filter-pill');
let activeFilter   = 'all';

function applyFilters() {
    const query = searchInput?.value.toLowerCase() ?? '';
    document.querySelectorAll('#documents-grid > .doc-card').forEach(card => {
        const matchesType  = activeFilter === 'all' || card.dataset.type === activeFilter;
        const matchesQuery = card.dataset.title.includes(query);
        card.style.display = matchesType && matchesQuery ? '' : 'none';
    });
}

searchInput?.addEventListener('input', applyFilters);

filterPills.forEach(pill => {
    pill.addEventListener('click', () => {
        filterPills.forEach(p => p.classList.remove('active'));
        pill.classList.add('active');
        activeFilter = pill.dataset.filter;
        applyFilters();
    });
});
</script>
</body>
</html>
