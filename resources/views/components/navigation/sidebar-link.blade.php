<a
    href="{{ $href }}"
    class="flex items-center gap-4 px-4 py-3 rounded-xl
           text-purple-100 hover:bg-white/10 hover:text-white
           transition-all duration-300 font-medium shadow-sm"
>
    <x-heroicon-o-{{ $icon }} class="w-5 h-5" />
    <span class="truncate">{{ $label }}</span>
</a>
