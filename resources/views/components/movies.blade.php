<div class="" x-show="isActive === 'movies'" style='display: none;' x-transition>
    <section>
        
        <div class="flex flex-col justify-between mt-4 bg-black/10 bg-blend-multiply rounded-3xl md:h-[32rem] h-[10rem] w-[91vw] md:w-full overflow-hidden bg-cover bg-center px-7 pt-4 pb-6 text-white"
            style="background-image: url('images/movie.jpg');" onclick="location.href='#' ">
            <!-- <img class="object-cover w-full h-full" src="images/inception.jpg" alt=""> -->
            <div class="flex items-center -space-x-1 ">
                <img class="border border-white rounded-full shadow-lg w-7 h-7"
                    src="https://api.lorem.space/image/face?w=32&amp;h=32&amp;hash=zsrj8csk" alt=""
                    srcset="">
                <img class="border border-white rounded-full shadow-lg w-7 h-7"
                    src="https://api.lorem.space/image/face?w=32&amp;h=32&amp;hash=zsrj8cck" alt=""
                    srcset="">
                <img class="border border-white rounded-full shadow-lg w-7 h-7"
                    src="https://api.lorem.space/image/face?w=32&amp;h=32&amp;hash=zsfj8cck" alt=""
                    srcset="">
                <span class="pl-4 text-xs drop-shadow-lg">+8 friends are watching</span>
            </div>

            <div class="pt-2 pb-6 -mb-6 bg-gradient-to-r from-black/30 to-transparent -mx-7 px-7">
                <span class="text-3xl font-semibold uppercase drop-shadow-lg ">New Release</span>
                <div class="mt-2 text-xs text-gray-200">
                    <a href="#" class="">Action</a>,
                    <a href="#" class="">Adventure</a>,
                    <a href="#" class="">Sci-Fi</a>
                </div>
                <div class="flex items-center mt-4 space-x-3">
                    <a href="#"
                        class="px-5 py-2.5 bg-red-600 hover:bg-red-700 rounded-lg text-xs inline-block">Watch</a>
                    <a href="#" class="p-2.5 bg-gray-800/80 rounded-lg hover:bg-red-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        <script>
            <?php
            $banners = glob('images/banner/*.{jpg,png,gif}', GLOB_BRACE);

            $images = [];
            foreach ($banners as $banner) {
                $images[] = basename($banner);
            }
            $images = implode(',', array_map(function ($image) {
                return "'" . $image . "'";
            }, $images));
            ?>
            let images = [<?php echo $images; ?>];
            let index = 0;
            setInterval(() => {
                document.querySelector('.bg-cover').style.backgroundImage = `url('images/banner/${images[index]}')`;
                index = (index + 1) % images.length;
            }, 3000);
        </script>
    </section>

    <section class="mt-9 ">
        <div class="relative flex items-center justify-between">
            <span class="py-2 text-base font-semibold">Top Movies</span>
            <div class="flex items-center space-x-2 fill-gray-500">
                <svg class="top-movie-swiper-button-prev p-1 border rounded-full h-7 w-7 hover:border-red-600 hover:fill-red-600"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M13.293 6.293L7.58 12l5.7 5.7 1.41-1.42 -4.3-4.3 4.29-4.293Z"></path>
                </svg>
                <svg class="top-movie-swiper-button-next p-1 border rounded-full h-7 w-7 hover:border-red-600 hover:fill-red-600"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M10.7 17.707l5.7-5.71 -5.71-5.707L9.27 7.7l4.29 4.293 -4.3 4.29Z"></path>
                </svg>
            </div>
        </div>

            <div class="flex items-center justify-between w-[91vw] md:w-full " >
                <div class="top-movie-swiper swiper" style="margin: 0;">
                        <div class="swiper-wrapper">
                            @foreach ($movies as $similarMovie)
                            <div class="swiper-slide flex max-w-[] flex-col rounded-xl overflow-hidden aspect-square border mr-4">
                                <img src="{{ asset('storage/'.$similarMovie->poster_image) }}" class="object-cover w-full h-4/5" alt="">
                                <div class="flex items-center justify-between w-full px-3 border-t-2 h-1/5 border-t-red-600" x-bind:class="isDark ? ' bg-gray-800 ' : 'light-mode'" x-transition >
                                    <span class="font-medium capitalize truncate">{{ $similarMovie->title }}</span>
                                    <div class="flex items-center space-x-2 text-xs">
                                        <svg class="w-8 h-5" xmlns="http://www.w3.org/2000/svg" width="64" height="32"
                                            viewBox="0 0 64 32" version="1.1">
                                            <g fill="#F5C518">
                                                <rect x="0" y="0" width="100%" height="100%" rx="4"></rect>
                                            </g>
                                            <g transform="translate(8.000000, 7.000000)" fill="#000000" fill-rule="nonzero">
                                                <polygon points="0 18 5 18 5 0 0 0"></polygon>
                                                <path
                                                    d="M15.6725178,0 L14.5534833,8.40846934 L13.8582008,3.83502426 C13.65661,2.37009263 13.4632474,1.09175121 13.278113,0 L7,0 L7,18 L11.2416347,18 L11.2580911,6.11380679 L13.0436094,18 L16.0633571,18 L17.7583653,5.8517865 L17.7707076,18 L22,18 L22,0 L15.6725178,0 Z">
                                                </path>
                                                <path
                                                    d="M24,18 L24,0 L31.8045586,0 C33.5693522,0 35,1.41994415 35,3.17660424 L35,14.8233958 C35,16.5777858 33.5716617,18 31.8045586,18 L24,18 Z M29.8322479,3.2395236 C29.6339219,3.13233348 29.2545158,3.08072342 28.7026524,3.08072342 L28.7026524,14.8914865 C29.4312846,14.8914865 29.8796736,14.7604764 30.0478195,14.4865461 C30.2159654,14.2165858 30.3021941,13.486105 30.3021941,12.2871637 L30.3021941,5.3078959 C30.3021941,4.49404499 30.272014,3.97397442 30.2159654,3.74371416 C30.1599168,3.5134539 30.0348852,3.34671372 29.8322479,3.2395236 Z">
                                                </path>
                                                <path
                                                    d="M44.4299079,4.50685823 L44.749518,4.50685823 C46.5447098,4.50685823 48,5.91267586 48,7.64486762 L48,14.8619906 C48,16.5950653 46.5451816,18 44.749518,18 L44.4299079,18 C43.3314617,18 42.3602746,17.4736618 41.7718697,16.6682739 L41.4838962,17.7687785 L37,17.7687785 L37,0 L41.7843263,0 L41.7843263,5.78053556 C42.4024982,5.01015739 43.3551514,4.50685823 44.4299079,4.50685823 Z M43.4055679,13.2842155 L43.4055679,9.01907814 C43.4055679,8.31433946 43.3603268,7.85185468 43.2660746,7.63896485 C43.1718224,7.42607505 42.7955881,7.2893916 42.5316822,7.2893916 C42.267776,7.2893916 41.8607934,7.40047379 41.7816216,7.58767002 L41.7816216,9.01907814 L41.7816216,13.4207851 L41.7816216,14.8074788 C41.8721037,15.0130276 42.2602358,15.1274059 42.5316822,15.1274059 C42.8031285,15.1274059 43.1982131,15.0166981 43.281155,14.8074788 C43.3640968,14.5982595 43.4055679,14.0880581 43.4055679,13.2842155 Z">
                                                </path>
                                            </g>
                                        </svg>
                                        <span>{{ $similarMovie->rating }}</span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <!-- <div class="swiper-pagination"></div> -->
                    </div>
            </div>
    </section>

    <section class="mt-9">
        <div class="flex items-center justify-between">
            <span class="text-base font-semibold ">Top Artists</span>
            <div class="flex items-center space-x-2 fill-gray-500">
                <svg class="top-artists-swiper-button-prev p-1 border rounded-full h-7 w-7 hover:border-red-600 hover:fill-red-600"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M13.293 6.293L7.58 12l5.7 5.7 1.41-1.42 -4.3-4.3 4.29-4.293Z"></path>
                </svg>
                <svg class="top-artists-swiper-button-next p-1 border rounded-full h-7 w-7 hover:border-red-600 hover:fill-red-600"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M10.7 17.707l5.7-5.71 -5.71-5.707L9.27 7.7l4.29 4.293 -4.3 4.29Z"></path>
                </svg>
            </div>
        </div>
        <div class="mt-4 overflow-x-auto flex ">
            <div class="swiper top-artists-swiper  flex-1">
                <div class="swiper-wrapper " style="width: 80vw;">
                    @foreach ($artists as $artist)

                    <div class="swiper-slide relative rounded-xl overflow-hidden flex-shrink-0 max-w-[200px]"
                        style="background-image: url('{{ asset('storage/' . $artist->photo) }}'); background-size: cover; background-position: center;">
                        <div class="absolute top-0 flex flex-col justify-between w-full h-full p-3 bg-gradient-to-t from-black/50">

                            <a href="#" class="p-2.5 bg-gray-800/80 rounded-lg text-white self-end hover:bg-red-600/80">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>

                            <div class="flex flex-col items-center self-center space-y-2">
                                <span class="font-medium text-white capitalize drop-shadow-md">{{ $artist->name }}</span>
                                <span class="text-xs text-gray-300">+{{ $artist->movies_count }} Movies</span>

                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section>
    <section class="mt-9 w-[91vw] md:w-full ">
        <div class="flex items-center justify-between">
            <span class="text-base font-semibold">Similar Movies</span>
            <div class="relative flex items-center space-x-2 fill-gray-500">
                <a href="#" class="">
                    <svg class="similar-movie-swiper-button-prev p-1 border rounded-full h-7 w-7 hover:border-red-600 hover:fill-red-600"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="M13.293 6.293L7.58 12l5.7 5.7 1.41-1.42 -4.3-4.3 4.29-4.293Z"></path>
                    </svg>
                </a>
                <a href="#" class="">
                    <svg class="similar-movie-swiper-button-next p-1 border rounded-full h-7 w-7 hover:border-red-600 hover:fill-red-600"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="M10.7 17.707l5.7-5.71 -5.71-5.707L9.27 7.7l4.29 4.293 -4.3 4.29Z"></path>
                    </svg>
                </a>
            </div>
        </div>

        <div class="mt-4 slider-container">
            <div class="similar-movie-swiper swiper">
                <div class="swiper-wrapper">
                    @foreach ($movies as $similarMovie)
                    <div class="swiper-slide">
                        <img src="{{ asset('storage/'.$similarMovie->poster_image) }}" alt="{{ $similarMovie->title }}">
                        <div class="flex items-center justify-between w-full px-3 border-t-2 h-1/5 border-t-red-600" x-bind:class="isDark ? ' bg-gray-800 ' : 'light-mode'" x-transition>
                            <span class="font-medium capitalize truncate">{{ $similarMovie->title }}</span>
                            <div class="flex items-center space-x-2 text-xs ">
                                <svg class="w-8 h-5" xmlns="http://www.w3.org/2000/svg" width="64" height="32"
                                    viewBox="0 0 64 32" version="1.1">
                                    <g fill="#F5C518">
                                        <rect x="0" y="0" width="100%" height="100%" rx="4"></rect>
                                    </g>    
                                    <g transform="translate(8.000000, 7.000000)" fill="#000000" fill-rule="nonzero">
                                        <polygon points="0 18 5 18 5 0 0 0"></polygon>
                                        <path d="M15.6725178,0 L14.5534833,8.40846934 L13.8582008,3.83502426 C13.65661,2.37009263 13.4632474,1.09175121 13.278113,0 L7,0 L7,18 L11.2416347,18 L11.2580911,6.11380679 L13.0436094,18 L16.0633571,18 L17.7583653,5.8517865 L17.7707076,18 L22,18 L22,0 L15.6725178,0 Z"></path>
                                        <path d="M24,18 L24,0 L31.8045586,0 C33.5693522,0 35,1.41994415 35,3.17660424 L35,14.8233958 C35,16.5777858 33.5716617,18 31.8045586,18 L24,18 Z M29.8322479,3.2395236 C29.6339219,3.13233348 29.2545158,3.08072342 28.7026524,3.08072342 L28.7026524,14.8914865 C29.4312846,14.8914865 29.8796736,14.7604764 30.0478195,14.4865461 C30.2159654,14.2165858 30.3021941,13.486105 30.3021941,12.2871637 L30.3021941,5.3078959 C30.3021941,4.49404499 30.272014,3.97397442 30.2159654,3.74371416 C30.1599168,3.5134539 30.0348852,3.34671372 29.8322479,3.2395236 Z"></path>
                                        <path d="M44.4299079,4.50685823 L44.749518,4.50685823 C46.5447098,4.50685823 48,5.91267586 48,7.64486762 L48,14.8619906 C48,16.5950653 46.5451816,18 44.749518,18 L44.4299079,18 C43.3314617,18 42.3602746,17.4736618 41.7718697,16.6682739 L41.4838962,17.7687785 L37,17.7687785 L37,0 L41.7843263,0 L41.7843263,5.78053556 C42.4024982,5.01015739 43.3551514,4.50685823 44.4299079,4.50685823 Z M43.4055679,13.2842155 L43.4055679,9.01907814 C43.4055679,8.31433946 43.3603268,7.85185468 43.2660746,7.63896485 C43.1718224,7.42607505 42.7955881,7.2893916 42.5316822,7.2893916 C42.267776,7.2893916 41.8607934,7.40047379 41.7816216,7.58767002 L41.7816216,9.01907814 L41.7816216,13.4207851 L41.7816216,14.8074788 C41.8721037,15.0130276 42.2602358,15.1274059 42.5316822,15.1274059 C42.8031285,15.1274059 43.1982131,15.0166981 43.281155,14.8074788 C43.3640968,14.5982595 43.4055679,14.0880581 43.4055679,13.2842155 Z"></path>
                                    </g>
                                </svg>
                                <span>{{ $similarMovie->rating }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <!-- <div class="-mb-2 swiper-pagination"></div> -->
            </div>
        </div>
    </section>

    <style>
    .movie-swiper {
        width: 100%;
        height: 350px;
        overflow: hidden;
        padding-bottom: 1rem;
    }
    .swiper-wrapper {
        display: flex;
        align-items: stretch;
    }
    .swiper-slide {
        display: flex;
        flex-direction: column;
        width: auto;
        max-width: 100px;
        min-width: 180px;
        aspect-ratio: 1/1.2;
        margin-right: 0.75rem;
        border-radius: 0.75rem;
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.1);
        background: white;
    }
    .swiper-slide img {
        width: 100%;
        height: 80%;
        object-fit: cover;
    }
    .swiper-slide .movie-info {
        width: 100%;
        height: 20%;
        background: white;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 0.75rem;
        border-top: 2px solid theme('colors.red.600');
    }
    @media (max-width: 640px) {
        .swiper-slide {
            max-width: 180px;
            min-width: 150px;
        }
    }
    @media (max-width: 480px) {
        .swiper-slide {
            max-width: 160px;
            min-width: 130px;
        }
    }
</style>


</div>
</div>