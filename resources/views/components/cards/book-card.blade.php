@props([
    'title',
    'price' => null,
    'image',
    'type' => null,
    'author' => null,
    'href' => '#',
    'outOfStock' => false,
])

<div class="group bg-white rounded-2xl overflow-hidden border border-zinc-200 hover:shadow-xl hover:-translate-y-1 transition duration-300">

    {{-- Image Section --}}
    <div class="relative aspect-[3/4] overflow-hidden bg-zinc-100">
        <img src="{{ asset($image) }}" 
             alt="{{ $title }}" 
             class="w-full h-full object-cover group-hover:scale-105 transition duration-500">

        {{-- Type Badge --}}
        @if($type)
            <span class="absolute top-3 left-3 px-3 py-1 text-[10px] font-semibold uppercase tracking-wide bg-purple-600 backdrop-blur rounded-full text-white shadow-sm">
                {{ $type }}
            </span>
        @endif

        {{-- Out of Stock Overlay --}}
        @if ($outOfStock)
            <div class="absolute inset-0 bg-black/50 flex items-center justify-center">
                <span class="px-4 py-2 text-xs font-semibold bg-white rounded-full">
                    OUT OF STOCK
                </span>
            </div>
        @endif
    </div>

    {{-- Content Section --}}
    <div class="p-5 space-y-3">

        {{-- Title --}}
        <h3 class="text-sm font-semibold text-zinc-900 leading-snug line-clamp-2">
            {{ $title }}
        </h3>

        {{-- Author --}}
        @if($author)
            <p class="text-xs text-zinc-500">
                by <span class="font-medium text-zinc-700">{{ $author }}</span>
            </p>
        @endif

        {{-- Price --}}
        @if($price)
            <p class="text-base font-semibold text-zinc-900">
                ₦{{ number_format($price, 2) }}
            </p>
        @endif

        {{-- Footer / CTA --}}
        <div class="pt-2">
            @if(isset($footer))
                {{ $footer }}
            @else
                <a href="{{ $href }}" class="block">
                    <button class="w-full px-4 py-2 text-xs font-medium rounded-lg bg-purple-600 text-white hover:bg-purple-700 transition">
                        View More
                    </button>
                </a>
            @endif
        </div>

    </div>
</div>
