<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\ApiService;

class AffiliateDashboard extends Component
{
    public $stats = [];

    // Form Properties
    public $amount;
    public $bank_name;
    public $account_number;
    public $account_name;

 public $hasBankDetails = false; // New property

public function mount(ApiService $api)
{
    $this->loadStats($api);
    $user = session('user');
    //dump($user);
    if ($user) {
        $this->bank_name = $user['bank_name'] ?? null;
        $this->account_number = $user['account_number'] ?? null;
        $this->account_name = $user['account_name'] ?? null;

        // If all three exist, set this to true
        if ($this->bank_name && $this->account_number && $this->account_name) {
            $this->hasBankDetails = true;
        }
    }
}

    public function loadStats(ApiService $api)
    {
        $response = $api->getAffiliateStats();
        if (!isset($response['error'])) {
            //dump($response);
            $this->stats = $response;
        }
    }

    public function withdrawMoney(ApiService $api)
    {
        $this->validate([
            'amount' => 'required|numeric|min:1000',
            'bank_name' => 'required|string',
            'account_number' => 'required|digits:10',
            'account_name' => 'required|string',
        ]);

        $data = [
            'amount' => $this->amount,
            'bank_name' => $this->bank_name,
            'account_number' => $this->account_number,
            'account_name' => $this->account_name,
        ];

        $response = $api->requestWithdrawal($data);

        if (isset($response['error']) && $response['error'] === true) {
            session()->flash('error', $response['message'] ?? 'Withdrawal failed.');
        } else {
            // SUCCESS logic

            // 1. Update the manual session so the new bank details are remembered
            $user = session('user');
            $user['bank_name'] = $this->bank_name;
            $user['account_number'] = $this->account_number;
            $user['account_name'] = $this->account_name;
            session(['user' => $user]);

            session()->flash('success', $response['message'] ?? 'Request submitted!');

            // 2. Reset only the amount (keep bank details visible for the next time)
            $this->reset(['amount']);
            $this->loadStats($api);
        }
    }

    public function render()
    {
        return view('livewire.affiliate-dashboard');
    }
}
