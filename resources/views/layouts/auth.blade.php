<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'E-Book Marketplace') }} - Join Us</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="antialiased bg-slate-50">

<nav class="sticky top-0 z-50 bg-purple-600/95 backdrop-blur border-b border-purple-500/30 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex justify-between h-16 items-center">

            <!-- Logo -->
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

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-4">
                <a href="{{ route('home') }}" class="text-purple-100 hover:text-white text-sm font-semibold transition">
                    Home
                </a>

                <div class="h-4 w-px bg-purple-400/50"></div>

                <a href="{{ route('contact') }}" class="text-purple-100 hover:text-white text-sm font-semibold transition">
                    Contact Us
                </a>
            </div>

            <!-- Mobile Button -->
            <div class="md:hidden">
                <button id="menu-btn" class="text-white focus:outline-none">
                    <svg id="menu-icon" xmlns="http://www.w3.org/2000/svg" class="h-7 w-7"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>

        </div>

    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden md:hidden px-4 pb-4 space-y-3 bg-purple-600">

        <a href="{{ route('home') }}"
            class="block text-purple-100 hover:text-white text-sm font-semibold">
            Home
        </a>

        <a href="{{ route('contact') }}"
            class="block text-purple-100 hover:text-white text-sm font-semibold">
            Contact Us
        </a>

    </div>
</nav>



    <main>
        {{ $slot }}
    </main>

    <footer class="py-8 text-center">
        <p class="text-slate-400 text-sm">
            &copy; {{ date('year') }} {{ config('app.name') }}. All rights reserved.
        </p>
    </footer>

    @livewireScripts
    <script>
    const btn = document.getElementById('menu-btn');
    const menu = document.getElementById('mobile-menu');

    btn.addEventListener('click', () => {
        menu.classList.toggle('hidden');
    });
</script>
</body>
</html>