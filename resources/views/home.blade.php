<x-app-layout  >
<style>
    /* Optional: You can add these custom styles in case you want to refine appearance, 
   but Tailwind's responsive utilities will handle most of this. */
.carousel {
    max-width: 100%;
    height: 500px;
    overflow: hidden;
}

/* .swiper.main-slider {
    width: 80%;
} */

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
<section class="carousel flex flex-col md:flex-row items-center">
    <div class="swiper main-slider w-full">
        <!-- Main slider -->
        <div class="swiper-wrapper">
            @foreach (scandir(public_path('images/banner')) as $file)
                @if ($file != '.' && $file != '..')
                    <div class="swiper-slide rounded-xl overflow-hidden">
                        <img style="width: 100%; object-fit: cover;" src="{{ asset('images/banner/' . $file) }}" alt="Banner Image">
                        <div class="absolute bottom-0 left-0 w-full h-1/2 bg-gradient-bottom"></div>
                        <div class="absolute bottom-6 left-6 transform text-white text-left">
                            <div class="flex gap-3">
                                <img class="rounded-lg w-full h-auto max-w-[80px] md:max-w-[120px]" src="{{ asset('images/movies/1.jpg') }}" alt="">
                                <div class="flex flex-col justify-end">
                                    <h1 class="text-3xl font-bold">Title</h1>
                                    <p class="text-lg">Description</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        <div class="swiper-pagination"></div>
        <div class="swiper-next"><i class="fa-solid fa-chevron-right fa-2x"></i></div>
        <div class="swiper-prev"><i class="fa-solid fa-chevron-left fa-2x"></i></div>
        <div class="swiper-scrollbar"></div>
    </div>

    <!-- Thumbnail Slider -->
    <div class="thumbnail-slider-container hidden lg:flex flex-col w-[500px] h-[600px] ml-4">
        <div class="swiper thumbnail-slider h-full">
            <div class="swiper-wrapper">
                @foreach (scandir(public_path('images/banner')) as $file)
                    @if ($file != '.' && $file != '..')
                        <div class="swiper-slide cursor-pointer bg-gray-800 p-2 rounded-lg">
                            <div class="flex flex-row gap-2 h-full">
                                <img class="w-[40%] max-w-[200px] h-full object-cover rounded-lg" src="{{ asset('images/banner/' . $file) }}" alt="Thumbnail">
                                <div class="flex flex-col justify-end mb-2">
                                    <h1 class="text-lg font-bold">Title</h1>
                                    <p class="text-xs">Description</p>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        
    </div>
</section>

<div class="">
    
        <section class="my-5">
            <h1 class="text-xl md:text-2xl lg:text-3xl font-bold"><span class="text-yellow-500 border-l border-4 border-yellow-500 mr-3"> </span> Top 10 Movies</h1>
        <div class="flex flex-row overflow-x-auto scrollbar-hide px-4 gap-5 py-4">
            @for ($i = 1; $i <= 10; $i++)
                <div class="bg-gray-800 rounded-lg shadow-md flex-shrink-0 mr-4 last:mr-0 hover:scale-110 transition-all">
                    <div class="relative">
                        <span class="absolute bottom-2 -left-5 text-shadow-md text-8xl font-bold text-stroke stroke-white text-yellow-500 mr-2">{{ $i }}</span>
                        <img class=" rounded-lg w-36 h-56 object-cover" src="{{ asset('images/movies/' . $i . '.jpg') }}"  alt="Movie Image">
                    </div>
                </div>
            @endfor
        </div>

        </section>
        <section class="my-5">
            <h1 class="text-xl md:text-2xl lg:text-3xl font-bold"><span class="text-yellow-500 border-l border-4 border-yellow-500 mr-3"> </span> Top 10 Songs</h1>
            <div class="flex flex-row overflow-x-auto scrollbar-hide px-4 gap-5 py-4">
                @for ($i = 1; $i <= 10; $i++)
                    <div class="bg-gray-800 rounded-lg shadow-md flex-shrink-0 mr-4 last:mr-0 hover:scale-110 transition-all">
                        <div class="relative">
                            <span class="absolute bottom-2 -left-5 text-shadow-md text-8xl font-bold text-stroke stroke-white text-yellow-500 mr-2">{{ $i }}</span>
                            <img class=" rounded-lg w-36 h-56 object-cover" src="{{ asset('images/songs/' . $i . '.jpg') }}"  alt="Song Image">
                        </div>
                    </div>
                @endfor
            </div>
        </section>
        <section class="my-5">
            <h1 class="text-xl md:text-2xl lg:text-3xl font-bold"> <span class="text-yellow-500 border-l border-4 border-yellow-500 mr-3"> </span> Top 10 Artists</h1>
            <div class="flex flex-row overflow-x-auto scrollbar-hide px-4 gap-5 py-4">
                @for ($i = 1; $i <= 10; $i++)
                    <div class="bg-gray-800 rounded-lg shadow-md flex-shrink-0 mr-4 last:mr-0 hover:scale-110 transition-all">
                        <div class="relative">
                            <span class="absolute bottom-2 -left-5 text-shadow-md text-8xl font-bold text-stroke stroke-white text-yellow-500 mr-2">{{ $i }}</span>
                            <img class=" rounded-lg w-36 h-56 object-cover" src="{{ asset('images/artists/' . $i . '.jpg') }}" alt="Artist Image">
                        </div>
                    </div>
                @endfor
            </div>
        </section>
    
    
</div>

    
</x-app-layout>