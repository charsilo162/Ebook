<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Services\ApiService;
use Illuminate\Support\Facades\Session;

class Login extends Component
{
    public $email;
    public $password;
    public $remember = false;

    protected ApiService $api;

    public function boot(ApiService $api) 
    { 
        $this->api = $api; 
    }

    public function login()
    {
        // 1. Local Validation
        $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 2. Call the Backend Login Endpoint
        $response = $this->api->post('login', [
            'email' => $this->email,
            'password' => $this->password,
        ]);
           //dd($response);
        // 3. Handle Errors (Invalid Credentials / Validation)
        if (isset($response['message']) && $response['message'] === 'Invalid credentials') {
            $this->addError('email', 'These credentials do not match our records.');
            return;
        }

        if (isset($response['errors'])) {
            foreach ($response['errors'] as $field => $messages) {
                $this->addError($field, $messages[0]);
            }
            return;
        }

        // 4. Success: Store Token and User Data in Session
        if (isset($response['token'])) {
            Session::put('api_token', $response['token']);
            Session::put('user', $response['user']);
            Session::save();

            // 5. Redirect based on role (Vendor vs Reader)
            $userType = $response['user']['type'] ?? null;
                    if ($userType === 'vendor') { 
                        return redirect()->route('dashboard');
                    }else
                    if ($userType === 'admin') { 
                        return redirect()->route('dashboard');
                    }

                    //dd($response['user']['type'] ?? null);
                    return redirect()->route('library.index');
        }
    }

    public function render()
    {
        return view('livewire.auth.login')->layout('layouts.auth');
    }
}