{{-- 1. Increased max-width and removed mx-auto if you want it strictly left-aligned --}}
<div class="max-w-7xl px-6 py-12 space-y-6">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <h1 class="text-2xl font-bold">Physical Book Orders</h1>
        
        <x-ui.search-input 
            wire:model.live.debounce.300ms="search" 
            placeholder="Search Order Reference..." 
        />
    </div>

    {{-- 2. Added Grid Wrapper: 1 column on mobile, 2 columns on desktop --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        @forelse($orders as $order)
            <div class="bg-white p-6 rounded-2xl border border-zinc-200 shadow-sm flex flex-col justify-between">
                <div>
                    {{-- Header --}}
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h2 class="font-bold text-lg text-zinc-800">Order #{{ $order['reference'] }}</h2>
                            <p class="text-xs text-zinc-500">Ordered: {{ $order['created_at'] }}</p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase 
                            {{ $order['status'] === 'delivered' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                            {{ $order['status'] }}
                        </span>
                    </div>

                    {{-- Progress Bar --}}
                    <div class="mb-8">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-[10px] font-bold text-zinc-400 uppercase">Tracking Progress</span>
                            <span class="text-xs font-bold text-purple-600">{{ $order['progress'] }}%</span>
                        </div>
                        <div class="overflow-hidden h-2 flex rounded bg-zinc-100">
                            <div style="width:{{ $order['progress'] }}%" class="bg-purple-600 transition-all duration-500 shadow-sm"></div>
                        </div>
                    </div>

                    {{-- Items Loop --}}
                    <div class="space-y-4">
                        @foreach($order['items'] as $item)
                        <div class="flex flex-col gap-3 p-4 rounded-xl border border-zinc-50 bg-zinc-50/50">
                            <div class="flex gap-4">
                                <img src="{{ $item['cover_image'] }}" class="w-14 h-20 object-cover rounded-lg shadow-sm">
                                <div class="flex-1">
                                    <h3 class="text-sm font-bold text-zinc-800">{{ $item['title'] }}</h3>
                                    <p class="text-xs text-purple-600 font-semibold mb-2">{{ $item['store_name'] }}</p>
                                    
                                    <div class="space-y-1">
                                        <div class="flex items-center gap-2 text-[11px] text-zinc-500">
                                            <span>📍 {{ $item['shop_address'] }}, {{ $item['shop_city'] }}</span>
                                        </div>
                                        <div class="flex items-center gap-2 text-[11px] text-zinc-500">
                                            <span>📞 {{ $item['shop_phone'] }}</span>
                                        </div>
                                    </div>
                                </div>
                                <p class="font-bold text-zinc-800 text-sm">₦{{ number_format($item['price']) }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Card Footer --}}
                <div class="mt-6 pt-4 border-t border-zinc-100 flex justify-between items-center">
                    <p class="text-sm font-bold text-zinc-500">Total: <span class="text-zinc-900 text-lg">₦{{ number_format($order['total_amount']) }}</span></p>
                    {{-- <a href="/orders/{{ $order['id'] }}" class="px-4 py-2 bg-zinc-900 text-white text-xs font-bold rounded-lg hover:bg-zinc-800 transition-colors">View Details</a> --}}
                </div>
            </div>
        @empty
            {{-- Spans across both columns if empty --}}
            <div class="lg:col-span-2 text-center py-20 bg-zinc-50 rounded-2xl border-2 border-dashed border-zinc-200">
                <p class="text-zinc-500">No physical orders found.</p>
            </div>
        @endforelse
    </div>

    {{-- Grid Ends Above --}}
    
    @if(isset($pagination['last_page']) && $pagination['last_page'] > 1)
    <div class="mt-12 flex items-center justify-between border-t border-zinc-200 pt-6">
        <div class="flex flex-1 justify-between sm:hidden">
            {{-- Mobile Buttons --}}
            <button wire:click="setPage({{ $page - 1 }})" @if($page <= 1) disabled @endif class="relative inline-flex items-center rounded-md border border-zinc-300 bg-white px-4 py-2 text-sm font-medium text-zinc-700 hover:bg-zinc-50 disabled:opacity-50">Previous</button>
            <button wire:click="setPage({{ $page + 1 }})" @if($page >= $pagination['last_page']) disabled @endif class="relative ml-3 inline-flex items-center rounded-md border border-zinc-300 bg-white px-4 py-2 text-sm font-medium text-zinc-700 hover:bg-zinc-50 disabled:opacity-50">Next</button>
        </div>

        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-zinc-700">
                    Showing <span class="font-medium">{{ $pagination['from'] }}</span> to <span class="font-medium">{{ $pagination['to'] }}</span> of <span class="font-medium">{{ $pagination['total'] }}</span> results
                </p>
            </div>
            <div>
                <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                    @foreach($pagination['links'] as $link)
                        @if($link['url'] === null)
                            <span class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-zinc-400 ring-1 ring-inset ring-zinc-300 focus:outline-offset-0">
                                {!! $link['label'] !!}
                            </span>
                        @else
                            <button 
                                wire:click="setPage({{ $link['page'] }})"
                                class="relative inline-flex items-center px-4 py-2 text-sm font-semibold {{ $link['active'] ? 'z-10 bg-purple-600 text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-purple-600' : 'text-zinc-900 ring-1 ring-inset ring-zinc-300 hover:bg-zinc-50 focus:outline-offset-0' }}"
                            >
                                {!! $link['label'] !!}
                            </button>
                        @endif
                    @endforeach
                </nav>
            </div>
        </div>
    </div>
    @endif
</div>
</div>