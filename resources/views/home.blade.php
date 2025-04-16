<x-app-layout  >
<style>
    /* Optional: You can add these custom styles in case you want to refine appearance, 
   but Tailwind's responsive utilities will handle most of this. */
.carousel {
    max-width: 100%;
    overflow: hidden;
}

.swiper-next, .swiper-prev {
    position: absolute;
    z-index: 1;
    top: 50%;
    padding: 10px;
    transform: translateY(-50%);
    background-color: rgba(0, 0, 0, 0.5);
    color: #fff;
    cursor: pointer;
}
.swiper-prev{
    left: 10px;
}
.swiper-next{
    right: 10px;
}

.swiper-next:active, .swiper-prev:active {
    transform: translateY(-50%) scale(0.9);
    background-color: rgba(0, 0, 0, 0.7);
}
/* For the thumbnail slider */
.thumbnail-slider-container {
    display: flex;
    flex-direction: column;
    width:305px;
    height: 600px;
    margin-left: 16px;
    margin-top: 72px;

}

.thumbnail-slider {
    height: 100%;
}
.thumbnail-slider .swiper-slide {
    cursor: pointer;
    padding: 10px;
    background-color: #333;
    border-radius: 8px;
}
.thumbnail-swiper-button-prev, .thumbnail-swiper-button-next {
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
        display: none; /* Hide thumbnail slider on tablets and mobile */
    }
}
@media (max-width: 768px) {
    .swiper.main-slider {
        width: 100%; /* Full width of the screen on tablets and smaller */
    }
}
</style>
<section class="flex flex-col items-center carousel md:flex-row">
    <div class="w-full swiper main-slider">
        <!-- Main slider -->
        <div class="swiper-wrapper ">
            @foreach ($banner_images as $banner_image)
                <div class="overflow-hidden swiper-slide rounded-xl">
                    <img style="width: 100%; object-fit: cover;" src="{{ asset('storage/' . $banner_image['poster_image_landscape']) }}" alt="Banner Image">
                    <div class="absolute bottom-0 left-0 w-full h-1/2 bg-gradient-bottoms black-tint"></div>
                    <div class="absolute text-left text-white transform bottom-6 left-6">
                        <div class="flex gap-3">
                            <img class="rounded-lg w-full h-auto max-w-[80px] md:max-w-[120px]" src="{{ asset('storage/' . $banner_image['poster_image']) }}" alt="">
                            <div class="flex flex-col justify-end">
                                <h1 class="text-xs font-bold md:text-3xl">{{ $banner_image['title'] }}</h1>
                                <small><i class='text-yellow-300 fas fa-calender'></i> {{ $banner_image['release_date'] }}</small>
                                <div class="flex flex-row items-center ">
                                    <img class="m-1 " style="width:25px;height:25px;" src="{{ asset('images/badge.png') }}" alt="CG Chartbusters Rating">
                                    <p class="text-xs"> {{ $banner_image['cg_chartbusters_ratings'] ?? 1 }} /10 Ratings</p>
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
<div class="thumbnail-slider-container hidden lg:flex flex-col w-[500px] h-[600px] ml-4">
    <div class="h-full swiper thumbnail-slider">
        <div class="swiper-wrapper gradient-overlay">
            @foreach ($banner_images as $banner_image)
                <div class="p-2 bg-gray-800 rounded-lg cursor-pointer swiper-slide max-w-[370px]">
                    <div class="flex items-end h-full gap-4">
                        <img class="object-cover w-24 h-32 rounded-lg" src="{{ asset('storage/' . ($banner_image['poster_image'] ?? 'storage/images/coming-soon.png')) }}" alt="Thumbnail">
                        <div class="flex flex-col justify-end flex-1">
                            <h1 class="text-xs font-bold truncate" style='width:165px'>{{ $banner_image['title'] }}</h1>
                            <div class="flex flex-row items-center text-gray-300 truncate" style='width:170px'>
                                <img class="m-1" style="width:15px;height:15px;" src="{{ asset('images/badge.png') }}" alt="CG Chartbusters Rating">
                                <div class="flex flex-col items-start justify-start">
                                    <p class="text-xs"> {{ $banner_image['cg_chartbusters_ratings'] ?? 1 }} /10 Ratings</p>
                                </div>
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
        <section class="my-5">
            <h1 class="text-xl font-bold md:text-2xl lg:text-3xl"><span class="mr-3 text-yellow-500 border-4 border-l border-yellow-500"> </span> Top 10 Movies</h1>
        <div class="flex flex-row gap-2 px-4 py-4 overflow-x-auto scrollbar-hide">
            @foreach ($movies as $movie)
                <a href="{{ route('movie.show', $movie) }}">
                    <div class="flex-shrink-0 mr-4 transition-all bg-gray-900 rounded-lg shadow-md last:mr-0 ">
                        <div class="relative min-w-48 max-w-48">
                            {{-- rating --}}
                            <span class="absolute z-50 mr-2 font-bold text-yellow-500 top-2 -left-5 text-shadow-md text-8xl text-stroke stroke-white">{{ $loop->index + 1 }}</span>
                            
                            <img class="object-cover w-full h-56 transition-all duration-300 rounded-t-lg hover:brightness-90" src="{{ Storage::url($movie->poster_image) }}"  alt="Movie Image">
                            <div class="px-4 py-4 bg-gray-900 rounded-b-lg h-30">
                                <div class="">
                                    <span class="text-white"> <i class="text-yellow-500 fa-solid fa-star"></i> {{ $movie->cg_chartbusters_ratings }} / 10 </span>
                                    <a href="{{ route('movie.show', $movie) }}#review" class="px-3 py-2 mx-1 my-2 font-bold text-center text-white bg-gray-900 rounded hover:bg-gray-600 active:bg-gray-500 "><i class="fa-regular fa-star"></i></a>
                                </div>
                                <h2 class="py-6 overflow-hidden text-sm font-normal text-white normal-case w-38 text-nowrap text-ellipsis"> {{ $loop->index + 1 }}. {{ ucwords(strtolower($movie->title)) }}</h2>

                                <a href="{{ route('movie.show', $movie) }}" class="block w-full px-2 py-2 my-2 font-bold text-center text-white bg-gray-700 rounded-full hover:bg-gray-600 active:bg-gray-500 ">Details</a>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        </section>
        <section class="my-5">
            <h1 class="text-xl font-bold md:text-2xl lg:text-3xl"><span class="mr-3 text-yellow-500 border-4 border-l border-yellow-500"> </span> Top 10 Songs</h1>
            <div class="flex flex-row gap-2 px-4 py-4 overflow-x-auto scrollbar-hide">
                @foreach ($songs as $song)
                    <a href="{{ route('song.show', $song) }}">
                        <div class="flex-shrink-0 mr-4 transition-all bg-gray-900 rounded-lg shadow-md last:mr-0">
                            <div class="relative min-w-48 max-w-48">
                            <span class="absolute z-50 mr-2 font-bold text-yellow-500 top-2 -left-5 text-shadow-md text-8xl text-stroke stroke-white">{{ $loop->index + 1 }}</span>

                                <img class="object-cover w-full h-56 transition-all duration-300 rounded-t-lg hover:brightness-90" src="{{ Storage::url($song->poster_image) }}" alt="Song Image">
                                <div class="px-4 py-4 bg-gray-900 rounded-b-lg h-30">
                                    <div class="">
                                        <span class="text-white"> <i class="text-yellow-500 fa-solid fa-star"></i> {{ $song->cg_chartbusters_ratings ?? 'N/A' }} / 10 </span>
                                        <a href="{{ route('song.show', $song) }}#review" class="px-3 py-2 mx-1 my-2 font-bold text-center text-white bg-gray-900 rounded hover:bg-gray-600 active:bg-gray-500 "><i class="fa-regular fa-star"></i></a>
                                    </div>
                                    <h2 class="py-6 overflow-hidden text-sm font-normal text-white normal-case w-38 text-nowrap text-ellipsis">{{ $loop->index + 1 }}. {{ ucwords(strtolower($song->title)) }}</h2>
                                    <a href="{{ route('song.show', $song) }}" class="block w-full px-2 py-2 my-2 font-bold text-center text-white bg-gray-700 rounded-full hover:bg-gray-600 active:bg-gray-500">Details</a>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
        <section class="pb-32 mt-5">
            <h1 class="text-xl font-bold md:text-2xl lg:text-3xl"> <span class="mr-3 text-yellow-500 border-4 border-l border-yellow-500"> </span> Top 10 Artists</h1>
            <div class="flex flex-row gap-5 px-4 py-4 overflow-x-auto scrollbar-hide">
                @foreach ($artists as $artist)
                    <a href="{{ route('artist.show', $artist) }}" class="flex flex-col items-center">
                        <div class="relative flex-shrink-0 transition-all group">
                            <div class="absolute z-50 font-bold text-yellow-500 transition-opacity opacity-50 -left-5 -bottom-5 text-8xl text-stroke stroke-white group-hover:opacity-100">
                                {{ $loop->index + 1 }}
                            </div>
                            <div class="w-40 h-40 overflow-hidden rounded-full ">
                                <img class="object-cover w-full h-full transition-transform duration-300 group-hover:scale-110" src="{{ Storage::url($artist->photo) }}" alt="Artist Image">
                            </div>
                        </div>
                        <h3 class="mt-4 text-lg text-center text-white">{{ ucwords(strtolower($artist->name)) }}</h3>
                    </a>
                @endforeach
            </div>
        </section>
    
    
</div>

</x-app-layout>