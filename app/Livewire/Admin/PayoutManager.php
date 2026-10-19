<?php
namespace App\Livewire\Admin;

use Livewire\Component;
use App\Services\ApiService;

class PayoutManager extends Component
{
    public $withdrawals = [];
    public $commission_rate;

    public function mount(ApiService $api)
    {
        $this->loadData($api);
    }

    public function loadData(ApiService $api)
    {
        $response = $api->getAllWithdrawals();
        if (!isset($response['error'])) {
            $this->withdrawals = $response;
        }
        
        // Load current rate (You might need a new API endpoint for this)
        // For now, let's assume it's part of a general settings API
    }

    public function updateStatus($id, $status, ApiService $api)
    {
        $response = $api->updateWithdrawalStatus($id, $status);
        
        if (isset($response['message'])) {
            session()->flash('message', $response['message']);
            $this->loadData($api); // Refresh the list
        }
    }

    public function render()
    {
        return view('livewire.admin.payout-manager');
    }
}