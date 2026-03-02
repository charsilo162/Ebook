@props([
    'book',
    'showActions' => false,
    'onEdit' => null,
    'onDelete' => null,
])

<div class="bg-white rounded-xl shadow-sm border border-zinc-200
            hover:shadow-md transition duration-300 group">

    {{-- Cover --}}
    <div class="relative overflow-hidden rounded-t-xl">
        <img
            src="{{ $book->cover_image ?? '' }}"
            alt="{{ $book->title ?? '' }}"
            class="w-full h-64 object-cover group-hover:scale-105 transition duration-300"
        />

        {{-- Admin Actions --}}
        @if($showActions)
            <div class="absolute top-3 right-3 flex gap-2">
                <button
                    wire:click="{{ $onEdit }}"
                    class="bg-white/90 text-blue-600 p-2 rounded-lg
                           hover:bg-blue-600 hover:text-white transition"
                    title="Edit"
                >
                    ✏️
                </button>

                <button
                    wire:click="{{ $onDelete }}"
                    class="bg-white/90 text-red-600 p-2 rounded-lg
                           hover:bg-red-600 hover:text-white transition"
                    title="Delete"
                >
                    🗑️
                </button>
            </div>
        @endif
    </div>

    {{-- Content --}}
    <div class="p-4">
        <h3 class="font-semibold text-zinc-900 line-clamp-2">
            {{ $book->title ?? '' }}
        </h3>

        <p class="text-sm text-zinc-500 mt-1">
            {{ $book->author ?? '' }}
        </p>

        {{-- Meta Row: Formats + Price + Stock --}}
        <div class="flex items-center justify-between gap-2 mt-3 flex-wrap">

            {{-- Formats --}}
            <div class="flex flex-wrap gap-1">
                @foreach($book->formats ?? [] as $format)
                    <span
                        class="text-[10px] px-2 py-0.5 rounded-full font-medium
                            {{ ($format['type'] ?? '') === 'digital'
                                ? 'bg-purple-100 text-purple-700'
                                : 'bg-blue-100 text-blue-700' }}">
                        {{ ucfirst($format['type'] ?? '') }}
                    </span>
                @endforeach
            </div>

            {{-- Price --}}
            <span class="text-sm font-bold text-zinc-900 whitespace-nowrap">
                ₦{{ number_format($book->starting_price ?? 0) }}
                <span class="text-[10px] text-zinc-400 font-normal">starting</span>
            </span>

            {{-- Stock (Physical only) --}}
            @php
                $physicalFormat = collect($book->formats ?? [])
                    ->first(fn ($f) => ($f['type'] ?? null) === 'physical');

                $stock = $physicalFormat['stock_count'] ?? null;
            @endphp

            @if(!is_null($stock))
                @if($stock === 0)
                    <span class="text-[11px] px-2 py-1 rounded-full
                                 bg-red-100 text-red-700 font-medium whitespace-nowrap">
                        Out of stock
                    </span>
                @elseif($stock <= 10)
                    <span class="text-[11px] px-2 py-1 rounded-full
                                 bg-yellow-100 text-yellow-800 font-medium whitespace-nowrap">
                        {{ $stock }} left
                    </span>
                @else
                    <span class="text-[11px] px-2 py-1 rounded-full
                                 bg-green-100 text-green-700 font-medium whitespace-nowrap">
                        {{ $stock }} in stock
                    </span>
                @endif
            @endif

        </div>
    </div>
</div>