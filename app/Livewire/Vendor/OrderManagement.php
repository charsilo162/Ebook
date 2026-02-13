<?php
namespace App\Livewire\Vendor;

use Livewire\Component;
use App\Services\ApiService;
use Livewire\WithPagination;

class OrderManagement extends Component
{
    use WithPagination;

    public $filterStatus = ''; 

    public function updateStatus($orderId, $newStatus, ApiService $api)
    {
        $response = $api->patch("vendor/orders/{$orderId}/status", [
            'status' => $newStatus
        ]);

        if (isset($response['message'])) {
            // 1. Dispatch browser event for the Toast
            $this->dispatch('notify', [
                'type' => 'success',
                'message' => $response['message']
            ]);
        } else {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => $response['error'] ?? 'Something went wrong'
            ]);
        }
    }

    public function render(ApiService $api)
    {
        $response = $api->get("vendor/orders", [
            'status' => $this->filterStatus,
            'page' => $this->paginators['page'] ?? 1
        ]);

        $orders = $response['data'] ?? [];
        
        // Use the stats directly from the API response (if you implemented the backend fix)
        // Otherwise, calculate from current page
        $stats = $response['stats'] ?? [
            'total_earnings' => collect($orders)->sum('total_amount'),
            'pending_count'  => collect($orders)->where('status', 'pending')->count(),
            'shipped_count'  => collect($orders)->where('status', 'shipped')->count(),
        ];

        return view('livewire.vendor.order-management', [
            'orders' => $orders,
            'meta'   => $response['meta'] ?? [],
            'stats'  => $stats
        ]); 
    }
}
