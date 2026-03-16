<?php
namespace App\Livewire\Books;

use Livewire\Component;
use App\Services\ApiService;
use Livewire\WithPagination;

class BookExplorer extends Component
{
    use WithPagination;

    public $search = '';
    public $activeCategory = null;
    public $categories = [];

    // Query string allows users to share a link with filters applied
    protected $queryString = [
        'search' => ['except' => ''],
        'activeCategory' => ['as' => 'category', 'except' => null],
    ];

    public function resetFilters()
        {
            $this->reset(['search', 'activeCategory']);
            $this->resetPage();
        }
    public function mount(ApiService $api)
    {
        // Load categories once
        $this->categories = $api->get('categories')['data'] ?? [];
    }

    public function setCategory($id)
    {
        // Toggle category: if clicked again, clear it
        $this->activeCategory = ($this->activeCategory == $id) ? null : $id;
        $this->resetPage(); // Reset pagination when filter changes
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

public function getActiveCategoryNameProperty()
{
    if (!$this->activeCategory) return 'All Books';
    
    $category = collect($this->categories)->firstWhere('id', $this->activeCategory);
    return $category['name'] ?? 'Category';
}

public function render(ApiService $api)
{
    $response = $api->getFilteredBooks([
        'search' => $this->search,
        'category_id' => $this->activeCategory,
        'page' => $this->paginators['page'] ?? 1,
        'per_page' => 15,
    ]);
    // dd($response['data']);
    return view('livewire.books.book-explorer', [
        'books' => $response['data'] ?? [],
        'meta'  => $response['meta'] ?? [],
        'activeCategoryName' => $this->activeCategoryName, // Use the computed property
    ]);
}
}
