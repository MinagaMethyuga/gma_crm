<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="bg-background text-on-background font-body-md antialiased flex">
        <!-- SideNavBar -->
        <nav class="fixed h-screen w-[280px] left-0 top-0 bg-surface-container-low dark:bg-inverse-surface shadow-sm z-50 hidden md:flex flex-col py-lg">
            <div class="px-6 mb-8 flex items-center gap-4">
                <div class="w-10 h-10 bg-transparent rounded-lg flex items-center justify-center">
                    <x-app-logo-icon class="h-8 w-auto object-contain" />
                </div>
                <div>
                    <h1 class="text-headline-md font-headline-md font-bold text-on-surface dark:text-inverse-on-surface leading-tight">GMA Global</h1>
                    <p class="text-label-sm font-label-sm text-on-surface-variant uppercase tracking-wider">Admin Console</p>
                </div>
            </div>

            <button class="mx-4 mb-8 bg-primary hover:bg-primary/90 text-on-primary rounded-lg py-3 px-4 flex items-center justify-center gap-2 font-label-md transition-colors shadow-sm">
                <span class="material-symbols-outlined">add</span>
                New Entry
            </button>

            <ul class="flex flex-col gap-1 flex-1 px-2">
                <li>
                    <a class="flex items-center gap-3 px-4 py-3 text-primary dark:text-primary-fixed-dim bg-secondary-container/20 border-l-4 border-primary dark:border-primary-fixed-dim rounded-r-lg font-label-md scale-[0.99] transition-transform duration-150" href="{{ route('dashboard') }}" wire:navigate>
                        <span class="material-symbols-outlined">dashboard</span>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant dark:text-surface-variant hover:bg-surface-container-high dark:hover:bg-surface-variant rounded-lg font-label-md transition-colors duration-200" href="#">
                        <span class="material-symbols-outlined">group</span>
                        Members
                    </a>
                </li>
                <li>
                    <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant dark:text-surface-variant hover:bg-surface-container-high dark:hover:bg-surface-variant rounded-lg font-label-md transition-colors duration-200" href="#">
                        <span class="material-symbols-outlined">payments</span>
                        Financials
                    </a>
                </li>
                <li>
                    <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant dark:text-surface-variant hover:bg-surface-container-high dark:hover:bg-surface-variant rounded-lg font-label-md transition-colors duration-200" href="#">
                        <span class="material-symbols-outlined">event</span>
                        Events
                    </a>
                </li>
                <li>
                    <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant dark:text-surface-variant hover:bg-surface-container-high dark:hover:bg-surface-variant rounded-lg font-label-md transition-colors duration-200" href="#">
                        <span class="material-symbols-outlined">analytics</span>
                        Reports
                    </a>
                </li>
                <li>
                    <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant dark:text-surface-variant hover:bg-surface-container-high dark:hover:bg-surface-variant rounded-lg font-label-md transition-colors duration-200" href="{{ route('profile.edit') }}" wire:navigate>
                        <span class="material-symbols-outlined">settings</span>
                        Settings
                    </a>
                </li>
            </ul>

            <ul class="flex flex-col gap-1 px-2 mt-auto">
                <li>
                    <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant dark:text-surface-variant hover:bg-surface-container-high dark:hover:bg-surface-variant rounded-lg font-label-md transition-colors duration-200" href="#">
                        <span class="material-symbols-outlined">help</span>
                        Help
                    </a>
                </li>
                <li>
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-on-surface-variant dark:text-surface-variant hover:bg-surface-container-high dark:hover:bg-surface-variant rounded-lg font-label-md transition-colors duration-200 cursor-pointer">
                            <span class="material-symbols-outlined">logout</span>
                            Sign Out
                        </button>
                    </form>
                </li>
            </ul>
        </nav>

        <!-- Main Content Area -->
        <main class="flex-1 md:ml-[280px] min-h-screen flex flex-col relative w-full overflow-x-hidden">
            <!-- TopAppBar -->
            <header class="docked full-width top-0 sticky z-40 border-b border-outline-variant dark:border-outline bg-surface-bright dark:bg-surface-dim flex justify-between items-center w-full px-8 h-16">
                <div class="flex items-center gap-6">
                    <!-- Search -->
                    <div class="relative hidden sm:block w-64">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-sm">search</span>
                        <input class="w-full bg-surface-container rounded-full py-1.5 pl-10 pr-4 text-body-sm font-body-sm border-none focus:ring-2 focus:ring-primary transition-shadow" placeholder="Search..." type="text"/>
                    </div>
                    <nav class="hidden lg:flex items-center gap-6">
                        <a class="text-on-surface-variant dark:text-surface-variant hover:text-primary dark:hover:text-primary-fixed-dim transition-colors font-label-md" href="#">Directory</a>
                        <a class="text-on-surface-variant dark:text-surface-variant hover:text-primary dark:hover:text-primary-fixed-dim transition-colors font-label-md" href="#">Invoices</a>
                        <a class="text-on-surface-variant dark:text-surface-variant hover:text-primary dark:hover:text-primary-fixed-dim transition-colors font-label-md" href="#">Support</a>
                    </nav>
                </div>
                <div class="flex items-center gap-4">
                    <button class="text-on-surface-variant hover:text-primary transition-colors">
                        <span class="material-symbols-outlined">notifications</span>
                    </button>
                    <button class="text-on-surface-variant hover:text-primary transition-colors hidden sm:block">
                        <span class="material-symbols-outlined">apps</span>
                    </button>
                    <button class="hidden sm:block bg-primary-container/10 text-primary hover:bg-primary-container/20 px-4 py-1.5 rounded-full font-label-md transition-colors border border-primary/20">
                        Create Event
                    </button>
                    <div class="w-8 h-8 rounded-full overflow-hidden border border-outline-variant flex items-center justify-center">
                        <flux:avatar :name="auth()->user()->name" :initials="auth()->user()->initials()" class="w-full h-full" />
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
