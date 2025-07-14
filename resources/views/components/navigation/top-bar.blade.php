<div class="container flex flex-col items-center justify-between gap-4 py-5 mx-auto md:flex-row md:gap-0 max-w-7xl">
    <!-- Logo + Nav Links -->
    <div class="flex flex-col items-center justify-center w-full gap-4 md:flex-row md:justify-start md:w-auto">
        <a href="{{ route('home') }}"
            class="flex items-center font-medium text-gray-100 lg:w-auto">
            <img src="{{ asset('images/logo.png') }}" class="w-auto h-auto max-w-[150px]" alt="">
        </a>
        <nav class="flex flex-wrap items-center justify-center gap-12 text-base md:ml-8 md:pl-8 md:border-l md:border-gray-200">
            <a href="{{ route('home') }}" class="font-medium text-gray-300 hover:text-yellow-300">Home</a>
            <a href="{{ route('movies') }}" class="font-medium text-gray-300 hover:text-yellow-300">Movies</a>
            <a href="{{ route('tv-shows') }}" class="font-medium text-gray-300 hover:text-yellow-300">TV Shows</a>
            <a href="{{ route('songs') }}" class="font-medium text-gray-300 hover:text-yellow-300">Songs</a>
            <a href="{{ route('artists') }}" class="font-medium text-gray-300 hover:text-yellow-300">Artist</a>
        </nav>
    </div>

    <!-- Search Bar + Auth Links -->
    <div class="flex items-center justify-end w-full md:w-auto gap-4 md:gap-6">

        <!-- Search Box -->
        <div class="relative max-w-xs w-full">
            <input
                type="text"
                id="liveSearchInput"
                name="query"
                placeholder="Search..."
                autocomplete="off"
                class="w-full px-4 py-2 pl-10 pr-4 text-sm text-white bg-gray-800 border border-gray-500 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-300"
            />
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                <i class="fa fa-search"></i>
            </div>

            <!-- Floating Results -->
            <div id="liveSearchResults"
                class="absolute z-50 w-full mt-2 bg-white rounded-md shadow-lg hidden max-h-80 overflow-auto border border-gray-200">
                <div id="liveSearchLoading"
                    class="flex items-center justify-center py-4 text-gray-500 hidden">
                    <svg class="w-5 h-5 mr-2 animate-spin text-yellow-500" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8v4l3.5-3.5L12 0v4a8 8 0 00-8 8z"></path>
                    </svg>
                    Loading...
                </div>
            </div>
        </div>

        <!-- Auth / User Menu -->
        <div>
            @auth
                <div x-data="{ open: false }">
                    <button @click="open = ! open"
                        class="flex items-center font-medium text-gray-300 hover:text-gray-100">
                        {{ explode(' ', auth()->user()->name)[0] }}
                        <i class="fa-solid fa-user-circle fa-2x ml-2"></i>
                    </button>
                    <div x-show="open" @click.outside="open = false"
                        class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                        <a href="{{ route('profile.edit') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Your Profile</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 w-full text-left">Log out</button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="font-medium text-gray-300 hover:text-gray-100">
                    <i class="text-yellow-400 fa-solid fa-user-circle fa-2x"></i>
                </a>
            @endauth
        </div>
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
                                html += `<a href="/${route}/${item.id}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-yellow-100">${item[prop]}</a>`;
                            });
                        }
                    };

                    renderSection("Movies", data.movies, "movie");
                    renderSection("TV Shows", data.tvshows, "tvshow");
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