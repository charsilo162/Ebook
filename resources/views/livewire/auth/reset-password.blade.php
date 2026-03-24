<div class="min-h-screen flex items-center justify-center bg-gray-50 px-4">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-2">Reset Password</h2>
        <p class="text-sm text-gray-500 mb-6">
            Choose a new password for your account.
        </p>

        <form wire:submit.prevent="resetPassword" class="space-y-5">

            <div>
                <label class="text-sm text-gray-600">Email</label>
                <input type="email"
                       wire:model="email"
                       readonly
                       class="w-full rounded-xl border bg-gray-100 px-4 py-2">
            </div>

            <div>
                <label class="text-sm text-gray-600">New Password</label>
                <input type="password"
                       wire:model.live="password"
                       class="w-full rounded-xl border px-4 py-2 focus:ring-2 focus:ring-black @error('password') border-red-500 @enderror">

                @error('password')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="text-sm text-gray-600">Confirm Password</label>
                <input type="password"
                       wire:model.live="password_confirmation"
                       class="w-full rounded-xl border px-4 py-2 focus:ring-2 focus:ring-black">
            </div>

            <button
                class="w-full bg-black text-white py-2.5 rounded-xl hover:bg-gray-800 transition flex items-center justify-center gap-2"
                wire:loading.attr="disabled">

                <span wire:loading.remove>Reset Password</span>

                <span wire:loading class="flex items-center gap-2">
                    <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                    </svg>
                    Processing...
                </span>
            </button>
        </form>
    </div>
</div>
