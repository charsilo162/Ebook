<aside
    class="fixed inset-y-0 left-0 w-64 bg-purple-600/95 backdrop-blur
           text-white transform transition-transform duration-300
           z-40 lg:translate-x-0"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
>
    <div class="h-16 flex items-center px-6 font-bold text-lg">
        Dashboard
    </div>

    <nav class="px-4 space-y-2">
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
