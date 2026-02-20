<aside
    class="fixed inset-y-0 left-0 w-64
           bg-gradient-to-b from-purple-800 via-purple-700 to-indigo-700
           text-white shadow-2xl z-40
           transform transition-transform duration-300 ease-in-out
           flex flex-col
           lg:translate-x-0"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
>
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
        <x-navigation.sidebar-link href="/dashboard" icon="home" label="Dashboard" />
        <x-navigation.sidebar-link href="{{ route('library.index') }}" icon="book-open" label="User Library" />
        <x-navigation.sidebar-link href="/vendor/settings" icon="cog-6-tooth" label="Settings" />
        <x-navigation.sidebar-link href="{{ route('user.settings') }}" icon="user" label="Profile" />
        <x-navigation.sidebar-link href="{{ route('order.management') }}" icon="shopping-cart" label="Order Management" />
        <x-navigation.sidebar-link href="{{ route('my.orders') }}" icon="shopping-cart" label="My Orders" />
        <x-navigation.sidebar-link href="{{ route('admin.books') }}" icon="book-open" label="Manage Books" />
    </nav>

    {{-- Logout --}}
    @php $user = Session::get('user'); @endphp
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