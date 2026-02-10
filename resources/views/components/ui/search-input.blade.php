@props([
    'placeholder' => 'Search...',
    'buttonLabel' => 'Search',
])

<div class="flex w-full max-w-2xl rounded-lg overflow-hidden bg-white ring-1 ring-zinc-300 focus-within:ring-2 focus-within:ring-purple-500 transition">
    <input
        type="text"
        placeholder="{{ $placeholder }}"
        {{-- ADD THIS: $attributes allows wire:model to bind here --}}
        {{ $attributes->whereDoesntStartWith('class') }}
        class="flex-1 px-4 py-3 text-sm text-zinc-900 bg-transparent focus:outline-none"
    />

    <button class="px-6 py-3 bg-purple-600 text-white text-sm font-medium hover:bg-purple-700 transition">
        {{ $buttonLabel }}
    </button>
</div>