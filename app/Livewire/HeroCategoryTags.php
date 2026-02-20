<?php
namespace App\Livewire;

use Livewire\Component;
use App\Services\ApiService; // Assuming you have this from previous context

class HeroCategoryTags extends Component
{
    public $categories = [];
    public $colors = ['pink', 'blue', 'green', 'zinc', 'purple', 'indigo', 'yellow', 'red', 'teal', 'cyan'];

    protected ApiService $api;

    public function boot(ApiService $api)
    {
        $this->api = $api;
    }

    public function mount()
    {
        $response = $this->api->get('categories/random?limit=10&with_count=1');
        // dd($response);
        $this->categories = $response['data'] ?? [];
    }

    public function render()
    {
        return view('livewire.hero-category-tags');
    }
}
