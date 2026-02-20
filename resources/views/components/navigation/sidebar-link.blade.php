@props([
    'href',
    'icon',
    'label',
])

<a
    href="{{ $href }}"
    class="group flex items-center gap-4 px-4 py-3 rounded-xl
           text-purple-100 hover:bg-white/10 hover:text-white
           transition-all duration-300 font-medium"
>

    {{-- Dynamic Heroicon --}}
    <x-dynamic-component
        :component="'heroicon-o-' . $icon"
        class="w-5 h-5 text-purple-200 group-hover:text-white transition duration-300"
    />

    <span class="truncate">
        {{ $label }}
    </span>

</a>
