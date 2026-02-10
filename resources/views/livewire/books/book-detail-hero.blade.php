<x-hero.content-hero
    :image="$book['cover_image']"
    :title="$book['title']"
    :subtitle="$book['category']['name'] ?? 'Book'"
    :meta="[$book['author'], $book['created_at_year'] ?? '2024']"
    :description="$book['description']"
    :tags="[['label' => $book['category']['name'], 'color' => 'purple']]"
>
  <x-slot:actions>
     <div class="space-y-2">
    <button 
        wire:click="buyNow" 
        wire:loading.attr="disabled"
        class="px-6 py-3 bg-purple-600 text-white rounded-md hover:bg-purple-700 transition flex items-center gap-2"
    >
        <span wire:loading.remove>Buy Now (₦{{ number_format($book['current_price'] ?? 0) }})</span>
        <span wire:loading>Processing...</span>
    </button>

           @error('book_id') <p class="text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
            @error('variant_id') <p class="text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
            @error('type') <p class="text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
            
            {{-- Display Flash Error (Generic) --}}
            @if (session()->has('error'))
                <p class="text-xs text-red-500 font-medium italic">{{ session('error') }}</p>
            @endif
    </div>
</x-slot:actions>
</x-hero.content-hero>
