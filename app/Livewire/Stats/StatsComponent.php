<?php

namespace App\Livewire\Stats;

use App\Services\ApiService;
use Livewire\Component;

class StatsComponent extends Component
{
    public $stats = [];

    public function render(ApiService $api)
    {
        // Fetch stats from the API endpoint
        $response = $api->get('stats');

        // Set stats to the 'data' key if present, otherwise default
        $this->stats = $response['data'] ?? [
            'total_books' => 0,
            'types' => [
                'hard_copy' => 0,
                'soft_copy' => 0,
            ],
            'total_books_bought' => 0,
            'total_users' => 0,
            'total_vendors' => 0,
        ];

        return view('livewire.stats.stats-component');
    }
}