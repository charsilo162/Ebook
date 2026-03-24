@props(['image', 'title', 'count', 'url' => '#'])

<a href="{{ $url }}" class="group relative h-44 rounded-xl overflow-hidden block">

    {{-- Background Image --}}
    <img 
        src="{{ $image }}" 
        alt="{{ $title }}" 
        class="absolute inset-0 w-full h-full object-cover 
               scale-100 group-hover:scale-110 
               transition duration-500 ease-out 
               blur-[1px]"
    />

    {{-- Gradient Overlay (KEY FIX) --}}
    <div class="absolute inset-0 
        bg-gradient-to-t 
        from-black/80 via-black/50 to-black/20">
    </div>

    {{-- Content --}}
    <div class="relative h-full p-4 flex flex-col justify-end text-white">

    {{-- Count --}}
    <span class="w-fit px-2 py-1 rounded-md 
                 bg-black/70 backdrop-blur-sm 
                 text-sm font-semibold 
                 border border-white/10
                 shadow-sm">
        {{ number_format($count) }}
    </span>

    {{-- Title --}}
    <span class="w-fit mt-2 px-3 py-1.5 rounded-lg 
                 bg-black/70 backdrop-blur-sm 
                 text-xs font-medium capitalize 
                 border border-white/10
                 shadow-sm">
        {{ $title }}
    </span>

</div>

</a>