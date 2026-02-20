<x-layouts.app>
@php
    $books = [
    [
        'title' => 'Gift A Book',
        'price' => 3500,
        'image' => 'storage/images/c2.jpg',
    ], 
    [
        'title' => 'Lovable A Book',
        'price' => 3500,
        'image' => 'storage/images/c3.jpg',
    ],
    [
        'title' => 'Nearly All The Men In Lagos Are Mad',
        'price' => 6000,
        'image' => 'storage/images/c11.jpg',
    ],
    [
        'title' => 'Small Business, Big Money',
        'price' => 5000,
        'image' => 'storage/images/c12.jpg',
    ],
    [
        'title' => 'Vantage',
        'price' => 10000,
        'image' => 'storage/images/c10.jpg',
        'out_of_stock' => true,
    ],
];

@endphp
    {{-- Filters + Search --}}
    <section class="max-w-7xl mx-auto px-6 pt-10 space-y-6">

        {{-- Category Pills --}}
        <div class="flex flex-wrap gap-3">
            @foreach ([
                ['Fiction', 'pink'],
                ['Sci-fi', 'blue'],
                ['Academic', 'green'],
                ['Violent', 'red'],
                ['Horror', 'zinc'],
                ['Business', 'blue'],
                ['Inspirational', 'green'],
                ['Spiritual', 'pink'],
                ['Educational', 'zinc'],
            ] as [$label, $color])
                <x-ui.pill-button :label="$label" :color="$color" />
            @endforeach
        </div>

        {{-- Search --}}
        <div class="flex justify-center">
            <x-ui.search-input placeholder="Search books, authors..." />
        </div>

    </section>

    {{-- Results --}}
    <section class="max-w-7xl mx-auto px-6 py-10">

        {{-- Header --}}
        <div class="flex items-center gap-4 mb-8">
            <h2 class="text-xl font-semibold text-zinc-900">
                just love
            </h2>
            <span class="text-sm text-zinc-500">
                1982 results
            </span>
        </div>

        {{-- Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">


            @foreach ($books as $book)
                <x-cards.book-card
                    :title="$book['title']"
                    :price="$book['price']"
                    :image="$book['image']"
                    :outOfStock="$book['out_of_stock'] ?? false"
                />
            @endforeach

        </div>

    </section>
<x-sections.site-footer
    :columns="[
        [
            'Corporate Info',
            'Accessibility',
            'Jobs',
            
        ],
        [
            'NBC App',
            'Peacock',
            'Advertise',
            'Closed Captioning',
        ],
        [
           
            'FAQ',
            'Casting',
            'Contact Us',
           
        ],
        [
            'Parental Guidelines and TV Ratings',
            'Video Viewing Policy',
            'Viewer Panel',
            'Shop',
        ],
    ]"
/>

</x-layouts.app>
