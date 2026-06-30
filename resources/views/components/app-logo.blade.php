@props([
    'sidebar' => false,
])

@if($sidebar)
    <flux:sidebar.brand name="GMA Global" {{ $attributes }}>
        <x-slot name="logo" class="flex aspect-square size-12 items-center justify-center rounded-md bg-transparent">
            <x-app-logo-icon class="size-10 object-contain drop-shadow-sm" />
        </x-slot>
    </flux:sidebar.brand>
@else
    <flux:brand name="GMA Global" {{ $attributes }}>
        <x-slot name="logo" class="flex aspect-square size-12 items-center justify-center rounded-md bg-transparent">
            <x-app-logo-icon class="size-10 object-contain drop-shadow-sm" />
        </x-slot>
    </flux:brand>
@endif
