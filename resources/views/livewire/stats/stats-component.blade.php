<section class="mt-6">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <x-ui.stat-card 
            label="Total Books" 
            :value="$stats['total_books']" 
            icon="book-open" 
            color="blue" 
        />
        
        <x-ui.stat-card 
            label="Hard Copies" 
            :value="$stats['types']['hard_copy'] ?? 0" 
            icon="book-open" 
            color="green" 
        />
        
        <x-ui.stat-card 
            label="Soft Copies" 
            :value="$stats['types']['soft_copy'] ?? 0" 
            icon="cloud-arrow-down" 
            color="purple" 
        />
        
        <x-ui.stat-card 
            label="Total Books Sold" 
            :value="$stats['total_books_bought'] ?? 0" 
            icon="o-shopping-cart" 
            color="yellow" 
        />
         @if (session('user') && session('user.type') === 'admin')
        @if (($stats['total_users'] ?? 0) > 0)
            <x-ui.stat-card 
                label="Total Users" 
                :value="$stats['total_users']" 
                icon="o-users" 
                color="indigo" 
            />
        @endif
        @endif
        
        @if (($stats['total_vendors'] ?? 0) > 0)
            <x-ui.stat-card 
                label="Total Vendors" 
                :value="$stats['total_vendors']" 
                icon="briefcase" 
                color="red" 
            />
        @endif
    </div>
</section>