@props(['href', 'icon', 'label'])

<a
    href="{{ $href }}"
    class="flex items-center gap-3 px-3 py-2 rounded-lg
           text-purple-100 hover:bg-purple-500/40
           transition"
>
    <x-heroicon-o-{{ $icon }} class="w-5 h-5" />
    <span>{{ $label }}</span>
</a>
