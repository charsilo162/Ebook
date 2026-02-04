@props([
    'maxWidth' => 'lg',
])

@php
    $maxWidthClass = [
        'sm' => 'max-w-sm',
        'md' => 'max-w-md',
        'lg' => 'max-w-lg',
        'xl' => 'max-w-xl',
        '2xl' => 'max-w-2xl',
    ][$maxWidth] ?? 'max-w-lg';
@endphp

<div
    x-data="{ open: @entangle($attributes->wire('model')) }"
    x-show="open"
    x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center"
>
    <!-- Overlay -->
    <div
        class="absolute inset-0 bg-black/50"
        @click="open = false"
    ></div>

    <!-- Modal -->
    <div
        x-show="open"
        x-transition
        class="relative bg-white rounded-2xl shadow-xl w-full {{ $maxWidthClass }} mx-4 p-6"
    >
        {{ $slot }}
    </div>
</div>
