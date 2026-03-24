<?php

namespace App\Livewire\Auth;

use App\Services\ApiService;
use Livewire\Component;
use Illuminate\Support\Facades\Http;

class ForgotPassword extends Component
{
    public $email = '';
    public $successMessage = '';

    protected $rules = [
        'email' => 'required|email',
    ];

    public function sendLink()
    {
        $this->validate();

       $response = (new ApiService())->post('forgot-password', [
         'email' => $this->email,
                ]);

                if (isset($response['message'])) {
                    $this->successMessage = $response['message'];
                } else {
                    $this->addError('email', 'Something went wrong');
                }

    }

    public function render()
    {
        return view('livewire.auth.forgot-password')
            ->layout('layouts.auth', ['title' => 'Forgot Password']);
    }
}
