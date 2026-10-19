<?php
namespace App\Livewire\Admin;

use Livewire\Component;
use App\Services\ApiService;

class AffiliateOverview extends Component
{
    public $balances = [];
    public $logs = [];
    public $newRate;
    public $currentRate;

    public function mount(ApiService $api)
    {
        $this->loadData($api);
    }

    public function loadData(ApiService $api)
    {
        // 1. Get all users with balances
        $this->balances = $api->getAffiliateBalances();
        
        // 2. Get the history of all commissions
        $this->logs = $api->getCommissionLogs();
        
        // 3. You can also fetch the current rate here if you add a 'getSettings' method
    }

    public function changeRate(ApiService $api)
    {
        $this->validate(['newRate' => 'required|numeric|min:0|max:100']);
        
        $response = $api->updateCommissionRate($this->newRate);
        
        if (isset($response['message'])) {
            session()->flash('success', $response['message']);
            $this->reset('newRate');
        }
    }

    public function render()
    {
        return view('livewire.admin.affiliate-overview');
    }
}