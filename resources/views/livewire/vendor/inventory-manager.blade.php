<div class="space-y-8">
    {{-- Low Stock Alert --}}
    @php $lowStockCount = collect($variants)->where('stock_quantity', '<=', 5)->count(); @endphp
    
    @if($lowStockCount > 0)
        <div class="bg-amber-50 border-l-4 border-amber-400 p-4 rounded-r-xl">
            <div class="flex items-center">
                <x-heroicon-o-exclamation-triangle class="w-5 h-5 text-amber-400 mr-3" />
                <p class="text-sm text-amber-700">
                    You have <span class="font-bold">{{ $lowStockCount }}</span> items running low on stock!
                </p>
            </div>
        </div>
    @endif

    {{-- Inventory Table --}}
    <div class="bg-white border border-zinc-200 rounded-xl overflow-hidden shadow-sm">
        <table class="w-full text-left border-collapse">
            <thead class="bg-zinc-50 border-b border-zinc-200">
                <tr>
                    <th class="py-4 px-6 text-[10px] font-bold uppercase text-zinc-500">Book Variant</th>
                    <th class="py-4 px-6 text-[10px] font-bold uppercase text-zinc-500">Current Stock</th>
                    <th class="py-4 px-6 text-right text-[10px] font-bold uppercase text-zinc-500">Quick Update</th>
                </tr>
            </thead>
            <tbody>
                @foreach($variants as $variant)
                <tr class="border-b border-zinc-100 last:border-0 hover:bg-zinc-50/50">
                    <td class="py-4 px-6">
                        <div class="flex items-center gap-3">
                            <img src="{{ $variant['book']['cover_image'] }}" class="w-10 h-14 object-cover rounded">
                            <div>
                                <p class="text-sm font-bold">{{ $variant['book']['title'] }}</p>
                                <span class="text-[10px] px-2 py-0.5 bg-zinc-100 rounded-full">{{ $variant['type'] }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="py-4 px-6">
                        <span @class([
                            'text-sm font-bold',
                            'text-red-600' => $variant['stock_quantity'] <= 2,
                            'text-amber-600' => $variant['stock_quantity'] > 2 && $variant['stock_quantity'] <= 5,
                            'text-zinc-900' => $variant['stock_quantity'] > 5,
                        ])>
                            {{ $variant['stock_quantity'] }} units
                        </span>
                    </td>
                    <td class="py-4 px-6 text-right">
                        <div class="flex justify-end items-center gap-2">
                            <input 
                                type="number" 
                                id="stock-{{ $variant['id'] }}"
                                class="w-20 text-xs border-zinc-200 rounded-md focus:ring-purple-600"
                                placeholder="Qty"
                            >
                            <button 
                                onclick="confirmStockUpdate({{ $variant['id'] }})"
                                class="bg-purple-600 text-white p-2 rounded-md hover:bg-purple-700 transition"
                            >
                                <x-heroicon-o-check class="w-4 h-4" />
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>