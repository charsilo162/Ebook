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
            <x-ui.book-card 
                {{-- Use ?? '' to provide a fallback if the key is missing --}}
                :image="$book['image'] ?? asset('storage/images/d6.jpg')" 
                :title="$book['title'] ?? 'Untitled Book'"
                :url="$book['url'] ?? '#'" 
            />
        @endforeach
    </div>
</div>