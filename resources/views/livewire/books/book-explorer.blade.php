<div>
    {{-- Filters + Search --}}
    <section class="max-w-7xl mx-auto px-6 pt-10 space-y-6">

        {{-- Category Pills --}}
        <div class="flex flex-wrap gap-3">
            {{-- All Categories Button --}}
            <x-ui.pill-button 
                label="All" 
                color="{{ is_null($activeCategory) ? 'blue' : 'zinc' }}"
                wire:click="setCategory(null)"
                
            />

            @foreach ($categories as $cat)
                @php
                    // Map your database categories to your component colors
                    $colorMap = ['Fiction' => 'pink', 'Business' => 'blue', 'Academic' => 'green'];
                    $color = $colorMap[$cat['name']] ?? 'zinc';
                @endphp
                
            <x-ui.pill-button 
                    wire:key="cat-{{ $cat['id'] }}" {{-- CRITICAL FOR FILTERS --}}
                    :label="$cat['name']" 
                    :color="$activeCategory == $cat['id'] ? 'pink' : 'zinc'" 
                    wire:click="setCategory('{{ $cat['uuid'] }}')" {{-- Quote the ID if it's a string/UUID --}}
                />
            @endforeach
        </div>

        {{-- Search Input Component --}}
        <div class="flex justify-center">
            {{-- We pass the wire:model into the component's input --}}
            <x-ui.search-input 
                placeholder="Search books, authors..." 
                wire:model.live.debounce.300ms="search"
            />
        </div>
    </section>

    {{-- Results Grid --}}
   {{-- Results Grid --}}
<section class="max-w-7xl mx-auto px-6 py-10">
    {{-- Header with Category Name, Count, and CLEAR button --}}
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center gap-4">
            <h2 class="text-xl font-semibold text-zinc-900">
                {{ $this->activeCategoryName }}
            </h2>
            <span class="text-sm text-zinc-500">
                {{ $meta['total'] ?? count($books) }} results
            </span>
        </div>

        {{-- Show this ONLY if a filter is active --}}
        @if($search || $activeCategory)
            <button 
                wire:click="resetFilters"
                class="text-sm font-medium text-purple-600 hover:text-purple-800 flex items-center gap-1 transition"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                Clear all filters
            </button>
        @endif
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
        @forelse ($books as $book)
            {{-- Use wire:key here too for smoother DOM updates --}}
            <x-cards.book-card
                wire:key="book-{{ $book['id'] }}" 
                :title="$book['title']"
                :price="$book['starting_price']"
                :image="$book['cover_image']"
                :type="$book['default_type']"
                :author="$book['author']"
                :href="route('books.show', ['uuid' => $book['id'], 'type' => $book['default_type']])"
                :outOfStock="($book['stock'] ?? 1) <= 0"
            />
        @empty
            <div class="col-span-full py-20 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-zinc-100 text-zinc-400 mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 9.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <p class="text-zinc-500 italic">No books found matching your selection.</p>
                <button wire:click="resetFilters" class="mt-4 text-purple-600 font-semibold underline">Try clearing your filters</button>
            </div>
        @endforelse
    </div>
</section>
</div>