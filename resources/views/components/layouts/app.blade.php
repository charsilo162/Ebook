<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
     @livewireStyles
</head>
<body class="bg-zinc-50 text-zinc-900">

    <x-navigation.navbar />

    <main>
        {{-- resources/views/layouts/app.blade.php --}}

            @if (session()->has('success'))
                <div class="fixed top-5 right-5 z-50 bg-purple-600 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-3 animate-bounce">
                    <x-heroicon-o-check-circle class="w-5 h-5" />
                    <span class="text-sm font-bold">{{ session('success') }}</span>
                </div>
            @endif

            @if (session()->has('error'))
                <div class="fixed top-5 right-5 z-50 bg-red-600 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-3">
                    <x-heroicon-o-x-circle class="w-5 h-5" />
                    <span class="text-sm font-bold">{{ session('error') }}</span>
                </div>
            @endif
        {{ $slot }}
    </main>
  @livewireScripts
</body>
</html>
