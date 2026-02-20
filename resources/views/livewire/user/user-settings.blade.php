<div class="max-w-5xl mx-auto space-y-8 pb-20">
    
    <div>
        <h1 class="text-2xl font-bold text-zinc-900">Account Settings</h1>
        <p class="text-sm text-zinc-500">Manage your personal information and role.</p>
    </div>

    @if (session()->has('success'))
        <div class="p-4 bg-purple-50 border border-purple-200 text-purple-700 rounded-2xl font-bold text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-3xl shadow-sm border border-zinc-200 overflow-hidden">
        <div class="p-8">
            <div x-data="{
                userType: @entangle('type'),
                storeName: @entangle('store_name'),
                storeBio: @entangle('bio')
            }">
                <form wire:submit.prevent="updateProfile" class="max-w-2xl space-y-8">
                    @if (session()->has('success'))
                        <div class="p-4 mb-4 text-green-700 bg-green-100 rounded-lg">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="p-4 mb-4 text-red-700 bg-red-100 rounded-lg">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <div class="space-y-6">
                        <h3 class="text-sm font-black text-purple-600 uppercase tracking-[0.2em]">Personal Information</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="text-xs font-black text-zinc-400 uppercase tracking-widest">First Name</label>
                                <input type="text" wire:model="first_name" class="w-full mt-2 p-3 bg-zinc-50 border border-zinc-200 rounded-xl focus:ring-2 focus:ring-purple-600 outline-none transition">
                                @error('first_name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="text-xs font-black text-zinc-400 uppercase tracking-widest">Last Name</label>
                                <input type="text" wire:model="last_name" class="w-full mt-2 p-3 bg-zinc-50 border border-zinc-200 rounded-xl focus:ring-2 focus:ring-purple-600 outline-none transition">
                                @error('last_name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="text-xs font-black text-zinc-400 uppercase tracking-widest">Email Address</label>
                                <input type="email" wire:model="email" class="w-full mt-2 p-3 bg-zinc-50 border border-zinc-200 rounded-xl focus:ring-2 focus:ring-purple-600 outline-none transition">
                                @error('email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="text-xs font-black text-zinc-400 uppercase tracking-widest">Phone Number</label>
                                <input type="text" wire:model="user_phone" class="w-full mt-2 p-3 bg-zinc-50 border border-zinc-200 rounded-xl focus:ring-2 focus:ring-purple-600 outline-none transition">
                                @error('phone') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <hr class="border-zinc-100">

                    <div>
                        <label class="text-xs font-black text-zinc-400 uppercase tracking-widest">
                            User Role
                        </label>

                        <select 
                            wire:model="type"
                            class="w-full mt-2 p-3 bg-zinc-50 border border-zinc-200 rounded-xl focus:ring-2 focus:ring-purple-600 outline-none transition"
                        >
                            <option value="user">User</option>
                            <option value="vendor">Vendor</option>
                        </select>

                        @error('type')
                            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div x-show="userType === 'vendor'" class="space-y-6">
                        <h3 class="text-sm font-black text-purple-600 uppercase tracking-[0.2em]">Vendor Settings</h3>
                        
                        <div>
                            <label class="text-xs font-black text-zinc-400 uppercase tracking-widest">Store Display Name</label>
                            <input type="text" wire:model="store_name" class="w-full mt-2 p-3 bg-zinc-50 border border-zinc-200 rounded-xl focus:ring-2 focus:ring-purple-600 outline-none transition">
                            @error('store_name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="text-xs font-black text-zinc-400 uppercase tracking-widest">Store Biography</label>
                            <textarea wire:model="bio" rows="4" class="w-full mt-2 p-3 bg-zinc-50 border border-zinc-200 rounded-xl focus:ring-2 focus:ring-purple-600 outline-none transition" placeholder="Tell your customers about your shop..."></textarea>
                            @error('bio') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" 
                            wire:loading.attr="disabled"
                            x-bind:disabled="userType === 'vendor' && (!storeName.trim() || !storeBio.trim())"
                            class="bg-purple-600 text-white px-10 py-4 rounded-xl font-bold shadow-lg shadow-purple-100 hover:bg-purple-700 transition-all disabled:opacity-50 flex items-center gap-2">
                            <span wire:loading.remove wire:target="updateProfile">Save All Changes</span>
                            <span wire:loading wire:target="updateProfile">Saving...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>