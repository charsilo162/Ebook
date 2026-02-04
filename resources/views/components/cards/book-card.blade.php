@props([
    'title',
    'price',
    'image',
    'href' => '#',
    'outOfStock' => false,
])

<div class="group bg-white rounded-xl overflow-hidden border border-zinc-200 hover:shadow-lg transition">

    {{-- Image --}}
    <div class="relative aspect-[3/4] overflow-hidden">
        <img
            src="{{ asset($image) }}"
            alt="{{ $title }}"
            class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
        >

        @if ($outOfStock)
            <div class="absolute inset-0 bg-black/50 flex items-center justify-center">
                <span class="px-4 py-2 text-xs font-semibold bg-white rounded-full">
                    OUT OF STOCK
                </span>
            </div>
        @endif
    </div>

    {{-- Content --}}
    <div class="p-4 space-y-2">
        <h3 class="text-sm font-semibold text-zinc-900 leading-snug">
            {{ $title }}
        </h3>

        <p class="text-sm text-zinc-600">
            ₦{{ number_format($price, 2) }}
        </p>

        <a href="{{ $href }}" class="inline-block">
            <button class="mt-2 px-4 py-2 text-xs font-medium rounded-md bg-purple-600 text-white hover:bg-purple-700 transition">
                View More
            </button>
        </a>
    </div>

</div>
