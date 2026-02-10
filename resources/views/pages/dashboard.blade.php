<x-layouts.dashboard title="Dashboard">
    <div class="max-w-7xl mx-auto px-4 py-6 space-y-10">
        <livewire:stats.stats-component />
        <livewire:books.popular-books-component />

        {{-- ================== STATS OVERVIEW (REUSED) ================== --}}
      
        {{-- ================== POPULAR BOOKS ================== --}}
        {{-- <section>
            <h2 class="text-lg font-bold mb-4">
                Popularly Patronized
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach (range(1, 8) as $i)
                    <x-book.book-card
                        :book="(object)[
                            'title' => 'Software Engineering',
                            'author' => 'Ian Sommerville',
                            'price' => 12000,
                            'format' => 'soft copy',
                            'cover_url' => asset('storage/images/d2.jpg'),
                        ]"
                    />
                @endforeach
            </div>
        </section> --}}

        {{-- ================== YOUR UPLOADS ================== --}}
        <section>
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-bold">
                    Your Uploads
                </h2>

                <a
                    href="#"
                    class="px-4 py-2 bg-purple-600 text-white rounded-lg
                           hover:bg-purple-700 transition"
                >
                    Upload a book
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach (range(1, 6) as $i)
                    <x-book.book-card
                        :showActions="true"
                        :book="(object)[
                            'title' => 'Fundamentals of Software Engineering',
                            'author' => 'Ian Sommerville',
                            'price' => 15000,
                            'format' => 'hard copy',
                            'cover_url' => asset('storage/images/d1.jpg'),
                        ]"
                    />
                @endforeach
            </div>
        </section>

        <livewire:vendor.books-manager />

    </div> 

</x-layouts.dashboard>
