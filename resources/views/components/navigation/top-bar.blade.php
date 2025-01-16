<div class="" x-data="{ open: false }">
    <nav>
        <section class="w-full px-8 text-gray-100 " {!! $attributes ?? '' !!}>
            <div class="container flex flex-col items-center justify-between py-5 mx-auto md:flex-row max-w-7xl">
                <div class="relative flex flex-col md:flex-row ">
                    <a href="#_" class="flex items-center mb-5 font-medium text-gray-100 lg:w-auto lg:items-center lg:justify-center md:mb-0">
                        <img src="{{ asset('images/logo.png') }}" class="w-auto h-auto max-w-[150px]" alt="">
                    </a>
                    <nav class="items-center hidden gap-6 mb-5 text-base sm:flex md:mb-0 md:pl-8 md:ml-8 md:border-l md:border-gray-200">
                        <a href="{{ route('home') }}" class="mr-8 font-medium leading-6 text-gray-300 hover:text-yellow-300">
                            Home
                        </a>
                        <a href="{{ route('movies') }}" class="mr-8 font-medium leading-6 text-gray-300 hover:text-yellow-300">
                            Movies
                        </a>
                        <a href="{{ route('tv-shows') }}" class="mr-8 font-medium leading-6 text-gray-300 text-nowrap hover:text-yellow-300">
                            TV Shows
                        </a>
                        <a href="{{ route('songs') }}" class="mr-8 font-medium leading-6 text-gray-300 hover:text-yellow-300">
                            Songs
                        </a>
                        <a href="{{ route('artists') }}" class="mr-8 font-medium leading-6 text-gray-300 hover:text-yellow-300">
                            Artist
                        </a>
                    </nav>
                </div>
    
                <div class="items-center hidden ml-5 space-x-6 md:inline-flex lg:justify-end">
    
                    <div class="hidden mb-5 text-base lg:block md:mb-0 md:pl-8 md:ml-8 ">
                        <form action="" method="GET" class="relative w-full mr-8 md:w-auto">
                            <input type="text" name="query" placeholder="Search" class="w-full px-4 py-2 text-base text-gray-700 transition duration-150 ease-in-out bg-gray-800 border border-gray-600 rounded-full focus:border-none focus:text-yellow-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-200" />
                            <button type="submit" class="absolute inset-y-0 right-0 flex items-center px-4 text-gray-500 hover:text-gray-700">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </form>
                    </div>
                      <div class="">
                        @auth
                            <a href="" class="mr-5 font-medium leading-6 text-gray-300 hover:text-gray-100">
                            <i class="fa-solid fa-user"></i> {{ auth()->user()->name }}
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="mr-5 font-medium leading-6 text-gray-300 hover:text-gray-100">
                                <i class="text-yellow-400 fa-solid fa-user-circle fa-2x"></i>
                            </a>
                        @endauth
                      </div>
                </div>
    
    
            </div>
        </section>
    
        <div class="flex flex-row justify-between w-full px-4 py-2 bg-black sm:hidden">
            <div class="" @click="open = ! open" >
                <a href="#" class="inline-flex items-center justify-center px-5 py-2 text-base font-medium text-black bg-yellow-400 border border-transparent rounded-md hover:bg-yellow-700">
                    <i class="fa-solid fa-bars"></i>
                </a>
            </div>
            <div class="">
                @auth
                    <a href="" class="mr-5 font-medium leading-6 text-gray-300 hover:text-gray-100">
                        <i class="fa-solid fa-user"></i> {{ auth()->user()->name }}
                    </a>
                @else
                    <a href="{{ route('login') }}" class="mr-5 font-medium leading-6 text-gray-300 hover:text-gray-100">
                        <i class="text-yellow-400 fa-solid fa-user-circle fa-2x"></i>
                    </a>
                @endauth
            </div>
    
        </div>
    </nav>
    <div class="mobile-bar ">
        <div class="fixed inset-0 bg-black bg-opacity-50 " x-show="open" @click="open = false" x-transition:enter="ease-out duration-300" x-transition:leave="ease-in duration-200" style="display: none;">
            <a class="absolute top-4 right-4" href="#">
                <i class="text-2xl text-white fa-solid fa-xmark"></i>
            </a>
        </div>
      
        <div id='sidebar'  :class="{'translate-x-0': open, '-translate-x-full': !open}" class="fixed top-0 left-0 z-10 h-full px-5 py-2 transition-transform duration-300 transform bg-gray-900 w-50">
            <a href="/" class="flex items-center mb-5">
                <img src="{{ asset('images/logo.png') }}" class="w-full h-full max-w-[150px]" alt="">
            </a>
    
            <nav class="flex flex-col px-4 py-2 space-y-2 text-sm">
                <a href="#" class="py-2 hover:text-yellow-300">
                    Home
                </a>
                <a href="{{ route('movies') }}" class="py-2 hover:text-yellow-300">
                    Movies
                </a>
                <a href="#" class="py-2 hover:text-yellow-300">
                    TV Shows
                </a>
                <a href="#" class="py-2 hover:text-yellow-300">
                    Songs
                </a>
                <a href="#" class="py-2 hover:text-yellow-300">
                    Artist
                </a>
            </nav>
    
        </div>
    </div>
</div>

