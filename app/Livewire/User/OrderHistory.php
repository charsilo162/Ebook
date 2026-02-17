<?php
namespace App\Livewire\User;

use App\Services\ApiService;
use Livewire\Component;
use Livewire\WithPagination;

class OrderHistory extends Component
{
    use WithPagination;

    public $search = '';
    public $page = 1; // Track current page

    // Reset page to 1 whenever search changes
    public function updatedSearch()
    {
        $this->page = 1;
    }

    public function setPage($pageNumber)
    {
        $this->page = $pageNumber;
    }

    public function render(ApiService $api)
    {
        $response = $api->get("myorders", [
            'search' => $this->search,
            'page'   => $this->page // Send current page to API
        ]);

        return view('livewire.user.order-history', [
            'orders' => $response['data'] ?? [],
            'pagination' => $response['meta'] ?? [] // Pass meta for the UI
        ]);
    }
}
