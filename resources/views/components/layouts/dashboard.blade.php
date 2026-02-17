<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body
    x-data="{ sidebarOpen: false }"
    class="bg-zinc-50 text-zinc-900"
    >

    {{-- Top bar (mobile + desktop) --}}
    <x-navigation.navbar
        dashboard
        @toggle-sidebar.window="sidebarOpen = !sidebarOpen"
    />

    <div class="flex min-h-screen">

        {{-- Sidebar --}}
        <x-navigation.sidebar />

        {{-- Mobile overlay --}}
        <div
            x-show="sidebarOpen"
            @click="sidebarOpen = false"
            x-transition.opacity
            class="fixed inset-0 bg-black/40 z-30 lg:hidden"
        ></div>

        {{-- Main content --}}
        <main class="flex-1 p-4 lg:p-6 lg:ml-64">
            @if (session()->has('success'))
            <div class="mb-4 p-4 bg-purple-50 border border-purple-200 text-purple-700 rounded-2xl font-bold text-sm">
                {{ session('success') }}
            </div>
        @endif
            {{ $slot }}
        </main>

    </div>

    @livewireScripts
</body>
</html>
