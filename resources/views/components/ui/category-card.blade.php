@props(['title', 'count', 'url' => '#'])

<a href="{{ $url }}" 
   class="group relative h-40 rounded-2xl overflow-hidden block border border-purple-500/20 shadow-lg transition-all duration-300 hover:shadow-purple-500/20">
    
    {{-- Branded Gradient Background --}}
    <div class="absolute inset-0 bg-gradient-to-br from-purple-900 via-purple-800 to-indigo-900 transition-colors duration-500"></div>

    {{-- Subtle Decorative Pattern Overlay (Optional: adds texture) --}}
    <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width=\"20\" height=\"20\" viewBox=\"0 0 20 20\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"1\" fill-rule=\"evenodd\"%3E%3Ccircle cx=\"3\" cy=\"3\" r=\"3\"/%3E%3C/g%3E%3C/svg%3E');"></div>

    {{-- Content Container --}}
    <div class="relative h-full p-5 flex flex-col justify-between items-start">
        
        {{-- Top Section: Count with Glassmorphism --}}
        <div class="flex justify-between w-full items-start">
            <span class="px-3 py-1 rounded-full bg-white/10 backdrop-blur-md text-purple-100 text-xs font-bold border border-white/20 shadow-sm uppercase tracking-wider">
                {{ number_format($count) }} Items
            </span>
            
            {{-- Arrow Icon --}}
            <div class="text-white/30 group-hover:text-white/80 transition-colors duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </div>
        </div>

        {{-- Bottom Section: Title --}}
        <div>
            <h3 class="text-white text-xl font-bold tracking-tight group-hover:translate-x-1 transition-transform duration-300">
                {{ $title }}
            </h3>
            <div class="h-1 w-8 bg-purple-400 rounded-full mt-2 group-hover:w-16 transition-all duration-500"></div>
        </div>
    </div>
</a>