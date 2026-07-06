<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'GMA Member' }}</title>
    <link rel="icon" href="/Global_Mobile_Association_Logo__1_-removebg-preview.png" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0,1&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #fbfcfd; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        .custom-scroll::-webkit-scrollbar { width: 6px; height: 6px; }
        .custom-scroll::-webkit-scrollbar-track { background: transparent; }
        .custom-scroll::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 10px; }
        .emil-btn { transition: transform 180ms cubic-bezier(0.23, 1, 0.32, 1); }
        .emil-btn:active { transform: scale(0.96) !important; }
    </style>
    @fluxStyles
</head>
<body class="overflow-hidden text-slate-800">
    <div class="flex h-screen w-full">
        @include('components.member-sidebar', ['active' => $active ?? 'manage-team'])

        <!-- Main Content Area -->
        <main class="flex-1 flex flex-col min-w-0 bg-[#fbfcfd]">
            @include('components.member-topbar')
            
            <div class="flex-1 overflow-y-auto overflow-x-hidden custom-scroll p-4 md:p-10">
                {{ $slot }}
            </div>
        </main>
    </div>
    @fluxScripts
    @include('components.settings-modal')
</body>
</html>
