@props(['order', 'isVendor' => false])

@php 
    $status = $order['status'] ?? 'pending'; 
@endphp

<tr class="border-b border-zinc-100 hover:bg-zinc-50/50 transition">
    {{-- 1. Book Details --}}
    <td class="py-4 px-4">
        <div class="flex items-center gap-3">
            <img src="{{ $order['items'][0]['cover_image'] ?? 'https://via.placeholder.com/150' }}" 
                 class="w-10 h-14 object-cover rounded shadow-sm">
            <div>
                <p class="text-sm font-bold text-zinc-900">{{ $order['items'][0]['book_title'] ?? 'Unknown Book' }}</p>
                <p class="text-[10px] text-zinc-500 uppercase tracking-widest">Ref: {{ $order['reference'] }}</p>
            </div>
        </div>
    </td>
    @php
        // @if ($order['order_type'] == 'digital')
        // dd($order['order_type'])
    @endphp
    {{-- 2. Customer Details --}}
    <td class="py-4 px-4">
        <p class="text-sm text-zinc-700 font-medium">{{ $order['customer']['name'] }}</p>
        
        <p class="text-xs text-zinc-500">{{ $order['created_at'] }}</p>
    </td>
    <td>
        <p class="text-sm text-zinc-700 font-medium">{{ $order['order_type'] . " copy" }} </p>
    </td>

    {{-- 3. Dynamic Status Badge --}}
    <td class="py-4 px-4">
        <span @class([
            'px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider',
            'bg-zinc-100 text-zinc-700' => $status === 'pending',
            'bg-blue-100 text-blue-700' => $status === 'processing',
            'bg-purple-100 text-purple-700' => $status === 'shipped',
            'bg-green-100 text-green-700' => $status === 'delivered',
            'bg-red-100 text-red-700' => $status === 'cancelled',
        ])>
            {{ $status }}
        </span>
    </td>

    {{-- 4. Amount --}}
    <td class="py-4 px-4 text-right text-sm font-bold text-zinc-900">
        ₦{{ number_format((float)($order['total_amount'] ?? 0), 2) }}
    </td>

    {{-- 5. Vendor Actions --}}
    
    <td class="py-4 px-4 text-right">
        @if ($order['order_type'] != 'digital')
        @if($isVendor)
            <div class="flex justify-end items-center gap-2">
                {{-- Quick Status Selector --}}
                <select 
                    wire:change="updateStatus({{ $order['id'] }}, $event.target.value)"
                    wire:loading.attr="disabled"
                    class="text-xs border-zinc-200 rounded-md py-1 px-2 focus:ring-purple-500 focus:border-purple-500 bg-white shadow-sm"
                >
                    <option value="pending" @selected($status === 'pending')>Pending</option>
                    <option value="processing" @selected($status === 'processing')>Processing</option>
                    <option value="shipped" @selected($status === 'shipped')>Shipped</option>
                    <option value="delivered" @selected($status === 'delivered')>Delivered</option>
                    <option value="cancelled" @selected($status === 'cancelled')>Cancel Order</option>
                </select>

                {{-- Spinner for visual feedback during the API call --}}
                <div wire:loading wire:target="updateStatus({{ $order['id'] }})">
                    <svg class="animate-spin h-4 w-4 text-purple-600" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
            </div>
        @else
            <a href="{{ route('orders.show', $order['id']) }}" class="text-xs font-semibold text-purple-600 hover:underline">
                View Details
            </a>
        @endif
        @endif
    </td>
</tr>