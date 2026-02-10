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
                <div class="animate-pulse bg-zinc-100 h-64 rounded-xl"></div>
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