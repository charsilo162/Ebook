<?php
namespace App\Livewire\Auth;

use App\Services\ApiService;
use Livewire\Component;
use Illuminate\Support\Facades\Http;

class ResetPassword extends Component
{
    public $email;
    public $token;
    public $password;
    public $password_confirmation;
    public $message = '';

    public function mount()
    {
        $this->email = request()->query('email');
        $this->token = request()->route('token');
    }

    public function resetPassword()
    {
        $response = (new ApiService())->post('reset-password', [
            'email' => $this->email,
            'token' => $this->token,
            'password' => $this->password,
            'password_confirmation' => $this->password_confirmation,
        ]);

        if ($response['message']) {
            session()->flash('success', 'Password reset successful. You can login now.');
            return redirect()->route('login');
        }

        $this->addError('password', $response->json('message') ?? 'Reset failed');
    }

    public function render()
    {
        return view('livewire.auth.reset-password')
            ->layout('layouts.auth', ['title' => 'Reset Password']);
    }
}
