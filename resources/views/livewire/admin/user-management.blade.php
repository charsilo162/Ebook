<div class="p-6 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto">
        
        {{-- Header & Search Section --}}
        <div class="bg-white rounded-2xl shadow-sm border border-purple-100 p-6 mb-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">User Management</h1>
                    <p class="text-sm text-gray-500 italic">Manage account access and toggle user status</p>
                </div>
                
                <div class="relative w-full md:w-96">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </span>
                    <input 
                        wire:model.live.debounce.300ms="search" 
                        type="text" 
                        placeholder="Search by name or email..." 
                        class="block w-full pl-10 pr-3 py-2 border border-purple-200 rounded-xl leading-5 bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 sm:text-sm transition duration-150 ease-in-out"
                    >
                </div>
            </div>
        </div>

        {{-- Flash Messages --}}
        @if (session()->has('message'))
            <div class="mb-4 p-4 bg-purple-600 text-white rounded-xl shadow-md flex items-center justify-between animate-pulse">
                <span class="font-medium">{{ session('message') }}</span>
                <button type="button" class="text-white hover:text-purple-200" onclick="this.parentElement.remove()">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
            </div>
        @endif

        {{-- Users Table --}}
        <div class="bg-white rounded-2xl shadow-sm border border-purple-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-purple-100">
                    <thead class="bg-purple-700">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">User Info</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Joined At</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-white uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-white uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-purple-50">
                        @forelse($users as $user)
                            <tr class="hover:bg-purple-50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 flex-shrink-0">
                                            <img class="h-10 w-10 rounded-full object-cover border-2 border-purple-200" src="{{ $user['photo'] }}" alt="">
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-bold text-gray-900">{{ $user['full_name'] }}</div>
                                            <div class="text-xs text-gray-500">{{ $user['email'] }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $user['joined_at'] }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-black rounded-full shadow-sm {{ $user['is_active'] ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        {{ $user['is_active'] ? 'ACTIVE' : 'DEACTIVATED' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button 
                                        wire:click="toggleStatus({{ $user['id'] }})"
                                        wire:loading.attr="disabled"
                                        class="inline-flex items-center px-4 py-2 border rounded-lg text-xs font-bold transition-all duration-200 {{ $user['is_active'] ? 'border-red-200 text-red-600 hover:bg-red-600 hover:text-white' : 'border-purple-200 text-purple-600 hover:bg-purple-600 hover:text-white' }}"
                                    >
                                        <span wire:loading.remove wire:target="toggleStatus({{ $user['id'] }})">
                                            {{ $user['is_active'] ? 'Deactivate' : 'Activate' }}
                                        </span>
                                        <span wire:loading wire:target="toggleStatus({{ $user['id'] }})">
                                            Updating...
                                        </span>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 text-purple-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                        </svg>
                                        <p class="text-gray-500 font-medium">No users found matching your search.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>