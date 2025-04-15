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
    width:300px;
    height: 600px;
    margin-left: 16px;
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
        <div class="swiper-wrapper">
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
        <div class="swiper-wrapper">
            <div class="flex items-center justify-between">
                <div class="swiper-wrapper">
                    @foreach ($banner_images as $banner_image)
                        <div class="p-2 bg-gray-800 rounded-lg cursor-pointer swiper-slide max-w-[370px]">
                            <div class="flex items-end h-full gap-4">
                                <img class="object-cover w-24 h-32 rounded-lg" src="{{ asset('storage/' . ($banner_image['poster_image'] ?? 'storage/images/coming-soon.png')) }}" alt="Thumbnail">
                                <div class="flex flex-col justify-end flex-1">
                                    <h1 class="text-xs font-bold truncate" style='width:165px'>{{ $banner_image['title'] }}</h1>
                                    <div class="flex flex-row items-center text-gray-300 truncate" style='width:170px'>
                                        <img class="m-1 " style="width:15px;height:15px;"
                                             src="{{ asset('images/badge.png') }}" alt="CG Chartbusters Rating">
                                        <div class="flex flex-col items-start justify-start">
                                            <p class="text-xs"> {{ $banner_image['cg_chartbusters_ratings'] ?? 1 }} /10 Ratings</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <a href="{{ route('movies') }}" class="text-blue-500 hover:underline">View More</a>
            </div>
        </div>
    </div>
</div>
</section>

<div class="">
        <section class="my-5">
            <h1 class="text-xl font-bold md:text-2xl lg:text-3xl"><span class="mr-3 text-yellow-500 border-4 border-l border-yellow-500"> </span> Top 10 Movies</h1>
        <div class="flex flex-row gap-5 px-4 py-4 overflow-x-auto scrollbar-hide">
            @foreach ($movies as $movie)
                <a href="{{ route('movie.show', $movie) }}">
                    <div class="flex-shrink-0 mr-4 transition-all bg-gray-800 rounded-lg shadow-md last:mr-0 hover:scale-110">
                        <div class="relative min-w-48 max-w-48">
                            {{-- <span class="absolute mr-2 font-bold text-yellow-500 bottom-2 -left-5 text-shadow-md text-8xl text-stroke stroke-white">{{ $loop->index + 1 }}</span> --}}
                            {{-- rating --}}
                            
                            <img class="object-cover h-56 rounded-t-lg w-full" src="{{ Storage::url($movie->poster_image) }}"  alt="Movie Image">
                            <div class="bg-gray-800 py-4 px-4 rounded-b-lg h-30">
                                <div class="">
                                    <span class="text-white"> <i class="text-yellow-500 fa-solid fa-star"></i> {{ $movie->imdb_ratings }}</span>
                                </div>
                                <h2 class="text-white text-xs py-2 ">{{ $movie->title }}</h2>
                                <a href="{{ route('movie.show', $movie) }}" class="text-center bg-yellow-500 px-2 py-2 my-2 rounded-full w-full block text-white font-bold hover:underline">View More</a>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        </section>
        <section class="my-5">
            <h1 class="text-xl font-bold md:text-2xl lg:text-3xl"><span class="mr-3 text-yellow-500 border-4 border-l border-yellow-500"> </span> Top 10 Songs</h1>
            <div class="flex flex-row gap-5 px-4 py-4 overflow-x-auto scrollbar-hide">
                @foreach ($songs as $song)
                    <a href="{{ route('song.show', $song) }}">
                        <div class="flex-shrink-0 mr-4 transition-all bg-gray-800 rounded-lg shadow-md last:mr-0 hover:scale-110">
                            <div class="relative">
                                <span class="absolute mr-2 font-bold text-yellow-500 bottom-2 -left-5 text-shadow-md text-8xl text-stroke stroke-white">{{ $loop->index + 1 }}</span>
                                <img class="object-cover h-56 rounded-lg min-w-36 max-w-36" src="{{ Storage::url($song->poster_image) }}"  alt="Song Image">
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
        <section class="pb-5 mt-5">
            <h1 class="text-xl font-bold md:text-2xl lg:text-3xl"> <span class="mr-3 text-yellow-500 border-4 border-l border-yellow-500"> </span> Top 10 Artists</h1>
            <div class="flex flex-row gap-5 px-4 py-4 overflow-x-auto scrollbar-hide">
                @foreach ($artists as $artist)
                    <a href="{{ route('artist.show', $artist) }}">
                        <div class="flex-shrink-0 mr-4 transition-all bg-gray-800 rounded-lg shadow-md last:mr-0 hover:scale-110">
                            <div class="relative">
                                <span class="absolute mr-2 font-bold text-yellow-500 bottom-2 -left-5 text-shadow-md text-8xl text-stroke stroke-white">{{ $loop->index + 1 }}</span>
                                <img class="object-cover h-56 rounded-lg min-w-36 max-w-36" src="{{ Storage::url($artist->photo) }}" alt="Artist Image">
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    
    
</div>

    
</x-app-layout>