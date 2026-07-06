<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>GMA - Documents Admin</title>
    <link rel="icon" href="/Global_Mobile_Association_Logo__1_-removebg-preview.png" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0,1&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fc; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        .material-symbols-outlined.fill { font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        .custom-scroll::-webkit-scrollbar { width: 6px; }
        .custom-scroll::-webkit-scrollbar-track { background: transparent; }
        .custom-scroll::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 10px; }

        /* Upload Modal */
        #panel-container { display: none; }
        #upload-modal-backdrop {
            animation: fadeIn 0.2s ease forwards;
        }
        #upload-modal {
            animation: modalIn 0.25s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        }
        @keyframes fadeIn {
            from { opacity: 0; } to { opacity: 1; }
        }
        @keyframes modalIn {
            from { opacity: 0; transform: scale(0.94) translateY(12px); }
            to   { opacity: 1; transform: scale(1) translateY(0); }
        }

        /* Drop zone */
        .drop-zone { border: 2px dashed #cbd5e1; transition: all 0.2s ease; }
        .drop-zone.dragover { border-color: #4338ca; background-color: #eef2ff; }

        /* Document row */
        .doc-row { transition: background 0.15s ease; }
        .doc-row:hover { background: #f8f9fc; }

        /* Plan badge */
        .plan-badge {
            display: inline-flex; align-items: center; gap: 4px;
            padding: 2px 10px; border-radius: 9999px; font-size: 11px; font-weight: 600; letter-spacing: 0.02em;
        }

        /* Toast */
        #toast {
            position: fixed; bottom: 24px; right: 24px; z-index: 9999;
            transform: translateY(100px); opacity: 0;
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        #toast.show { transform: translateY(0); opacity: 1; }

        /* Upload progress */
        .progress-bar { transition: width 0.3s ease; }
    </style>
</head>
<body class="overflow-hidden text-slate-800">

<div class="flex h-screen w-full">
    @include('components.admin-sidebar', ['active' => 'documents'])

    <!-- Main Content -->
    <main class="flex-1 flex flex-col min-w-0 bg-[#f8f9fc]">
        @include('components.admin-header')

        <div class="flex-1 overflow-y-auto custom-scroll p-8">
            <div class="max-w-6xl mx-auto flex flex-col gap-6">

                <!-- Page Header -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4">
                    <div>
                        <h2 class="text-3xl font-bold text-slate-900 tracking-tight">Documents</h2>
                        <p class="text-slate-500 text-sm mt-1">Upload and manage member documents by plan.</p>
                    </div>
                    <button onclick="openUploadPanel()" class="inline-flex items-center gap-2 bg-gradient-to-r from-[#006a6a] to-[#009090] hover:from-[#009090] hover:to-[#006a6a] text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition-all duration-300 shadow-[0_6px_20px_-6px_rgba(0,106,106,0.5)] hover:shadow-[0_8px_24px_-4px_rgba(0,106,106,0.55)]">
                        <span class="material-symbols-outlined text-[18px]">upload_file</span>
                        Upload Document
                    </button>
                </div>

                <!-- Success / Error Flash -->
                <!-- Document data store for JS -->
<script id="documents-data" type="application/json">@json($documentsJson)</script>

@if(session('success'))
                    <div class="flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl px-4 py-3 text-sm">
                        <span class="material-symbols-outlined text-emerald-500 text-[20px]">check_circle</span>
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Stats Row -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 flex items-center gap-4">
                        <div class="w-11 h-11 rounded-xl bg-red-50 flex items-center justify-center">
                            <span class="material-symbols-outlined text-red-500 text-[22px]">picture_as_pdf</span>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-slate-900">{{ $documents->count() }}</p>
                            <p class="text-xs text-slate-500 font-medium">PDF Documents</p>
                        </div>
                    </div>
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 flex items-center gap-4">
                        <div class="w-11 h-11 rounded-xl bg-indigo-50 flex items-center justify-center">
                            <span class="material-symbols-outlined text-indigo-500 text-[22px]">folder_open</span>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-slate-900">{{ $documents->count() }}</p>
                            <p class="text-xs text-slate-500 font-medium">Total Documents</p>
                        </div>
                    </div>
                </div>

                <!-- Documents Table -->
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                    @if($documents->isEmpty())
                        <div class="flex flex-col items-center justify-center py-20 text-center">
                            <div class="w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center mb-4">
                                <span class="material-symbols-outlined text-slate-400 text-[32px]">description</span>
                            </div>
                            <h3 class="text-slate-700 font-semibold text-lg mb-1">No documents yet</h3>
                            <p class="text-slate-400 text-sm mb-5">Upload your first document to get started.</p>
                            <button onclick="openUploadPanel()" class="inline-flex items-center gap-2 bg-[#1a1a1a] text-white text-sm font-semibold px-4 py-2 rounded-xl transition hover:bg-slate-800">
                                <span class="material-symbols-outlined text-[16px]">add</span> Upload Document
                            </button>
                        </div>
                    @else
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-slate-100">
                                    <th class="text-left text-xs font-semibold text-slate-400 uppercase tracking-wider px-6 py-4">Document</th>
                                    <th class="text-left text-xs font-semibold text-slate-400 uppercase tracking-wider px-6 py-4 hidden sm:table-cell">Accessible Plans</th>
                                    <th class="text-left text-xs font-semibold text-slate-400 uppercase tracking-wider px-6 py-4 hidden md:table-cell">Uploaded By</th>
                                    <th class="text-left text-xs font-semibold text-slate-400 uppercase tracking-wider px-6 py-4 hidden md:table-cell">Date</th>
                                    <th class="px-6 py-4"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @foreach($documents as $doc)
                                    <tr class="doc-row" id="doc-row-{{ $doc->id }}">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 rounded-xl {{ $doc->isPdf() ? 'bg-red-50' : 'bg-blue-50' }} flex items-center justify-center shrink-0">
                                                    <span class="material-symbols-outlined {{ $doc->getIconColor() }} text-[20px]">{{ $doc->getIconClass() }}</span>
                                                </div>
                                                <div>
                                                    <p class="font-semibold text-slate-800 text-sm leading-tight">{{ $doc->title }}</p>
                                                    <p class="text-xs text-slate-400 mt-0.5">{{ $doc->original_filename }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 hidden sm:table-cell">
                                            <div class="flex flex-wrap gap-1">
                                                @forelse($doc->plans as $plan)
                                                    @php
                                                        $colors = ['bg-indigo-50 text-indigo-700', 'bg-emerald-50 text-emerald-700', 'bg-amber-50 text-amber-700', 'bg-purple-50 text-purple-700'];
                                                        $color = $colors[$loop->index % count($colors)];
                                                    @endphp
                                                    <span class="plan-badge {{ $color }}">{{ $plan->name }}</span>
                                                @empty
                                                    <span class="text-xs text-slate-400 italic">No plans</span>
                                                @endforelse
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 hidden md:table-cell">
                                            <span class="text-sm text-slate-600">{{ $doc->uploader?->name ?? '—' }}</span>
                                        </td>
                                        <td class="px-6 py-4 hidden md:table-cell">
                                            <span class="text-sm text-slate-500">{{ $doc->created_at->format('M d, Y') }}</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-1">
                                                <button onclick="openEditPanel({{ $doc->id }})"
                                                    class="p-2 rounded-xl text-slate-400 hover:text-[#006a6a] hover:bg-[#006a6a]/5 transition-all duration-200">
                                                    <span class="material-symbols-outlined text-[18px]">edit</span>
                                                </button>
                                                <button onclick="confirmDelete({{ $doc->id }}, '{{ addslashes($doc->title) }}')"
                                                    class="p-2 rounded-xl text-slate-400 hover:text-red-500 hover:bg-red-50 transition-all duration-200">
                                                    <span class="material-symbols-outlined text-[18px]">delete</span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>

            </div>
        </div>
    </main>
</div>

<!-- ═══ Upload Modal ═══ -->
<div id="panel-container" style="display:none;">
    <!-- Backdrop -->
    <div id="upload-modal-backdrop" class="fixed inset-0 bg-slate-900/40 backdrop-blur-[3px] z-40" onclick="closeUploadPanel()"></div>

    <!-- Modal Box -->
    <div id="upload-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg flex flex-col overflow-hidden" style="max-height: 90vh;">

            <!-- Modal Header -->
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-[#006a6a]/10 to-[#009090]/15 flex items-center justify-center">
                        <span class="material-symbols-outlined text-[#006a6a] text-[20px]" id="modal-icon">upload_file</span>
                    </div>
                    <div>
                        <h3 class="text-[15px] font-bold text-slate-900" id="modal-title">Upload Document</h3>
                        <p class="text-xs text-slate-400 mt-0.5" id="modal-subtitle">PDF format only · up to 50 MB</p>
                    </div>
                </div>
                <button onclick="closeUploadPanel()" class="w-8 h-8 flex items-center justify-center rounded-xl hover:bg-slate-100 text-slate-400 hover:text-slate-600 transition">
                    <span class="material-symbols-outlined text-[18px]">close</span>
                </button>
            </div>

            <!-- Modal Body -->
            <form id="upload-form" class="overflow-y-auto custom-scroll p-5 space-y-4" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="edit-doc-id" value="">

                <!-- Title -->
                <div>
                    <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">Document Title <span class="text-red-500">*</span></label>
                    <input type="text" id="doc-title" name="title" required placeholder="e.g. Q1 Market Report 2026"
                        class="w-full h-10 px-4 rounded-xl border border-slate-200 bg-slate-50 text-slate-800 text-sm focus:outline-none focus:border-[#006a6a] focus:ring-2 focus:ring-[#006a6a]/10 transition">
                </div>

                <!-- File Upload Drop Zone -->
                <div>
                    <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">
                        File <span class="text-red-500 file-required">*</span>
                        <span id="file-optional-label" class="text-slate-400 font-normal normal-case hidden">(leave empty to keep current file)</span>
                    </label>
                    <div id="drop-zone" class="drop-zone rounded-xl p-6 flex flex-col items-center justify-center cursor-pointer relative"
                        onclick="document.getElementById('file-input').click()"
                        ondragover="handleDragOver(event)"
                        ondragleave="handleDragLeave(event)"
                        ondrop="handleDrop(event)">
                        <input type="file" id="file-input" name="file" accept=".pdf" class="hidden" onchange="handleFileSelect(this)">
                        <div id="drop-zone-default" class="flex flex-col items-center text-center">
                            <div class="w-10 h-10 rounded-xl bg-[#006a6a]/8 flex items-center justify-center mb-2.5" style="background:rgba(0,106,106,0.08)">
                                <span class="material-symbols-outlined text-[#006a6a] text-[22px]">cloud_upload</span>
                            </div>
                            <p class="text-sm font-semibold text-slate-700">Drop file here or click to browse</p>
                            <p class="text-xs text-slate-400 mt-0.5">PDF Only</p>
                        </div>
                        <div id="drop-zone-selected" class="hidden flex-col items-center text-center w-full">
                            <div id="selected-icon" class="w-10 h-10 rounded-xl bg-red-50 flex items-center justify-center mb-2.5">
                                <span class="material-symbols-outlined text-red-500 text-[22px]">picture_as_pdf</span>
                            </div>
                            <p id="selected-name" class="text-sm font-semibold text-slate-800 truncate max-w-full px-4"></p>
                            <p id="selected-size" class="text-xs text-slate-400 mt-0.5"></p>
                            <button type="button" onclick="clearFile(event)" class="mt-2 text-xs text-red-500 hover:underline">Remove file</button>
                        </div>
                    </div>

                    <!-- Progress -->
                    <div id="upload-progress" class="hidden mt-2.5">
                        <div class="flex justify-between text-xs text-slate-500 mb-1">
                            <span>Uploading...</span>
                            <span id="progress-pct">0%</span>
                        </div>
                        <div class="h-1.5 bg-slate-100 rounded-full overflow-hidden">
                            <div id="progress-fill" class="h-full rounded-full progress-bar" style="width:0%; background: linear-gradient(90deg, #006a6a, #009090);"></div>
                        </div>
                    </div>
                </div>

                <!-- Plan Selection -->
                <div>
                    <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">Accessible Plans <span class="text-red-500">*</span></label>
                    <p class="text-xs text-slate-400 mb-2">Only members on selected plan(s) can view this document.</p>
                    <div class="space-y-1.5" id="plan-checkboxes">
                        @foreach($plans as $plan)
                            @php
                                $planColors = [
                                    'bg-indigo-50 border-indigo-200 text-indigo-700',
                                    'bg-emerald-50 border-emerald-200 text-emerald-700',
                                    'bg-amber-50 border-amber-200 text-amber-700',
                                    'bg-purple-50 border-purple-200 text-purple-700',
                                ];
                                $pc = $planColors[$loop->index % count($planColors)];
                            @endphp
                            <label class="flex items-center gap-3 p-2.5 rounded-xl border border-slate-100 bg-slate-50 cursor-pointer hover:border-[#006a6a]/30 hover:bg-[#006a6a]/5 transition-all duration-200">
                                <input type="checkbox" name="plan_ids[]" value="{{ $plan->id }}"
                                    class="w-4 h-4 rounded accent-[#006a6a] border-slate-300 cursor-pointer">
                                <div class="flex items-center gap-2 flex-1">
                                    <span class="plan-badge {{ $pc }}">{{ $plan->name }}</span>
                                    @if($plan->subtitle)
                                        <span class="text-xs text-slate-400">{{ $plan->subtitle }}</span>
                                    @endif
                                </div>
                            </label>
                        @endforeach
                        @if($plans->isEmpty())
                            <p class="text-sm text-slate-400 italic py-2">No plans available. Please create plans first.</p>
                        @endif
                    </div>
                </div>
            </form>

            <!-- Modal Footer -->
            <div class="px-5 py-4 border-t border-slate-100 flex gap-3 shrink-0">
                <button onclick="closeUploadPanel()" class="flex-1 h-10 rounded-xl border border-slate-200 text-slate-600 font-semibold text-sm hover:bg-slate-50 transition">
                    Cancel
                </button>
                <button onclick="submitUpload()" id="submit-btn" class="flex-1 h-10 rounded-xl bg-gradient-to-r from-[#006a6a] to-[#009090] hover:from-[#009090] hover:to-[#006a6a] text-white font-semibold text-sm transition-all duration-300 flex items-center justify-center gap-2 shadow-[0_4px_14px_-4px_rgba(0,106,106,0.45)]">
                    <span class="material-symbols-outlined text-[16px]" id="submit-btn-icon">upload</span>
                    <span id="submit-btn-text">Upload Document</span>
                </button>
            </div>
        </div>
    </div>
</div><!-- /#panel-container -->

<!-- ═══ Delete Confirm Modal ═══ -->
<div id="delete-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
    <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm" onclick="closeDeleteModal()"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-sm p-6 animate-in fade-in zoom-in duration-200">
        <div class="flex items-center justify-center w-14 h-14 rounded-2xl bg-red-50 mx-auto mb-4">
            <span class="material-symbols-outlined text-red-500 text-[28px]">delete_forever</span>
        </div>
        <h3 class="text-lg font-bold text-slate-900 text-center">Delete Document?</h3>
        <p class="text-sm text-slate-500 text-center mt-2 mb-6">
            "<span id="delete-doc-title" class="font-semibold text-slate-700"></span>" will be permanently removed and the file deleted.
        </p>
        <div class="flex gap-3">
            <button onclick="closeDeleteModal()" class="flex-1 h-11 rounded-xl border border-slate-200 text-slate-700 font-semibold text-sm hover:bg-slate-50 transition">
                Cancel
            </button>
            <form id="delete-form" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full h-11 px-6 rounded-xl bg-red-500 hover:bg-red-600 text-white font-semibold text-sm transition">
                    Delete
                </button>
            </form>
        </div>
    </div>
</div>

<!-- ═══ Toast ═══ -->
<div id="toast" class="bg-white border border-slate-200 rounded-2xl shadow-xl px-5 py-3.5 flex items-center gap-3 min-w-[280px]">
    <span id="toast-icon" class="material-symbols-outlined text-emerald-500 text-[20px]">check_circle</span>
    <span id="toast-msg" class="text-sm font-semibold text-slate-800"></span>
</div>

<script>
// ─── Panel ──────────────────────────────────────────────────────────────────
function openUploadPanel() {
    const container = document.getElementById('panel-container');
    container.style.display = 'block';
    document.body.style.overflow = 'hidden';
}
function closeUploadPanel() {
    const container = document.getElementById('panel-container');
    container.style.display = 'none';
    document.body.style.overflow = '';
    // Reset form
    document.getElementById('upload-form').reset();
    document.getElementById('drop-zone-default').classList.remove('hidden');
    document.getElementById('drop-zone-selected').classList.add('hidden');
    document.getElementById('drop-zone-selected').classList.remove('flex');
    document.getElementById('upload-progress').classList.add('hidden');
    resetModalToUpload();
}

// ─── File handling ───────────────────────────────────────────────────────────
function handleDragOver(e) { e.preventDefault(); document.getElementById('drop-zone').classList.add('dragover'); }
function handleDragLeave(e) { document.getElementById('drop-zone').classList.remove('dragover'); }
function handleDrop(e) {
    e.preventDefault();
    document.getElementById('drop-zone').classList.remove('dragover');
    const file = e.dataTransfer.files[0];
    if (file) {
        const input = document.getElementById('file-input');
        const dt = new DataTransfer();
        dt.items.add(file);
        input.files = dt.files;
        showSelectedFile(file);
    }
}
function handleFileSelect(input) {
    if (input.files[0]) showSelectedFile(input.files[0]);
}
function showSelectedFile(file) {
    const isPdf = file.type === 'application/pdf';
    const icon = document.getElementById('selected-icon');
    icon.className = `w-12 h-12 rounded-xl flex items-center justify-center mb-3 ${isPdf ? 'bg-red-50' : 'bg-blue-50'}`;
    icon.querySelector('span').className = `material-symbols-outlined text-[24px] ${isPdf ? 'text-red-500' : 'text-blue-500'}`;
    icon.querySelector('span').textContent = isPdf ? 'picture_as_pdf' : 'article';
    document.getElementById('selected-name').textContent = file.name;
    document.getElementById('selected-size').textContent = formatBytes(file.size);
    document.getElementById('drop-zone-default').classList.add('hidden');
    document.getElementById('drop-zone-selected').classList.remove('hidden');
    document.getElementById('drop-zone-selected').classList.add('flex');
}
function clearFile(e) {
    e.stopPropagation();
    document.getElementById('file-input').value = '';
    document.getElementById('drop-zone-default').classList.remove('hidden');
    document.getElementById('drop-zone-selected').classList.add('hidden');
    document.getElementById('drop-zone-selected').classList.remove('flex');
}
function formatBytes(bytes) {
    if (bytes < 1024) return bytes + ' B';
    if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
    return (bytes / 1048576).toFixed(1) + ' MB';
}

// ─── Edit Mode ───────────────────────────────────────────────────────────────
let editMode = false;
let editDocId = null;

function openEditPanel(docId) {
    editMode = true;
    editDocId = docId;

    const docs = JSON.parse(document.getElementById('documents-data').textContent);
    const doc = docs.find(d => d.id === docId);
    if (!doc) return;

    document.getElementById('modal-icon').textContent = 'edit';
    document.getElementById('modal-title').textContent = 'Edit Document';
    document.getElementById('modal-subtitle').textContent = 'Update title, plans, or replace the file';
    document.getElementById('submit-btn-icon').textContent = 'save';
    document.getElementById('submit-btn-text').textContent = 'Save Changes';

    document.getElementById('edit-doc-id').value = docId;
    document.getElementById('doc-title').value = doc.title;

    document.getElementById('file-optional-label').classList.remove('hidden');
    document.querySelector('.file-required').classList.add('hidden');

    document.getElementById('drop-zone-default').classList.remove('hidden');
    document.getElementById('drop-zone-selected').classList.add('hidden');
    document.getElementById('drop-zone-selected').classList.remove('flex');
    document.getElementById('file-input').value = '';
    document.getElementById('upload-progress').classList.add('hidden');

    document.querySelectorAll('input[name="plan_ids[]"]').forEach(cb => {
        cb.checked = doc.plan_ids.includes(parseInt(cb.value));
    });

    openUploadPanel();
}

function resetModalToUpload() {
    editMode = false;
    editDocId = null;
    document.getElementById('edit-doc-id').value = '';
    document.getElementById('modal-icon').textContent = 'upload_file';
    document.getElementById('modal-title').textContent = 'Upload Document';
    document.getElementById('modal-subtitle').textContent = 'PDF format only · up to 50 MB';
    document.getElementById('submit-btn-icon').textContent = 'upload';
    document.getElementById('submit-btn-text').textContent = 'Upload Document';
    document.getElementById('file-optional-label').classList.add('hidden');
    document.querySelector('.file-required').classList.remove('hidden');
}

// ─── Upload / Update ─────────────────────────────────────────────────────────
function submitUpload() {
    const title = document.getElementById('doc-title').value.trim();
    const file = document.getElementById('file-input').files[0];
    const planCheckboxes = document.querySelectorAll('input[name="plan_ids[]"]:checked');

    if (!title) { showToast('Please enter a document title.', 'error'); return; }
    if (!editMode && !file) { showToast('Please select a file to upload.', 'error'); return; }
    if (planCheckboxes.length === 0) { showToast('Please select at least one plan.', 'error'); return; }

    const formData = new FormData();
    formData.append('_token', document.querySelector('input[name="_token"]').value);
    formData.append('title', title);
    if (file) formData.append('file', file);
    planCheckboxes.forEach(cb => formData.append('plan_ids[]', cb.value));

    const btn = document.getElementById('submit-btn');
    btn.disabled = true;
    btn.innerHTML = '<span class="material-symbols-outlined text-[16px] animate-spin">progress_activity</span> Saving...';

    const progress = document.getElementById('upload-progress');
    const fill = document.getElementById('progress-fill');
    const pct = document.getElementById('progress-pct');
    if (file) progress.classList.remove('hidden');

    const xhr = new XMLHttpRequest();
    const url = editMode
        ? '{{ url('admin/documents') }}/' + editDocId
        : '{{ route('admin.documents.store') }}';
    xhr.open(editMode ? 'POST' : 'POST', url);
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.setRequestHeader('Accept', 'application/json');

    if (editMode) {
        formData.append('_method', 'PUT');
    }

    xhr.upload.onprogress = function(e) {
        if (e.lengthComputable) {
            const p = Math.round((e.loaded / e.total) * 100);
            fill.style.width = p + '%';
            pct.textContent = p + '%';
        }
    };

    xhr.onload = function() {
        btn.disabled = false;
        btn.innerHTML = editMode
            ? '<span class="material-symbols-outlined text-[16px]">save</span> Save Changes'
            : '<span class="material-symbols-outlined text-[16px]">upload</span> Upload Document';
        progress.classList.add('hidden');
        fill.style.width = '0%';

        if (xhr.status === 200) {
            showToast(editMode ? 'Document updated successfully!' : 'Document uploaded successfully!', 'success');
            closeUploadPanel();
            setTimeout(() => location.reload(), 1200);
        } else {
            try {
                const data = JSON.parse(xhr.responseText);
                const msg = data.message || (data.errors ? Object.values(data.errors).flat().join(' ') : 'Operation failed.');
                showToast(msg, 'error');
            } catch(e) {
                showToast('Operation failed.', 'error');
            }
        }
    };
    xhr.onerror = function() {
        btn.disabled = false;
        btn.innerHTML = editMode
            ? '<span class="material-symbols-outlined text-[16px]">save</span> Save Changes'
            : '<span class="material-symbols-outlined text-[16px]">upload</span> Upload Document';
        progress.classList.add('hidden');
        showToast('Operation failed. Please try again.', 'error');
    };

    xhr.send(formData);
}

// ─── Delete ──────────────────────────────────────────────────────────────────
function confirmDelete(id, title) {
    document.getElementById('delete-doc-title').textContent = title;
    document.getElementById('delete-form').action = `/admin/documents/${id}`;
    document.getElementById('delete-modal').classList.remove('hidden');
    document.getElementById('delete-modal').classList.add('flex');
}
function closeDeleteModal() {
    document.getElementById('delete-modal').classList.add('hidden');
    document.getElementById('delete-modal').classList.remove('flex');
}

// ─── Toast ───────────────────────────────────────────────────────────────────
function showToast(msg, type = 'success') {
    const toast = document.getElementById('toast');
    const icon  = document.getElementById('toast-icon');
    const text  = document.getElementById('toast-msg');
    icon.textContent  = type === 'success' ? 'check_circle' : 'error';
    icon.className    = `material-symbols-outlined text-[20px] ${type === 'success' ? 'text-emerald-500' : 'text-red-500'}`;
    text.textContent  = msg;
    toast.classList.add('show');
    setTimeout(() => toast.classList.remove('show'), 3500);
}
</script>

@include('components.settings-modal')

</body>
</html>
