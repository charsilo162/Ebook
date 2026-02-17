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


<div>
    @if (session()->has('success'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
            {{ session('error') }}
        </div>
    @endif

    </div>


    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        {{-- @php
            dd($books);
        @endphp --}}
    @forelse ($books as $book)
            <x-book.book-card
                :book="$book"
                :showActions="true"
                {{-- ADD SINGLE QUOTES AROUND THE ID BELOW --}}
                onEdit="openModal('{{ $book->id }}')"
                onDelete="confirmDelete('{{ $book->id }}')"
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

                   <div class="space-y-1">
            <label class="block text-xs font-bold uppercase tracking-wide text-zinc-600">
                Category
            </label>
    
            <div class="rounded-xl border border-zinc-200 bg-white p-2 shadow-sm focus-within:ring-2 focus-within:ring-purple-200 focus-within:border-purple-500 transition">
                {{-- Search Input - styled to look like a header --}}
                <div class="relative mb-2">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-3 h-3 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input 
                        type="text" 
                        wire:model.live="categorySearch" 
                        placeholder="Type to filter..." 
                        class="w-full rounded-lg border-none bg-zinc-50 pl-8 py-1.5 text-xs focus:ring-0"
                    >
                </div> 

                {{-- The actual Select - border removed to blend in --}}
                <select
                    wire:model.defer="category_id"
                    class="w-full border-none p-0 text-sm focus:ring-0 cursor-pointer bg-transparent"
                    size="5" {{-- Makes it look more like a dropdown list --}}
                >
                    <option value="" class="py-1">Select a Category</option>
                    @forelse($this->filteredCategories as $category)
                        @php 
                            $catId = is_array($category) ? $category['id'] : $category->id;
                            $catName = is_array($category) ? $category['name'] : $category->name;
                        @endphp
                        <option value="{{ $catId }}" class="py-1 px-2 hover:bg-purple-50 rounded">
                            {{ $catName }}
                        </option>
                    @empty
                        <option disabled>No categories found...</option>
                    @endforelse
                </select>
            </div>
            @error('category_id') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
        </div>

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
                            @php
                            $hasPhysical = collect($variants)->contains('type', 'physical');
                            $hasDigital = collect($variants)->contains('type', 'digital');
                            $canAddMore = count($variants) < 2;
                        @endphp
                        {{-- Show duplicate error message here --}}
                        @error('variants')
                            <span class="text-xs text-red-500 font-medium">
                                {{ $message }}
                            </span>
                        @enderror
                        @if($canAddMore)
                            <button type="button" wire:click="addVariant" class="text-xs font-bold text-purple-600 uppercase hover:underline">
                                + Add Format
                            </button>
                        @else
                            <span class="text-[10px] text-zinc-400 italic">Maximum formats reached (Physical & Digital)</span>
                        @endif
                    </div>

                 @foreach($variants as $index => $variant)
                        <div class="p-4 bg-zinc-50 rounded-2xl border border-zinc-100 relative space-y-3 shadow-sm">
                            {{-- Remove Button --}}
                            <button type="button" wire:click="removeVariant({{ $index }})"
                                class="absolute top-2 right-2 text-zinc-400 hover:text-red-500 text-xl leading-none">
                                &times;
                            </button>

                            <div class="grid grid-cols-2 gap-3">
                                {{-- TYPE SELECTION --}}
                                @php
                                    $usedTypes = collect($variants)->pluck('type')->filter()->toArray();
                                @endphp

                                <x-form.select 
                                    label="Format Type" 
                                    name="variants.{{ $index }}.type" 
                                    wire:model.live="variants.{{ $index }}.type"
                                >
                                    <option value="">-- Choose Format --</option>
                                    
                                    {{-- Physical Option --}}
                                    <option value="physical" 
                                        @if(in_array('physical', $usedTypes) && ($variants[$index]['type'] ?? '') !== 'physical') disabled @endif>
                                        Physical (Hardcover) @if(in_array('physical', $usedTypes) && ($variants[$index]['type'] ?? '') !== 'physical') (Added) @endif
                                    </option>

                                    {{-- Digital Option --}}
                                    <option value="digital" 
                                        @if(in_array('digital', $usedTypes) && ($variants[$index]['type'] ?? '') !== 'digital') disabled @endif>
                                        Digital (E-Book) @if(in_array('digital', $usedTypes) && ($variants[$index]['type'] ?? '') !== 'digital') (Added) @endif
                                    </option>
                                </x-form.select>

                                {{-- PRICE (Only shows if a type is selected) --}}
                                <div @if(empty($variants[$index]['type'])) class="opacity-50 pointer-events-none" @endif>
                                    <x-form.input 
                                        type="number" 
                                        label="Price" 
                                        name="variants.{{ $index }}.price" 
                                        wire:model.defer="variants.{{ $index }}.price" 
                                        placeholder="0.00" />
                                </div>
                            </div>

                            {{-- CONDITIONAL FIELDS BASED ON TYPE --}}
                            @if(($variants[$index]['type'] ?? '') === 'digital')
                                <div class="mt-2 p-3 bg-white rounded-xl border border-zinc-200 animate-in fade-in zoom-in-95 duration-200">
                                    <label class="text-xs font-bold text-zinc-500 uppercase">Upload E-book (PDF/EPUB)</label>
                                    <input type="file" wire:model="variants.{{ $index }}.file" class="block w-full text-xs mt-1 file:mr-4 file:py-1 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100">
                                    @error("variants.$index.file") <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                                </div>

                            @elseif(($variants[$index]['type'] ?? '') === 'physical')
                                <div class="grid grid-cols-2 gap-3 mt-2 animate-in fade-in zoom-in-95 duration-200">
                                    <x-form.input 
                                        type="number" 
                                        label="Stock" 
                                        name="variants.{{ $index }}.stock" 
                                        wire:model.defer="variants.{{ $index }}.stock" />

                                    <x-form.select 
                                        label="Bookshop" 
                                        name="variants.{{ $index }}.bookshop_id" 
                                        wire:model.defer="variants.{{ $index }}.bookshop_id"
                                    >
                                        <option value="">Select Location</option>
                                        @foreach($bookshops as $shop)
                                            <option value="{{ $shop['id'] ?? $shop->id }}">
                                                {{ $shop['shop_name'] ?? $shop->shop_name }} ({{ $shop['city'] ?? $shop->city }})
                                            </option>
                                        @endforeach
                                    </x-form.select>
                                </div>
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
                                    ${{ number_format((float)($v['price'] ?? 0), 2) }}                                    </span>
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
    <div class="p-6">
        <h3 class="text-lg font-semibold text-zinc-900 mb-2">
            Delete Book
        </h3>
        
        <p class="text-sm text-zinc-500 mb-6">
            Are you sure you want to delete this book? This action cannot be undone and all associated files will be removed.
        </p>

        <div class="flex justify-end gap-3">
            <button 
                type="button" 
                wire:click="$set('confirmingDelete', false)" 
                class="px-4 py-2 text-sm font-bold text-zinc-500 hover:text-zinc-700 transition"
            >
                Cancel
            </button>

            <button 
                type="button" 
                wire:click="deleteBook" 
                wire:loading.attr="disabled"
                class="px-6 py-2 bg-red-600 text-white rounded-xl font-bold text-sm shadow-lg hover:bg-red-700 transition disabled:opacity-50"
            >
                <span wire:loading.remove wire:target="deleteBook">Yes, Delete Book</span>
                <span wire:loading wire:target="deleteBook">Deleting...</span>
            </button>
        </div>
    </div>
</x-modal>

</div>
