<?php
namespace App\Livewire\Vendor;

use Livewire\Component;
use App\Services\ApiService;
use Livewire\WithPagination;

class OrderManagement extends Component
{
    use WithPagination;

    public $filterStatus = ''; // Filter by status (pending, shipped, etc.)

    public function updateStatus($orderId, $newStatus, ApiService $api)
    {
        $response = $api->patch("vendor/orders/{$orderId}/status", [
            'status' => $newStatus
        ]);

        if (isset($response['message'])) {
            session()->flash('success', $response['message']);
        }
    }

  public function render(ApiService $api)
        {
            // 1. Fetch the orders
            $response = $api->get("vendor/orders", [
                'status' => $this->filterStatus,
                'page' => $this->paginators['page'] ?? 1
            ]);

            $orders = $response['data'] ?? [];

            // 2. Prepare Stats Data
            // In a real app, you might get these from a specific /vendor/stats API endpoint
            $stats = [
                'total_earnings' => collect($orders)->sum('total_amount'),
                'pending_count'  => collect($orders)->where('status', 'pending')->count(),
                'shipped_count'  => collect($orders)->where('status', 'shipped')->count(),
            ];

            return view('livewire.vendor.order-management', [
                'orders' => $orders,
                'meta' => $response['meta'] ?? [],
                'stats' => $stats
            ]);
        }
        
}
