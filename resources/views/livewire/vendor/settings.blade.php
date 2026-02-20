<div class="max-w-5xl mx-auto space-y-8 pb-20">
    
    <div>
        <h1 class="text-2xl font-bold text-zinc-900">Store Settings</h1>
        <p class="text-sm text-zinc-500 text-zinc-500">Manage your bookstore identity and physical locations.</p>
    </div>

    @if (session()->has('success'))
        <div class="p-4 bg-purple-50 border border-purple-200 text-purple-700 rounded-2xl font-bold text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div x-data="{ tab: 'profile' }" class="bg-white rounded-3xl shadow-sm border border-zinc-200 overflow-hidden">
        
        <div class="flex border-b border-zinc-100 bg-zinc-50/50">
            <button @click="tab = 'profile'" :class="tab === 'profile' ? 'text-purple-600 border-purple-600 bg-white' : 'text-zinc-500'" class="px-8 py-4 text-sm font-bold border-b-2 transition-all">Store Profile</button>
            <button @click="tab = 'shops'" :class="tab === 'shops' ? 'text-purple-600 border-purple-600 bg-white' : 'text-zinc-500'" class="px-8 py-4 text-sm font-bold border-b-2 transition-all">
                Physical Bookshops ({{ count($shops) }})
            </button>
        </div>

        <div class="p-8">
    <div x-show="tab === 'profile'">
    <form wire:submit.prevent="updateProfile" class="max-w-2xl space-y-8">
        
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

        <div class="space-y-6">
            <h3 class="text-sm font-black text-purple-600 uppercase tracking-[0.2em]">Store Settings</h3>
            
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
                class="bg-purple-600 text-white px-10 py-4 rounded-xl font-bold shadow-lg shadow-purple-100 hover:bg-purple-700 transition-all disabled:opacity-50 flex items-center gap-2">
                <span wire:loading.remove wire:target="updateProfile">Save All Changes</span>
                <span wire:loading wire:target="updateProfile">Saving...</span>
            </button>
        </div>
    </form>
</div>

           <div x-show="tab === 'shops'">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-bold text-zinc-800">Your Locations</h3>
                    <button wire:click="openAddModal" class="text-xs bg-purple-100 text-purple-700 px-4 py-2 rounded-lg font-bold hover:bg-purple-200 transition">
                        + Add New Branch
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @forelse($shops as $shop)
                        <div class="p-5 border border-zinc-100 bg-zinc-50 rounded-2xl relative group">
                            <button wire:click="editShop({{ $shop['id'] }})" class="absolute top-4 right-4 opacity-100  transition p-2 bg-white rounded-lg shadow-sm text-purple-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </button>

                            <h4 class="font-bold text-zinc-900">{{ $shop['shop_name'] }}</h4>
                            <p class="text-sm text-zinc-500 mt-1">{{ $shop['address'] }}, {{ $shop['city'] }}</p>
                            <p class="text-[10px] text-zinc-400 font-bold uppercase mt-2 tracking-tighter">{{ $shop['phone'] }}</p>
                        </div>
                    @empty
                        @endforelse
                </div>
            </div>
        </div>
    </div>

@if($showShopModal)
<div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
    <div class="bg-white w-full max-w-md rounded-3xl p-8 shadow-2xl">
        <h2 class="text-xl font-bold text-zinc-900 mb-6">
            {{ $editingShopId ? 'Edit Branch Location' : 'Add New Branch' }}
        </h2>

        <form wire:submit.prevent="saveShop" class="space-y-4">
            <div>
                <label class="text-[10px] font-black text-zinc-400 uppercase tracking-widest">Branch Name</label>
                <input type="text" wire:model="shop_name" placeholder="e.g. Lagos Mainland" class="w-full mt-1 p-3 bg-zinc-50 border border-zinc-200 rounded-xl outline-none focus:ring-2 focus:ring-purple-600">
                @error('shop_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="text-[10px] font-black text-zinc-400 uppercase tracking-widest">Address</label>
                <input type="text" wire:model="address" placeholder="Street Address" class="w-full mt-1 p-3 bg-zinc-50 border border-zinc-200 rounded-xl outline-none focus:ring-2 focus:ring-purple-600">
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-[10px] font-black text-zinc-400 uppercase tracking-widest">City</label>
                    <input type="text" wire:model="city" placeholder="City" class="w-full mt-1 p-3 bg-zinc-50 border border-zinc-200 rounded-xl outline-none focus:ring-2 focus:ring-purple-600">
                </div>
                <div>
                    <label class="text-[10px] font-black text-zinc-400 uppercase tracking-widest">State</label>
                    <input type="text" wire:model="state" placeholder="State" class="w-full mt-1 p-3 bg-zinc-50 border border-zinc-200 rounded-xl outline-none focus:ring-2 focus:ring-purple-600">
                </div>
            </div>

            <div>
                <label class="text-[10px] font-black text-zinc-400 uppercase tracking-widest">Contact Phone</label>
                <input type="text" wire:model="phone" placeholder="Branch Phone" class="w-full mt-1 p-3 bg-zinc-50 border border-zinc-200 rounded-xl outline-none focus:ring-2 focus:ring-purple-600">
            </div>

            <div class="flex gap-4 pt-4">
                <button type="button" wire:click="$set('showShopModal', false)" class="flex-1 py-3 text-zinc-500 font-bold">Cancel</button>
                
                <button type="submit" class="flex-1 bg-purple-600 text-white py-3 rounded-xl font-bold shadow-lg shadow-purple-200">
                    {{ $editingShopId ? 'Update Branch' : 'Save Branch' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endif
</div>