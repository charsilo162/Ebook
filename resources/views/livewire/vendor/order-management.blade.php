<div class="max-w-6xl mx-auto px-4 py-10">
    
    {{-- Header Section --}}
    <div class="mb-10">
        <h1 class="text-2xl font-bold text-zinc-900">Vendor Dashboard</h1>
        <p class="text-zinc-500 text-sm">Overview of your book sales and fulfillment.</p>
    </div>

    {{-- Stats Bar --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        {{-- Total Revenue --}}
        <x-ui.stat-card 
            label="Total Earnings" 
            value="₦{{ number_format($stats['total_earnings']) }}" 
            icon="banknotes" 
            color="purple" 
        />

        {{-- Pending Shipments --}}
        <x-ui.stat-card 
            label="Pending Shipments" 
            value="{{ $stats['pending_count'] }}" 
            icon="clock" 
            color="orange" 
        />

        {{-- Completed Deliveries --}}
        <x-ui.stat-card 
            label="Successful Shipments" 
            value="{{ $stats['shipped_count'] }}" 
            icon="truck" 
            color="green" 
        />
    </div>

    {{-- Orders Management Section --}}
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-bold text-zinc-900">Recent Orders</h2>
        
        {{-- Filter Dropdown --}}
        <select wire:model.live="filterStatus" class="text-sm border-zinc-200 rounded-lg focus:ring-purple-600 focus:border-purple-600">
            <option value="">All Statuses</option>
            <option value="pending">Pending</option>
            <option value="processing">Processing</option>
            <option value="shipped">Shipped</option>
            <option value="delivered">Delivered</option>
        </select>
    </div>

    {{-- Table Container --}}
    <div class="bg-white border border-zinc-200 rounded-xl overflow-hidden shadow-sm">
        <table class="w-full text-left border-collapse">
            <thead class="bg-zinc-50 border-b border-zinc-200">
                <tr>
                    <th class="py-4 px-4 text-[10px] font-bold uppercase tracking-widest text-zinc-500">Book Details</th>
                    <th class="py-4 px-4 text-[10px] font-bold uppercase tracking-widest text-zinc-500">Customer</th>
                    <th class="py-4 px-4 text-[10px] font-bold uppercase tracking-widest text-zinc-500">Status</th>
                    <th class="py-4 px-4 text-right text-[10px] font-bold uppercase tracking-widest text-zinc-500">Amount</th>
                    <th class="py-4 px-4"></th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <x-orders.order-row :order="$order" :isVendor="true" />
                @empty
                    <tr>
                        <td colspan="5" class="py-20 text-center text-zinc-400 italic text-sm">
                            No orders found matching your criteria.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
     <div class="mt-6">
        {{-- Custom Laravel/Livewire pagination links --}}
    </div>
</div>