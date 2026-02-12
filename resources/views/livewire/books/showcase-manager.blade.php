<div>
    @if(!empty($sections))
        {{-- This calls your existing x-sections.book-showcase component --}}
        <x-sections.book-showcase :sections="$sections" />
    @else
        {{-- A simple loading state while the API fetches --}}
        <div class="max-w-7xl mx-auto px-6 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                @foreach(range(1,4) as $i)
                    <div class="animate-pulse bg-zinc-100 h-64 rounded-xl"></div>
                @endforeach
            </div>
        </div>
    @endif
</div>