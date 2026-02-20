<?php

namespace App\Livewire\Reader;

use Livewire\Component;
use App\Livewire\Settings\SettingsBase;
class Settings extends SettingsBase
{
    public function mount()
    {
        $user = session('user') ?? [];
        $this->mountBase($user); // load shared personal info
    }

    public function updateProfile()
    {
        $this->updateProfileBase(); // only updates personal info
    }

    public function render()
    {
        return view('livewire.reader.settings')->layout('components.layouts.dashboard');
    }
}
