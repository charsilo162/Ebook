<?php

namespace App\Livewire\Vendor;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Services\ApiService;

class BooksManager extends Component
{
    use WithFileUploads;

    protected ApiService $api;
    public $confirmingDelete = false;
    public $deletingBookId = null;
    public $variants = []; 
    public $step = 1;
    public $totalSteps = 3;

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
            $this->addVariant(); // Starts with one variant row
        }
   


   public function nextStep()
        {
            if ($this->step == 1) {
                $this->validate([
                    'title' => 'required|string',
                    'author_name' => 'required',
                    'category_id' => 'required',
                ]);
            }
            if ($this->step == 2 && empty($this->variants)) {
                $this->addError('variants', 'Please add at least one format.');
                return;
            }
            $this->step++;
        }

        public function prevStep()
        {
            $this->step--;
        }

        public function addVariant()
        {
            $this->variants[] = [
                'type' => 'physical', 
                'price' => '', 
                'discount_price' => '', 
                'stock' => 0, 
                'file' => null
            ];
        }
    public function removeVariant($index)
        {
            unset($this->variants[$index]);
            $this->variants = array_values($this->variants);
        }
    public function confirmDelete($bookId)
    {
        $this->deletingBookId = $bookId;
        $this->confirmingDelete = true;
    }

    public function deleteBook()
    {
        $this->api->delete("books/{$this->deletingBookId}");

        $this->confirmingDelete = false;
        $this->deletingBookId = null;

        $this->loadBooks();
        session()->flash('success', 'Book deleted successfully.');
    }

    // public function loadBooks()
    // {
    //     $this->books = $this->api->get('books?limit=12') ?? [];
    //     //dd($this->books);
    // }

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

            if (!$book) {
                return;
            }

            $this->title       = $book->title ?? '';
            $this->author_name = $book->author_name ?? $book->author ?? '';
            $this->category_id = $book->category_id ?? $book->category->id ?? null;
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
                'editingBookId'
            ]);
        }

    public function save()
        {
            //dd('yes');
            // 1. Validation
            $this->validate([
                'title' => 'required|string|max:255',
                'author_name' => 'required|string|max:255',
                'category_id' => 'required',
                'variants' => 'required|array|min:1',
                'variants.*.price' => 'required|numeric|min:0',
                'cover_image' => $this->editingBookId ? 'nullable|image|max:2048' : 'required|image|max:2048',
            ]);

            // 2. Transform standard data into your ApiService's Multipart Format
            $formData = [
                ['name' => 'title',        'contents' => $this->title],
                ['name' => 'author_name',  'contents' => $this->author_name],
                ['name' => 'category_id',  'contents' => $this->category_id],
                ['name' => 'description',  'contents' => $this->description],
            ];

            // 3. Add Cover Image as a File Resource
            if ($this->cover_image && !is_string($this->cover_image)) {
                $formData[] = [
                    'name'     => 'cover_image',
                    'contents' => fopen($this->cover_image->getRealPath(), 'r'),
                    'filename' => $this->cover_image->getClientOriginalName()
                ];
            }
            // dd('yes');
            // 4. Add Nested Variants (Pricing, Type, and E-book files)
            foreach ($this->variants as $index => $variant) {
                $formData[] = ['name' => "variants[$index][type]",           'contents' => $variant['type']];
                $formData[] = ['name' => "variants[$index][price]",          'contents' => $variant['price']];
                $formData[] = ['name' => "variants[$index][discount_price]", 'contents' => $variant['discount_price'] ?? ''];
                // $formData[] = ['name' => "variants[$index][stock_quantity]", 'contents' => $variant['stock'] ?? 0];
                $formData[] = ['name' => "variants[$index][stock]", 'contents' => $variant['stock'] ?? 0];
                // If it's a digital book and a file was uploaded in Step 2
                    if (isset($variant['file']) && !is_string($variant['file'])) {
                        $formData[] = [
                            // Ensure this string matches exactly: variants.index.file
                            'name'     => "variants[$index][file]", 
                            'contents' => fopen($variant['file']->getRealPath(), 'r'),
                            'filename' => $variant['file']->getClientOriginalName()
                        ];
                    }
                // if (isset($variant['file']) && !is_string($variant['file'])) {
                //     $formData[] = [
                //         'name'     => "variants[$index][file]",
                //         'contents' => fopen($variant['file']->getRealPath(), 'r'),
                //         'filename' => $variant['file']->getClientOriginalName()
                //     ];
                // }
            }

            // 5. API Call using your existing service methods
            $response = $this->editingBookId
                ? $this->api->putWithFile("books/{$this->editingBookId}", $formData)
                : $this->api->postWithFile('books', $formData);
              //  dd( $response);
            // 6. Handle Errors
            if (isset($response['errors'])) {
                foreach ($response['errors'] as $field => $messages) {
                    $this->addError($field, $messages[0]);
                }
                
                // Jump back to the step that has the error
                if ($this->hasError('title') || $this->hasError('author_name')) {
                    $this->step = 1;
                } elseif (collect($this->getErrorBag()->keys())->contains(fn($key) => str_contains($key, 'variants'))) {
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

