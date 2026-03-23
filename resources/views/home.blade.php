<x-app-layout>
    <style>
        /* Optional: You can add these custom styles in case you want to refine appearance, 
   but Tailwind's responsive utilities will handle most of this. */
        .carousel {
            max-width: 100%;
            overflow: hidden;
        }

        .swiper-next,
        .swiper-prev {
            position: absolute;
            z-index: 1;
            top: 50%;
            padding: 10px;
            transform: translateY(-50%);
            background-color: rgba(0, 0, 0, 0.5);
            color: #fff;
            cursor: pointer;
        }

        .swiper-prev {
            left: 10px;
        }

        .swiper-next {
            right: 10px;
        }

        .swiper-next:active,
        .swiper-prev:active {
            transform: translateY(-50%) scale(0.9);
            background-color: rgba(0, 0, 0, 0.7);
        }

        /* For the thumbnail slider */
        /* .thumbnail-slider-container {
            display: flex;
            flex-direction: column;
            width: 305px;
            height: 600px;
            margin-left: 16px;
            margin-top: 72px;

        } */

        .thumbnail-slider {
            height: 100%;
        }

        .thumbnail-slider .swiper-slide-thumb-active {
            background-color: rgba(55, 65, 81, 0.6);
            border-left: 4px solid #eab308 !important;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        .thumbnail-slider .swiper-slide {
            cursor: pointer;
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }

        .movie-next.swiper-button-disabled,
        .movie-prev.swiper-button-disabled,
        .song-next.swiper-button-disabled,
        .song-prev.swiper-button-disabled,
        .artist-next.swiper-button-disabled,
        .artist-prev.swiper-button-disabled {
            opacity: 0 !important;
            pointer-events: none;
        }

        .thumbnail-swiper-button-prev,
        .thumbnail-swiper-button-next {
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            z-index: 10;
            cursor: pointer;
        }

        /* Adjustments for mobile and tablet */
        @media (max-width: 1024px) {
            .thumbnail-slider-container {
                display: none;
                /* Hide thumbnail slider on tablets and mobile */
            }
        }

        @media (max-width: 768px) {
            .swiper.main-slider {
                width: 100%;
                /* Full width of the screen on tablets and smaller */
            }
        }

        .text-stroke {
            -webkit-text-stroke: 2px #fff;
        }

        .text-shadow-md {
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
    <section class="flex flex-col items-stretch gap-6 carousel lg:flex-row h-[280px] sm:h-[350px] md:h-[450px] lg:h-[480px] xl:h-[550px]">
        <div class="w-full swiper main-slider lg:flex-1 h-full rounded-xl overflow-hidden shadow-2xl">
            <!-- Main slider -->
            <div class="swiper-wrapper h-full">
                @foreach ($banner_images as $banner_image)
                    <div class="overflow-hidden swiper-slide h-full">
                        <img class="w-full h-full object-cover"
                            src="{{ asset('storage/' . $banner_image['poster_image_landscape']) }}" alt="Banner Image">
                        <div class="absolute bottom-0 left-0 w-full h-1/2 bg-gradient-bottoms black-tint"></div>
                        <div class="absolute right-4 bottom-4 left-4 text-left text-white transform sm:bottom-6 sm:left-6 sm:right-auto">
                            <div class="flex gap-3">
                                <img class="rounded-lg w-full h-auto max-w-[80px] md:max-w-[120px]"
                                    src="{{ asset('storage/' . $banner_image['poster_image']) }}" alt="">
                                <div class="flex flex-col justify-end">
                                    <h1 class="text-sm font-bold break-words md:text-3xl">{{ $banner_image['title'] }}</h1>
                                    <small><i class='text-yellow-300 fas fa-calender'></i>
                                        {{ $banner_image['release_date'] }}</small>
                                    <div class="flex flex-row items-center ">
                                        <img class="m-1 " style="width:25px;height:25px;"
                                            src="{{ asset('images/badge.png') }}" alt="CG Chartbusters Rating">
                                        <p class="text-xs"> {{ $banner_image['cg_chartbusters_ratings'] ?? 1 }} /10 Ratings
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="swiper-pagination"></div>
            <div class="swiper-next"><i class="fa-solid fa-chevron-right fa-2x"></i></div>
            <div class="swiper-prev"><i class="fa-solid fa-chevron-left fa-2x"></i></div>
            <div class="swiper-scrollbar"></div>
        </div>
        <!-- Thumbnail Slider -->
        <div class="thumbnail-slider-container hidden lg:flex flex-col lg:w-[350px] xl:w-[400px] h-full bg-gray-900/40 rounded-xl p-4 border border-white/5">
            <h2 class="text-sm font-bold text-gray-400 mb-4 uppercase tracking-widest flex items-center gap-2">
                <span class="w-1 h-4 bg-yellow-500 rounded-full"></span>
                Up Next
            </h2>
            <div class="flex-1 overflow-hidden swiper thumbnail-slider">
                <div class="swiper-wrapper">
                    @foreach ($banner_images as $banner_image)
                        <div class="p-2 bg-gray-800/40 hover:bg-gray-800/80 rounded-lg cursor-pointer swiper-slide">
                            <div class="flex items-center h-full gap-4 px-2">
                                <div class="relative flex-shrink-0">
                                    <img class="object-cover w-16 h-20 rounded-md shadow-lg"
                                        src="{{ asset('storage/' . ($banner_image['poster_image'] ?? 'storage/images/coming-soon.png')) }}"
                                        alt="Thumbnail">
                                </div>
                                <div class="flex flex-col justify-center flex-1 min-w-0">
                                    <h1 class="text-xs font-bold truncate text-gray-100">
                                        {{ $banner_image['title'] }}
                                    </h1>
                                    <div class="flex items-center gap-1 mt-1">
                                        <img class="w-3 h-3" src="{{ asset('images/badge.png') }}" alt="Rating">
                                        <span class="text-[10px] text-gray-400">
                                            {{ $banner_image['cg_chartbusters_ratings'] ?? 1 }} / 10
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="swiper-pagination"></div>
                {{-- <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div> --}}
            <a href="{{ route('movies') }}" class="mt-4 text-blue-500 hover:underline">View More</a>
        </div>
    </section>

    <div class="">
        <section class="my-5 relative group">
            <h1 class="text-xl font-bold md:text-2xl lg:text-3xl"><span
                    class="mr-3 text-yellow-500 border-4 border-l border-yellow-500"> </span> Top 10 Movies</h1>
            <div class="swiper movie-slider !px-3 sm:!px-10">
                <div class="swiper-wrapper py-4">
                    @foreach ($movies as $movie)
                        <div class="swiper-slide">
                            <div class="flex-shrink-0 transition-all bg-gray-900 rounded-lg shadow-md">
                                <div class="relative min-w-40 max-w-40 sm:min-w-48 sm:max-w-48">
                                    {{-- rating --}}
                                    <span
                                        class="absolute z-50 mr-2 font-bold text-yellow-500 top-2 -left-5 text-shadow-md text-8xl text-stroke">{{ $loop->index + 1 }}</span>

                                    <a href="{{ route('movie.show', $movie->slug) }}">
                                        <img class="object-cover w-full h-56 transition-all duration-300 rounded-t-lg hover:brightness-90"
                                            src="{{ Storage::url($movie->poster_image) }}" alt="Movie Image">
                                    </a>
                                    <div class="px-4 py-4 bg-gray-900 rounded-b-lg">
                                        <div class="flex items-center justify-between mb-4">
                                            <div class="flex items-center gap-1 text-xs text-gray-300">
                                                <img src="{{ asset('images/badge.png') }}" alt="CG Chartbusters Rating"
                                                    class="w-4 h-4">
                                                <span>{{ $movie->cg_chartbusters_ratings }} / 10 Ratings</span>
                                            </div>
                                            <a href="{{ route('movie.show', $movie->slug) }}#review"
                                                class="px-3 py-2 font-bold text-center text-white bg-gray-900 rounded hover:bg-gray-600 active:bg-gray-500 "><i
                                                    class="fa-regular fa-star"></i></a>
                                        </div>
                                        <a href="{{ route('movie.show', $movie->slug) }}">
                                            <h2
                                                class="truncate text-sm font-normal text-white normal-case">
                                                {{ $loop->index + 1 }}. {{ ucwords(strtolower($movie->title)) }}
                                            </h2>
                                        </a>

                                        <a href="{{ route('movie.show', $movie->slug) }}"
                                            class="block w-full px-2 py-2 my-2 font-bold text-center text-white bg-gray-700 rounded-full hover:bg-gray-600 active:bg-gray-500 ">Details</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- Navigation -->
                <div class="movie-next absolute top-1/2 -right-4 z-50 flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 bg-gray-800/90 hover:bg-yellow-500 text-white hover:text-black rounded-full cursor-pointer shadow-xl transition-all opacity-100 sm:opacity-0 sm:group-hover:opacity-100 -translate-y-1/2 border border-white/10">
                    <i class="fa-solid fa-chevron-right text-lg"></i>
                </div>
                <div class="movie-prev absolute top-1/2 -left-4 z-50 flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 bg-gray-800/90 hover:bg-yellow-500 text-white hover:text-black rounded-full cursor-pointer shadow-xl transition-all opacity-100 sm:opacity-0 sm:group-hover:opacity-100 -translate-y-1/2 border border-white/10">
                    <i class="fa-solid fa-chevron-left text-lg"></i>
                </div>
            </div>

        </section>
        <section class="my-5 relative group">
            <h1 class="text-xl font-bold md:text-2xl lg:text-3xl"><span
                    class="mr-3 text-yellow-500 border-4 border-l border-yellow-500"> </span> Top 10 Songs</h1>
            <div class="swiper song-slider !px-3 sm:!px-10">
                <div class="swiper-wrapper py-4">
                    @foreach ($songs as $song)
                        <div class="swiper-slide">
                            <div class="flex-shrink-0 transition-all bg-gray-900 rounded-lg shadow-md">
                                <div class="relative min-w-40 max-w-40 sm:min-w-48 sm:max-w-48">
                                    <span
                                        class="absolute z-50 mr-2 font-bold text-yellow-500 top-2 -left-5 text-shadow-md text-8xl text-stroke">{{ $loop->index + 1 }}</span>

                                    <a href="{{ route('song.show', $song->slug) }}">
                                        <img class="object-cover w-full h-56 transition-all duration-300 rounded-t-lg hover:brightness-90"
                                            src="{{ Storage::url($song->poster_image) }}" alt="Song Image">
                                    </a>
                                    <div class="px-4 py-4 bg-gray-900 rounded-b-lg">
                                        <div class="flex items-center justify-between mb-4">
                                            <div class="flex items-center gap-1 text-xs text-gray-300">
                                                <img src="{{ asset('images/badge.png') }}" alt="CG Chartbusters Rating"
                                                    class="w-4 h-4">
                                                <span>{{ $song->cg_chartbusters_ratings }} / 10 Ratings</span>
                                            </div>
                                            <a href="{{ route('song.show', $song->slug) }}#review"
                                                class="px-3 py-2 font-bold text-center text-white bg-gray-900 rounded hover:bg-gray-600 active:bg-gray-500 "><i
                                                    class="fa-regular fa-star"></i></a>
                                        </div>
                                        <a href="{{ route('song.show', $song->slug) }}">
                                            <h2
                                                class="truncate text-sm font-normal text-white normal-case">
                                                {{ $loop->index + 1 }}. {{ ucwords(strtolower($song->title)) }}
                                            </h2>
                                        </a>
                                        <a href="{{ route('song.show', $song->slug) }}"
                                            class="block w-full px-2 py-2 my-2 font-bold text-center text-white bg-gray-700 rounded-full hover:bg-gray-600 active:bg-gray-500">Details</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- Navigation -->
                <div class="song-next absolute top-1/2 -right-4 z-50 flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 bg-gray-800/90 hover:bg-yellow-500 text-white hover:text-black rounded-full cursor-pointer shadow-xl transition-all opacity-100 sm:opacity-0 sm:group-hover:opacity-100 -translate-y-1/2 border border-white/10">
                    <i class="fa-solid fa-chevron-right text-lg"></i>
                </div>
                <div class="song-prev absolute top-1/2 -left-4 z-50 flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 bg-gray-800/90 hover:bg-yellow-500 text-white hover:text-black rounded-full cursor-pointer shadow-xl transition-all opacity-100 sm:opacity-0 sm:group-hover:opacity-100 -translate-y-1/2 border border-white/10">
                    <i class="fa-solid fa-chevron-left text-lg"></i>
                </div>
            </div>
        </section>
        <section class="pb-32 mt-5 relative group">
            <h1 class="text-xl font-bold md:text-2xl lg:text-3xl"> <span
                    class="mr-3 text-yellow-500 border-4 border-l border-yellow-500"> </span> Top 10 Artists</h1>
            <div class="swiper artist-slider !px-3 sm:!px-10">
                <div class="swiper-wrapper py-4">
                    @foreach ($artists as $artist)
                        <div class="swiper-slide">
                            <a href="{{ route('artist.show', $artist->slug) }}" class="flex flex-col items-center">
                                <div class="relative flex-shrink-0 transition-all group">
                                    <div
                                        class="absolute z-50 font-bold text-yellow-500 transition-opacity opacity-50 -left-5 -bottom-5 text-8xl text-stroke group-hover:opacity-100">
                                        {{ $loop->index + 1 }}
                                    </div>
                                    <div class="w-40 h-40 overflow-hidden rounded-full ">
                                        <img class="object-cover w-full h-full transition-transform duration-300 group-hover:scale-110"
                                            src="{{ Storage::url($artist->photo) }}" alt="Artist Image">
                                    </div>
                                </div>
                                <h3 class="mt-4 text-lg text-center text-white">{{ ucwords(strtolower($artist->name)) }}</h3>
                                <div class="flex justify-start items-center gap-1 text-xs mb-4 text-gray-300">
                                    <img src="{{ asset('images/badge.png') }}" alt="CG Chartbusters Rating"
                                        class="w-4 h-4">
                                    <span>{{ $artist->cgcb_rating ?? 0 }} / 10 Ratings</span>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
                <!-- Navigation -->
                <div class="artist-next absolute top-1/2 -right-4 z-50 flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 bg-gray-800/90 hover:bg-yellow-500 text-white hover:text-black rounded-full cursor-pointer shadow-xl transition-all opacity-100 sm:opacity-0 sm:group-hover:opacity-100 -translate-y-1/2 border border-white/10">
                    <i class="fa-solid fa-chevron-right text-lg"></i>
                </div>
                <div class="artist-prev absolute top-1/2 -left-4 z-50 flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 bg-gray-800/90 hover:bg-yellow-500 text-white hover:text-black rounded-full cursor-pointer shadow-xl transition-all opacity-100 sm:opacity-0 sm:group-hover:opacity-100 -translate-y-1/2 border border-white/10">
                    <i class="fa-solid fa-chevron-left text-lg"></i>
                </div>
            </div>
        </section>


    </div>

</x-app-layout>
