<div class="min-h-screen flex items-center justify-center bg-gray-50 px-4">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-2">Forgot your password?</h2>
        <p class="text-sm text-gray-500 mb-6">
            Enter your email and we’ll send you a reset link.
        </p>

        {{-- Success Toast --}}
        @if($successMessage)
            <div class="mb-4 bg-green-100 text-green-700 px-4 py-3 rounded-lg">
                {{ $successMessage }}
            </div>
        @endif

        <form wire:submit.prevent="sendLink" class="space-y-5">
            <div class="">
                <label class="block text-sm font-medium text-gray-600 mb-1">Email</label>
                <input type="email"
                       wire:model.live="email"
                       class="w-full rounded-xl border px-4 py-2 focus:ring-2 focus:ring-black focus:outline-none @error('email') border-red-500 @enderror"
                       placeholder="you@example.com">

                @error('email')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button
                class="w-full bg-purple-500 text-white py-2.5 rounded-xl hover:bg-gray-800 transition flex items-center justify-center gap-2"
                wire:loading.attr="disabled">

                <span wire:loading.remove>Send reset link</span>

                {{-- Spinner --}}
                <span wire:loading class="flex items-center gap-2">
                    <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                    </svg>
                    Sending...
                </span>
            </button>
        </form>
    </div>
</div>
