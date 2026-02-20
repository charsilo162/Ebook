<?php

namespace App\Livewire\User;

use App\Services\ApiService;
use Livewire\Component;

class UserSettings extends Component
{
    // Profile Fields
    public $store_name, $bio; 
    public $type;
    public $first_name, $last_name, $email, $user_phone;
    
    protected ApiService $api;

    public function boot(ApiService $api) 
    { 
        $this->api = $api; 
    }

    public function mount()
    {
        // Fetch profile data - assuming a general or user-specific endpoint
        $response = $this->api->get('user-profile');
        //dd($response);
        if (isset($response['user'])) {
            $this->first_name = $response['user']['first_name'] ?? '';
            $this->last_name = $response['user']['last_name'] ?? '';
            $this->email = $response['user']['email'] ?? '';
            $this->user_phone = $response['user']['phone'] ?? '';
            $this->type = $response['user']['type'] ?? 'user';
            $this->store_name = $response['store_name'] ?? '';
            $this->bio = $response['bio'] ?? '';
        }
    }

    public function updateProfile()
    {
        $response = $this->api->post('user-profile-update', [
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

        session()->flash('success', 'Profile updated successfully!');

        if ($this->type === 'vendor') {
            return redirect()->to('/vendor/settings');
        }
    }

    public function render()
    {
                return view('livewire.user.user-settings')->layout('components.layouts.dashboard'); 
    }
}
