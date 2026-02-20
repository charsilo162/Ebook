<?php

namespace App\Livewire\Settings;


use Livewire\Component;
use App\Services\ApiService;

abstract class SettingsBase extends Component
{
    public $first_name;
    public $last_name;
    public $email;
    public $user_phone;
    protected ApiService $api;

    public function boot(ApiService $api)
    {
        $this->api = $api;
    }

    public function mountBase($userData)
    {
        $this->first_name = $userData['first_name'] ?? '';
        $this->last_name  = $userData['last_name'] ?? '';
        $this->email      = $userData['email'] ?? '';
        $this->user_phone = $userData['phone'] ?? '';
    }

    public function updateProfileBase()
    {
        $payload = [
            'first_name' => $this->first_name,
            'last_name'  => $this->last_name,
            'email'      => $this->email,
            'phone'      => $this->user_phone,
        ];

        $response = $this->api->post('user/update-profile', $payload);

        if (isset($response['errors'])) {
            foreach ($response['errors'] as $field => $messages) {
                $this->addError($field, $messages[0]);
            }
            return;
        }

        session()->flash('success', 'Profile updated successfully!');
    }
}

