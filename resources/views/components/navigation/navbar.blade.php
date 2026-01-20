<nav
    x-data="{ open: false }"
    class="sticky top-0 z-50 bg-purple-600/95 backdrop-blur"
>
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

        {{-- Logo --}}
        <div class="font-bold text-xl text-white">
            Logo
        </div>

        {{-- Desktop Nav --}}
        <ul class="hidden md:flex items-center gap-6 text-white">
            @foreach (config('navigation') as $nav)
                <li>
                    <a
                        href="{{ route($nav['route']) }}"
                        class="px-4 py-2 rounded-full hover:bg-white/20 transition"
                    >
                        {{ $nav['label'] }}
                    </a>
                </li>
            @endforeach
        </ul>

        {{-- Desktop Login --}}
        <a
            href="{{ route('login') }}"
            class="hidden md:inline-flex bg-white text-purple-600 px-5 py-2 rounded-full font-medium"
        >
            Login
        </a>

        {{-- Mobile Menu Button --}}
        <button
            @click="open = !open"
            class="md:hidden text-white"
        >
            ☰
        </button>
    </div>

    {{-- Mobile Menu --}}
    <div
        x-show="open"
        x-transition
        @click.outside="open = false"
        class="md:hidden bg-purple-700 text-white px-6 pb-6"
    >
        <ul class="flex flex-col gap-4 mt-4">
            @foreach (config('navigation') as $nav)
                <li>
                    <a
                        href="{{ route($nav['route']) }}"
                        class="block px-4 py-3 rounded-lg hover:bg-white/20 transition"
                    >
                        {{ $nav['label'] }}
                    </a>
                </li>
            @endforeach
        </ul>

        <a
            href="{{ route('login') }}"
            class="block mt-4 text-center bg-white text-purple-600 px-5 py-3 rounded-lg font-medium"
        >
            Login
        </a>
    </div>
</nav>
