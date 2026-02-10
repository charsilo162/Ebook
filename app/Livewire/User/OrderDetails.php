<?php

namespace App\Livewire\User;

use App\Services\ApiService;
use Livewire\Component;

class OrderDetails extends Component
{
   public function render(ApiService $api)
{
    $response = $api->get("orders/{$this->orderId}");
    $order = $response['data'];

    // Map status to progress bar width
    $steps = [
        'pending'    => 25,
        'processing' => 50,
        'shipped'    => 75,
        'delivered'  => 100,
    ];

    return view('livewire.user.order-details', [
        'order' => $order,
        'progress' => $steps[$order['status']] ?? 0
    ]);
}
}
