<nav
    x-data="{ open: false }"
    class="sticky top-0 z-50 bg-gradient-to-r from-purple-700/95 to-purple-600/95 backdrop-blur-lg shadow-md"
>
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

        {{-- Logo --}}
        <div class="font-bold text-2xl text-white tracking-wide drop-shadow-lg">
            MyDashboard
        </div>

        {{-- Desktop Nav --}}
        <ul class="hidden md:flex items-center gap-6 text-white font-medium">
            @foreach (config('navigation') as $nav)
                <li>
                    <a
                        href="{{ route($nav['route']) }}"
                        class="px-4 py-2 rounded-full hover:bg-white/20 transition-all duration-300"
                    >
                        {{ $nav['label'] }}
                    </a>
                </li>
            @endforeach
        </ul>

        {{-- Desktop Login --}}
        <a
            href="{{ route('login') }}"
            class="hidden md:inline-flex bg-white text-purple-600 px-5 py-2 rounded-full font-semibold shadow-lg hover:shadow-xl transition"
        >
            Login
        </a>

        {{-- Mobile Menu Button --}}
        <button
            @click="open = !open"
            class="md:hidden text-white text-2xl"
        >
            ☰
        </button>
    </div>

    {{-- Mobile Menu --}}
    <div
        x-show="open"
        x-transition
        @click.outside="open = false"
        class="md:hidden bg-purple-700 text-white px-6 pb-6 space-y-4 rounded-b-xl shadow-lg"
    >
        <ul class="flex flex-col gap-4 mt-4 font-medium">
            @foreach (config('navigation') as $nav)
                <li>
                    <a
                        href="{{ route($nav['route']) }}"
                        class="block px-4 py-3 rounded-lg hover:bg-white/20 transition-all duration-300"
                    >
                        {{ $nav['label'] }}
                    </a>
                </li>
            @endforeach
        </ul>

        <a
            href="{{ route('login') }}"
            class="block mt-4 text-center bg-white text-purple-600 px-5 py-3 rounded-lg font-semibold shadow hover:shadow-md transition"
        >
            Login
        </a>
    </div>
</nav>
