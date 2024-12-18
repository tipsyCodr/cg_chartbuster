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


<body class="font-montserrat text-sm bg-white ">
    <div
        class="flex min-h-screen  2xl:max-w-screen-2xl 2xl:mx-auto 2xl:border-x-2 2xl:border-gray-200 ">
        <!-- Left Sidebar -->
        <x-left-sidebar />
        <!-- /Left Sidebar -->

        <main class=" flex-1 py-10  px-5 sm:px-10 " x-data="{ isActive: 'movies' }">
            <x-mobile-navbar />

            <nav class="flex space-x-6 text-gray-400 font-medium">
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
        <x-right-sidebar :movies="$movies" :artists="$artists" />
        <!-- /Right Sidebar -->

    </div>

</body>

</html>
