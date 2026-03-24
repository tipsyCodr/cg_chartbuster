<div x-data="{ mobileMenuOpen: false }" class="container flex flex-col items-center justify-between gap-4 py-4 mx-auto md:flex-row md:gap-0 md:py-5 max-w-7xl">
    <!-- Logo + Desktop Nav Links -->
    <div class="flex items-center justify-between w-full gap-3 md:w-auto md:justify-start md:gap-4">
        <a href="{{ route('home') }}"
            class="flex items-center font-medium text-gray-100 lg:w-auto">
            <img src="{{ asset('images/logo.png') }}" class="w-auto h-auto max-w-[120px] md:max-w-[150px]" alt="Logo">
        </a>

        <!-- Hamburger Button -->
        <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-300 md:hidden focus:outline-none">
            <i class="fa-solid" :class="mobileMenuOpen ? 'fa-xmark fa-2x' : 'fa-bars fa-2x'"></i>
        </button>

        <!-- Desktop Navigation -->
        <nav
            class="hidden md:flex items-center justify-start gap-6 text-sm md:ml-8 md:gap-8 md:border-l md:border-gray-700 md:pl-8 md:text-base">
            <a href="{{ route('home') }}" class="font-medium text-gray-300 transition-colors hover:text-yellow-400">Home</a>
            <a href="{{ route('movies') }}" class="font-medium text-gray-300 transition-colors hover:text-yellow-400">Movies</a>
            <a href="{{ route('tv-shows') }}" class="font-medium text-gray-300 transition-colors hover:text-yellow-400">TV Shows</a>
            <a href="{{ route('songs') }}" class="font-medium text-gray-300 transition-colors hover:text-yellow-400">Songs</a>
            <a href="{{ route('artists') }}" class="font-medium text-gray-300 transition-colors hover:text-yellow-400">Artists</a>
        </nav>
    </div>

    <!-- Search Bar + Auth Links -->
    <div class="flex items-center justify-between w-full md:w-auto gap-3 md:gap-6">
        <!-- Search Box (Desktop and Tablet) -->
        <div class="relative flex-1 md:flex-none md:w-[250px] lg:w-[300px]">
            <input
                type="text"
                id="liveSearchInput"
                name="query"
                placeholder="Search..."
                autocomplete="off"
                class="w-full px-4 py-2 pl-10 pr-4 text-sm text-white bg-gray-900/50 border border-gray-600 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent transition-all"
            />
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                <i class="fa fa-search"></i>
            </div>

            <!-- Floating Results -->
            <div id="liveSearchResults"
                class="absolute z-[100] w-full mt-2 bg-gray-900 border border-gray-700 rounded-lg shadow-2xl hidden max-h-[70vh] overflow-y-auto">
                <div id="liveSearchLoading"
                    class="items-center justify-center py-6 text-gray-400 hidden">
                    <svg class="w-6 h-6 mr-3 animate-spin text-yellow-500" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8v4l3.5-3.5L12 0v4a8 8 0 00-8 8z"></path>
                    </svg>
                    <span>Searching...</span>
                </div>
            </div>
        </div>

        <!-- Language & Auth -->
        <div class="flex items-center gap-4 shrink-0">
            <!-- Google Translate Widget -->
            <div id="google_translate_element" class="hidden lg:block"></div>

            <!-- Manual Toggle (EN/HI) -->
            <div class="flex items-center bg-gray-800 rounded-full p-1 border border-gray-700">
                <a href="{{ route('set-locale', 'en') }}" 
                   class="px-3 py-1 text-xs font-bold rounded-full transition-all {{ app()->getLocale() == 'en' ? 'bg-yellow-500 text-black shadow-lg' : 'text-gray-400 hover:text-white' }}">
                    EN
                </a>
                <a href="{{ route('set-locale', 'hi') }}" 
                   class="px-3 py-1 text-xs font-bold rounded-full transition-all {{ app()->getLocale() == 'hi' ? 'bg-yellow-500 text-black shadow-lg' : 'text-gray-400 hover:text-white' }}">
                    हि
                </a>
            </div>

            <!-- User Menu -->
            @auth
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = ! open"
                        class="flex items-center gap-2 font-medium text-gray-300 hover:text-yellow-400 transition-colors">
                        <span class="hidden sm:inline">{{ explode(' ', auth()->user()->name)[0] }}</span>
                        <i class="fa-solid fa-circle-user text-2xl"></i>
                    </button>
                    <div x-show="open" @click.outside="open = false"
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        class="absolute right-0 mt-3 w-48 bg-gray-900 border border-gray-700 rounded-lg shadow-2xl py-2 z-[110]">
                        <a href="{{ route('profile.edit') }}"
                            class="block px-4 py-2.5 text-sm text-gray-300 hover:bg-gray-800 hover:text-yellow-400 transition-colors">Your Profile</a>
                        <div class="h-px bg-gray-700 my-1 mx-2"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button
                                class="block px-4 py-2.5 text-sm text-gray-300 hover:bg-gray-800 hover:text-red-400 w-full text-left transition-colors">Log out</button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="font-medium text-gray-300 hover:text-yellow-400 transition-colors">
                    <i class="fa-solid fa-circle-user text-2xl"></i>
                </a>
            @endauth
        </div>
    </div>

    <!-- Mobile Navigation Menu -->
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-4"
         class="md:hidden w-full bg-gray-900/95 backdrop-blur-md rounded-xl border border-gray-700 p-4 shadow-2xl mt-2" x-cloak>
        <nav class="flex flex-col gap-4">
            <a href="{{ route('home') }}" @click="mobileMenuOpen = false" class="py-2 text-base font-semibold text-gray-200 border-b border-gray-800 flex justify-between items-center group">
                Home <i class="fa-solid fa-chevron-right text-xs text-gray-600 group-hover:text-yellow-400 transition-colors"></i>
            </a>
            <a href="{{ route('movies') }}" @click="mobileMenuOpen = false" class="py-2 text-base font-semibold text-gray-200 border-b border-gray-800 flex justify-between items-center group">
                Movies <i class="fa-solid fa-chevron-right text-xs text-gray-600 group-hover:text-yellow-400 transition-colors"></i>
            </a>
            <a href="{{ route('tv-shows') }}" @click="mobileMenuOpen = false" class="py-2 text-base font-semibold text-gray-200 border-b border-gray-800 flex justify-between items-center group">
                TV Shows <i class="fa-solid fa-chevron-right text-xs text-gray-600 group-hover:text-yellow-400 transition-colors"></i>
            </a>
            <a href="{{ route('songs') }}" @click="mobileMenuOpen = false" class="py-2 text-base font-semibold text-gray-200 border-b border-gray-800 flex justify-between items-center group">
                Songs <i class="fa-solid fa-chevron-right text-xs text-gray-600 group-hover:text-yellow-400 transition-colors"></i>
            </a>
            <a href="{{ route('artists') }}" @click="mobileMenuOpen = false" class="py-2 text-base font-semibold text-gray-200 flex justify-between items-center group">
                Artists <i class="fa-solid fa-chevron-right text-xs text-gray-600 group-hover:text-yellow-400 transition-colors"></i>
            </a>
        </nav>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const input = document.getElementById("liveSearchInput");
        const resultsBox = document.getElementById("liveSearchResults");
        const loading = document.getElementById("liveSearchLoading");

        const debounce = (func, delay) => {
            let timer;
            return function (...args) {
                clearTimeout(timer);
                timer = setTimeout(() => func.apply(this, args), delay);
            };
        };

        const fetchSearchResults = debounce(function () {
            const query = input.value.trim();

            if (query.length < 2) {
                resultsBox.classList.add("hidden");
                resultsBox.innerHTML = "";
                return;
            }

            // Show results box + loading spinner
            resultsBox.classList.remove("hidden");
            resultsBox.innerHTML = "";
            loading.classList.remove("hidden");
            resultsBox.appendChild(loading);

            fetch(`/live-search?query=${encodeURIComponent(query)}`)
                .then(res => res.json())
                .then(data => {
                    let html = "";

                    const renderSection = (title, items, route, prop = 'title') => {
                        if (items.length > 0) {
                            html += `<div class="px-4 py-2 text-sm font-semibold text-gray-800 bg-gray-100">${title}</div>`;
                            items.forEach(item => {
                                html += `<a href="/${route}/${item.slug}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-yellow-100">${item[prop]}</a>`;
                            });
                        }
                    };

                    renderSection("Movies", data.movies, "movie");
                    renderSection("TV Shows", data.tvshows, "tv-show");
                    renderSection("Songs", data.songs, "song");
                    renderSection("Artists", data.artists, "artist", "name");

                    if (!html) {
                        html = `<div class="px-4 py-2 text-sm text-gray-500">No results found.</div>`;
                    }

                    resultsBox.innerHTML = html;
                })
                .catch(() => {
                    resultsBox.innerHTML = `<div class="px-4 py-2 text-sm text-red-500">Error fetching results.</div>`;
                });
        }, 300); // ⏱ 300ms debounce

        input.addEventListener("input", fetchSearchResults);

        // Hide results box on outside click
        document.addEventListener("click", function (e) {
            if (!input.contains(e.target) && !resultsBox.contains(e.target)) {
                resultsBox.classList.add("hidden");
            }
        });
    });
</script>
