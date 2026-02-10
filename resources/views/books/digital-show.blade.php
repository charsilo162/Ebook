<x-layouts.app>
    {{-- Now $id and $authorName are available variables --}}
   @livewire('books.book-detail-hero', ['id' => $id])


    @livewire('books.author-books-grid', [
        'authorName' => $authorName, 
        'currentBookId' => $id
    ])
</x-layouts.app>