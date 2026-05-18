@props(['banners' => collect()])

@if ($banners && $banners->isNotEmpty())
    <div
        class="hero-section mb-8 rounded-xl overflow-hidden shadow-2xl border-4 border-yellow-600/20 swiper hero-slider lg:max-h-[200px]">
        <div class="swiper-wrapper">
            @foreach ($banners as $banner)
                <div class="swiper-slide relative h-full">
                    @if ($banner->link_url)
                        <a href="{{ $banner->link_url }}" target="_blank" class="block w-full h-full">
                    @endif
                    <img src="{{ asset('storage/' . $banner->image_path) }}"
                        class="w-full h-full object-cover aspect-[21/9] lg:aspect-auto" alt="Hero Banner">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex items-end p-6">
                        {{-- Optional overlay content can go here --}}
                    </div>
                    @if ($banner->link_url)
                        </a>
                    @endif
                </div>
            @endforeach
        </div>
        <div class="swiper-pagination !bottom-4"></div>
    </div>
@else
    <div class="hero-section  bg-yellow-500 rounded-xl overflow-hidden shadow-2xl mb-8  lg:max-h-[200px]">
        <div class="flex flex-col lg:flex-row divide-y lg:divide-y-0 lg:divide-x divide-yellow-600/30 h-full">
            <!-- Box 1: Rate. Recommend. Rise. -->
            <div
                class="flex-1 p-4 sm:p-6 flex flex-col justify-center bg-gradient-to-br from-yellow-500 to-yellow-600 group relative overflow-hidden h-full">
                <div class="relative z-10 p-4 sm:p-6">
                    <h2 class="text-xl sm:text-2xl font-black text-black mb-2">Rate. Recommend. Rise.</h2>
                    <p class="text-black/80 text-xs sm:text-sm mb-4 max-w-md font-medium leading-tight">
                        India's community-driven rating platform for Chhattisgarhi (Chhollywood) entertainment. We do
                        not
                        host or stream media content.
                    </p>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('movies') }}"
                            class="px-4 py-2 bg-black text-yellow-500 text-xs font-bold rounded-lg hover:bg-gray-900 transition-all shadow-lg active:scale-95">
                            Explore Movies
                        </a>
                        <a href="{{ route('artists') }}"
                            class="px-4 py-2 bg-yellow-400/30 border-2 border-black/10 text-xs font-bold text-black rounded-lg hover:bg-yellow-400/50 transition-all active:scale-95">
                            Top Artists
                        </a>
                    </div>
                </div>
                <!-- Decorative icon -->
                <i
                    class="fa-solid fa-star absolute -right-3 -bottom-3 text-black/5 text-7xl transform -rotate-12 group-hover:scale-110 transition-transform"></i>
            </div>

            <!-- Box 2: Building Digital Foundation -->
            <div
                class="hidden md:flex flex-1 p-4 sm:p-6 flex-col justify-center bg-black/5 relative group overflow-hidden h-full">
                <div class="relative z-10">
                    <h2 class="text-xl sm:text-2xl font-black text-black mb-2 leading-tight">Digital Foundation of
                        Chhollywood</h2>
                    <p class="text-black/70 text-[10px] sm:text-xs mb-3 font-semibold leading-snug">
                        CG Chartbusters is an independent digital platform dedicated to rating, reviewing, and promoting
                        Chhollywood entertainment.
                    </p>
                    <ul class="space-y-1.5">
                        <li class="flex items-start gap-2 text-black/80 text-[10px] sm:text-xs font-bold">
                            <i class="fa-solid fa-check-circle mt-0.5 text-black"></i>
                            <span>Independent recognition space.</span>
                        </li>
                        <li class="flex items-start gap-2 text-black/80 text-[10px] sm:text-xs font-bold">
                            <i class="fa-solid fa-check-circle mt-0.5 text-black"></i>
                            <span>Structured ratings and recognition.</span>
                        </li>
                        <li class="flex items-start gap-2 text-black/80 text-[10px] sm:text-xs font-bold">
                            <i class="fa-solid fa-check-circle mt-0.5 text-black"></i>
                            <span>Digitally empowered ecosystem.</span>
                        </li>
                    </ul>
                </div>
                <!-- Decorative icon -->
                <i
                    class="fa-solid fa-clapperboard absolute -right-3 -top-3 text-black/5 text-7xl transform rotate-12 group-hover:scale-110 transition-transform"></i>
            </div>


        </div>
    </div>
@endif

<style>
    .vertical-text {
        writing-mode: vertical-rl;
        transform: rotate(180deg);
    }

    @media (max-width: 768px) {
        .hero-section {
            /* height: 58vh !important; */
            min-height: auto !important;
        }

        /* Fallback static container height on mobile */
        div.hero-section:not(.hero-slider) {
            /* height: 20vh !important; */
        }

        .hero-section .flex-col {
            height: 100% !important;
        }

        .hero-section .hidden {
            display: none !important;
        }

        .hero-section .flex-1:not(.hidden) {
            padding: 0px 4px !important;
            display: flex !important;
            flex-direction: column !important;
            justify-content: center !important;
        }

        .hero-section h2 {
            font-size: 1.15rem !important;
            margin-bottom: 4px !important;
            line-height: 1.25 !important;
            font-weight: 900 !important;
        }

        .hero-section p {
            font-size: 0.72rem !important;
            margin-bottom: 8px !important;
            line-height: 1.3 !important;
        }

        .hero-section .flex-wrap {
            gap: 6px !important;
        }

        .hero-section a {
            padding: 6px 12px !important;
            font-size: 0.7rem !important;
        }

        .hero-section ul {
            margin-top: 4px !important;
        }

        .hero-section ul>*+* {
            margin-top: 4px !important;
        }

        .hero-section li {
            font-size: 0.72rem !important;
            line-height: 1.2 !important;
        }

        .hero-section li span {
            font-size: 0.72rem !important;
        }

        .hero-section li i {
            font-size: 0.65rem !important;
            margin-top: 2px !important;
        }

        .hero-section .fa-star,
        .hero-section .fa-clapperboard {
            font-size: 4rem !important;
            opacity: 0.03 !important;
        }

        /* Swiper slider height and optimization on mobile */
        .hero-slider.hero-section {
            height: 58vh !important;
        }

        .hero-slider.hero-section .swiper-slide img {
            width: 100% !important;
            height: 100% !important;
            object-fit: cover !important;
            object-position: center !important;
        }
    }
</style>
