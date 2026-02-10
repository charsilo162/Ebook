<?php

namespace App\Livewire\Vendor;

use App\Services\ApiService;
use Livewire\Component;

class InventoryManager extends Component
{


public function updateStock($variantId, $newQuantity, ApiService $api)
{
    $response = $api->patch("vendor/variants/{$variantId}/stock", [
        'stock_quantity' => $newQuantity
    ]);

    if (isset($response['message'])) {
        session()->flash('success', $response['message']);
    }
}
    public function render()
    {
        return view('livewire.vendor.inventory-manager');
    }
}
