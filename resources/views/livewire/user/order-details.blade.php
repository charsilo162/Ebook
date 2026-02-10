<div class="max-w-3xl mx-auto px-6 py-12">
    <div class="bg-white p-8 rounded-2xl border border-zinc-200 shadow-sm">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-xl font-bold">Order #{{ $order['reference'] }}</h1>
                <p class="text-sm text-zinc-500">Placed on {{ $order['created_at'] }}</p>
            </div>
            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider 
                {{ $order['status'] === 'delivered' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                {{ $order['status'] }}
            </span>
        </div>

        {{-- Progress Bar --}}
        <div class="relative pt-1 mb-10">
            <div class="flex mb-2 items-center justify-between">
                <div class="text-xs font-semibold text-zinc-600">Delivery Progress</div>
                <div class="text-right text-xs font-semibold text-purple-600">{{ $progress }}%</div>
            </div>
            <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-zinc-100">
                <div style="width:{{ $progress }}%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-purple-600 transition-all duration-500"></div>
            </div>
            
            {{-- Status Labels --}}
            <div class="flex justify-between text-[10px] font-bold text-zinc-400 uppercase">
                <span class="{{ $progress >= 25 ? 'text-purple-600' : '' }}">Ordered</span>
                <span class="{{ $progress >= 50 ? 'text-purple-600' : '' }}">Processing</span>
                <span class="{{ $progress >= 75 ? 'text-purple-600' : '' }}">Shipped</span>
                <span class="{{ $progress >= 100 ? 'text-purple-600' : '' }}">Delivered</span>
            </div>
        </div>

        {{-- Item Info --}}
        <div class="flex gap-4 border-t border-zinc-100 pt-6">
            <img src="{{ $order['book']['cover_image'] }}" class="w-20 h-28 object-cover rounded-lg">
            <div>
                <h3 class="font-bold">{{ $order['book']['title'] }}</h3>
                <p class="text-sm text-zinc-500">Quantity: 1</p>
                <p class="text-lg font-bold mt-2">₦{{ number_format($order['total_amount']) }}</p>
            </div>
        </div>
    </div>
</div>