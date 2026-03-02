<div class="p-6 bg-gray-50 min-h-screen">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 space-y-4 md:space-y-0">
        <div>
            <h2 class="text-2xl font-bold text-purple-900 leading-tight">Category Dashboard</h2>
            <p class="text-sm text-purple-600/60 font-medium">Manage your book genres and organization</p>
        </div>

        <div class="flex flex-col sm:flex-row items-center space-y-3 sm:space-y-0 sm:space-x-4 w-full md:w-auto">
            <x-ui.search-input 
                wire:model.live.debounce.400ms="search" 
                placeholder="Find a category..." 
                buttonLabel="Filter"
            />

            <button wire:click="openModal" class="w-full sm:w-auto bg-purple-600 hover:bg-purple-700 text-white px-5 py-3 rounded-lg font-bold transition flex items-center justify-center shadow-lg shadow-purple-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                New Category
            </button>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="bg-white border-l-4 border-purple-500 p-4 rounded-r-xl shadow-sm mb-6 flex items-center justify-between">
            <div class="flex items-center">
                <div class="bg-purple-100 p-2 rounded-full mr-3 text-purple-600">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                </div>
                <span class="font-semibold text-purple-900">{{ session('message') }}</span>
            </div>
        </div>
    @endif

    @if(empty($categories))
        <div class="flex flex-col items-center justify-center py-20 bg-white rounded-3xl border border-dashed border-purple-200">
            <div class="bg-purple-50 p-6 rounded-full mb-4">
                <svg class="w-12 h-12 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-purple-900">No categories found</h3>
            <p class="text-gray-500">We couldn't find any results for "{{ $search }}"</p>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($categories as $category)
                <div class="bg-white rounded-2xl border border-purple-50 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden group">
                    <div class="h-40 bg-purple-100 flex items-center justify-center relative">
                        @if($category['thumbnail_url'] ?? false)
                            <img src="{{ $category['thumbnail_url'] }}" class="object-cover h-full w-full">
                        @else
                            <span class="text-purple-300 font-bold uppercase tracking-widest text-xs">No Preview</span>
                        @endif
                        <div class="absolute inset-0 bg-purple-900/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    </div>
                    <div class="p-5">
                        <h3 class="font-bold text-purple-900 text-lg mb-4">{{ $category['name'] }}</h3>
                        <div class="flex space-x-2">
                            <button wire:click="openModal({{ $category['id'] }})" class="flex-1 bg-white border border-purple-200 text-purple-700 py-2 rounded-lg font-bold text-sm hover:bg-purple-600 hover:text-white hover:border-purple-600 transition-all">
                                Edit
                            </button>
                            <button onclick="confirm('Delete this category?') || event.stopImmediatePropagation()" 
                                    wire:click="deleteCategory({{ $category['id'] }})" 
                                    class="p-2 text-red-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if(!empty($paginationMeta) && $paginationMeta['last_page'] > 1)
            <div class="mt-12 flex flex-col md:flex-row items-center justify-between border-t border-purple-100 pt-8">
                <span class="text-sm font-medium text-purple-900/50 mb-4 md:mb-0">
                    Showing {{ $paginationMeta['from'] }}-{{ $paginationMeta['to'] }} of {{ $paginationMeta['total'] }}
                </span>
                <div class="flex space-x-1">
                    @foreach($paginationMeta['links'] as $link)
                        <button 
                            wire:click="setPage({{ (int) filter_var($link['label'], FILTER_SANITIZE_NUMBER_INT) ?: 1 }})"
                            @class([
                                'px-4 py-2 rounded-lg text-sm font-bold transition-all',
                                'bg-purple-600 text-white shadow-lg shadow-purple-200' => $link['active'],
                                'bg-white text-purple-600 border border-purple-100 hover:bg-purple-50' => !$link['active'],
                                'opacity-50 cursor-not-allowed' => !$link['url']
                            ])
                            {{ !$link['url'] ? 'disabled' : '' }}
                        >
                            {!! $link['label'] !!}
                        </button>
                    @endforeach
                </div>
            </div>
        @endif
    @endif

    @if($isModalOpen)
        <div class="fixed inset-0 bg-purple-900/60 backdrop-blur-md flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-3xl w-full max-w-md shadow-2xl overflow-hidden border border-white">
                <div class="bg-purple-600 p-6 text-white flex justify-between items-center">
                    <h3 class="text-xl font-bold">{{ $editingCategoryId ? 'Edit Category' : 'Create New Category' }}</h3>
                    <button wire:click="closeModal" class="text-purple-200 hover:text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                
                <form wire:submit.prevent="save" class="p-8 space-y-6">
                    <div>
                        <label class="block text-purple-900 text-sm font-bold mb-2 uppercase tracking-wider">Category Title</label>
                        <input type="text" wire:model="name" class="w-full bg-purple-50 border-0 rounded-xl p-4 focus:ring-2 focus:ring-purple-500 transition outline-none text-purple-900">
                        @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-purple-900 text-sm font-bold mb-2 uppercase tracking-wider">Thumbnail Image</label>
                        <div class="flex items-center space-x-4">
                            @if ($thumbnail)
                                <img src="{{ $thumbnail->temporaryUrl() }}" class="w-16 h-16 rounded-xl object-cover ring-4 ring-purple-100">
                            @endif
                            <input type="file" wire:model="thumbnail" class="text-sm text-purple-600 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-purple-100 file:text-purple-700 hover:file:bg-purple-200 transition">
                        </div>
                        <div wire:loading wire:target="thumbnail" class="text-xs text-purple-500 mt-2 font-bold italic animate-pulse">Processing image...</div>
                    </div>

                    <div class="flex justify-end pt-4">
                        <button type="submit" wire:loading.attr="disabled" class="bg-purple-600 text-white px-10 py-4 rounded-2xl font-black uppercase tracking-widest hover:bg-purple-700 shadow-xl shadow-purple-200 transition-all active:scale-95 flex items-center">
                            <span wire:loading.remove wire:target="save">Confirm & Save</span>
                            <span wire:loading wire:target="save" class="flex items-center">
                                <svg class="animate-spin h-5 w-5 mr-3 text-white" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                Uploading...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>