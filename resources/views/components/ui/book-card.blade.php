@props([
    'image',
    'title' => null,
    'url' => '#', // Add a default URL prop
])

<a href="{{ $url }}" class="block group">
    <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition">

        <div class="relative overflow-hidden rounded-lg">
            <img
                src="{{ $image }}"
                alt="{{ $title }}"
                class="w-full aspect-[3/4] object-cover group-hover:scale-105 transition duration-500"
            />
        </div>

        {{-- TEXT SECTION --}}
        <div class="p-3">
            <h4 class="text-sm font-medium text-gray-800 line-clamp-2">
                {{ $title }}
            </h4>
        </div>
    </div>
</a>