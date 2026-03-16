<footer class="relative bg-gradient-to-br from-purple-700 via-purple-600 to-indigo-600 text-white">

    <div class="h-px w-full bg-white/20"></div>

    <div class="max-w-6xl mx-auto px-6 py-14 text-center space-y-8">

        {{-- Logo --}}
            <div class="flex justify-center">
                <a href="/" class="text-white font-black text-2xl tracking-tighter flex items-center gap-2">
                    <div class="bg-white p-1 rounded-lg">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <span>E<span class="opacity-70"> BOOK</span></span>
                </a>
            </div>

        {{-- Navigation --}}
        <div class="flex flex-wrap justify-center items-center gap-8 text-sm font-medium">

            @foreach ($links as $link)

                <a href="{{ route($link['route']) }}"
                   class="text-white/80 hover:text-white
                          relative transition
                          after:absolute after:left-0 after:-bottom-1
                          after:h-[1px] after:w-0 after:bg-white
                          after:transition-all after:duration-300
                          hover:after:w-full">
                    {{ $link['label'] }}
                </a>

            @endforeach

        </div>

        {{-- Social Icons --}}
        {{-- <div class="flex justify-center gap-4">
            <a href="#" class="h-10 w-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-white hover:text-purple-700 transition">𝕏</a>
            <a href="#" class="h-10 w-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-white hover:text-purple-700 transition">📘</a>
            <a href="#" class="h-10 w-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-white hover:text-purple-700 transition">📸</a>
        </div> --}}

        {{-- Copyright --}}
        <p class="text-sm text-white/70">
            © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </p>

    </div>

</footer>