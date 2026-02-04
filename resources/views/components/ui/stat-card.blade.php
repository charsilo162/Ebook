@props([
    'label',
    'value',
    'icon' => null, // heroicon name e.g. 'book-open'
    'color' => 'zinc',
])

<div
    class="bg-white rounded-xl border border-zinc-200 p-5
           flex items-center gap-4 shadow-sm hover:shadow-md transition"
>

    {{-- Icon --}}
    @if ($icon)
        <div
            class="flex items-center justify-center w-12 h-12 rounded-lg
                   bg-{{ $color }}-100 text-{{ $color }}-600"
        >
            <x-heroicon-o-{{ $icon }} class="w-6 h-6" />
        </div>
    @endif

    <div>
        <p class="text-sm text-zinc-500">
            {{ $label }}
        </p>

        <p class="text-xl font-bold text-zinc-900">
            {{ $value }}
        </p>
    </div>
</div>
