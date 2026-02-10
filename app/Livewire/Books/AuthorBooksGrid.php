<?php

namespace App\Livewire\Books;

use App\Services\ApiService;
use Livewire\Component;
class AuthorBooksGrid extends Component
{
    public $authorName;
    public $currentBookId;
    public $books = [];

    public function mount($authorName, $currentBookId, ApiService $api)
    {
        $this->authorName = $authorName;
        $this->currentBookId = $currentBookId;

        // Use your API index search logic: search by author name
        $response = $api->get("books", [
            'search' => $authorName,
            'limit' => 6
        ]);

        // Filter out the current book so we don't suggest the one the user is already looking at
        $this->books = collect($response['data'] ?? [])
            ->filter(fn($b) => $b['id'] != $this->currentBookId)
            ->toArray();
    }
    public function render()
    {
        return view('livewire.books.author-books-grid');
    }
}
