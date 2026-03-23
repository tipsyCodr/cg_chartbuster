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
    <section class="flex flex-col items-stretch gap-6 carousel lg:flex-row h-[320px] sm:h-[400px] md:h-[450px] lg:h-[480px] xl:h-[550px]">
        <div class="w-full swiper main-slider lg:flex-1 h-full rounded-xl overflow-hidden shadow-2xl">
            <!-- Main slider -->
            <div class="swiper-wrapper h-full">
                @foreach ($banner_images as $banner_image)
                    <div class="overflow-hidden swiper-slide h-full relative group">
                        <img class="w-full h-full object-cover"
                            src="{{ asset('storage/' . $banner_image['poster_image_landscape']) }}" alt="Banner Image">
                        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/40 to-transparent"></div>
                        <div class="absolute inset-x-0 bottom-0 p-4 sm:p-8 flex flex-col justify-end">
                            <div class="flex gap-4 items-end">
                                <img class="rounded-lg w-20 sm:w-28 md:w-32 lg:w-36 shadow-2xl border border-white/10 hidden xs:block"
                                    src="{{ asset('storage/' . $banner_image['poster_image']) }}" alt="">
                                <div class="flex flex-col gap-1 sm:gap-2">
                                    <h1 class="text-xl sm:text-2xl md:text-3xl lg:text-4xl font-black text-white leading-tight drop-shadow-lg">
                                        {{ $banner_image['title'] }}
                                    </h1>
                                    <div class="flex flex-wrap items-center gap-3 text-xs sm:text-sm text-gray-200">
                                        <span class="flex items-center gap-1.5 bg-black/40 backdrop-blur-md px-2 py-1 rounded">
                                            <i class='text-yellow-400 fas fa-calendar-alt'></i>
                                            {{ $banner_image['release_date'] }}
                                        </span>
                                        <span class="flex items-center gap-1.5 bg-black/40 backdrop-blur-md px-2 py-1 rounded">
                                            <img class="w-4 h-4" src="{{ asset('images/badge.png') }}" alt="Rating">
                                            {{ $banner_image['cg_chartbusters_ratings'] ?? 1 }} / 10
                                        </span>
                                    </div>
                                    <div class="mt-3 flex gap-3">
                                        <a href="{{ route($banner_image['type'] == 'movie' ? 'movie.show' : ($banner_image['type'] == 'tv_show' ? 'tv-show.show' : 'song.show'), $banner_image['slug']) }}" 
                                           class="px-5 py-2 bg-yellow-500 hover:bg-yellow-400 text-black font-bold rounded-full text-sm transition-all shadow-lg hover:scale-105 active:scale-95">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="swiper-pagination !bottom-4"></div>
            <div class="swiper-next hidden md:flex"><i class="fa-solid fa-chevron-right text-xl"></i></div>
            <div class="swiper-prev hidden md:flex"><i class="fa-solid fa-chevron-left text-xl"></i></div>
        </div>
        <!-- Thumbnail Slider -->
        <div class="thumbnail-slider-container hidden lg:flex flex-col lg:w-[320px] xl:w-[380px] h-full bg-gray-900/40 rounded-xl p-4 border border-white/5 backdrop-blur-sm">
            <h2 class="text-xs font-black text-gray-400 mb-4 uppercase tracking-widest flex items-center gap-2">
                <span class="w-1.5 h-4 bg-yellow-500 rounded-full"></span>
                Up Next
            </h2>
            <div class="flex-1 overflow-hidden swiper thumbnail-slider">
                <div class="swiper-wrapper">
                    @foreach ($banner_images as $banner_image)
                        <div class="p-2 hover:bg-white/5 rounded-lg cursor-pointer swiper-slide transition-colors">
                            <div class="flex items-center h-full gap-3 px-1">
                                <div class="relative flex-shrink-0">
                                    <img class="object-cover w-12 h-16 rounded shadow-md"
                                        src="{{ asset('storage/' . ($banner_image['poster_image'] ?? 'storage/images/coming-soon.png')) }}"
                                        alt="Thumbnail">
                                </div>
                                <div class="flex flex-col justify-center flex-1 min-w-0">
                                    <h1 class="text-xs font-bold truncate text-gray-100 group-hover:text-yellow-400">
                                        {{ $banner_image['title'] }}
                                    </h1>
                                    <div class="flex items-center gap-1.5 mt-1">
                                        <img class="w-3 h-3" src="{{ asset('images/badge.png') }}" alt="Rating">
                                        <span class="text-[10px] text-gray-400 font-medium">
                                            {{ $banner_image['cg_chartbusters_ratings'] ?? 1 }} / 10
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <a href="{{ route('movies') }}" class="mt-4 text-xs font-bold text-gray-400 hover:text-yellow-400 transition-colors uppercase tracking-widest text-center">View More <i class="fa-solid fa-chevron-right ml-1"></i></a>
        </div>
    </section>

    <div class="space-y-12 my-12">
        <section class="relative group">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-xl font-black md:text-2xl lg:text-3xl flex items-center gap-3">
                    <span class="w-2 h-8 bg-yellow-500 rounded-full"></span>
                    Top 10 Movies
                </h1>
                <a href="{{ route('movies') }}" class="text-sm font-bold text-gray-400 hover:text-yellow-400 transition-colors">View All</a>
            </div>
            <div class="swiper movie-slider !px-4 sm:!px-0 overflow-visible">
                <div class="swiper-wrapper">
                    @foreach ($movies as $movie)
                        <div class="swiper-slide">
                            <div class="group/card relative bg-gray-900/50 rounded-xl overflow-hidden border border-white/5 hover:border-yellow-500/30 transition-all duration-300">
                                <div class="relative aspect-[2/3]">
                                    {{-- ranking number --}}
                                    <span class="absolute -left-3 -top-1 z-20 font-black text-white/20 text-7xl sm:text-8xl italic select-none group-hover/card:text-yellow-500/20 transition-colors">
                                        {{ $loop->index + 1 }}
                                    </span>

                                    <a href="{{ route('movie.show', $movie->slug) }}" class="block h-full w-full">
                                        <img class="object-cover w-full h-full transform group-hover/card:scale-105 transition-transform duration-500"
                                            src="{{ Storage::url($movie->poster_image) }}" alt="{{ $movie->title }}">
                                    </a>
                                    
                                    <div class="absolute inset-0 bg-gradient-to-t from-gray-900 to-transparent opacity-60 group-hover/card:opacity-80 transition-opacity"></div>
                                    
                                    <div class="absolute bottom-0 left-0 right-0 p-4 transform translate-y-2 group-hover/card:translate-y-0 transition-transform">
                                        <div class="flex items-center gap-1.5 mb-2">
                                            <img src="{{ asset('images/badge.png') }}" class="w-4 h-4" alt="Rating">
                                            <span class="text-xs font-bold text-gray-200">{{ $movie->cg_chartbusters_ratings }} / 10</span>
                                        </div>
                                        <h2 class="text-sm font-bold text-white line-clamp-1 mb-3">
                                            {{ $movie->title }}
                                        </h2>
                                        <a href="{{ route('movie.show', $movie->slug) }}"
                                            class="block w-full py-2 bg-white/10 hover:bg-yellow-500 hover:text-black backdrop-blur-md rounded-lg text-xs font-black text-center transition-all uppercase tracking-wider">
                                            Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
            </div>
            <!-- Navigation -->
            <div class="movie-next absolute top-1/2 right-2 lg:-right-10 z-50 hidden sm:flex items-center justify-center w-10 h-10 bg-gray-900/80 backdrop-blur-md border border-white/10 hover:bg-yellow-500 hover:text-black rounded-full cursor-pointer shadow-2xl transition-all -translate-y-1/2">
                <i class="fa-solid fa-chevron-right"></i>
            </div>
            <div class="movie-prev absolute top-1/2 left-2 lg:-left-10 z-50 hidden sm:flex items-center justify-center w-10 h-10 bg-gray-900/80 backdrop-blur-md border border-white/10 hover:bg-yellow-500 hover:text-black rounded-full cursor-pointer shadow-2xl transition-all -translate-y-1/2">
                <i class="fa-solid fa-chevron-left"></i>
            </div>
        </section>

        <section class="relative group">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-xl font-black md:text-2xl lg:text-3xl flex items-center gap-3">
                    <span class="w-2 h-8 bg-yellow-500 rounded-full"></span>
                    Top 10 Songs
                </h1>
                <a href="{{ route('songs') }}" class="text-sm font-bold text-gray-400 hover:text-yellow-400 transition-colors">View All</a>
            </div>
            <div class="swiper song-slider !px-4 sm:!px-0 overflow-visible">
                <div class="swiper-wrapper">
                    @foreach ($songs as $song)
                        <div class="swiper-slide">
                            <div class="group/card relative bg-gray-900/50 rounded-xl overflow-hidden border border-white/5 hover:border-yellow-500/30 transition-all duration-300">
                                <div class="relative aspect-[2/3]">
                                    {{-- ranking number --}}
                                    <span class="absolute -left-3 -top-1 z-20 font-black text-white/20 text-7xl sm:text-8xl italic select-none group-hover/card:text-yellow-500/20 transition-colors">
                                        {{ $loop->index + 1 }}
                                    </span>

                                    <a href="{{ route('song.show', $song->slug) }}" class="block h-full w-full">
                                        <img class="object-cover w-full h-full transform group-hover/card:scale-105 transition-transform duration-500"
                                            src="{{ Storage::url($song->poster_image) }}" alt="{{ $song->title }}">
                                    </a>
                                    
                                    <div class="absolute inset-0 bg-gradient-to-t from-gray-900 to-transparent opacity-60 group-hover/card:opacity-80 transition-opacity"></div>
                                    
                                    <div class="absolute bottom-0 left-0 right-0 p-4 transform translate-y-2 group-hover/card:translate-y-0 transition-transform">
                                        <div class="flex items-center gap-1.5 mb-2">
                                            <img src="{{ asset('images/badge.png') }}" class="w-4 h-4" alt="Rating">
                                            <span class="text-xs font-bold text-gray-200">{{ $song->cg_chartbusters_ratings }} / 10</span>
                                        </div>
                                        <h2 class="text-sm font-bold text-white line-clamp-1 mb-3">
                                            {{ $song->title }}
                                        </h2>
                                        <a href="{{ route('song.show', $song->slug) }}"
                                            class="block w-full py-2 bg-white/10 hover:bg-yellow-500 hover:text-black backdrop-blur-md rounded-lg text-xs font-black text-center transition-all uppercase tracking-wider">
                                            Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
            </div>
            <!-- Navigation -->
            <div class="song-next absolute top-1/2 right-2 lg:-right-10 z-50 hidden sm:flex items-center justify-center w-10 h-10 bg-gray-900/80 backdrop-blur-md border border-white/10 hover:bg-yellow-500 hover:text-black rounded-full cursor-pointer shadow-2xl transition-all -translate-y-1/2">
                <i class="fa-solid fa-chevron-right"></i>
            </div>
            <div class="song-prev absolute top-1/2 left-2 lg:-left-10 z-50 hidden sm:flex items-center justify-center w-10 h-10 bg-gray-900/80 backdrop-blur-md border border-white/10 hover:bg-yellow-500 hover:text-black rounded-full cursor-pointer shadow-2xl transition-all -translate-y-1/2">
                <i class="fa-solid fa-chevron-left"></i>
            </div>
        </section>

        <section class="relative group pb-12">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-xl font-black md:text-2xl lg:text-3xl flex items-center gap-3">
                    <span class="w-2 h-8 bg-yellow-500 rounded-full"></span>
                    Top 10 Artists
                </h1>
                <a href="{{ route('artists') }}" class="text-sm font-bold text-gray-400 hover:text-yellow-400 transition-colors">View All</a>
            </div>
            <div class="swiper artist-slider !px-4 sm:!px-0 overflow-visible">
                <div class="swiper-wrapper">
                    @foreach ($artists as $artist)
                        <div class="swiper-slide">
                            <a href="{{ route('artist.show', $artist->slug) }}" class="flex flex-col items-center group/artist">
                                <div class="relative">
                                    <span class="absolute -left-4 -bottom-4 z-20 font-black text-white/10 text-7xl italic select-none group-hover/artist:text-yellow-500/20 transition-colors">
                                        {{ $loop->index + 1 }}
                                    </span>
                                    <div class="w-28 h-28 sm:w-36 sm:h-36 md:w-40 md:h-40 lg:w-44 lg:h-44 overflow-hidden rounded-full border-4 border-white/5 group-hover/artist:border-yellow-500 transition-colors">
                                        <img class="object-cover w-full h-full transform group-hover/artist:scale-110 transition-transform duration-500"
                                            src="{{ Storage::url($artist->photo) }}" alt="{{ $artist->name }}">
                                    </div>
                                </div>
                                <h3 class="mt-4 text-sm sm:text-base font-bold text-white group-hover/artist:text-yellow-500 transition-colors text-center">
                                    {{ $artist->name }}
                                </h3>
                                <div class="flex items-center gap-1 mt-1 text-[10px] sm:text-xs text-gray-400 font-medium">
                                    <img src="{{ asset('images/badge.png') }}" class="w-3 h-3 sm:w-4 sm:h-4" alt="Rating">
                                    {{ $artist->cgcb_rating ?? 0 }} / 10 Ratings
                                </div>
                            </a>
                        </div>
                    @endforeach
            </div>
            <!-- Navigation -->
            <div class="artist-next absolute top-1/2 right-2 lg:-right-10 z-50 hidden sm:flex items-center justify-center w-10 h-10 bg-gray-900/80 backdrop-blur-md border border-white/10 hover:bg-yellow-500 hover:text-black rounded-full cursor-pointer shadow-2xl transition-all -translate-y-1/2">
                <i class="fa-solid fa-chevron-right"></i>
            </div>
            <div class="artist-prev absolute top-1/2 left-2 lg:-left-10 z-50 hidden sm:flex items-center justify-center w-10 h-10 bg-gray-900/80 backdrop-blur-md border border-white/10 hover:bg-yellow-500 hover:text-black rounded-full cursor-pointer shadow-2xl transition-all -translate-y-1/2">
                <i class="fa-solid fa-chevron-left"></i>
            </div>
        </section>
    </div>



    </div>

</x-app-layout>
