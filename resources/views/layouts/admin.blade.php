<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ isDark: false, isSidebarOpen: false }">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard | {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-100">


    <div class="flex min-h-screen">
        <!-- Mobile Sidebar Toggle -->
        <button
            @click="isSidebarOpen = !isSidebarOpen"
            class="fixed top-4 right-4 z-50 p-2 text-gray-600 bg-white rounded-md shadow-md md:hidden focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <!-- Sidebar -->
        <aside
            x-show="isSidebarOpen || $screen('md')"
            x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-300 transform"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
            @click.away="isSidebarOpen = false"
            class="fixed inset-y-0 left-0 z-40 w-64 bg-white shadow-md md:relative md:translate-x-0 
                   transform transition-transform duration-300 ease-in-out 
                   {{ request()->is('admin/*') ? 'block' : 'hidden md:block' }}
                   md:flex md:flex-col md:w-64">
            <div class=" z-50 text-center">
                <a href="{{ route('admin.dashboard') }}">
                    <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                </a>
            </div>
            <div class="p-6 border-b">
                <h1 class="text-2xl font-bold text-gray-800">Admin Panel</h1>
            </div>
            <nav class="p-4">
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('admin.dashboard') }}"
                            class="block py-2 px-4 hover:bg-gray-100 
                           {{ request()->routeIs('admin.dashboard') ? 'bg-accent-light text-accent' : 'text-gray-700' }}">
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.user-management') }}"
                            class="block py-2 px-4 hover:bg-gray-100
                           {{ request()->routeIs('admin.user-management') ? 'bg-accent-light text-accent' : 'text-gray-700' }}">
                            User Management
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.movies.index') }}"
                            class="block py-2 px-4 hover:bg-gray-100
                           {{ request()->routeIs('admin.movies.index') ? 'bg-accent-light text-accent' : 'text-gray-700' }}">
                            Movies
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.albums.index') }}"
                            class="block py-2 px-4 hover:bg-gray-100
                           {{ request()->routeIs('admin.albums.index') ? 'bg-accent-light text-accent' : 'text-gray-700' }}">
                            Albums
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.artists.index') }}"
                            class="block py-2 px-4 hover:bg-gray-100
                           {{ request()->routeIs('admin.artists.index') ? 'bg-accent-light text-accent' : 'text-gray-700' }}">
                            Artists
                        </a>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <button type="submit" class="w-full text-left py-2 px-4 hover:bg-red-50 hover:text-red-600 text-gray-700">
                                Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </nav>
        </aside>

        <aside class=" hidden md:block inset-y-0  w-64 bg-white shadow-md">
            <div class="flex items-center justify-center z-50 ">
                <a href="{{ route('admin.dashboard') }}">
                    <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                </a>
            </div>
            <div class="p-6 border-b">
                <h1 class="text-2xl font-bold text-gray-800">Admin Panel</h1>
            </div>
            <nav class="p-4">
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('admin.dashboard') }}"
                            class="block py-2 px-4 hover:bg-gray-100 
                           {{ request()->routeIs('admin.dashboard') ? 'bg-accent-light text-accent' : 'text-gray-700' }}">
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.user-management') }}"
                            class="block py-2 px-4 hover:bg-gray-100
                           {{ request()->routeIs('admin.user-management') ? 'bg-accent-light text-accent' : 'text-gray-700' }}">
                            User Management
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.movies.index') }}"
                            class="block py-2 px-4 hover:bg-gray-100
                           {{ request()->routeIs('admin.movies.index') ? 'bg-accent-light text-accent' : 'text-gray-700' }}">
                            Movies
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.albums.index') }}"
                            class="block py-2 px-4 hover:bg-gray-100
                           {{ request()->routeIs('admin.albums.index') ? 'bg-accent-light text-accent' : 'text-gray-700' }}">
                            Albums
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.artists.index') }}"
                            class="block py-2 px-4 hover:bg-gray-100
                           {{ request()->routeIs('admin.artists.index') ? 'bg-accent-light text-accent' : 'text-gray-700' }}">
                            Artists
                        </a>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <button type="submit" class="w-full text-left py-2 px-4 hover:bg-red-50 hover:text-red-600 text-gray-700">
                                Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </nav>
        </aside>
        <!-- Overlay for mobile sidebar -->
        <div
            x-show="isSidebarOpen"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-30 bg-black opacity-50 md:hidden"
            @click="isSidebarOpen = false">
        </div>

        <!-- Main Content -->
        <main class="flex-1 p-4 md:p-10 transition-all duration-300 ease-in-out">
            <header class="mb-4 md:mb-8">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0">
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800">@yield('page-title')</h2>
                    <div class="text-sm text-gray-500">
                        Logged in as: {{ Auth::user()->name }}
                    </div>
                </div>
            </header>

            @yield('content')
        </main>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('screen', {
                md: window.innerWidth >= 768,
                check(breakpoint) {
                    switch (breakpoint) {
                        case 'md':
                            return this.md;
                        default:
                            return false;
                    }
                }
            });

            window.addEventListener('resize', () => {
                Alpine.store('screen').md = window.innerWidth >= 768;
            });
        });
    </script>
</body>

</html>