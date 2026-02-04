<?php

namespace App\Livewire\Vendor;

use Livewire\Component;
use App\Services\ApiService;
use Illuminate\Support\Facades\Session;

class Settings extends Component
{
    // Profile Fields
    public $store_name, $bio;
    
    // Modal & Shop Fields
    public $showShopModal = false;
    public $shop_name, $address, $city, $state, $phone;
    
    public $shops = [];
    protected ApiService $api;

    public function boot(ApiService $api) 
    { 
     
        $this->api = $api; 
    }

    public function mount()
    {
        // 1. Fetch profile data
        $response = $this->api->get('vendor/profile');

        if (isset($response['store_name'])) {
            $this->store_name = $response['store_name'];
            $this->bio = $response['bio'];
        }

        $this->loadShops();
    }

    public function loadShops()
    {
         
        $this->shops = $this->api->get('vendor/shops') ?? [];
       //dd($this->shops);
    }

    public function updateProfile()
    {
        $response = $this->api->post('vendor/update-profile', [
            'store_name' => $this->store_name,
            'bio' => $this->bio,
        ]);

        if (isset($response['errors'])) {
            foreach ($response['errors'] as $field => $messages) {
                $this->addError($field, $messages[0]);
            }
            return;
        }

        session()->flash('success', 'Profile updated successfully!');
    }

    public function addShop()
    {
        // 1. Call the API to create the shop
        
        $response = $this->api->post('vendor/shops', [
            'shop_name' => $this->shop_name,
            'address'   => $this->address,
            'city'      => $this->city,
            'state'     => $this->state,
            'phone'     => $this->phone,
        ]);

        if (isset($response['errors'])) {
            foreach ($response['errors'] as $field => $messages) {
                $this->addError('shop_'.$field, $messages[0]);
            }
            return;
        }

        // 2. Reset fields and close modal
        $this->reset(['shop_name', 'address', 'city', 'state', 'phone', 'showShopModal']);
        
        // 3. Refresh list
        $this->loadShops();
        session()->flash('success', 'New branch added successfully!');
    }

    public function render()
    {
        return view('livewire.vendor.settings')->layout('components.layouts.dashboard'); 
    }
}