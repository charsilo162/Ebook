<?php

namespace App\Livewire\Books;
use Livewire\Component;
use App\Services\ApiService;

namespace App\Livewire\Books;

use Livewire\Component;
use App\Services\ApiService;

class ShowcaseManager extends Component
{
    public $sections = [];

    public function render(ApiService $api)
    {
        // Call the public showcase endpoint
        $response = $api->get('vendor/showcase');
        // dd($response);
        $this->sections = $response['sections'] ?? [];

        return view('livewire.books.showcase-manager');
    }
}
