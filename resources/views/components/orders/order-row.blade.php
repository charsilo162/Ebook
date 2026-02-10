@props(['order', 'isVendor' => false])

<tr class="border-b border-zinc-100 hover:bg-zinc-50/50 transition">
    <td class="py-4 px-4">
        <div class="flex items-center gap-3">
            <img src="{{ $order['items'][0]['cover_image'] }}" class="w-10 h-14 object-cover rounded shadow-sm">
            <div>
                <p class="text-sm font-bold text-zinc-900">{{ $order['items'][0]['book_title'] }}</p>
                <p class="text-[10px] text-zinc-500 uppercase tracking-widest">Ref: {{ $order['reference'] }}</p>
            </div>
        </div>
    </td>
    
    <td class="py-4 px-4">
        <p class="text-sm text-zinc-700 font-medium">{{ $order['customer']['name'] }}</p>
        <p class="text-xs text-zinc-500">{{ $order['created_at'] }}</p>
    </td>

    <td class="py-4 px-4">
        <span @class([
            'px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider',
            'bg-purple-100 text-purple-700' => $order['status'] !== 'delivered',
            'bg-green-100 text-green-700' => $order['status'] === 'delivered',
        ])>
            {{ $order['status'] }}
        </span>
    </td>

    <td class="py-4 px-4 text-right text-sm font-bold text-zinc-900">
        ₦{{ number_format($order['total_amount']) }}
    </td>

    <td class="py-4 px-4 text-right">
        @if($isVendor && $order['status'] !== 'delivered')
            <div class="flex justify-end gap-2">
                {{-- Dropdown or Quick Action Button --}}
                <button 
                    wire:click="updateStatus({{ $order['id'] }}, 'shipped')"
                    wire:loading.attr="disabled"
                    class="px-3 py-1.5 text-xs font-semibold bg-purple-600 text-white rounded hover:bg-purple-700 transition disabled:opacity-50"
                >
                    Mark Shipped
                </button>
            </div>
        @else
            <a href="{{ route('orders.show', $order['id']) }}" class="text-xs font-semibold text-purple-600 hover:underline">
                View Details
            </a>
        @endif
    </td>
</tr>