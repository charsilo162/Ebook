<?php

namespace App\Livewire\Vendor;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Services\ApiService;
use Illuminate\Support\Facades\Log;

class BooksManager extends Component
{
    use WithFileUploads;

    protected ApiService $api;
    public $confirmingDelete = false;
    public $deletingBookId = null;
    public $variants = []; 
    public $step = 1;
    public $totalSteps = 3;
    public $categories = []; 
    public $categorySearch = '';
    public $bookshops = []; 

    public $books = [];

    // Modal state
    public $showModal = false;
    public $editingBookId = null;

    // Form fields
    public $title, $author_name, $category_id, $description;
    public $cover_image;

    public function boot(ApiService $api)
    {
        $this->api = $api;
    }



    public function mount()
        {
            $this->loadBooks();
            $this->loadCategories();
            $this->loadBookshops(); // 2. Load shops on mount
            $this->addVariant();
        }
   
        public function loadBookshops()
                {
                    // Fetch from your BookshopController index route
                    $response = $this->api->get('bookshops');
                    $this->bookshops = $response['data'] ?? $response ?? [];
                }
        public function loadCategories()
        {
            // Assuming your API returns ['data' => [['id' => 1, 'name' => 'Fiction'], ...]]
            $response = $this->api->get('categories');
            
            // Normalize the data (handling potential 'data' wrapper from API)
            $this->categories = $response['data'] ?? $response ?? [];
        }
    public function getFilteredCategoriesProperty()
            {
                // 1. Convert to collection if it isn't one
                $collection = collect($this->categories);

                if (empty($this->categorySearch)) {
                    return $collection;
                }

                $searchTerm = strtolower($this->categorySearch);

                return $collection->filter(function ($category) use ($searchTerm) {
                    // Handle both object and array formats
                    $name = is_array($category) ? ($category['name'] ?? '') : ($category->name ?? '');
                    return str_contains(strtolower($name), $searchTerm);
                });
            }

     public function updatedCategorySearch($value)
            {
                if (strlen($value) < 2) {
                    $this->categories = []; // Don't search for just 1 letter
                    return;
                }

                // Call your API with a search query
                // Endpoint likely looks like: /api/categories?search=fiction
                $response = $this->api->get("categories?search={$value}");
                
                $this->categories = $response['data'] ?? $response ?? [];
            }
        public function nextStep()
            {
                if ($this->step == 1) {
                    $this->validate([
                        'title' => 'required',
                        'author_name' => 'required',
                        'category_id' => 'required',
                    ]);
                }

                if ($this->step == 2) {
                    $this->validate([
                        'variants' => 'required|array|min:1',
                        'variants.*.type' => 'required',
                        'variants.*.price' => 'required|numeric|min:0',
                        'variants.*.stock' => 'required_if:variants.*.type,physical',
                        'variants.*.bookshop_id' => 'required_if:variants.*.type,physical',
                        'variants.*.file' => 'required_if:variants.*.type,digital',
                    ]);
                }

                $this->step++;
            }

        public function prevStep()
        {
            $this->step--;
        }


    public function removeVariant($index)
        {
            unset($this->variants[$index]);
            $this->variants = array_values($this->variants);
        }

        public function updated($propertyName)
                {
                    // If the user changes a type (e.g., variants.0.type)
                    if (str_contains($propertyName, 'variants') && str_ends_with($propertyName, '.type')) {
                        preg_match('/variants\.(\d+)\.type/', $propertyName, $matches);
                        $index = $matches[1];
                        
                        if ($this->variants[$index]['type'] === 'digital') {
                            $this->variants[$index]['stock'] = 0; // Clear stock for digital
                        } else {
                            $this->variants[$index]['file'] = null; // Clear file for physical
                        }
                        
                        // Clear any previous duplicate errors when they change the type
                        $this->resetValidation('variants');
                    }
                }

    public function addVariant()
        {
            if (count($this->variants) >= 2) {
                $this->addError('variants', 'A book can only have one Physical and one Digital format.');
                return;
            }

            $this->variants[] = [
                // 'type' => count($this->variants) === 0 ? 'physical' : ($this->variants[0]['type'] === 'physical' ? 'digital' : 'physical'), 
                'type' => '',
                'price' => 0, // Changed from '' to 0
                'discount_price' => 0, // Changed from '' to 0
                'stock' => 0, 
                'bookshop_id' => '',
                'file' => null
            ];
        }
                // public function addVariant()
                //     {
                //         // Prevent adding more than 2 variants
                //         if (count($this->variants) >= 2) {
                //             $this->addError('variants', 'A book can only have one Physical and one Digital format.');
                //             return;
                //         }

                //         $this->variants[] = [
                //             'type' => count($this->variants) === 0 ? 'physical' : ($this->variants[0]['type'] === 'physical' ? 'digital' : 'physical'), 
                //             'price' => '', 
                //             'discount_price' => '', 
                //             'stock' => 0, 
                //             'file' => null
                //         ];
                //     }
    public function confirmDelete($bookId)
    {
        $this->deletingBookId = $bookId;
        // dd($this->deletingBookId);
        $this->confirmingDelete = true;
    }

    public function deleteBook()
        {
            $response = $this->api->delete("books/{$this->deletingBookId}");

            // 1. Close the modal immediately for better UX
            $this->confirmingDelete = false;

            // 2. Check for errors
            if (isset($response['errors']) || (isset($response['message']) && $response['message'] !== 'Book deleted successfully')) {
                $msg = $response['message'] ?? 'An error occurred';
                session()->flash('error', $msg);
                $this->dispatch('notify', ['type' => 'error', 'message' => $msg]); 
                return;
            }

            // 3. Clear State
            $this->deletingBookId = null;

            // 4. Refresh the data
            $this->loadBooks();
            
            // 5. Success Flash
            session()->flash('success', 'Book deleted successfully.');
            
            // 6. Optional: Trigger a browser event for a toast notification
            $this->dispatch('notify', ['type' => 'success', 'message' => 'Book deleted successfully.']);
        }


    public function loadBooks()
        {
            $response = $this->api->get('books?limit=12');
            $books = $response['data'] ?? $response ?? [];
            

            $this->books = collect($books)
                ->filter(fn ($book) => is_array($book) && isset($book['id']))
                ->map(fn ($book) => (object) $book)
                ->values()
                ->toArray();
        }



        public function openModal($bookId = null)
                {
                
                    $this->resetValidation();
                    $this->resetForm();
                    $this->step = 1; // Always reset to step 1 when opening
                    $this->categorySearch = '';

                    if ($bookId) {
                        $this->editingBookId = $bookId;
                        $this->fillForm($bookId);
                    } else {
                        $this->addVariant(); // Add one default row for new books
                    }

                    $this->showModal = true;
                }

    protected function fillForm($bookId)
        {
            $book = collect($this->books)->firstWhere('id', $bookId);
                if (!$book){
                    logger("Book not found for ID: " . $bookId);
                    return;
                } 

                // 1. Set the ID
                $this->category_id = isset($book->category_id) ? (string)$book->category_id : (string)($book->category->id ?? '');

                // 2. IMPORTANT: If we are editing, we must manually add the current 
                // category to the list so the dropdown can show its name
                if (isset($book->category)) {
                    $this->categories = [$book->category]; 
                }

            $this->title       = $book->title ?? '';
            $this->author_name = $book->author_name ?? $book->author ?? '';
            // $this->category_id = $book->category_id ?? $book->category->id ?? null;
            $this->description = $book->description ?? '';

            // Map existing formats/variants from API → form structure
            $this->variants = collect($book->formats ?? [])
                ->map(function ($v) {
                    return [
                        'id'             => $v->id ?? $v['id'] ?? null,
                        'type'           => $v->type ?? $v['type'] ?? 'physical',
                        'price'          => $v->price ?? $v['price'] ?? 0,
                        'discount_price' => $v->discount_price ?? $v['discount_price'] ?? 0,
                        'stock'          => $v->stock_count ?? $v['stock_quantity'] ?? 0,
                    ];
                })
                ->toArray();
        }

    protected function resetForm()
        {
            $this->reset([
                'title',
                'author_name',
                'category_id',
                'description',
                'cover_image',
                'editingBookId',
            ]);

            $this->variants = [];
        }


    public function save()
        {
            // 1. Local Validation
            $this->validate([
                'title' => 'required|string|max:255',
                'author_name' => 'required|string|max:255',
                'category_id' => 'required',
                'cover_image' => $this->editingBookId ? 'nullable|image|max:2048' : 'required|image|max:2048',
                
                // Variant Specific Validation
                'variants' => 'required|array|min:1',
                'variants.*.type' => 'required|string',
                'variants.*.price' => 'required|numeric|min:0',
                'variants.*.stock' => 'required_if:variants.*.type,physical',
                'variants.*.bookshop_id' => 'required_if:variants.*.type,physical',
                'variants.*.file' => 'required_if:variants.*.type,digital|max:10240',
            ], [
                'variants.*.type.required' => 'Please select a format type.',
                'variants.*.price.required' => 'Price is required.',
                'variants.*.file.required_if' => 'Please upload the e-book file.',
                'variants.*.bookshop_id.required_if' => 'Please select a bookshop location.',
            ]);

            // Check for duplicate types locally before calling API
            $types = collect($this->variants)->pluck('type');
            if ($types->count() !== $types->unique()->count()) {
                $this->addError('variants', 'You cannot have two variants of the same type (e.g., two physical copies).');
                $this->step = 2; 
                return;
            }

            // 2. Build Multipart Data
            $formData = [
                ['name' => 'title',        'contents' => $this->title],
                ['name' => 'author_name',  'contents' => $this->author_name],
                ['name' => 'category_id',  'contents' => $this->category_id],
                ['name' => 'description',  'contents' => $this->description],
            ];

            // 3. Cover Image
            if ($this->cover_image && !is_string($this->cover_image)) {
                $formData[] = [
                    'name'     => 'cover_image',
                    'contents' => fopen($this->cover_image->getRealPath(), 'r'),
                    'filename' => $this->cover_image->getClientOriginalName()
                ];
            }

            // 4. Variants (Crucial Change Here)
            foreach ($this->variants as $index => $variant) {
                // !!! IMPORTANT: If editing, we MUST send the variant ID so the backend 
                // knows this isn't a "new" duplicate variant.
                if (isset($variant['id'])) {
                    $formData[] = ['name' => "variants[$index][id]", 'contents' => $variant['id']];
                }
                  if ($variant['type'] === 'physical' && !empty($variant['bookshop_id'])) {
                            $formData[] = ['name' => "variants[$index][bookshop_id]", 'contents' => $variant['bookshop_id']];
                        }

                $formData[] = ['name' => "variants[$index][type]",           'contents' => $variant['type']];
                $formData[] = ['name' => "variants[$index][price]",          'contents' => $variant['price']];
                $formData[] = ['name' => "variants[$index][discount_price]", 'contents' => $variant['discount_price'] ?? ''];
                $formData[] = ['name' => "variants[$index][stock]",          'contents' => $variant['stock'] ?? 0];

                // E-book file handling
                    if (isset($variant['file']) && !is_string($variant['file'])) {
                        // Determine the MIME type
                        $mimeType = $variant['file']->getMimeType(); // e.g., application/pdf

                        $formData[] = [
                            'name'     => "variants[$index][file]", 
                            'contents' => fopen($variant['file']->getRealPath(), 'r'),
                            'filename' => $variant['file']->getClientOriginalName(),
                           
                            'headers'  => [
                                'Content-Type' => $mimeType
                            ]
                        ];
                    }
            }
           
            // 5. API Call
            $response = $this->editingBookId
                ? $this->api->putWithFile("books/{$this->editingBookId}", $formData)
                : $this->api->postWithFile('books', $formData);
           dd($response);
            // 6. Handle Errors from API
            if (isset($response['errors'])) {
                foreach ($response['errors'] as $field => $messages) {
                    $this->addError($field, $messages[0]);
                }
                
                // Auto-navigate to the step with the error
                if ($this->hasError('title') || $this->hasError('author_name')) {
                    $this->step = 1;
                } else {
                    $this->step = 2;
                }
                return;
            }

            // 7. Success
            $this->showModal = false;
            $this->resetForm();
            $this->step = 1; 
            $this->loadBooks();
            session()->flash('success', 'Book saved successfully!');
        }
     public function render()
            {
                return view('livewire.vendor.books-manager', [
                'books' => $this->books,
            ]);
            
                // ->layout('components.layouts.dashboard');;
            }
}

