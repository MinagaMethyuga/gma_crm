@props(['title', 'width' => 'max-w-xl'])

<x-layouts::auth.custom :title="$title ?? null" :width="$width">
    {{ $slot }}
</x-layouts::auth.custom>

