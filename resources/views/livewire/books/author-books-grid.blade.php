<section class="max-w-7xl mx-auto px-6 py-12">
    <h3 class="text-xl font-bold text-zinc-900 mb-6">More from {{ $authorName }}</h3>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
        @forelse($books as $book)
            <x-ui.book-cards
                :title="$book['title']"
                :image="$book['cover_image']"
                :href="route('books.show', $book['id'])"
                :original-price="$book['variants'][0]['price'] ?? 0"
                :deal-price="$book['variants'][0]['discount_price'] ?? null"
                :out-of-stock="($book['variants'][0]['stock'] ?? 0) <= 0"
            />
        @empty
            <p class="text-zinc-500 italic">No other books found by this author.</p>
        @endforelse
    </div>
</section>