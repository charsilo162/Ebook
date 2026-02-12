<?php
namespace App\Livewire\Category;

use Livewire\Component;
use App\Services\ApiService;

class CategoryGridManager extends Component
{
    public $categories = [];

    public function render(ApiService $api)
    {
        $response = $api->get('public/categories');
        //dd($response);
        $this->categories = $response['categories'] ?? [];

        return view('livewire.category.category-grid-manager');
    }
}