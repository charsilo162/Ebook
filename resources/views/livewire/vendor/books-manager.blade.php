<div>
<section>
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-bold">Your Uploads</h2>

        <button
            wire:click="openModal"
            class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition"
        >
            Upload a book
        </button>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        {{-- @php
            dd($books);
        @endphp --}}
       @forelse ($books as $book)
              
                    <x-book.book-card
                        :book="$book"
                        :showActions="true"
                        onEdit="openModal({{ $book->id }})"
                        onDelete="confirmDelete({{ $book->id }})"
                        wire:key="book-{{ $book->id }}"
                    />
               
            @empty
                <p class="text-zinc-500">No books uploaded yet.</p>
            @endforelse

    </div> 
</section>
    <x-modal wire:model="showModal" maxWidth="xl">
        <h3 class="text-xl font-semibold mb-6">
            {{ $editingBookId ? 'Edit Book' : 'Upload New Book' }}
        </h3>
        
            <form wire:submit.prevent="save" class="space-y-5">

                {{-- ========================= --}}
                {{-- 1. STEPPER HEADER --}}
                {{-- ========================= --}}
                <div class="mb-8">
                    <div class="flex items-center justify-between relative">
                        <div class="w-full absolute top-1/2 h-0.5 bg-zinc-100 -z-0"></div>

                        @foreach(['Details', 'Pricing', 'Review'] as $i => $label)
                            @php $current = $i + 1; @endphp

                            <div class="relative z-10 flex flex-col items-center">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold transition-all duration-300
                                    {{ $step >= $current
                                        ? 'bg-purple-600 text-white shadow-lg shadow-purple-200'
                                        : 'bg-zinc-200 text-zinc-500' }}">

                                    @if($step > $current) ✓ @else {{ $current }} @endif
                                </div>

                                <span class="text-[10px] font-bold mt-1 uppercase tracking-wider
                                    {{ $step >= $current ? 'text-purple-600' : 'text-zinc-400' }}">
                                    {{ $label }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- ========================= --}}
                {{-- STEP 1 : BASIC INFO --}}
                {{-- ========================= --}}
                @if($step == 1)
                <div class="space-y-4 animate-in fade-in slide-in-from-right-4 duration-300">

                    <x-form.input
                        label="Book Title"
                        name="title"
                        wire:model.defer="title" />

                    <x-form.input
                        label="Author Name"
                        name="author_name"
                        wire:model.defer="author_name" />

                    <x-form.input
                        label="Category ID"
                        name="category_id"
                        wire:model.defer="category_id" />

                    <x-form.textarea
                        label="Description"
                        name="description"
                        rows="3"
                        wire:model.defer="description" />

                </div>
                @endif


                {{-- ========================= --}}
                {{-- STEP 2 : VARIANTS --}}
                {{-- ========================= --}}
                @if($step == 2)
                <div class="space-y-4 animate-in fade-in slide-in-from-right-4 duration-300">

                    <div class="flex items-center justify-between">
                        <h4 class="font-medium text-zinc-700">Pricing & Formats</h4>

                        <button
                            type="button"
                            wire:click="addVariant"
                            class="text-xs font-bold text-purple-600 uppercase hover:underline">
                            + Add Format
                        </button>
                    </div>

                    @foreach($variants as $index => $variant)

                    <div class="p-4 bg-zinc-50 rounded-2xl border border-zinc-100 relative space-y-3 shadow-sm">

                        <button
                            type="button"
                            wire:click="removeVariant({{ $index }})"
                            class="absolute top-2 right-2 text-zinc-400 hover:text-red-500 text-xl">
                            ×
                        </button>

                        <div class="grid grid-cols-2 gap-3">

                            {{-- TYPE --}}
                            <x-form.select
                                label="Type"
                                name="variants.{{ $index }}.type"
                                wire:model="variants.{{ $index }}.type">

                                <option value="physical">Physical</option>
                                <option value="digital">Digital</option>

                            </x-form.select>

                            {{-- PRICE --}}
                            <x-form.input
                                type="number"
                                label="Price"
                                name="variants.{{ $index }}.price"
                                wire:model.defer="variants.{{ $index }}.price" />

                        </div>


                        {{-- DIGITAL --}}
                        @if(($variants[$index]['type'] ?? '') === 'digital')

                            <x-form.file
                                label="E-book File (PDF/EPUB)"
                                name="variants.{{ $index }}.file"
                                wire:model="variants.{{ $index }}.file" />

                        @else

                            {{-- STOCK --}}
                            <x-form.input
                                type="number"
                                label="Stock Quantity"
                                name="variants.{{ $index }}.stock"
                                wire:model.defer="variants.{{ $index }}.stock" />

                        @endif

                    </div>

                    @endforeach

                </div>
                @endif


                {{-- ========================= --}}
                {{-- STEP 3 : REVIEW --}}
                {{-- ========================= --}}
                @if($step == 3)

                <div class="space-y-6 animate-in fade-in slide-in-from-right-4 duration-300">

                    {{-- COVER IMAGE --}}
                    <div class="border-2 border-dashed border-purple-200 rounded-3xl p-6 bg-purple-50/30 text-center">

                        <x-form.file
                            label="Book Cover Image"
                            name="cover_image"
                            wire:model="cover_image"
                            class="mx-auto" />

                        @if($cover_image)
                            <div class="mt-4 flex justify-center">
                                <img
                                    src="{{ $cover_image->temporaryUrl() }}"
                                    class="h-32 rounded-lg shadow-lg border-2 border-white">
                            </div>
                        @endif

                    </div>


                    {{-- SUMMARY --}}
                    <div class="bg-zinc-900 rounded-3xl p-6 text-white space-y-3">

                        <h3 class="text-lg font-bold border-b border-zinc-800 pb-2">
                            Final Review
                        </h3>

                        <div class="flex justify-between text-sm">
                            <span class="text-zinc-400">Title:</span>
                            <span>{{ $title }}</span>
                        </div>

                        <div class="flex justify-between text-sm">
                            <span class="text-zinc-400">Author:</span>
                            <span>{{ $author_name }}</span>
                        </div>

                        <div class="pt-2">
                            <p class="text-[10px] font-bold uppercase text-zinc-500 mb-2">
                                Pricing Breakdown
                            </p>

                            @foreach($variants as $v)
                                <div class="flex justify-between text-xs py-1">
                                    <span>{{ ucfirst($v['type']) }} copy:</span>
                                    <span class="text-purple-400 font-bold">
                                        ${{ number_format($v['price'] ?? 0, 2) }}
                                    </span>
                                </div>
                            @endforeach
                        </div>

                    </div>

                </div>
                @endif


                {{-- ========================= --}}
                {{-- FOOTER --}}
                {{-- ========================= --}}
                <div class="flex justify-between items-center pt-6 border-t border-zinc-100">

                    @if($step > 1)
                        <button
                            type="button"
                            wire:click="prevStep"
                            class="text-sm font-bold text-zinc-400 hover:text-zinc-800 transition">
                            ← Back
                        </button>
                    @else
                        <div></div>
                    @endif


                    <div class="flex gap-3">

                        @if($step < 3)

                            <button
                                type="button"
                                wire:click="nextStep"
                                class="px-8 py-2.5 bg-zinc-900 text-white rounded-xl font-bold text-sm shadow-xl hover:bg-black transition">
                                Continue
                            </button>

                        @else

                            <button
                                type="submit"
                                wire:loading.attr="disabled"
                                class="px-8 py-2.5 bg-purple-600 text-white rounded-xl font-bold text-sm shadow-xl hover:bg-purple-700 transition">

                                <span wire:loading.remove>
                                    Upload Book
                                </span>

                                <span wire:loading>
                                    Processing...
                                </span>

                            </button>

                        @endif

                    </div>
                </div>

            </form>

    </x-modal>

<x-modal wire:model="confirmingDelete" maxWidth="md">
    <h3 class="text-lg font-semibold text-zinc-900 mb-4">
        Delete Book
    </h3>

    <p class="text-zinc-600">
        Are you sure you want to delete this book?
        This action cannot be undone.
    </p>

    <div class="flex justify-end gap-3 mt-6">
        <button
            wire:click="$set('confirmingDelete', false)"
            class="px-4 py-2 rounded-lg border"
        >
            Cancel
        </button>

        <button
            wire:click="deleteBook"
            class="px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700"
        >
            Delete
        </button>
    </div>
</x-modal>


</div>
