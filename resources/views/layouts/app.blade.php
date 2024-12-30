<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" :class="isDark ? 'dark' : 'light'" x-data="{ isDark: false }">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>


<body class="text-sm bg-white font-montserrat " x-data="{ 
    isDark: sessionStorage.getItem('isDark') === 'true',
    toggleDarkMode() {
        this.isDark = !this.isDark;
        sessionStorage.setItem('isDark', this.isDark);
    }
}" x-bind:class="isDark ? 'dark-mode' : 'light-mode'" x-transition>  
    <div
        class="flex min-h-screen 2xl:max-w-screen-2xl 2xl:mx-auto ">
        <!-- Left Sidebar -->
        <x-left-sidebar />
        <!-- /Left Sidebar -->

        <main  class="flex-1 px-5 py-10 sm:px-10" x-data="{ isActive: 'movies' }">
            <x-mobile-navbar />

            <nav class="flex space-x-6 font-medium text-gray-400">
                <a @click="isActive = 'movies'"
                    :class="{ 'text-gray-700 font-semibold': isActive === 'movies' }"
                    href="#">Movies</a>
                <a @click="isActive = 'albums'"
                    :class="{ 'text-gray-700 font-semibold': isActive === 'albums' }"
                    href="#">Albums</a>
                <a @click="isActive = 'artists'"
                    :class="{ 'text-gray-700 font-semibold': isActive === 'artists' }"
                    href="#">Artists</a>
            </nav>

            {{-- main content starts from here --}}
            <div class="mt-10">
                {{ $slot }}
            </div>
            {{-- main content ends here --}}

        </main>

        <!-- Right Sidebar -->
        {{-- <x-right-sidebar :movies="$movies" :artists="$artists" /> --}}
        <!-- /Right Sidebar -->

    </div>

</body>

</html>
