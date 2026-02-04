<section class="mt-10">
    <h2 class="text-lg font-bold mb-4">
        Popularly Patronized
    </h2>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach ($popularBooks as $book)
            <x-book.book-card :book="$book" />
        @endforeach
    </div>
</section>
