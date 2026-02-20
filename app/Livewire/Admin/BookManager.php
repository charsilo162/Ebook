<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Services\ApiService;
use Illuminate\Support\Facades\Log;
class BookManager extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = 'all'; // all | active | inactive

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => 'all'],
    ];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }



    public function toggleBook($id)
        {
           // dd("Toggling book with ID: {$id}");
            try {
                $response = app(ApiService::class)
                    ->patch("books/{$id}/toggle-active");

                // Check if API returned success
                if (isset($response['is_active'])) {

                    session()->flash('message', 'Book status updated successfully.');

                } else {

                    Log::error('Toggle book failed: Invalid response structure', [
                        'book_id' => $id,
                        'response' => $response,
                    ]);

                    session()->flash('error', 'Failed to update book status. Please try again.');

                }

            } catch (\Throwable $e) {

                Log::error('Toggle book exception occurred', [
                    'book_id' => $id,
                    'error' => $e->getMessage(),
                ]);

                session()->flash('error', 'Something went wrong. Please contact developer.');
            }
        }


    public function render(ApiService $api)
    {
        $response = $api->get('books', [
            'search' => $this->search,
            'include_inactive' => 1, // ADMIN MUST SEE ALL
            'page' => $this->paginators['page'] ?? 1,
            'per_page' => 15,
        ]);

            $books = collect($response['data'] ?? []);

            if ($this->statusFilter === 'active') {
                $books = $books->where('is_active', true);
            }

            if ($this->statusFilter === 'inactive') {
                $books = $books->where('is_active', false);
            }

        return view('livewire.admin.book-manager', [
            'books' => $books,
            'meta'  => $response['meta'] ?? [],
        ]);
    }
}
