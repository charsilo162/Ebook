<div class="min-h-screen flex items-center justify-center bg-zinc-50 p-6">
    <div class="w-full max-w-md bg-white rounded-3xl shadow-xl border border-zinc-100 p-10">
        
        <div class="text-center mb-10">
            <div class="w-16 h-16 bg-purple-600 rounded-2xl mx-auto mb-4 flex items-center justify-center shadow-lg shadow-purple-200">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
            </div>
            <h1 class="text-2xl font-black text-zinc-900 tracking-tight">Welcome Back</h1>
            <p class="text-zinc-500 text-sm mt-1">Enter your details to access your bookstore</p>
        </div>

        <form wire:submit.prevent="login" class="space-y-5">
            <div>
                <label class="text-xs font-black text-zinc-400 uppercase tracking-widest ml-1">Email Address</label>
                <input type="email" wire:model="email" class="w-full mt-2 p-4 bg-zinc-50 border border-zinc-200 rounded-2xl outline-none focus:ring-2 focus:ring-purple-600 transition-all" placeholder="name@example.com">
                @error('email') <span class="text-red-500 text-xs mt-1 ml-1 block font-bold">{{ $message }}</span> @enderror
            </div>

            <div>
                <div class="flex justify-between items-center ml-1">
                    <label class="text-xs font-black text-zinc-400 uppercase tracking-widest">Password</label>
                    <a href="#" class="text-[10px] font-bold text-purple-600 uppercase tracking-widest">Forgot?</a>
                </div>
                <input type="password" wire:model="password" class="w-full mt-2 p-4 bg-zinc-50 border border-zinc-200 rounded-2xl outline-none focus:ring-2 focus:ring-purple-600 transition-all" placeholder="••••••••">
                @error('password') <span class="text-red-500 text-xs mt-1 ml-1 block font-bold">{{ $message }}</span> @enderror
            </div>

            {{-- <div class="flex items-center gap-2 px-1">
                <input type="checkbox" wire:model="remember" id="remember" class="rounded border-zinc-300 text-purple-600 focus:ring-purple-600">
                <label for="remember" class="text-xs text-zinc-500 font-bold">Stay logged in for 30 days</label>
            </div> --}}

            <button type="submit" wire:loading.attr="disabled" class="w-full bg-purple-600 text-white p-4 rounded-2xl font-bold shadow-lg shadow-purple-100 hover:bg-purple-700 transition-all flex items-center justify-center gap-2">
                <span wire:loading.remove wire:target="login">Sign In</span>
                <span wire:loading wire:target="login" class="flex items-center gap-2">
                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    Authenticating...
                </span>
            </button>
        </form>

        <div class="mt-8 text-center">
            <p class="text-sm text-zinc-500">
                New to the platform? 
                <a href="{{ route('signup') }}" class="text-purple-600 font-bold hover:underline ml-1">Create an account</a>
            </p>
        </div>
    </div>
</div>