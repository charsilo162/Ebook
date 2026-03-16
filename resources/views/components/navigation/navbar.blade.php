@php
    $user = Session::get('user');
@endphp

<nav x-data="{ open: false }" class="sticky top-0 z-50 bg-gradient-to-r from-purple-700/95 to-purple-600/95 backdrop-blur-lg shadow-md">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
        {{-- Logo --}}
        {{-- <div class="font-bold text-2xl text-white tracking-wide drop-shadow-lg">
            MyDashboard
        </div> --}}
        <div class="flex-shrink-0 flex items-center">
                        <a href="/" class="text-white font-black text-2xl tracking-tighter flex items-center gap-2">
                            <div class="bg-white p-1 rounded-lg">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                            <span>E<span class="opacity-70"> BOOK</span></span>
                        </a>
                    </div>
        {{-- Desktop Nav --}}
        <ul class="hidden md:flex items-center gap-6 text-white font-medium">
            @foreach (config('navigation') as $nav)
                <li>
                    <a href="{{ route($nav['route']) }}" class="px-4 py-2 rounded-full hover:bg-white/20 transition-all duration-300">
                        {{ $nav['label'] }}
                    </a>
                </li>
            @endforeach
                       {{-- <li>
                    <a href="{{ route(dashboard) }}" class="px-4 py-2 rounded-full hover:bg-white/20 transition-all duration-300">
                        {{ "Dashboard" }}
                    </a>
                </li> --}}
        </ul>

        {{-- Desktop Auth --}}
        <div class="hidden md:flex items-center gap-3">
            @if ($user)
                {{-- Show Logout --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-white text-purple-600 px-5 py-2 rounded-full font-semibold shadow-lg hover:shadow-xl transition">
                        Logout
                    </button>
                </form>
                      <a href="{{ route('dashboard') }}" class="bg-white text-purple-600 px-5 py-2 rounded-full font-semibold shadow-lg hover:shadow-xl transition">
                    Dashboard
                </a>
            @else
                {{-- Show Login and Sign Up --}}
                <a href="{{ route('login') }}" class="bg-white text-purple-600 px-5 py-2 rounded-full font-semibold shadow-lg hover:shadow-xl transition">
                    Login
                </a>
                <a href="{{ route('signup') }}" class="bg-purple-200 text-purple-800 px-5 py-2 rounded-full font-semibold shadow hover:shadow-md transition">
                    Sign Up
                </a>
            @endif
        </div>

        {{-- Mobile Menu Button --}}
        <button @click="open = !open" class="md:hidden text-white text-2xl">
            ☰
        </button>
    </div>

    {{-- Mobile Menu --}}
    <div x-show="open" x-transition @click.outside="open = false" class="md:hidden bg-purple-700 text-white px-6 pb-6 space-y-4 rounded-b-xl shadow-lg">
        <ul class="flex flex-col gap-4 mt-4 font-medium">
            @foreach (config('navigation') as $nav)
                <li>
                    <a href="{{ route($nav['route']) }}" class="block px-4 py-3 rounded-lg hover:bg-white/20 transition-all duration-300">
                        {{ $nav['label'] }}
                    </a>
                </li>
            @endforeach
        </ul>

        @if ($user)
            <form method="POST" action="{{ route('logout') }}" class="mt-4 text-center">
                @csrf
                <button type="submit" class="block w-full bg-white text-purple-600 px-5 py-3 rounded-lg font-semibold shadow hover:shadow-md transition">
                    Logout
                </button>
            </form>
        @else
            <a href="{{ route('login') }}" class="block mt-4 text-center bg-white text-purple-600 px-5 py-3 rounded-lg font-semibold shadow hover:shadow-md transition">
                Login
            </a>
            <a href="{{ route('signup') }}" class="block mt-2 text-center bg-purple-200 text-purple-800 px-5 py-3 rounded-lg font-semibold shadow hover:shadow-md transition">
                Sign Up
            </a>
        @endif
    </div>
</nav>
