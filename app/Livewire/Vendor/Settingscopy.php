<?php

namespace App\Livewire\Vendor;

use Livewire\Component;
use App\Services\ApiService;
use Illuminate\Support\Facades\Session;

class Settings extends Component
{
    // Profile Fields
    public $store_name, $bio; 
    public $type;
    public $canEditType = false;
    public $first_name, $last_name, $email, $user_phone;
    // Modal & Shop Fields
    public $showShopModal = false;
    public $editingShopId = null;
    public $shop_name, $address, $city, $state, $phone;
    
    
    public $shops = [];
    protected ApiService $api;

    public function boot(ApiService $api) 
    { 
     
        $this->api = $api; 
    }

    public function mount()
    {
        // Fetch profile data - updated to include user data
        $response = $this->api->get('vendor/profile');
        //dd($response);
        if (isset($response['store_name'])) {
            // Mapping Vendor data
            $this->store_name = $response['store_name'];
            $this->bio = $response['bio'];
            
            // Mapping User data (Assuming your API returns the user relation)
            $this->first_name = $response['user']['first_name'] ?? '';
            $this->type = $response['user']['type'] ?? 'user';
            $this->last_name = $response['user']['last_name'] ?? '';
            $this->email = $response['user']['email'] ?? '';
            $this->user_phone = $response['user']['phone'] ?? '';
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
                    'first_name' => $this->first_name,
                    'last_name'  => $this->last_name,
                    'email'      => $this->email,
                    'phone'      => $this->user_phone,
                    'store_name' => $this->store_name,
                    'type'       => $this->type,
                    'bio'        => $this->bio,
                ]);

                if (isset($response['errors'])) {
                    foreach ($response['errors'] as $field => $messages) {
                        $this->addError($field, $messages[0]);
                    }
                    return;
                }

                session()->flash('success', 'Full profile updated successfully!');
            }
        public function openAddModal()
    {
        $this->reset(['shop_name', 'address', 'city', 'state', 'phone', 'editingShopId']);
        $this->showShopModal = true;
    }

    public function editShop($shopId)
    {
        // Find the shop in our current list
        $shop = collect($this->shops)->firstWhere('id', $shopId);
        
        if ($shop) {
            $this->editingShopId = $shopId;
            $this->shop_name = $shop['shop_name'];
            $this->address = $shop['address'];
            $this->city = $shop['city'];
            $this->state = $shop['state'];
            $this->phone = $shop['phone'];
            $this->showShopModal = true;
        }
    }
    
    public function saveShop()
    {
        $payload = [
            'shop_name' => $this->shop_name,
            'address'   => $this->address,
            'city'      => $this->city,
            'state'     => $this->state,
            'phone'     => $this->phone,
        ];

        // If editingShopId exists, use PUT/PATCH, otherwise use POST
        if ($this->editingShopId) {
            $response = $this->api->put("vendor/shops/{$this->editingShopId}", $payload);
           // dd($response);
        } else {
            $response = $this->api->post('vendor/shops', $payload);
        }

        if (isset($response['errors'])) {
            foreach ($response['errors'] as $field => $messages) {
                $this->addError('shop_'.$field, $messages[0]);
            }
            return;
        }

        $this->reset(['shop_name', 'address', 'city', 'state', 'phone', 'showShopModal', 'editingShopId']);
        $this->loadShops();
        session()->flash('success', $this->editingShopId ? 'Branch updated!' : 'New branch added!');
    }
    public function render()
    {
        return view('livewire.vendor.settings')->layout('components.layouts.dashboard'); 
    }
}