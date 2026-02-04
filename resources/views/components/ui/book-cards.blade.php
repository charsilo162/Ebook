@props([
    'title',
    'image',
    'href',
    'originalPrice' => null,
    'dealPrice' => null,
    'outOfStock' => false,
])



<a href="{{ $href }}" class="group block bg-white rounded-xl shadow hover:shadow-lg transition p-3 relative">

    {{-- Image --}}
    <div class="relative overflow-hidden rounded-lg">
        <img 
            src="{{ $image }}" 
            alt="{{ $title }}" 
            class="w-full h-56 object-cover group-hover:scale-105 transition duration-300"
        >

        @if($outOfStock)
            <div class="absolute inset-0 bg-black/60 flex items-center justify-center text-white font-semibold">
                OUT OF STOCK
            </div>
        @endif
    </div>

    {{-- Title --}}
    <h3 class="mt-3 text-sm font-semibold text-gray-800 line-clamp-2">
        {{ $title }}
    </h3>

    {{-- Prices --}}
   {{-- Prices --}}
<div class="mt-2 flex items-center justify-between">
    @if($originalPrice)
        <p class="text-xs text-gray-500 line-through">
            ₦{{ number_format($originalPrice) }}
        </p>
    @endif

    @if($dealPrice)
        <p class="text-sm font-bold text-purple-600">
            ₦{{ number_format($dealPrice) }}
        </p>
    @endif
</div>

</a>
