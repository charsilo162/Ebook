<section class="mt-8">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-bold text-zinc-900">
            Popularly Patronized
        </h2>
        <span class="text-xs text-zinc-500 uppercase tracking-wider">Top Sellers</span>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        
        @forelse ($books as $bookData)
            <x-book.book-card :book="(object) $bookData" />
        @empty
           @foreach (range(1, 4) as $placeholder)
                <div class="flex flex-col items-center justify-center h-64 rounded-xl border border-zinc-200 bg-gradient-to-br from-zinc-50 to-zinc-100 text-center px-6">

                    <svg class="w-8 h-8 text-purple-500 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>

                    <p class="text-sm font-semibold text-zinc-700 tracking-wide">
                        No Popularly Patronized Books
                    </p>

                    <span class="text-xs text-zinc-500 mt-1">
                        Trending titles will appear here
                    </span>

                </div>
            @endforeach
        @endforelse
    </div>

    {{-- Pagination Controls --}}
    @if(count($paginationLinks) > 3)
        <div class="mt-10 flex justify-center items-center gap-2">
            @foreach ($paginationLinks as $link)
                <button 
                   type="button"
                    wire:click="setPage({{ $link['page'] }})"
                    wire:key="pop-page-{{ $loop->index }}"
                    wire:loading.attr="disabled"
                    @disabled(!$link['url'])
                    class="px-4 py-2 text-sm font-medium rounded-lg transition-all relative
                        {{ $link['active'] 
                            ? 'bg-zinc-900 text-white z-10 shadow-md' 
                            : 'bg-white border border-zinc-200 text-zinc-600 hover:bg-zinc-50' 
                        }} 
                        {{ !$link['url'] ? 'opacity-30 cursor-not-allowed' : 'cursor-pointer' }}"
                >
                    {{-- Show a small spinner while loading this specific page --}}
                    <span wire:loading.remove wire:target="setPage({{ $link['page'] ?? 'null' }})">
                        {!! $link['label'] !!}
                    </span>
                    <span wire:loading wire:target="setPage({{ $link['page'] ?? 'null' }})">
                        ...
                    </span>
                </button>
            @endforeach
        </div>
    @endif
</section>