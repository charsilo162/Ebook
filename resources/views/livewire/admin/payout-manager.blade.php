<div class="p-6">
    <h2 class="text-2xl font-bold mb-4">Withdrawal Requests</h2>

    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    <table class="min-w-full bg-white border">
        <thead>
            <tr>
                <th class="border px-4 py-2">User</th>
                <th class="border px-4 py-2">Amount</th>
                <th class="border px-4 py-2">Bank Details</th>
                <th class="border px-4 py-2">Status</th>
                <th class="border px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($withdrawals as $w)
                <tr>
                    <td class="border px-4 py-2">{{ $w['user']['name'] }}</td>
                    <td class="border px-4 py-2">₦{{ number_format($w['amount'], 2) }}</td>
                    <td class="border px-4 py-2">
                        <strong>{{ $w['bank_name'] }}</strong><br>
                        {{ $w['account_number'] }} ({{ $w['account_name'] }})
                    </td>
                    <td class="border px-4 py-2">
                        <span class="badge {{ $w['status'] == 'pending' ? 'bg-yellow-500' : 'bg-green-500' }}">
                            {{ strtoupper($w['status']) }}
                        </span>
                    </td>
                    <td class="border px-4 py-2">
                        @if($w['status'] == 'pending')
                            <button wire:click="updateStatus({{ $w['id'] }}, 'completed')" class="btn-success">Approve</button>
                            <button wire:click="updateStatus({{ $w['id'] }}, 'rejected')" class="btn-danger">Reject</button>
                        @else
                            <span class="text-gray-400">Processed</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>