@props([
    'image',
    'title' => null,
    'url' => '#', // Add a default URL prop
])

<a href="{{ $url }}" class="block rounded-xl overflow-hidden bg-white shadow-sm hover:shadow-md transition group">
    <div class="relative">
        <img
            src="{{ $image }}"
            alt="{{ $title }}"
            class="w-full h-64 object-cover group-hover:scale-105 transition duration-500"
        />
        {{-- Optional: Add a "View Details" overlay on hover --}}
        <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
            <span class="bg-white px-4 py-2 rounded-lg text-sm font-semibold shadow-xl">View Book</span>
        </div>
    </div>
</a>