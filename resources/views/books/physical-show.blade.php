<x-layouts.app>
    {{-- Physical Hero (Specialized for Hardcopy) --}}
    @livewire('book-physical-hero', ['id' => $id])

    {{-- Unique Physical Sections: e.g., Shipping Calculator or Warehouse Info --}}
    <section class="max-w-7xl mx-auto px-6 py-4">
        <div class="bg-zinc-50 p-6 rounded-xl border border-dashed border-zinc-300">
            <h4 class="font-bold text-zinc-900">🚚 Shipping Information</h4>
            <p class="text-sm text-zinc-600">Standard delivery: 3-5 business days.</p>
        </div>
    </section>

    {{-- Shared Author Section --}}
    @livewire('author-books-grid', ['authorName' => $authorName, 'currentBookId' => $id])
</x-layouts.app>