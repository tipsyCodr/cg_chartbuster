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
    <x-home-hero :banners="$hero_banners" />

    @if($hero_sliders->isNotEmpty())
        <div class="mb-12">
            <x-premium-hero-slider :sliders="$hero_sliders" />
        </div>
    @endif

    <div class="space-y-12 py-12">
        <section class="relative group">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-xl font-black md:text-2xl lg:text-3xl flex items-center gap-3">
                    <span class="w-2 h-8 bg-yellow-500"></span>
                    Top 10 Movies
                </h1>
                <a href="{{ route('movies') }}" class="text-sm font-bold text-gray-400 hover:text-yellow-400 transition-colors">View All</a>
            </div>
            <div class="relative group/slider">
                <div class="swiper movie-slider !pl-16 !pr-4 sm:!pl-20 overflow-visible">
                    <div class="swiper-wrapper">
                        @foreach ($movies as $movie)
                            <div class="swiper-slide">
                                <x-media-card 
                                    :index="$loop->index + 1"
                                    :route="route('movie.show', $movie->slug)"
                                    :image="Storage::url($movie->poster_image)"
                                    :title="preg_replace('/^\d+[\s.-]+/', '', $movie->title)"
                                    :rating="$movie->cg_chartbusters_ratings"
                                />
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- Navigation -->
                <div class="movie-next absolute top-1/2 -right-2 md:-right-4 lg:-right-10 z-50 hidden sm:flex items-center justify-center w-10 h-10 bg-gray-900/90 backdrop-blur-md border border-white/10 text-white hover:bg-yellow-500 hover:text-black rounded-full cursor-pointer shadow-2xl transition-all -translate-y-1/2 hover:scale-110 opacity-70 hover:opacity-100">
                    <i class="fa-solid fa-chevron-right"></i>
                </div>
                <div class="movie-prev absolute top-1/2 -left-2 md:-left-4 lg:-left-10 z-50 hidden sm:flex items-center justify-center w-10 h-10 bg-gray-900/90 backdrop-blur-md border border-white/10 text-white hover:bg-yellow-500 hover:text-black rounded-full cursor-pointer shadow-2xl transition-all -translate-y-1/2 hover:scale-110 opacity-70 hover:opacity-100">
                    <i class="fa-solid fa-chevron-left"></i>
                </div>
            </div>

            <!-- See More Button -->
            <div class="mt-8 flex justify-center">
                <a href="{{ route('movies') }}" class="group relative inline-flex items-center gap-3 px-8 py-3 bg-gray-900 border border-white/10 rounded-full text-white font-bold hover:bg-yellow-500 hover:text-black hover:border-yellow-500 transition-all duration-300 shadow-xl">
                    See More Movies
                    <i class="fa-solid fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </section>

        <section class="relative group">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-xl font-black md:text-2xl lg:text-3xl flex items-center gap-3">
                    <span class="w-2 h-8 bg-yellow-500"></span>
                    Top 10 Songs
                </h1>
                <a href="{{ route('songs') }}" class="text-sm font-bold text-gray-400 hover:text-yellow-400 transition-colors">View All</a>
            </div>
            <div class="relative group/slider">
                <div class="swiper song-slider !pl-16 !pr-4 sm:!pl-20 overflow-visible">
                    <div class="swiper-wrapper">
                        @foreach ($songs as $song)
                            <div class="swiper-slide">
                                <x-media-card 
                                    :index="$loop->index + 1"
                                    :route="route('song.show', $song->slug)"
                                    :image="Storage::url($song->poster_image)"
                                    :title="preg_replace('/^\d+[\s.-]+/', '', $song->title)"
                                    :rating="$song->cg_chartbusters_ratings"
                                />
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- Navigation -->
                <div class="song-next absolute top-1/2 -right-2 md:-right-4 lg:-right-10 z-50 hidden sm:flex items-center justify-center w-10 h-10 bg-gray-900/90 backdrop-blur-md border border-white/10 text-white hover:bg-yellow-500 hover:text-black rounded-full cursor-pointer shadow-2xl transition-all -translate-y-1/2 hover:scale-110 opacity-70 hover:opacity-100">
                    <i class="fa-solid fa-chevron-right"></i>
                </div>
                <div class="song-prev absolute top-1/2 -left-2 md:-left-4 lg:-left-10 z-50 hidden sm:flex items-center justify-center w-10 h-10 bg-gray-900/90 backdrop-blur-md border border-white/10 text-white hover:bg-yellow-500 hover:text-black rounded-full cursor-pointer shadow-2xl transition-all -translate-y-1/2 hover:scale-110 opacity-70 hover:opacity-100">
                    <i class="fa-solid fa-chevron-left"></i>
                </div>
            </div>

            <!-- See More Button -->
            <div class="mt-8 flex justify-center">
                <a href="{{ route('songs') }}" class="group relative inline-flex items-center gap-3 px-8 py-3 bg-gray-900 border border-white/10 rounded-full text-white font-bold hover:bg-yellow-500 hover:text-black hover:border-yellow-500 transition-all duration-300 shadow-xl">
                    See More Songs
                    <i class="fa-solid fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </section>

        <section class="relative group">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-xl font-black md:text-2xl lg:text-3xl flex items-center gap-3">
                    <span class="w-2 h-8 bg-yellow-500"></span>
                    Top 10 TV Shows
                </h1>
                <a href="{{ route('tv-shows') }}" class="text-sm font-bold text-gray-400 hover:text-yellow-400 transition-colors">View All</a>
            </div>
            <div class="relative group/slider">
                <div class="swiper tvshow-slider !pl-16 !pr-4 sm:!pl-20 overflow-visible">
                    <div class="swiper-wrapper">
                        @foreach ($tvshows as $tvshow)
                            <div class="swiper-slide">
                                <x-media-card 
                                    :index="$loop->index + 1"
                                    :route="route('tv-show.show', $tvshow->slug)"
                                    :image="Storage::url($tvshow->poster_image)"
                                    :title="preg_replace('/^\d+[\s.-]+/', '', $tvshow->title)"
                                    :rating="$tvshow->cg_chartbusters_ratings"
                                />
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- Navigation -->
                <div class="tvshow-next absolute top-1/2 -right-2 md:-right-4 lg:-right-10 z-50 hidden sm:flex items-center justify-center w-10 h-10 bg-gray-900/90 backdrop-blur-md border border-white/10 text-white hover:bg-yellow-500 hover:text-black rounded-full cursor-pointer shadow-2xl transition-all -translate-y-1/2 hover:scale-110 opacity-70 hover:opacity-100">
                    <i class="fa-solid fa-chevron-right"></i>
                </div>
                <div class="tvshow-prev absolute top-1/2 -left-2 md:-left-4 lg:-left-10 z-50 hidden sm:flex items-center justify-center w-10 h-10 bg-gray-900/90 backdrop-blur-md border border-white/10 text-white hover:bg-yellow-500 hover:text-black rounded-full cursor-pointer shadow-2xl transition-all -translate-y-1/2 hover:scale-110 opacity-70 hover:opacity-100">
                    <i class="fa-solid fa-chevron-left"></i>
                </div>
            </div>

            <!-- See More Button -->
            <div class="mt-8 flex justify-center">
                <a href="{{ route('tv-shows') }}" class="group relative inline-flex items-center gap-3 px-8 py-3 bg-gray-900 border border-white/10 rounded-full text-white font-bold hover:bg-yellow-500 hover:text-black hover:border-yellow-500 transition-all duration-300 shadow-xl">
                    See More TV Shows
                    <i class="fa-solid fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </section>

        <section class="relative group pb-12">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-xl font-black md:text-2xl lg:text-3xl flex items-center gap-3">
                    <span class="w-2 h-8 bg-yellow-500"></span>
                    Popular Artists
                </h1>
                <a href="{{ route('artists') }}" class="text-sm font-bold text-gray-400 hover:text-yellow-400 transition-colors">View All</a>
            </div>
            <div class="relative group/slider">
                <div class="swiper artist-slider !px-4 sm:!px-0 overflow-visible">
                    <div class="swiper-wrapper">
                        @foreach ($artists as $artist)
                            <div class="swiper-slide">
                                <a href="{{ route('artist.show', $artist->slug) }}" class="flex flex-col items-center group/artist">
                                    <div class="relative">
                                        <div class="w-28 h-28 sm:w-36 sm:h-36 md:w-40 md:h-40 lg:w-44 lg:h-44 overflow-hidden rounded-full border-4 border-white/5 group-hover/artist:border-yellow-500 transition-colors">
                                            <img class="object-cover w-full h-full transform group-hover/artist:scale-110 transition-transform duration-500"
                                                src="{{ Storage::url($artist->photo) }}" alt="{{ preg_replace('/^\d+[\s.-]+/', '', $artist->name) }}">
                                        </div>
                                    </div>
                                    <h3 class="mt-4 text-sm sm:text-base font-bold text-white group-hover/artist:text-yellow-500 transition-colors text-center">
                                        {{ preg_replace('/^\d+[\s.-]+/', '', $artist->name) }}
                                    </h3>
                                    <div class="flex items-center gap-1 mt-1 text-[10px] sm:text-xs text-gray-400 font-medium">
                                        <img src="{{ asset('images/badge.png') }}" class="w-3 h-3 sm:w-4 sm:h-4" alt="Rating">
                                        {{ $artist->cgcb_rating ?? 0 }} / 10 Ratings
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- Navigation -->
                <div class="artist-next absolute top-1/2 -right-2 md:-right-4 lg:-right-10 z-50 hidden sm:flex items-center justify-center w-10 h-10 bg-gray-900/90 backdrop-blur-md border border-white/10 text-white hover:bg-yellow-500 hover:text-black rounded-full cursor-pointer shadow-2xl transition-all -translate-y-1/2 hover:scale-110 opacity-70 hover:opacity-100">
                    <i class="fa-solid fa-chevron-right"></i>
                </div>
                <div class="artist-prev absolute top-1/2 -left-2 md:-left-4 lg:-left-10 z-50 hidden sm:flex items-center justify-center w-10 h-10 bg-gray-900/90 backdrop-blur-md border border-white/10 text-white hover:bg-yellow-500 hover:text-black rounded-full cursor-pointer shadow-2xl transition-all -translate-y-1/2 hover:scale-110 opacity-70 hover:opacity-100">
                    <i class="fa-solid fa-chevron-left"></i>
                </div>
            </div>

            <!-- See More Button -->
            <div class="mt-8 flex justify-center">
                <a href="{{ route('artists') }}" class="group relative inline-flex items-center gap-3 px-8 py-3 bg-gray-900 border border-white/10 rounded-full text-white font-bold hover:bg-yellow-500 hover:text-black hover:border-yellow-500 transition-all duration-300 shadow-xl">
                    See More Artists
                    <i class="fa-solid fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </section>
    </div>
</div>
</x-app-layout>
