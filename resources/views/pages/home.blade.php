<x-layouts.app>
<x-hero.hero-section>
<livewire:hero-category-tags />
</x-hero.hero-section>

{{-- <x-sections.category-grid
    :categories="[
        ['title' => 'fiction', 'count' => 1000, 'image' => 'storage/images/c1.jpg'],
        ['title' => 'sci-fi', 'count' => 1000, 'image' => 'storage/images/c2.jpg'],
        ['title' => 'academic', 'count' => 1000, 'image' => 'storage/images/c3.jpg'],
        ['title' => 'violent', 'count' => 1000, 'image' => 'storage/images/c4.jpg'],
        ['title' => 'horror', 'count' => 1000, 'image' => 'storage/images/c5.jpg'],
        ['title' => 'business', 'count' => 1000, 'image' => 'storage/images/c6.jpg'],
        ['title' => 'inspirational', 'count' => 1000, 'image' => 'storage/images/c7.jpg'],
        ['title' => 'spiritual', 'count' => 1000, 'image' => 'storage/images/c8.jpg'],
    ]"
/> --}}
{{-- <x-sections.book-showcase
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
/> --}}
<livewire:category.category-grid-manager />
<livewire:books.showcase-manager />
<x-sections.trust-bar
    :items="[
        [
            'title' => 'Free Delivery',
            'description' => 'Get free shipping on all orders above NGN50,000 in Lagos and Abuja.',
            'icon' => 'delivery',
        ],
        [
            'title' => 'Secure Payment',
            'description' => 'Your payments are protected with industry-grade security.',
            'icon' => 'secure',
        ],
        [
            'title' => '24/7 Support',
            'description' => 'Our support team is always available to help you.',
            'icon' => 'support',
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
