<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="bg-zinc-50 text-zinc-900 font-body-md antialiased">
        <!-- SideNavBar -->
        <nav class="fixed h-screen w-[280px] left-0 top-0 bg-zinc-50 border-r border-zinc-200 z-50 hidden md:flex flex-col py-lg">
            <div class="px-6 mb-8 flex items-center gap-4">
                <div class="w-10 h-10 bg-transparent rounded-lg flex items-center justify-center">
                    <x-app-logo-icon class="h-8 w-auto object-contain" />
                </div>
                <div>
                    <h1 class="text-headline-md font-headline-md font-bold text-zinc-900 leading-tight">Kinetic Ledger</h1>
                    <p class="text-label-sm font-label-sm text-zinc-500 uppercase tracking-wider">Admin Console</p>
                </div>
            </div>

            <button class="mx-4 mb-8 bg-[#3525cd] text-white rounded-lg py-2.5 px-4 flex items-center justify-center gap-2 font-label-md shadow-sm kowalski-card-hover kowalski-spring">
                <span class="material-symbols-outlined text-[18px]">add</span>
                New Entry
            </button>

            <ul class="flex flex-col gap-1 flex-1 px-2">
                <li>
                    <a class="flex items-center gap-3 px-4 py-2.5 kowalski-nav-active rounded-lg font-label-md" href="{{ route('dashboard') }}" wire:navigate>
                        <span class="material-symbols-outlined">dashboard</span>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a class="flex items-center gap-3 px-4 py-2.5 text-zinc-600 hover:text-zinc-900 hover:bg-zinc-200/50 rounded-lg font-label-md kowalski-spring" href="{{ route('members') }}" wire:navigate>
                        <span class="material-symbols-outlined">group</span>
                        Members
                    </a>
                </li>
                <li>
                    <a class="flex items-center gap-3 px-4 py-2.5 text-zinc-600 hover:text-zinc-900 hover:bg-zinc-200/50 rounded-lg font-label-md kowalski-spring" href="#">
                        <span class="material-symbols-outlined">event</span>
                        Events
                    </a>
                </li>
                <li>
                    <a class="flex items-center gap-3 px-4 py-2.5 text-zinc-600 hover:text-zinc-900 hover:bg-zinc-200/50 rounded-lg font-label-md kowalski-spring" href="{{ route('profile.edit') }}" wire:navigate>
                        <span class="material-symbols-outlined">settings</span>
                        Settings
                    </a>
                </li>
            </ul>

            <ul class="flex flex-col gap-1 px-2 mt-auto">
                <li>
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 text-zinc-600 hover:text-zinc-900 hover:bg-zinc-200/50 rounded-lg font-label-md kowalski-spring cursor-pointer">
                            <span class="material-symbols-outlined">logout</span>
                            Sign Out
                        </button>
                    </form>
                </li>
            </ul>
        </nav>

        <!-- Main Content Area -->
        <main class="flex-1 md:ml-[280px] min-h-screen flex flex-col relative overflow-x-hidden">
            <!-- TopAppBar -->
            <header class="docked top-0 sticky z-40 bg-zinc-50 border-b border-zinc-200 flex justify-between items-center w-full px-8 h-16">
                <div class="flex items-center gap-6">
                    <!-- Search -->
                    <div class="relative hidden sm:block w-64 group">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-zinc-400 text-[18px] group-focus-within:text-[#3525cd] kowalski-spring">search</span>
                        <input class="w-full bg-zinc-200/50 rounded-full py-1.5 pl-10 pr-4 text-body-sm font-body-sm border border-transparent focus:border-zinc-300 focus:bg-white focus:ring-4 focus:ring-zinc-100 kowalski-spring shadow-sm text-zinc-900 placeholder:text-zinc-400" placeholder="Search..." type="text"/>
                    </div>
                    <nav class="hidden lg:flex items-center gap-6">
                        <a class="text-zinc-600 hover:text-zinc-900 kowalski-spring font-label-md" href="#">Directory</a>
                        <a class="text-zinc-600 hover:text-zinc-900 kowalski-spring font-label-md" href="#">Invoices</a>
                        <a class="text-zinc-600 hover:text-zinc-900 kowalski-spring font-label-md" href="#">Support</a>
                    </nav>
                </div>
                <div class="flex items-center gap-4">
                    <button class="text-zinc-500 hover:text-zinc-900 kowalski-spring">
                        <span class="material-symbols-outlined">notifications</span>
                    </button>
                    <button class="text-zinc-500 hover:text-zinc-900 kowalski-spring hidden sm:block">
                        <span class="material-symbols-outlined">apps</span>
                    </button>
                    <button class="hidden sm:block bg-[#3525cd]/10 text-[#3525cd] hover:bg-[#3525cd]/20 px-4 py-1.5 rounded-full font-label-md kowalski-spring">
                        Create Event
                    </button>
                    <div class="w-8 h-8 rounded-full overflow-hidden border border-outline-variant flex items-center justify-center">
                        @auth
                            <flux:avatar :name="auth()->user()->name" :initials="auth()->user()->initials()" class="w-full h-full" />
                        @else
                            <flux:avatar name="Guest" class="w-full h-full" />
                        @endauth
                    </div>
                </div>
            </header>
            
            {{ $slot }}

        </main>
        
        <livewire:create-team-modal />

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>
