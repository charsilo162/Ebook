<div class="max-w-7xl mx-auto px-6 py-10 space-y-8">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-zinc-900">
                Book Management
            </h1>
            <p class="text-sm text-zinc-500">
                Enable or disable books from appearing publicly
            </p>
        </div>
    </div>

    {{-- Flash Message --}}
    @if (session()->has('message'))
        <div class="p-3 text-sm text-green-700 bg-green-100 rounded-lg">
            {{ session('message') }}
        </div>
    @endif

    {{-- Filters --}}
    <div class="flex flex-wrap gap-4 items-center justify-between">

        {{-- Search --}}
        <div class="w-full md:w-1/3">
            <input
                type="text"
                placeholder="Search books..."
                wire:model.live.debounce.400ms="search"
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500 focus:outline-none"
            >
        </div>

        {{-- Status Filter --}}
        <div>
            <select
               
                wire:model.live="statusFilter"
                class="px-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500 focus:outline-none"
            >
                <option value="all">All Books</option>
                <option value="active">Active Only</option>
                <option value="inactive">Disabled Only</option>
            </select>
        </div>
    </div>

    {{-- Books Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">

        @forelse ($books as $book)

            <x-cards.book-card
                wire:key="admin-book-{{ $book['id'] }}"
                :title="$book['title']"
                :price="$book['starting_price']"
                :image="$book['cover_image']"
                :type="$book['default_type']"
                :author="$book['author']"
            >

                <x-slot:footer>
                    <div class="flex items-center justify-between">

                        <span class="text-xs font-medium
                            {{ $book['is_active'] ? 'text-green-600' : 'text-red-500' }}">
                            {{ $book['is_active'] ? 'Active' : 'Disabled' }}
                        </span>

                        <x-ui.toggle-switch
                            :checked="$book['is_active']"
                            wire:click="toggleBook('{{ $book['id'] }}')"
                        />

                    </div>
                </x-slot:footer>

            </x-cards.book-card>

        @empty

            <div class="col-span-full text-center py-20 text-zinc-500">
                No books found.
            </div>

        @endforelse

    </div>

</div>
