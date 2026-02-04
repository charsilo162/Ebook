@props([
    'book',
    'showActions' => false,
    'onEdit' => null,
    'onDelete' => null,
])

<div class="bg-white rounded-xl shadow-sm border border-zinc-200
            hover:shadow-md transition duration-300 group">
{{-- @php
    dd($book);
@endphp --}}
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
                <!-- EDIT -->
                <button
                    wire:click="{{ $onEdit }}"
                    class="bg-white/90 text-blue-600 p-2 rounded-lg
                           hover:bg-blue-600 hover:text-white transition"
                    title="Edit"
                >
                    ✏️
                </button>

                <!-- DELETE -->
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

        <div class="flex items-center justify-between mt-3">
            <span class="text-sm font-semibold text-purple-600">
                ₦{{ number_format($book->starting_price ?? 0) }}
            </span>

          <span class="text-xs px-2 py-1 rounded-full bg-zinc-100 text-zinc-600">
                {{ ucfirst($book->formats[0]['type'] ?? 'digital') }}
            </span>

        </div>

    </div>
</div>
