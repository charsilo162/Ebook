<?php
namespace App\Livewire\Contact;

use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Illuminate\Support\Facades\Mail;

class ContactUs extends Component
{
    public $name = '';
    public $email = '';
    public $message = '';
    public $status = null;
    public $statusType = null; // success | error

    protected $rules = [
        'name' => 'required|string|min:2|max:255',
        'email' => 'required|email',
        'message' => 'required|string|min:10|max:2000',
    ];
public function submit()
{
    $this->validate();

    try {
        Mail::to(config('mail.contact_recipient'))
            ->send(new \App\Mail\ContactUsMail(
                $this->name,
                $this->email,
                $this->message
            ));

        $this->status = 'Your message has been sent successfully!';
        $this->statusType = 'success';

        $this->reset(['name', 'email', 'message']);

    } catch (\Exception $e) {
        Log::info('Contact Us email failed to send: ' . $e->getMessage());
        $this->status = 'Something went wrong. Please try again.';
        $this->statusType = 'error';
    }
}
    public function render()
    {
         return view('livewire.contact.contact-us');
    }
}