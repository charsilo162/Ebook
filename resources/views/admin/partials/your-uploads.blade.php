<section class="mt-10">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-bold">
            Your Uploads
        </h2>

        <a
            href="{{ route('books.create') }}"
            class="px-4 py-2 bg-purple-600 text-white rounded-lg
                   hover:bg-purple-700 transition"
        >
            Upload a book
        </a>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach ($myBooks as $book)
            <x-book.book-card
                :book="$book"
                :showActions="true"
            />
        @endforeach
    </div>
</section>
