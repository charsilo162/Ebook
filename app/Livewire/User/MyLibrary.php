<?php
namespace App\Livewire\User;

use Livewire\Component;
use App\Services\ApiService;
use Livewire\WithPagination;

class MyLibrary extends Component
{
    use WithPagination;

    public $search = '';

    public function render(ApiService $api)
    {
        // Calling the Backend API we just routed above
        $response = $api->get("library", [
            'search' => $this->search,
            'page' => $this->paginators['page'] ?? 1
        ]);
//dd($response);
        return view('livewire.user.my-library', [
            'items' => $response['data'] ?? [],
            'meta'  => $response['meta'] ?? []
        ]);
    }

    public function downloadBook($libraryId, ApiService $api)
            {
                // The libraryId here should be the ID of the record in user_libraries table
                $response = $api->get("library/{$libraryId}/download");

                if (isset($response['download_url'])) {
                    return redirect()->away($response['download_url']);
                }

                session()->flash('error', 'Could not prepare download.');
            }
}