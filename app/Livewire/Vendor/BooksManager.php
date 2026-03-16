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
                // Instead of clearing, reload the default list
                $this->loadCategories(); 
                return;
            }

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
                    // 1. First, validate the basics
                    $this->validate([
                        'variants' => 'required|array|min:1',
                        'variants.*.type' => 'required',
                        'variants.*.price' => 'required|numeric|min:0',
                        'variants.*.stock' => 'required_if:variants.*.type,physical',
                        'variants.*.bookshop_id' => 'required_if:variants.*.type,physical',
                    ]);

                    // 2. Now, manually check the digital files for NEW variants only
                    foreach ($this->variants as $index => $variant) {
                        if ($variant['type'] === 'digital') {
                            $isNewVariant = empty($variant['id']);
                            $noFileSelected = empty($variant['file']) || is_string($variant['file']);

                            if ($isNewVariant && $noFileSelected) {
                                $this->addError("variants.$index.file", 'Please upload the e-book file for this new digital variant.');
                                return; // Stop and stay on step 2
                            }
                        }
                    }
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
            $response = $this->api->get('vendor/books?limit=12');
            $books = $response['data'] ?? $response ?? [];
            
                //  dd($books);
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
            // Find the book in the local collection
            $book = collect($this->books)->firstWhere('id', $bookId);
                // dd($book);
            if (!$book) {
                logger("Book not found for ID: " . $bookId);
                return;
            }

            // 1. Ensure the full category list is loaded so the user can reselect
            if (empty($this->categories)) {
                $this->loadCategories();
            }

            // 2. Set the ID (cast to string for HTML select compatibility)
            $this->category_id = (string)($book->category_id ?? $book->category->id ?? $book->category['id'] ?? '');

            // 3. Prevent the "only one category" bug: 
            // Check if the book's current category exists in the loaded list. 
            // If it doesn't (e.g., if it's an old category), add it to the array.
            if (isset($book->category)) {
                $currentCatId = $book->category->id ?? $book->category['id'] ?? null;
                $exists = collect($this->categories)->contains(function ($cat) use ($currentCatId) {
                    return ($cat->id ?? $cat['id']) == $currentCatId;
                });

                if (!$exists) {
                    // We use array_merge or push to keep existing categories 
                    // instead of overwriting the whole list
                    $this->categories[] = $book->category;
                }
            }

            // 4. Fill basic text fields
            $this->title       = $book->title ?? '';
            $this->author_name = $book->author_name ?? $book->author ?? '';
            $this->description = $book->description ?? '';

            // 5. Map variants/formats 
           $this->variants = collect($book->formats ?? $book->variants ?? [])
            ->map(function ($v) {
                // Safety: make sure we work with array (your API returns arrays)
                $variant = is_object($v) ? (array) $v : $v;

                return [
                    'id'             => $variant['id']   ?? null,
                    'type'           => $variant['type'] ?? 'physical',

                    'price'          => (float) ($variant['price'] ?? 0),
                    'discount_price' => (float) ($variant['discount_price'] ?? 0),

                    // Fixed: prioritize the actual key name from your API response
                    'stock'          => (int) ($variant['stock_count'] ?? 
                                            $variant['stock']       ?? 
                                            $variant['quantity']    ?? 
                                            0),

                    'bookshop_id'    => $variant['bookshop_id'] ?? 
                                        $variant['location_id'] ?? 
                                        $variant['store_id']    ?? 
                                        '',

                    'file'           => null
                ];
            })
            ->values()   // re-index array (good practice)
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


// Inside your Livewire Component

public function save()
        {
            // 1. MANUALLY CHECK DIGITAL FILES FIRST
            // This solves the "required during add, optional during edit" logic
            foreach ($this->variants as $index => $variant) {
                if ($variant['type'] === 'digital') {
                    $isNewVariant = empty($variant['id']);
                    $noFileUploaded = empty($variant['file']) || is_string($variant['file']);

                    if ($isNewVariant && $noFileUploaded) {
                        $this->addError("variants.$index.file", 'Please upload the e-book file.');
                        $this->step = 2;
                        return; // Stop here if digital file is missing for a new entry
                    }
                }
            }

            // 2. STANDARD VALIDATION
            // Notice I removed the Closure from here to keep it simple.
            $this->validate([
                'title' => 'required|string|max:255',
                'author_name' => 'required|string|max:255',
                'category_id' => 'required',
                'cover_image' => $this->editingBookId ? 'nullable|image|max:2048' : 'required|image|max:2048',
                'variants' => 'required|array|min:1',
                'variants.*.type' => 'required|string',
                'variants.*.price' => 'required|numeric|min:0',
                
                // Physical specific
                'variants.*.stock' => 'required_if:variants.*.type,physical',
                'variants.*.bookshop_id' => 'required_if:variants.*.type,physical',
                
                // Digital file (Standard rules only, no "required" here)
                'variants.*.file' => 'nullable|file|max:10240', 
            ], [
                'variants.*.type.required' => 'Please select a format type.',
                'variants.*.price.required' => 'Price is required.',
                'variants.*.bookshop_id.required_if' => 'Please select a bookshop location.',
            ]);

            // 3. DUPLICATE CHECK
            $types = collect($this->variants)->pluck('type');
            if ($types->count() !== $types->unique()->count()) {
                $this->addError('variants', 'You cannot have two variants of the same type.');
                $this->step = 2;
                return;
            }

            // 4. BUILD MULTIPART DATA
            $formData = [
                ['name' => 'title',       'contents' => $this->title],
                ['name' => 'author_name',  'contents' => $this->author_name],
                ['name' => 'category_id',  'contents' => $this->category_id],
                ['name' => 'description',  'contents' => $this->description ?? ''],
            ];

            // Cover Image
            if ($this->cover_image && !is_string($this->cover_image)) {
                $formData[] = [
                    'name'     => 'cover_image',
                    'contents' => fopen($this->cover_image->getRealPath(), 'r'),
                    'filename' => $this->cover_image->getClientOriginalName()
                ];
            }

            // 5. PROCESS VARIANTS
            foreach ($this->variants as $index => $variant) {
                if (!empty($variant['id'])) {
                    $formData[] = ['name' => "variants[$index][id]", 'contents' => $variant['id']];
                }

                $formData[] = ['name' => "variants[$index][type]", 'contents' => $variant['type']];
                $formData[] = ['name' => "variants[$index][price]", 'contents' => $variant['price']];
                $formData[] = ['name' => "variants[$index][discount_price]", 'contents' => $variant['discount_price'] ?? 0];

                if ($variant['type'] === 'physical') {
                    $formData[] = ['name' => "variants[$index][stock]", 'contents' => $variant['stock'] ?? 0];
                    $formData[] = ['name' => "variants[$index][bookshop_id]", 'contents' => $variant['bookshop_id'] ?? ''];
                } 
                
                // Digital File Upload logic
                if (isset($variant['file']) && !is_string($variant['file']) && !is_null($variant['file'])) {
                    $formData[] = [
                        'name'     => "variants[$index][file]",
                        'contents' => fopen($variant['file']->getRealPath(), 'r'),
                        'filename' => $variant['file']->getClientOriginalName(),
                        'headers'  => ['Content-Type' => $variant['file']->getMimeType()]
                    ];
                }
            }

            // 6. API CALL
            $response = $this->editingBookId
                ? $this->api->putWithFile("books/{$this->editingBookId}", $formData)
                : $this->api->postWithFile('books', $formData);
            //dd($response);
            // 7. HANDLE ERRORS
            if (isset($response['errors'])) {
                foreach ($response['errors'] as $field => $messages) {
                    $this->addError($field, $messages[0]);
                }
                $this->step = (collect(['title', 'author_name', 'category_id'])->some(fn($f) => $this->getErrorBag()->has($f))) ? 1 : 2;
                return;
            }

            $this->showModal = false;
            $this->resetForm();
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

