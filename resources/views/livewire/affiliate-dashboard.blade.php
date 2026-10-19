<div class="max-w-2xl mx-auto space-y-8 pb-10">
    <!-- Header Section -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-zinc-900 tracking-tight">Withdraw Funds</h1>
            <p class="text-sm text-zinc-500">Move your earnings to your bank account.</p>
        </div>
        <div class="px-4 py-2 bg-purple-50 rounded-full border border-purple-100">
            <span class="text-xs font-bold text-purple-600 uppercase tracking-widest">Affiliate Program</span>
        </div>
    </div>

    <!-- Balance Card (The Hero Component) -->
    <div class="relative overflow-hidden bg-zinc-900 rounded-[2rem] p-8 shadow-2xl shadow-purple-200">
        <!-- Abstract Background Glow -->
        <div class="absolute -top-24 -right-24 w-64 h-64 bg-purple-600/20 blur-[80px] rounded-full"></div>
        <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-indigo-600/10 blur-[80px] rounded-full"></div>

        <div class="relative z-10 space-y-6">
            <div class="flex justify-between items-start">
                <p class="text-zinc-400 text-sm font-medium">Available Balance</p>
                <div class="text-right">
                    <p class="text-[10px] text-zinc-500 uppercase font-black tracking-widest">Referral Code</p>
                    <p class="text-white font-mono text-sm">{{ $stats['referral_code'] ?? 'N/A' }}</p>
                </div>
            </div>
            
            <h2 class="text-4xl md:text-5xl font-black text-white tracking-tighter">
                <span class="text-purple-500">₦</span>{{ number_format($stats['affiliate_balance'] ?? 0, 2) }}
            </h2>

            <div class="flex items-center gap-2 text-zinc-400 text-xs">
                <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                Secure Payouts Enabled
            </div>
        </div>
    </div>

    <!-- Feedback Messages -->
    @if (session()->has('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl flex items-center gap-3">
            <div class="bg-emerald-500 text-white p-1 rounded-full">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <span class="font-bold text-sm">{{ session('success') }}</span>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="p-4 bg-rose-50 border border-rose-100 text-rose-700 rounded-2xl flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="font-bold text-sm">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Withdrawal Form Card -->
    <div class="bg-white rounded-[2rem] border border-zinc-100 shadow-sm overflow-hidden">
        <form wire:submit.prevent="withdrawMoney" class="p-8 space-y-6">
    
    <!-- Amount Input -->
    <div class="space-y-2">
        <label class="text-xs font-black text-zinc-400 uppercase tracking-widest">Amount to Withdraw</label>
        <div class="relative">
            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-zinc-400 font-bold">₦</span>
            <input type="number" wire:model="amount" 
                class="w-full pl-10 p-4 bg-zinc-50 border border-zinc-200 rounded-2xl focus:ring-2 focus:ring-purple-600 focus:bg-white outline-none transition text-lg font-bold" 
                placeholder="0.00">
        </div>
        @error('amount') <span class="text-rose-500 text-xs">{{ $message }}</span> @enderror
    </div>

    <!-- Pre-filled Bank Summary -->
    <div class="p-6 bg-purple-50/50 rounded-2xl border border-purple-100 space-y-4">
        <div class="flex justify-between items-center">
            <h4 class="text-xs font-black text-purple-900 uppercase tracking-widest">Destination Account</h4>
            <a href="{{ route('user.settings') }}" class="text-[10px] font-bold text-purple-600 underline uppercase tracking-tighter">Edit Bank</a>
        </div>
        
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-[10px] text-zinc-400 uppercase font-bold">Bank Name</p>
                <p class="text-sm font-bold {{ $bank_name ? 'text-zinc-700' : 'text-rose-400' }}">
                    {{ $bank_name ?? 'Not Set' }}
                </p>
            </div>
            <div>
                <p class="text-[10px] text-zinc-400 uppercase font-bold">Account Number</p>
                <p class="text-sm font-bold {{ $account_number ? 'text-zinc-700' : 'text-rose-400' }}">
                    {{ $account_number ?? 'Not Set' }}
                </p>
            </div>
        </div>
        <div>
            <p class="text-[10px] text-zinc-400 uppercase font-bold">Account Holder</p>
            <p class="text-sm font-bold {{ $account_name ? 'text-zinc-700' : 'text-rose-400' }}">
                {{ $account_name ?? 'Please update in settings' }}
            </p>
        </div>

        <!-- Hidden inputs to keep Livewire properties synced -->
        <input type="hidden" wire:model="bank_name">
        <input type="hidden" wire:model="account_number">
        <input type="hidden" wire:model="account_name">
    </div>

    <!-- Dynamic Smart Button -->
    <button type="submit" 
        {{ !$hasBankDetails ? 'disabled' : '' }}
        wire:loading.attr="disabled"
        class="w-full p-5 rounded-2xl font-black text-sm uppercase tracking-widest transition-all flex justify-center items-center gap-3 
        {{ $hasBankDetails 
            ? 'bg-purple-600 text-white shadow-xl shadow-purple-200 hover:bg-purple-700 hover:-translate-y-0.5 active:scale-95' 
            : 'bg-zinc-200 text-zinc-400 cursor-not-allowed' 
        }}">
        
        <!-- Button Text logic -->
        <span wire:loading.remove>
            {{ $hasBankDetails ? 'Request Payout Now' : 'Setup Bank in Settings to Withdraw' }}
        </span>
        
        <!-- Loading State -->
        <span wire:loading>Processing...</span>

        <!-- Icon (only shows if bank is set) -->
        @if($hasBankDetails)
            <svg wire:loading.remove class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
            </svg>
        @endif
    </button>

</form>
    </div>

    <!-- Referral Link Section -->
<div class="bg-white rounded-[2rem] border border-zinc-100 shadow-sm p-8 space-y-4">
    <div class="flex items-center justify-between">
        <h3 class="text-xs font-black text-zinc-400 uppercase tracking-widest">Your Referral Link</h3>
        <span class="text-[10px] font-bold text-emerald-500 bg-emerald-50 px-2 py-1 rounded-lg uppercase">Earn 10% Commission</span>
    </div>

    <div class="flex flex-col md:flex-row gap-3">
        <div class="flex-1 bg-zinc-50 border border-zinc-200 rounded-2xl p-4 flex items-center justify-between overflow-hidden">
            <code class="text-sm font-mono text-purple-600 truncate mr-4">
                {{ url('/signup') . '?ref=' . ($stats['referral_code'] ?? '') }}
            </code>
        </div>
        
        <!-- Copy Button using Alpine.js -->
        <button 
            x-data="{ 
                copyLink() {
                    navigator.clipboard.writeText('{{ url('/signup') . '?ref=' . ($stats['referral_code'] ?? '') }}');
                    $el.innerText = 'Copied!';
                    setTimeout(() => $el.innerText = 'Copy Link', 2000);
                } 
            }"
            @click="copyLink()"
            class="bg-zinc-900 text-white px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-purple-600 transition-colors whitespace-nowrap">
            Copy Link
        </button>
    </div>
    
    <p class="text-[10px] text-zinc-400">Share this link with friends. When they sign up and make a purchase, you get paid!</p>
</div>
</div>