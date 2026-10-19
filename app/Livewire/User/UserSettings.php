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
    // NEW Bank Fields
    public $bank_name, $account_number, $account_name; 

    protected ApiService $api;

    public function boot(ApiService $api) 
    { 
        $this->api = $api; 
    }

     public function mount()
        {
            $response = $this->api->get('user-profile');
            
            if (isset($response['user'])) {
                $user = $response['user'];
                $this->first_name = $user['first_name'] ?? '';
                $this->last_name = $user['last_name'] ?? '';
                $this->email = $user['email'] ?? '';
                $this->user_phone = $user['phone'] ?? '';
                $this->type = $user['type'] ?? 'user';
                
                // Fill Bank Details
                $this->bank_name = $user['bank_name'] ?? '';
                $this->account_number = $user['account_number'] ?? '';
                $this->account_name = $user['account_name'] ?? '';
                //dump($response);
                $this->store_name = $response['store_name'] ?? '';
                $this->bio = $response['bio'] ?? '';
            }
        }

     public function updateProfile()
        {
            $data = [
                'first_name' => $this->first_name,
                'last_name'  => $this->last_name,
                'email'      => $this->email,
                'phone'      => $this->user_phone,
                'type'       => $this->type,
                'store_name' => $this->store_name,
                'bio'        => $this->bio,
                // Send Bank Details to Backend
                'bank_name'      => $this->bank_name,
                'account_number' => $this->account_number,
                'account_name'   => $this->account_name,
            ];

            $response = $this->api->post('user-profile-update', $data);

            if (isset($response['errors'])) {
                foreach ($response['errors'] as $field => $messages) {
                    $this->addError($field, $messages[0]);
                }
                return;
            }

            // IMPORTANT: Update the Frontend Session so 'auth()->user()' or 'session(user)' is fresh
            $sessionUser = session('user');
            foreach ($data as $key => $value) {
                $sessionUser[$key] = $value;
            }
            session(['user' => $sessionUser]);

            session()->flash('success', 'Profile and Bank details updated!');
        }

    public function render()
        {
                    return view('livewire.user.user-settings')->layout('components.layouts.dashboard'); 
        }
}
