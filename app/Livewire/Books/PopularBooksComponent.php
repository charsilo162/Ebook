<?php

namespace App\Livewire\Books;
use Livewire\Component;
use App\Services\ApiService;

class PopularBooksComponent extends Component
{
    public $books = [];
    public $paginationLinks = [];
    public $currentPage = 1;

    protected $queryString = [
        'currentPage' => ['as' => 'page', 'history' => true]
    ];

    // This runs when the component is first loaded
    public function mount(ApiService $api)
    {
        $this->loadBooks($api);
    }

    // This runs automatically whenever $currentPage is updated
    public function updatedCurrentPage()
    {
        // We use app() to resolve the service or pass it manually
        $this->loadBooks(app(ApiService::class));
    }

    public function setPage($page)
    {
        if (!$page || $page == $this->currentPage) return;
        $this->currentPage = $page;
        
        // Manual trigger for older Livewire versions if updatedCurrentPage doesn't fire
        $this->loadBooks(app(ApiService::class));
    }

public function loadBooks(ApiService $api)
{
    // Pass the page as an array instead of a string
    $response = $api->get("vendor/popular-books", [
        'page' => $this->currentPage
    ]);
    
    $this->books = $response['data'] ?? [];
    $this->paginationLinks = $response['links'] ?? [];
}

    public function render()
    {
        return view('livewire.books.popular-books-component');
    }
}