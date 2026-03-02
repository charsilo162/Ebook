<?php
namespace App\Livewire\Admin;

use Livewire\Component;
use App\Services\ApiService;
use Livewire\WithPagination;

class UserManagement extends Component
{
    use WithPagination;

    public $search = '';

    /**
     * Resets pagination when searching
     */
    public function updatingSearch()
    {
        $this->resetPage();
    }

    /**
     * Toggles the user active status via ApiService
     */
    public function toggleStatus(ApiService $api, $userId)
    {
        // Sends PATCH request to: /api/admin/users/{id}/toggle
        $response = $api->patch("admin/users/{$userId}/toggle");

        if ($response && isset($response['is_active'])) {
            session()->flash('message', $response['message']);
        } else {
            session()->flash('error', 'Update failed.');
        }
    }

    public function render(ApiService $api)
    {
        // Build the API URL with search
        $url = 'admin/users';
        if (!empty($this->search)) {
            $url .= '?search=' . urlencode($this->search);
        }

        // Fetch data from your API
        $response = $api->get($url);
    //dd($response);
        return view('livewire.admin.user-management', [
            'users' => $response['data'] ?? [],
            'meta'  => $response['meta'] ?? []
        ]);
    }
}