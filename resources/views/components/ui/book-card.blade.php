@props([
    'image',
    'title' => null,
])

<div class="rounded-xl overflow-hidden bg-white shadow-sm hover:shadow-md transition">
    <img
        src="{{ $image }}"
        alt="{{ $title }}"
        class="w-full h-64 object-cover"
    />
</div>
