<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body x-data="{ sidebarOpen: false }" class="bg-zinc-50 text-zinc-900">

    <div class="flex min-h-screen">
        {{-- 1. THE SIDEBAR COMPONENT --}}
        <x-navigation.sidebar />

        {{-- 2. MOBILE OVERLAY (Darkens the screen when sidebar is open) --}}
        <div 
            x-show="sidebarOpen" 
            x-cloak
            @click="sidebarOpen = false" 
            x-transition.opacity
            class="fixed inset-0 bg-black/50 z-30 lg:hidden">
        </div>

        {{-- 3. MAIN CONTENT AREA --}}
        <main class="flex-1 flex flex-col min-w-0 lg:ml-64">
            
            {{-- MOBILE TOP BAR (Only visible on mobile) --}}
            <header class="flex items-center justify-between p-4 bg-white border-b lg:hidden">
                <button @click="sidebarOpen = true" class="p-2 text-zinc-600 hover:bg-zinc-100 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <span class="font-bold text-purple-700"> 
                   <span class="text-xl text-zinc-700">E</span>
                      Book</span>
                <div class="w-6"></div> {{-- Placeholder for symmetry --}}
            </header>

            <div class="p-4 lg:p-8">
                @if (session()->has('success'))
                    <div class="mb-4 p-4 bg-purple-50 border border-purple-200 text-purple-700 rounded-2xl font-bold text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                {{ $slot }}
            </div>
        </main>
    </div>

    @livewireScripts
</body>
</html>