<?php

namespace App\Livewire\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Services\ApiService;
use Illuminate\Support\Facades\Session;

class UnifiedSignup extends Component
{
    use WithFileUploads;

    // Toggle State
    public string $role = 'user'; // 'user' (Reader) or 'vendor' (Sellers)

    // Common Fields
    public $first_name, $last_name, $email, $phone, $password, $photo;

    // Vendor Specific Fields
    public $store_name, $bio;

    protected ApiService $api;

    public function boot(ApiService $api) 
    { 
        $this->api = $api; 
    }

    public function mount()
    {
        // Check if user is already logged in
        if (Session::has('api_token')) {
            return redirect()->route('dashboard');
        }
    }

    public function setRole($role)
    {
        $this->role = $role;
        $this->resetValidation();
    }

    private function validationRules() 
    {
        $rules = [
            'first_name' => 'required|string|max:50',
            'last_name'  => 'required|string|max:50',
            'email'      => 'required|email',
            'password'   => 'required|min:8',
        ];

        if ($this->role === 'vendor') {
            $rules['store_name'] = 'required|string|min:3';
            $rules['bio']        = 'nullable|string|max:500';
        }

        return $rules;
    }

    public function signup()
    {
        $this->validate($this->validationRules());

        // Build Multipart Payload
        $payload = [
            ['name' => 'first_name', 'contents' => $this->first_name],
            ['name' => 'last_name',  'contents' => $this->last_name],
            ['name' => 'email',      'contents' => $this->email],
            ['name' => 'password',   'contents' => $this->password],
            ['name' => 'role',       'contents' => $this->role],
        ];

        // Add Vendor specific data if applicable
        if ($this->role === 'vendor') {
            $payload[] = ['name' => 'store_name', 'contents' => $this->store_name];
            $payload[] = ['name' => 'bio',        'contents' => $this->bio];
        }

        // Handle Photo Upload to API
        if ($this->photo) {
            $payload[] = [
                'name'     => 'photo',
                'contents' => fopen($this->photo->getRealPath(), 'r'),
                'filename' => $this->photo->getClientOriginalName(),
            ];
        }

        $response = $this->api->postWithFile('register', $payload);

        if (isset($response['errors'])) {
            foreach ($response['errors'] as $field => $messages) {
                $this->addError($field, $messages[0]);
            }
            return;
        }

        // Success: Set Session and Redirect
        if (isset($response['access_token'])) {
            Session::put('api_token', $response['access_token']);
            Session::put('user', $response['user']);

            // Redirect based on whether they have a vendor profile
           $userType = $response['user']['type'] ?? null;

            if ($userType === 'vendor') {
                return redirect()->route('dashboard');
            }

            return redirect()->route('library.index');
        }
    }

    public function render()
    {
        return view('livewire.auth.unified-signup')->layout('layouts.auth');
    }
}