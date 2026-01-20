@props([
    'title',
    'books',
])

<div>
    <h3 class="text-lg font-semibold mb-4">
        {{ $title }}
    </h3>

    <div class="grid grid-cols-1 gap-4">
        @foreach ($books as $book)
            <x-ui.book-card :image="$book['image']" />
        @endforeach
    </div>
</div>
