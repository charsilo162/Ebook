<div>
    @if(!empty($categories))
     {{-- @php
            dd($categories);
        @endphp --}}
        <x-sections.category-grid :categories="$categories" />
    @else
        {{-- Skeleton loading for categories --}}
        <div class="max-w-7xl mx-auto px-6 py-12 grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach(range(1, 8) as $i)
                <div class="h-44 bg-zinc-100 animate-pulse rounded-xl"></div>
            @endforeach
        </div>
    @endif
</div>