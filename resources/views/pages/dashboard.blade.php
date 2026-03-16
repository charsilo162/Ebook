<x-layouts.dashboard title="Dashboard">
    <div class="max-w-7xl mx-auto px-4 py-6 space-y-10">
        @php
    $user = Session::get('user');
    //dd($user['type']);
@endphp
@if ($user['type'] === 'vendor')
        <livewire:stats.stats-component />
        <livewire:books.popular-books-component />
        <livewire:vendor.books-manager />

        @elseif ($user['type'] === 'admin')
            
   
        <livewire:admin.user-management />

@else
<livewire:user.my-library />
@endif
    </div> 

</x-layouts.dashboard>
