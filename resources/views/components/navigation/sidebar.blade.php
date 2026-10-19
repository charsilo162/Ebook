<aside
    class="fixed inset-y-0 left-0 w-64
           bg-gradient-to-b from-purple-800 via-purple-700 to-indigo-700
           text-white shadow-2xl z-40
           transform transition-transform duration-300 ease-in-out
           flex flex-col
           lg:translate-x-0"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
>
    @php $user = Session::get('user'); 
  
    @endphp
    {{-- Logo / Header & Close Button --}}
    <div class="h-20 flex items-center justify-between px-6 border-b border-white/10">
        <a href="{{ route('home') }}" class="text-2xl font-bold tracking-wide">
            E<span class="text-xl text-zinc-300 tex">Book</span>
        </a>
        {{-- <span class="text-2xl font-bold tracking-wide">
           E<span class="text-xl text-zinc-300">Book</span>
        </span> --}}
        
        {{-- Close button (only shows on mobile) --}}
        <button @click="sidebarOpen = false" class="lg:hidden p-2 text-white/70 hover:text-white">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>

    {{-- Navigation Links --}}
    {{-- Note: Added @click="sidebarOpen = false" so it closes when a link is clicked on mobile --}}
    <nav class="flex-1 px-4 mt-8 space-y-2" @click="if(window.innerWidth < 1024) sidebarOpen = false">
      @if ($user['type'] === 'admin')
        <x-navigation.sidebar-link href="/dashboard" icon="home" label="Dashboard" />
        <x-navigation.sidebar-link href="{{ route('admin.books') }}" icon="book-open" label="Manage Books" />
        <x-navigation.sidebar-link href="{{ route('admin.user') }}" icon="users" label="Manage Users" />
        <x-navigation.sidebar-link href="{{ route('admin.category') }}" icon="tag" label="Manage Categories" />
       @endif
        @if ($user['type'] === 'vendor')

        <x-navigation.sidebar-link href="/dashboard" icon="home" label="Dashboard" />
        <x-navigation.sidebar-link href="/vendor/settings" icon="cog-6-tooth" label="Settings" />
        <x-navigation.sidebar-link href="{{ route('order.management') }}" icon="shopping-cart" label="Order Management" />
       @endif
        @if ($user['type'] === 'user')
        {{-- @if ($user['type'] === 'user' || $user['type'] === 'vendor') --}}
            {{-- <x-navigation.sidebar-link href="{{ route('admin.users') }}" icon="users" label="Manage Users" /> --}}
        <x-navigation.sidebar-link href="{{ route('user.settings') }}" icon="user" label="Profile" />
        <x-navigation.sidebar-link href="{{ route('category.books') }}" icon="book-open" label="Browse Books" />
        <x-navigation.sidebar-link href="{{ route('my.orders') }}" icon="shopping-cart" label="My Orders" />
        <x-navigation.sidebar-link href="{{ route('library.index') }}" icon="book-open" label="User Library" />
    
@endif 
</nav>

<!-- Earnings Section (For Regular Users & Vendors) -->
<div class="mt-6">
    <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">
        Earnings & Referrals
    </p>
    <div class="mt-2 space-y-1">
        <a href="{{ route('affiliate.dashboard') }}" 
           class="group flex items-center px-4 py-2 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('affiliate.dashboard') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
            <!-- Icon: Cash/Wallet -->
            <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Affiliate Center
        </a>
    </div>
</div>

<!-- Admin Management (Only visible to type === 'admin') -->
  @if ($user['type'] === 'admin')
    <div class="mt-8">
        <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">
            Platform Admin
        </p>
        <div class="mt-2 space-y-1">
            <!-- Affiliate Logs & Settings -->
            <a href="{{ route('admin.overview') }}" 
               class="group flex items-center px-4 py-2 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('admin.overview') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 022 2h2a2 2 0 022-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                Affiliate Stats
            </a>

            <!-- Withdrawal Requests Queue -->
            <a href="{{ route('admin.payouts') }}" 
               class="group flex items-center px-4 py-2 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('admin.payouts') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                Payout Requests
                
                <!-- Optional: Add a simple indicator if you want to show 'activity' -->
                <span class="ml-auto inline-block py-0.5 px-2 text-xs font-medium rounded-full bg-red-500 text-white">
                    !
                </span>
            </a>
        </div>
    </div>
@endif
    {{-- Logout --}}
   
    @if($user)
        <div class="px-4 pb-6">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 bg-white/10 hover:bg-white/20 border border-white/10 text-white font-medium px-4 py-3 rounded-xl transition">
                    <span>Logout</span>
                </button>
            </form>
        </div>
    @endif
</aside>