@props(['sections'])

<section class="max-w-7xl mx-auto px-6 py-12">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
        @foreach ($sections as $section)
            <x-sections.book-column
                :title="$section['title']"
                :books="$section['books']"
            />
        @endforeach
    </div>
</section>
