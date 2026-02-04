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
<x-sections.book-showcase
    :sections="[
        [
            'title' => 'Discount Deals',
            'books' => [
                ['image' => 'storage/images/c11.jpg'],
            ],
        ],
        [
            'title' => 'New arrival',
            'books' => [
                ['image' => 'storage/images/c12.jpg'],
            ],
        ],
        [
            'title' => 'Best selling',
            'books' => [
                ['image' => 'storage/images/c10.jpg'],
            ],
        ],
        [
            'title' => 'Todays Deal',
            'books' => [
                ['image' => 'storage/images/c11.jpg'],
            ],
        ],
    ]"
/>



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