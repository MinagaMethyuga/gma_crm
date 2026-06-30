<x-layouts::app>
    <div class="p-8">
        <h1 class="text-headline-lg font-headline-lg font-bold text-zinc-900">{{ __('Member Dashboard') }}</h1>
        <p class="text-zinc-500 mt-2">{{ __('Welcome, :name', ['name' => auth()->user()->name]) }}</p>
    </div>
</x-layouts::app>
