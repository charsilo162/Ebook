<?php

namespace App\Livewire\Books;
use Livewire\Component;
use App\Services\ApiService;

class BookPhysicalHero extends Component

    {
        public $bookId;
        public $book;

            public function buyNow(ApiService $api)
            {
            // 1. Get the variant
            $variant = collect($this->book['formats'])
                ->firstWhere('type', $this->book['default_type']);

            // 2. Make the API Call
            $response = $api->post("payments/initialize", [
            'book_id'    => $this->bookId,
            'variant_id' => $variant['id'],
            'type'       => $this->book['default_type'],
            ]);
            // dd($response);
            // 3. Handle Success
            if (isset($response['authorization_url'])) {
            return redirect()->away($response['authorization_url']);
            }

            // 4. Handle Validation Errors from API (422)
            if (isset($response['errors'])) {
            foreach ($response['errors'] as $field => $messages) {
            // This pushes the API error into Livewire's validation bag
            $this->addError($field, $messages[0]);
            }
            return;
            }

            // 5. Handle Generic Errors (500, etc.)
            if (isset($response['error'])) {
            session()->flash('error', $response['error']);
            }
            }
            public function mount($id, ApiService $api)
            {
            $this->bookId = $id;
            $response = $api->get("books/{$id}");
            $this->book = $response['data'] ?? null;

            if ($this->book && !empty($this->book['formats'])) {
            // Determine price based on default_type
            $defaultType = $this->book['default_type'] ?? 'physical';

            $variant = collect($this->book['formats'])
            ->firstWhere('type', $defaultType);

            $this->book['current_price'] = $variant['price'] ?? 0;
            } else {
            $this->book['current_price'] = 0;
            }
            }

            public function render()
            {
                //dd($this->book);
            return view('livewire.books.book-physical-hero');
            }
    }
