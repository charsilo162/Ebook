<x-layouts.app>
    <x-hero.content-hero
    image="storage/images/c4.jpg"
    title="Science and The Environmental Advantages"
    subtitle="Engineering"
    :meta="['James Kalu', '2024']"
    description="An exploration of environmental science concepts designed for academic excellence."
    :tags="[
        ['label' => 'Fiction', 'color' => 'pink'],
        ['label' => 'Sci-fi', 'color' => 'blue'],
        ['label' => 'Academic', 'color' => 'green'],
        ['label' => 'Violent', 'color' => 'red'],
    ]"
>
    <x-slot:actions>
        <button class="px-6 py-3 bg-purple-600 text-white rounded-md">
            Buy Now
        </button>
    </x-slot:actions>
</x-hero.content-hero>

@php
$books = [
    [
        'title' => 'Nearly All the Men in Lagos Are Mad',
        'image' => asset('storage/images/c1.jpg'),
        'price' => 6000,
        'deal' => 3000,
        'stock' => true,
    ],
    [
        'title' => 'Small Business, Big Money',
        'image' => asset('storage/images/c2.jpg'),
        'price' => 5000,
        'deal' => 3000,
        'stock' => true,
    ],
    [
        'title' => 'Vantage',
        'image' => asset('storage/images/c3.jpg'),
        'price' => 10000,
        'deal' => 3000,
        'stock' => false,
    ],
    [
        'title' => 'Stay With Me',
        'image' => asset('storage/images/c4.jpg'),
        'price' => 5000,
        'deal' => 3000,
        'stock' => true,
    ],
    [
        'title' => 'Risk and Return',
        'image' => asset('storage/images/c5.jpg'),
        'price' => 3000,
        'deal' => 3000,
        'stock' => false,
    ],
    [
        'title' => 'Fellow Nigerians, It’s All Politics',
        'image' => asset('storage/images/c6.jpg'),
        'price' => 6000,
        'deal' => 3000,
        'stock' => true,
    ],
];
@endphp
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
    @foreach($books as $book)
        <x-ui.book-cards
            :title="$book['title']"
            :image="$book['image']"
            href="#"
            :original-price="$book['price']"
            :deal-price="$book['deal']"
            :out-of-stock="!$book['stock']"
        />
    @endforeach
</div>



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