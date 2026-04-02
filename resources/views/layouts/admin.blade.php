<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" 
      x-data="{ 
          isSidebarOpen: false, 
          isSidebarCollapsed: false,
          isUserMenuOpen: false,
          isNotificationsOpen: false 
      }">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/x-icon">

    <title>@yield('page-title') | Admin | {{ config('app.name') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        body { font-family: 'Outfit', sans-serif; }
        [x-cloak] { display: none !important; }
        .sidebar-transition { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .glass-header { 
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(243, 244, 246, 1);
        }
    </style>
</head>

<body class="bg-[#f8fafc] text-gray-900 antialiased overflow-x-hidden">

    <div class="flex min-h-screen relative">
        
        <!-- Sidebar Backdrop (Mobile) -->
        <div x-show="isSidebarOpen" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="isSidebarOpen = false"
             class="fixed inset-0 z-40 bg-gray-900/40 backdrop-blur-sm lg:hidden" 
             x-cloak>
        </div>

        <!-- Sidebar -->
        <aside id="admin-sidebar"
            class="sidebar-transition fixed inset-y-0 left-0 z-50 flex flex-col bg-white border-r border-gray-100 shadow-xl 
                   lg:static lg:translate-x-0"
            :class="{
                'translate-x-0 w-72': isSidebarOpen,
                '-translate-x-full w-72 lg:w-72': !isSidebarOpen && !isSidebarCollapsed,
                'lg:w-24': isSidebarCollapsed
            }">
            
            <!-- Sidebar Header / Logo -->
            <div class="h-20 flex items-center px-6 border-b border-gray-50 bg-white sticky top-0 z-10">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 overflow-hidden">
                    <div class="min-w-[40px]">
                        <x-application-logo class="w-10 h-auto" />
                    </div>
                    <div class="sidebar-text-transition" :class="isSidebarCollapsed ? 'opacity-0 w-0' : 'opacity-100'">
                        <span class="text-xl font-black tracking-tighter text-blue-600 block whitespace-nowrap">CG ADMIN</span>
                    </div>
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="flex-1 overflow-y-auto overflow-x-hidden p-4">
                <nav>
                    <ul class="space-y-2">
                        <x-admin.sidebar-item href="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.dashboard')" icon="fas fa-th-large">
                            <span :class="isSidebarCollapsed ? 'hidden' : ''">Dashboard</span>
                        </x-admin.sidebar-item>

                        <x-admin.sidebar-item href="{{ route('admin.user-management') }}" :active="request()->routeIs('admin.user-management')" icon="fas fa-users">
                            <span :class="isSidebarCollapsed ? 'hidden' : ''">User Management</span>
                        </x-admin.sidebar-item>

                        <div class="pt-4 pb-2 px-4" :class="isSidebarCollapsed ? 'text-center' : ''">
                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest" :class="isSidebarCollapsed ? 'hidden' : ''">Content</span>
                            <div x-show="isSidebarCollapsed" class="h-px bg-gray-100 w-full"></div>
                        </div>

                        <x-admin.sidebar-item href="{{ route('admin.movies.index') }}" :active="request()->routeIs('admin.movies.*')" icon="fas fa-film">
                            <span :class="isSidebarCollapsed ? 'hidden' : ''">Movies</span>
                        </x-admin.sidebar-item>

                        <x-admin.sidebar-item href="{{ route('admin.tvshows.index') }}" :active="request()->routeIs('admin.tvshows.*')" icon="fas fa-tv">
                            <span :class="isSidebarCollapsed ? 'hidden' : ''">TV Shows</span>
                        </x-admin.sidebar-item>

                        <x-admin.sidebar-item href="{{ route('admin.songs.index') }}" :active="request()->routeIs('admin.songs.*')" icon="fas fa-music">
                            <span :class="isSidebarCollapsed ? 'hidden' : ''">Songs</span>
                        </x-admin.sidebar-item>

                        <x-admin.sidebar-item href="{{ route('admin.artists.index') }}" :active="request()->routeIs('admin.artists.*')" icon="fas fa-microphone">
                            <span :class="isSidebarCollapsed ? 'hidden' : ''">Artists</span>
                        </x-admin.sidebar-item>

                        <div class="pt-4 pb-2 px-4" :class="isSidebarCollapsed ? 'text-center' : ''">
                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest" :class="isSidebarCollapsed ? 'hidden' : ''">Site Design</span>
                            <div x-show="isSidebarCollapsed" class="h-px bg-gray-100 w-full"></div>
                        </div>

                        <x-admin.sidebar-item href="{{ route('admin.hero-banners.index') }}" :active="request()->routeIs('admin.hero-banners.*')" icon="fas fa-images">
                            <span :class="isSidebarCollapsed ? 'hidden' : ''">Hero Banners</span>
                        </x-admin.sidebar-item>

                        <x-admin.sidebar-item href="{{ route('admin.articles.index') }}" :active="request()->routeIs('admin.articles.*')" icon="fas fa-newspaper">
                            <span :class="isSidebarCollapsed ? 'hidden' : ''">Articles</span>
                        </x-admin.sidebar-item>

                        <div class="pt-4 pb-2 px-4" :class="isSidebarCollapsed ? 'text-center' : ''">
                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest" :class="isSidebarCollapsed ? 'hidden' : ''">Core Settings</span>
                            <div x-show="isSidebarCollapsed" class="h-px bg-gray-100 w-full"></div>
                        </div>

                        <li>
                            <div x-data="{ open: {{ (request()->is('admin/regions*') || request()->is('admin/genres*')) ? 'true' : 'false' }} }">
                                <button @click="open = !open" 
                                    class="group flex items-center w-full px-4 py-3 text-sm font-bold transition-all duration-200 rounded-2xl text-gray-500 hover:bg-blue-50 hover:text-blue-600">
                                    <div class="mr-3 p-2 rounded-xl bg-gray-50 text-gray-400 group-hover:bg-white group-hover:text-blue-500 group-hover:shadow-sm transition-all">
                                        <i class="fas fa-cog text-base"></i>
                                    </div>
                                    <span class="flex-1 text-left" :class="isSidebarCollapsed ? 'hidden' : ''">Settings</span>
                                    <i class="fas fa-chevron-down text-[10px] transition-transform duration-200" :class="[open ? 'rotate-180' : '', isSidebarCollapsed ? 'hidden' : '']"></i>
                                </button>
                                <ul x-show="open" x-cloak class="mt-1 space-y-1" :class="isSidebarCollapsed ? 'hidden' : 'pl-14'">
                                    <li>
                                        <a href="{{ route('admin.regions.index') }}" @class([
                                            'block py-2 px-4 rounded-xl text-xs font-bold transition-colors',
                                            'text-blue-600 bg-blue-50' => request()->routeIs('admin.regions.*'),
                                            'text-gray-500 hover:text-blue-600 hover:bg-gray-50' => !request()->routeIs('admin.regions.*'),
                                        ])>Regions</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.genres.index') }}" @class([
                                            'block py-2 px-4 rounded-xl text-xs font-bold transition-colors',
                                            'text-blue-600 bg-blue-50' => request()->routeIs('admin.genres.*'),
                                            'text-gray-500 hover:text-blue-600 hover:bg-gray-50' => !request()->routeIs('admin.genres.*'),
                                        ])>Genres</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </nav>
            </div>

            <!-- Sidebar Footer -->
            <div class="p-4 border-t border-gray-50 bg-gray-50/50">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center px-4 py-3 text-sm font-bold text-rose-500 hover:bg-rose-50 rounded-2xl transition-all">
                        <div class="mr-3 p-2 rounded-xl bg-rose-100/50 text-rose-500">
                            <i class="fas fa-sign-out-alt text-base"></i>
                        </div>
                        <span :class="isSidebarCollapsed ? 'hidden' : ''">Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-w-0 bg-[#f8fafc]">
            
            <!-- Top Navbar -->
            <header class="glass-header h-20 flex items-center justify-between px-4 lg:px-8 sticky top-0 z-30">
                
                <div class="flex items-center">
                    <!-- Mobile Toggle -->
                    <button @click="isSidebarOpen = !isSidebarOpen" class="lg:hidden p-2 text-gray-500 hover:bg-gray-100 rounded-xl mr-2">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <!-- Desktop Collapse Toggle -->
                    <button @click="isSidebarCollapsed = !isSidebarCollapsed" class="hidden lg:block p-2 text-gray-500 hover:bg-gray-100 rounded-xl mr-4">
                        <i class="fas fa-indent text-xl transition-transform" :class="isSidebarCollapsed ? 'rotate-180' : ''"></i>
                    </button>

                    <!-- Page Title (Desktop) -->
                    <h1 class="hidden md:block text-xl font-black text-gray-800 tracking-tight">
                        @yield('page-title', 'Dashboard')
                    </h1>
                </div>

                <!-- Right Actions -->
                <div class="flex items-center space-x-2 lg:space-x-4">
                    
                    <!-- Search Bar (Desktop) -->
                    <div class="hidden sm:flex relative items-center">
                        <span class="absolute left-4 text-gray-400">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" placeholder="Global search..." 
                               class="bg-gray-100 border-none rounded-2xl pl-10 pr-4 py-2 text-sm focus:ring-2 focus:ring-blue-500/20 w-48 lg:w-64 transition-all">
                    </div>

                    <!-- Notifications -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false" 
                                class="p-3 text-gray-500 hover:bg-gray-100 rounded-2xl relative transition-all">
                            <i class="far fa-bell text-xl"></i>
                            <span class="absolute top-3 right-3 w-2 h-2 bg-rose-500 rounded-full border-2 border-white"></span>
                        </button>
                        <div x-show="open" x-cloak 
                             class="absolute right-0 mt-2 w-80 bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden transform origin-top-right transition-all">
                            <div class="p-4 border-b border-gray-50 flex justify-between items-center">
                                <span class="font-bold text-sm">Notifications</span>
                                <span class="text-[10px] bg-blue-50 text-blue-600 px-2 py-0.5 rounded-full font-black">2 NEW</span>
                            </div>
                            <div class="py-2">
                                <a href="#" class="flex px-4 py-3 hover:bg-gray-50 transition-colors">
                                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center mr-3 shrink-0">
                                        <i class="fas fa-user-plus text-xs"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-gray-800">New user registered</p>
                                        <p class="text-[10px] text-gray-400 mt-0.5">2 minutes ago</p>
                                    </div>
                                </a>
                                <a href="#" class="flex px-4 py-3 hover:bg-gray-50 transition-colors">
                                    <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center mr-3 shrink-0">
                                        <i class="fas fa-flag text-xs"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-gray-800">Content flagged for review</p>
                                        <p class="text-[10px] text-gray-400 mt-0.5">1 hour ago</p>
                                    </div>
                                </a>
                            </div>
                            <a href="#" class="block p-3 text-center text-[10px] font-black text-blue-600 bg-gray-50 hover:bg-blue-50 transition-colors">VIEW ALL</a>
                        </div>
                    </div>

                    <!-- User Profile -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false" 
                                class="flex items-center space-x-3 p-1.5 hover:bg-gray-100 rounded-2xl transition-all">
                            <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center font-black shadow-lg shadow-blue-200">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <div class="hidden lg:block text-left">
                                <p class="text-xs font-black text-gray-800 leading-tight">{{ Auth::user()->name }}</p>
                                <p class="text-[10px] font-bold text-gray-400">Super Admin</p>
                            </div>
                            <i class="fas fa-chevron-down text-[10px] text-gray-400 transition-transform hidden lg:block" :class="open ? 'rotate-180' : ''"></i>
                        </button>
                        <div x-show="open" x-cloak 
                             class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden transform origin-top-right transition-all">
                            <div class="p-4 bg-gray-50 border-b border-gray-50">
                                <p class="text-xs font-black text-gray-800">{{ Auth::user()->name }}</p>
                                <p class="text-[10px] text-gray-400 truncate">{{ Auth::user()->email }}</p>
                            </div>
                            <div class="p-2">
                                <a href="#" class="flex items-center px-4 py-2.5 text-xs font-bold text-gray-600 hover:bg-blue-50 hover:text-blue-600 rounded-xl transition-all">
                                    <i class="far fa-user mr-3 text-sm opacity-50"></i> Profile Settings
                                </a>
                                <a href="#" class="flex items-center px-4 py-2.5 text-xs font-bold text-gray-600 hover:bg-blue-50 hover:text-blue-600 rounded-xl transition-all">
                                    <i class="fas fa-shield-alt mr-3 text-sm opacity-50"></i> Security
                                </a>
                            </div>
                            <div class="p-2 border-t border-gray-50">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center px-4 py-2.5 text-xs font-bold text-rose-500 hover:bg-rose-50 rounded-xl transition-all">
                                        <i class="fas fa-sign-out-alt mr-3 text-sm opacity-50"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 p-4 lg:p-8">
                <x-notification-toast />
                
                <!-- Mobile Breadcrumb / Title -->
                <div class="md:hidden mb-6">
                    <h2 class="text-2xl font-black text-gray-800 tracking-tight">@yield('page-title')</h2>
                    <p class="text-xs text-gray-400 font-bold">Admin Panel Dashboard</p>
                </div>

                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="p-6 text-center">
                <p class="text-xs text-[10px] font-black text-gray-400 uppercase tracking-widest">
                    &copy; {{ date('Y') }} CG Chartbusters
                </p>
            </footer>
        </div>
    </div>

    @livewireScripts
</body>
</html>
