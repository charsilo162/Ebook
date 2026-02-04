<x-layouts.app>
 
<x-hero.content-hero
    image="storage/images/p1.jpg"
    title="Arcane Bookstore"
    subtitle="Children’s Bookshop"
    :meta="[
        '📍 Alausa, Lagos',
        '📞 +234 806 357 4489'
    ]"
    :tags="[
        ['label' => 'Fiction'],
        ['label' => 'Academic'],
        ['label' => 'Violent'],
    ]"
>
    <x-slot:actions>
        <button class="px-6 py-3 bg-purple-600 text-white rounded-md">
            View on Map
        </button>
    </x-slot:actions>
</x-hero.content-hero>



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