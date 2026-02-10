<x-layouts.app>
    <div class="min-h-[60vh] flex items-center justify-center px-6">
        <div class="max-w-md text-center">
            <div class="mx-auto mb-6 w-16 h-16 rounded-full bg-zinc-100 flex items-center justify-center">
                <svg class="w-8 h-8 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>

            <h1 class="text-2xl font-semibold text-zinc-900 mb-2">
                This book isn’t available
            </h1>

            <p class="text-zinc-600 mb-6">
                The book you’re looking for may have been removed, renamed,
                or is temporarily unavailable.
            </p>

            <div class="flex items-center justify-center gap-4">
                <a href="{{ route('category.books') }}"
                   class="px-6 py-2 rounded-lg bg-purple-600 text-white font-medium hover:bg-purple-700 transition">
                    Browse books
                </a>

                <a href="{{ url()->previous() }}"
                   class="text-sm font-medium text-zinc-600 hover:text-zinc-900">
                    Go back
                </a>
            </div>
        </div>
    </div>
</x-layouts.app>
