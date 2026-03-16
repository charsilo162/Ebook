@props(['image', 'title', 'count', 'url' => '#'])
@php
   // dd($image);
@endphp
<a href="{{ $url }}" class="group relative h-44 rounded-xl overflow-hidden bg-zinc-200 block">
    <img src="{{ $image }}" alt="{{ $title }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition duration-300" />
    <div class="absolute inset-0 bg-black/50"></div>
    <div class="relative h-full p-4 flex flex-col justify-end text-white">
        <span class="text-2xl font-bold leading-none">{{ number_format($count) }}</span>
        <span class="text-sm font-medium capitalize">{{ $title }}</span>
    </div>
</a>