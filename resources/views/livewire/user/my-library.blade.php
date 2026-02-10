<div class="max-w-7xl mx-auto px-6 py-10">
    {{-- Header Section --}}
    <div class="flex items-baseline justify-between mb-8">
        <h1 class="text-2xl font-bold text-zinc-900">My Library</h1>
        <span class="text-zinc-500 text-sm">{{ $meta['total'] ?? 0 }} Digital Books</span>
    </div>

    {{-- Books Grid --}}
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
        @forelse($items as $item)
            <x-cards.book-card
                :title="$item['title']"
                :image="$item['cover_image']"
            >
                <x-slot:footer>
                    {{-- 
                        CLEAN LOGIC: Since this is the Library, we assume it's digital.
                        We use 'library_id' directly from your LibraryResource.
                    --}}
                    <button 
                        wire:click="downloadBook('{{ $item['library_id'] }}')"
                        wire:loading.attr="disabled"
                        class="w-full px-4 py-2 text-xs font-bold rounded-md bg-purple-600 text-white hover:bg-purple-700 transition flex items-center justify-center gap-2"
                    >
                        {{-- Download Icon --}}
                        <svg wire:loading.remove class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>

                        {{-- Status Text --}}
                        <span wire:loading.remove>Download PDF</span>
                        <span wire:loading>Preparing...</span>
                    </button>

                    {{-- Optional: Show purchase date below button --}}
                    <p class="text-[10px] text-zinc-400 text-center mt-2">
                        Bought: {{ $item['purchased_at'] }}
                    </p>
                </x-slot:footer>
            </x-cards.book-card>
        @empty
            {{-- Empty State --}}
            <div class="col-span-full py-20 text-center border-2 border-dashed border-zinc-200 rounded-2xl">
                <p class="text-zinc-500 italic">Your library is empty. Your purchased ebooks will appear here.</p>
            </div>
        @endforelse
    </div>
</div>