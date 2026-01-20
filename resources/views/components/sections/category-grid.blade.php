@props(['categories'])

<section class="max-w-7xl mx-auto px-6 py-12">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        @foreach ($categories as $category)
            <x-ui.category-card
                :image="$category['image']"
                :title="$category['title']"
                :count="$category['count']"
            />
        @endforeach
    </div>
</section>
