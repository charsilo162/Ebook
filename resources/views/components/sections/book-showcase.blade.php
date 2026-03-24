@props(['sections'])

{{-- <section class="max-w-7xl mx-auto px-6 py-12"> --}}
    <section class="max-w-7xl mx-auto px-6 py-16 bg-gray-50">
    {{-- <div class="grid grid-cols-1 md:grid-cols-4 gap-8"> --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
        @foreach ($sections as $section)
            <x-sections.book-column
                :title="$section['title']"
                :books="$section['books']"
            />
        @endforeach
    </div>
</section>
