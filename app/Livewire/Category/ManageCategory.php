<?php
namespace App\Livewire\Category;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Services\ApiService;
use Livewire\Attributes\Url; 

class ManageCategory extends Component
{
    use WithFileUploads;

    public $categories = [];
    public $name, $thumbnail, $editingCategoryId;
    public $isModalOpen = false;

    // Search and Pagination properties

    

        #[Url(history: true)] 
    public $search = '';

    #[Url]
    public $page = 1;
    public $paginationLinks = [];
    public $paginationMeta = [];

    // Reset pagination when the search query changes
    public function updatedSearch()
    {
        $this->page = 1;
    }

    public function setPage($page)
    {
        $this->page = $page;
        
    }

    public function openModal($id = null)
    {
        $this->resetInputFields();
        if ($id) {
            $this->editingCategoryId = $id;
            $category = collect($this->categories)->firstWhere('id', $id);
            $this->name = $category['name'];
        }
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetInputFields();
    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->thumbnail = null;
        $this->editingCategoryId = null;
    }

    public function save(ApiService $api)
    {
        $this->validate([
            'name' => 'required|string|max:100',
            'thumbnail' => 'nullable|image|max:2048',
        ]);

        $formData = [['name' => 'name', 'contents' => $this->name]];

        if ($this->thumbnail && !is_string($this->thumbnail)) {
            $formData[] = [
                'name'     => 'thumbnail',
                'contents' => fopen($this->thumbnail->getRealPath(), 'r'),
                'filename' => $this->thumbnail->getClientOriginalName(),
                'headers'  => ['Content-Type' => $this->thumbnail->getMimeType()]
            ];
        }

        try {
            $response = $this->editingCategoryId
                ? $api->putWithFile("categories/{$this->editingCategoryId}", $formData)
                : $api->postWithFile('categories', $formData);

            if (isset($response['errors'])) {
                foreach ($response['errors'] as $field => $messages) {
                    $this->addError($field, $messages[0]);
                }
                return;
            }

            $this->closeModal();
            session()->flash('message', 'Category saved successfully!');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function deleteCategory(ApiService $api, $id)
    {
        $api->delete("categories/{$id}");
        session()->flash('message', 'Category deleted.');
    }

public function render(ApiService $api)
{
    // Define parameters as an associative array
    $params = [
        'page' => $this->page,
        'with_count' => 1 // If you want book counts
    ];

    if (!empty($this->search)) {
        $params['search'] = $this->search;
    }

    // Pass the endpoint and the array separately
    $response = $api->get('categories', $params);
    
    $this->categories = $response['data'] ?? [];
    $this->paginationLinks = $response['links'] ?? [];
    $this->paginationMeta = $response['meta'] ?? [];

    return view('livewire.category.manage-category');
}
}
