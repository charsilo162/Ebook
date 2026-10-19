<div class="p-6 space-y-8">
    <!-- Header & Settings -->
    <div class="flex justify-between items-center bg-white p-6 rounded-lg shadow">
        <div>
            <h2 class="text-2xl font-bold">Affiliate Overview</h2>
            <p class="text-gray-600">Track earnings across the platform</p>
        </div>
        <div class="flex items-center space-x-2">
            <label class="font-medium">Global Rate (%):</label>
            <input type="number" wire:model="newRate" class="border rounded px-2 py-1 w-20" placeholder="10">
            <button wire:click="changeRate" class="bg-blue-600 text-white px-4 py-1 rounded">Update</button>
        </div>
    </div>

    @if (session()->has('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded">{{ session('success') }}</div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Table 1: Current User Balances -->
        <div class="bg-white p-4 rounded-lg shadow">
            <h3 class="font-bold mb-4 border-b pb-2">Active Affiliate Balances</h3>
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left bg-gray-50">
                        <th class="p-2">User</th>
                        <th class="p-2">Code</th>
                        <th class="p-2 text-right">Balance</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($balances as $user)
                        <tr class="border-t">
                            <td class="p-2">{{ $user['first_name'] }} {{ $user['last_name'] }}</td>
                            <td class="p-2"><span class="bg-gray-100 px-1 rounded">{{ $user['referral_code'] }}</span></td>
                            <td class="p-2 text-right font-bold">₦{{ number_format($user['affiliate_balance'], 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Table 2: Recent Commission Logs -->
        <div class="bg-white p-4 rounded-lg shadow">
            <h3 class="font-bold mb-4 border-b pb-2">Recent Commissions Earned</h3>
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left bg-gray-50">
                        <th class="p-2">Referrer</th>
                        <th class="p-2">Earned</th>
                        <th class="p-2">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @php $items = $logs['data'] ?? $logs; @endphp
                    @foreach($items as $log)
                        <tr class="border-t">
                            <td class="p-2">{{ $log['user']['name'] ?? 'N/A' }}</td>
                            <td class="p-2 text-green-600 font-medium">+₦{{ number_format($log['amount'], 2) }}</td>
                            <td class="p-2 text-gray-500 text-xs">{{ \Carbon\Carbon::parse($log['created_at'])->format('d M, Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>