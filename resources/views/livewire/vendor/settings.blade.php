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
                <form wire:submit.prevent="updateProfile" class="max-w-2xl space-y-6">
                    <div>
                        <label class="text-xs font-black text-zinc-400 uppercase tracking-widest">Store Display Name</label>
                        <input type="text" wire:model="store_name" class="w-full mt-2 p-3 bg-zinc-50 border border-zinc-200 rounded-xl focus:ring-2 focus:ring-purple-600 outline-none">
                        @error('store_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="text-xs font-black text-zinc-400 uppercase tracking-widest">Store Biography</label>
                        <textarea wire:model="bio" rows="4" class="w-full mt-2 p-3 bg-zinc-50 border border-zinc-200 rounded-xl focus:ring-2 focus:ring-purple-600 outline-none"></textarea>
                    </div>

                    <button type="submit" class="bg-purple-600 text-white px-8 py-3 rounded-xl font-bold shadow-lg shadow-purple-100">Save Changes</button>
                </form>
            </div>

            <div x-show="tab === 'shops'">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-bold text-zinc-800">Your Locations</h3>
                    <button wire:click="$set('showShopModal', true)" class="text-xs bg-purple-100 text-purple-700 px-4 py-2 rounded-lg font-bold hover:bg-purple-200 transition">
                        + Add New Branch
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @forelse($shops as $shop)
                        <div class="p-5 border border-zinc-100 bg-zinc-50 rounded-2xl">
                            <h4 class="font-bold text-zinc-900">{{ $shop['shop_name'] }}</h4>
                            <p class="text-sm text-zinc-500 mt-1">{{ $shop['address'] }}, {{ $shop['city'] }}</p>
                            <p class="text-[10px] text-zinc-400 font-bold uppercase mt-2 tracking-tighter">{{ $shop['phone'] }}</p>
                        </div>
                    @empty
                        <div class="col-span-2 text-center py-12 bg-zinc-50 rounded-3xl border-2 border-dashed border-zinc-200 text-zinc-500">
                            No physical branches registered yet.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    @if($showShopModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
        <div class="bg-white w-full max-w-md rounded-3xl p-8 shadow-2xl">
            <h2 class="text-xl font-bold text-zinc-900 mb-6">Add New Branch</h2>
            <form wire:submit.prevent="addShop" class="space-y-4">
                <input type="text" wire:model="shop_name" placeholder="Branch Name (e.g. Lagos Mainland)" class="w-full p-3 bg-zinc-50 border border-zinc-200 rounded-xl outline-none focus:ring-2 focus:ring-purple-600">
                @error('shop_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

                <input type="text" wire:model="address" placeholder="Street Address" class="w-full p-3 bg-zinc-50 border border-zinc-200 rounded-xl outline-none focus:ring-2 focus:ring-purple-600">
                
                <div class="grid grid-cols-2 gap-4">
                    <input type="text" wire:model="city" placeholder="City" class="w-full p-3 bg-zinc-50 border border-zinc-200 rounded-xl outline-none focus:ring-2 focus:ring-purple-600">
                    <input type="text" wire:model="state" placeholder="State" class="w-full p-3 bg-zinc-50 border border-zinc-200 rounded-xl outline-none focus:ring-2 focus:ring-purple-600">
                </div>

                <input type="text" wire:model="phone" placeholder="Branch Contact Phone" class="w-full p-3 bg-zinc-50 border border-zinc-200 rounded-xl outline-none focus:ring-2 focus:ring-purple-600">

                <div class="flex gap-4 pt-4">
                    <button type="button" wire:click="$set('showShopModal', false)" class="flex-1 py-3 text-zinc-500 font-bold">Cancel</button>
                    <button type="submit" class="flex-1 bg-purple-600 text-white py-3 rounded-xl font-bold shadow-lg shadow-purple-200">Save Branch</button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>