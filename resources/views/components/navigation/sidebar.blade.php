<aside
    class="fixed inset-y-0 left-0 w-64 bg-gradient-to-b from-purple-700/95 to-purple-600/95 backdrop-blur-lg
           text-white shadow-lg transform transition-transform duration-300 z-40 lg:translate-x-0"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
>
    {{-- Logo / Header --}}
    <div class="h-16 flex items-center px-6 font-extrabold text-xl tracking-wider uppercase drop-shadow-lg">
        MyDashboard
    </div>

    {{-- Navigation --}}
    <nav class="px-4 mt-6 space-y-2">
        <x-navigation.sidebar-link
            href="/dashboard"
            icon="home"
            label="Dashboard"
        />

        <x-navigation.sidebar-link
            href="#"
            icon="book-open"
            label="Books"
        />

        <x-navigation.sidebar-link
            href="/vendor/settings"
            icon="cog"
            label="Settings"
        />

        <x-navigation.sidebar-link
            href="{{ route('order.management') }}"
            icon="o-shopping-cart"
            label="Order Management"
        />
        <x-navigation.sidebar-link
            href="{{ route('my.orders') }}"
            icon="o-shopping-cart"
            label="My Orders"
        />

        <x-navigation.sidebar-link
            href="#"
            icon="users"
            label="Users"
        />

        <x-navigation.sidebar-link
            href="#"
            icon="chart-bar"
            label="Analytics"
        />
    </nav>
</aside>
