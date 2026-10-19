<div class="min-h-screen bg-slate-50 flex flex-col justify-center py-12 px-4 sm:px-6 lg:px-8">
    
    <div class="sm:mx-auto sm:w-full sm:max-w-md text-center">
        <h2 class="text-4xl font-extrabold text-slate-900 tracking-tight">Create Account</h2>
        <p class="mt-2 text-slate-500">Join the marketplace today.</p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-xl">
        <div class="bg-white py-10 px-6 shadow-2xl shadow-slate-200/50 rounded-3xl border border-slate-100 sm:px-12">
            
            <div class="flex p-1.5 bg-slate-100 rounded-2xl mb-10 border border-slate-200">
                <button wire:click="setRole('user')" 
                    class="flex-1 py-3 text-sm font-bold rounded-xl transition-all {{ $role === 'user' ? 'bg-purple-600 text-white shadow-lg' : 'text-slate-500 hover:text-slate-700' }}">
                    Reader / Buyer
                </button>
                <button wire:click="setRole('vendor')" 
                    class="flex-1 py-3 text-sm font-bold rounded-xl transition-all {{ $role === 'vendor' ? 'bg-purple-600 text-white shadow-lg' : 'text-slate-500 hover:text-slate-700' }}">
                    Author / Seller
                </button>
            </div>

            <form wire:submit.prevent="signup" class="space-y-6">
                
                {{-- <div class="flex flex-col items-center mb-8">
                    <div class="relative group">
                        <div class="w-24 h-24 rounded-full bg-purple-50 border-2 border-dashed border-purple-200 flex items-center justify-center overflow-hidden transition-all group-hover:border-purple-400">
                            @if ($photo)
                                <img src="{{ $photo->temporaryUrl() }}" class="w-full h-full object-cover">
                            @else
                                <svg class="w-10 h-10 text-purple-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                            @endif
                        </div>
                        <label class="absolute bottom-0 right-0 bg-purple-600 p-2 rounded-full cursor-pointer text-white hover:bg-purple-700 shadow-xl border-4 border-white">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/></svg>
                            <input type="file" wire:model="photo" class="hidden">
                        </label>
                    </div>
                    @error('photo') <span class="text-red-500 text-xs mt-2">{{ $message }}</span> @enderror
                </div> --}}

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="space-y-1">
                        <label class="text-xs font-black text-slate-500 uppercase">First Name</label>
                        <input type="text" wire:model="first_name" class="w-full bg-slate-50 border-slate-200 rounded-xl p-3.5 focus:ring-2 focus:ring-purple-600 outline-none border transition-all">
                        @error('first_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-black text-slate-500 uppercase">Last Name</label>
                        <input type="text" wire:model="last_name" class="w-full bg-slate-50 border-slate-200 rounded-xl p-3.5 focus:ring-2 focus:ring-purple-600 outline-none border transition-all">
                        @error('last_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-black text-slate-500 uppercase">Email Address</label>
                    <input type="email" wire:model="email" class="w-full bg-slate-50 border-slate-200 rounded-xl p-3.5 focus:ring-2 focus:ring-purple-600 outline-none border transition-all">
                    @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                @if($role === 'vendor')
                <div class="p-6 bg-purple-50 rounded-2xl border border-purple-100 space-y-4 animate-in fade-in slide-in-from-top-4">
                    <h3 class="text-purple-800 font-bold text-sm">Store Information</h3>
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-purple-400 uppercase">Store Name</label>
                        <input type="text" wire:model="store_name" placeholder="E.g. The Reading Room" class="w-full bg-white border-purple-200 rounded-xl p-3 focus:ring-2 focus:ring-purple-600 outline-none border">
                        @error('store_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-purple-400 uppercase">Short Bio</label>
                        <textarea wire:model="bio" rows="2" class="w-full bg-white border-purple-200 rounded-xl p-3 focus:ring-2 focus:ring-purple-600 outline-none border"></textarea>
                    </div>
                </div>
                @endif

           
                <div class="space-y-1" x-data="{
    showPassword: false,
    password: @entangle('password').live,
    get strength() {
        if (!this.password) return 0;
        let score = 0;
        if (this.password.length >= 8) score++;
        if (/[A-Z]/.test(this.password)) score++;
        if (/[a-z]/.test(this.password)) score++;
        if (/[0-9]/.test(this.password)) score++;
        if (/[^A-Za-z0-9]/.test(this.password)) score++;
        return score;
    },
    get label() {
        return ['', 'Very Weak', 'Weak', 'Fair', 'Good', 'Strong'][this.strength];
    },
    get color() {
        return ['', 'bg-red-500', 'bg-orange-500', 'bg-yellow-500', 'bg-blue-500', 'bg-green-500'][this.strength];
    },
    get width() {
        return ['0%', '20%', '40%', '60%', '80%', '100%'][this.strength];
    }
}">
    <label class="text-xs font-black text-slate-500 uppercase">Password</label>
    
    <div class="relative">
        <input
            :type="showPassword ? 'text' : 'password'"
            wire:model.live="password"
            class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3.5 pr-12 focus:ring-2 focus:ring-purple-600 outline-none transition-all"
            placeholder="Create a strong password"
        >

        <button
            type="button"
            @click="showPassword = !showPassword"
            class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-purple-600 focus:outline-none transition-colors"
        >
            <!-- Eye (show) -->
            <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
            <!-- Eye-slash (hide) -->
            <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-cloak>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908a10.018 10.018 0 013.682-.763c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m-1.503 1.341M9.88 9.88a3 3 0 104.243 4.243M9.88 9.88L13.875 18.825M3 3l18 18" />
            </svg>
        </button>
    </div>

    <!-- Strength Meter -->
    <div class="mt-2 space-y-1" x-show="password" x-cloak>
        <div class="w-full h-1.5 bg-slate-200 rounded-full overflow-hidden">
            <div class="h-full transition-all duration-300 rounded-full"
                 :class="color"
                 :style="`width: ${width}`">
            </div>
        </div>
        <div class="flex justify-between text-xs">
            <span class="font-medium" :class="{
                'text-red-500': strength <= 2,
                'text-yellow-600': strength === 3,
                'text-blue-600': strength === 4,
                'text-green-600': strength === 5
            }" x-text="label"></span>
            <span class="text-slate-400" x-text="strength + '/5'"></span>
        </div>
    </div>

    @error('password')
        <span class="text-red-500 text-xs">{{ $message }}</span>
    @enderror
</div>

                <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white py-4 rounded-2xl font-bold text-lg shadow-xl shadow-purple-200 transition-all active:scale-95">
                    <span wire:loading.remove>Get Started</span>
                    <span wire:loading>Authenticating...</span>
                </button>
            </form>

               <div class="mt-8 text-center">
            <p class="text-sm text-zinc-500">
                Have an account? 
                <a href="{{ route('login') }}" class="text-purple-600 font-bold hover:underline ml-1">Sign in</a>
            </p>
        </div>
        </div>
    </div>
</div> 