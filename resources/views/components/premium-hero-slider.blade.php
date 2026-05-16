@props(['sliders'])

<div class="relative w-full h-[320px] sm:h-[400px] md:h-[450px] lg:h-[480px] xl:h-[550px] overflow-hidden group rounded-2xl shadow-2xl">
    <!-- Main Slider -->
    <div class="swiper premium-hero-slider h-full w-full">
        <div class="swiper-wrapper">
            @foreach ($sliders as $slider)
                <div class="swiper-slide relative overflow-hidden group">
                    <!-- Background Image with Lazy Loading -->
                    <img 
                        src="{{ asset('storage/' . $slider['image']) }}" 
                        class="ken-burns absolute inset-0 w-full h-full object-cover"
                        alt="{{ $slider['title'] }}"
                        loading="{{ $loop->first ? 'eager' : 'lazy' }}"
                    >
                    
                    <!-- Gradient Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black via-black/40 to-transparent"></div>
                    <div class="absolute inset-0 bg-gradient-to-r from-black/60 via-transparent to-transparent"></div>

                    <!-- Content -->
                    <div class="absolute inset-0 flex flex-col justify-end p-6 md:p-10 lg:p-12 z-10">
                        <div class="max-w-6xl flex flex-col md:flex-row items-end gap-10">
                            <!-- Portrait Poster (Hidden on mobile) -->
                            @if($slider['poster'])
                                <div class="hidden md:block w-40 lg:w-48 shrink-0 opacity-0 -translate-x-12 transition-all duration-1000 group-[.swiper-slide-active]:opacity-100 group-[.swiper-slide-active]:translate-x-0 delay-200">
                                    <img src="{{ asset('storage/' . $slider['poster']) }}" 
                                         class="w-full aspect-[2/3] object-cover rounded-2xl shadow-[0_20px_50px_rgba(0,0,0,0.5)] border border-white/10" 
                                         alt="Poster">
                                </div>
                            @endif

                            <div class="flex-1 space-y-4 md:space-y-6">
                                <!-- Category Badge & Type -->
                                <div class="flex flex-wrap items-center gap-3 opacity-0 translate-y-4 transition-all duration-700 group-[.swiper-slide-active]:opacity-100 group-[.swiper-slide-active]:translate-y-0 delay-100">
                                    @if($slider['type'])
                                        <span class="px-3 py-1 bg-yellow-500 text-black text-[10px] font-black uppercase tracking-widest rounded-full shadow-lg shadow-yellow-500/20">
                                            {{ $slider['type'] }}
                                        </span>
                                    @endif
                                    
                                    @if($slider['rating'])
                                        <div class="flex items-center gap-2 px-3 py-1 bg-white/10 backdrop-blur-md rounded-full border border-white/10">
                                            <i class="fa-solid fa-star text-yellow-500 text-[10px]"></i>
                                            <span class="text-white text-[10px] font-black tracking-widest">{{ $slider['rating'] }}/10</span>
                                        </div>
                                    @endif

                                    @if($slider['release_year'])
                                        <div class="flex items-center gap-2 px-3 py-1 bg-white/10 backdrop-blur-md rounded-full border border-white/10">
                                            <i class="fa-solid fa-calendar-days text-gray-400 text-[10px]"></i>
                                            <span class="text-gray-300 text-[10px] font-black tracking-widest">{{ $slider['release_year'] }}</span>
                                        </div>
                                    @endif
                                </div>

                                @if($slider['title'])
                                    <h1 class="text-3xl md:text-5xl lg:text-6xl font-black text-white leading-tight opacity-0 translate-y-8 transition-all duration-1000 group-[.swiper-slide-active]:opacity-100 group-[.swiper-slide-active]:translate-y-0 delay-300">
                                        {{ $slider['title'] }}
                                    </h1>
                                @endif
                                
                                @if($slider['subtitle'])
                                    <div class="relative opacity-0 translate-y-8 transition-all duration-1000 group-[.swiper-slide-active]:opacity-100 group-[.swiper-slide-active]:translate-y-0 delay-500">
                                        <p class="text-base md:text-xl text-gray-300/90 max-w-2xl font-medium leading-relaxed line-clamp-3">
                                            {{ $slider['subtitle'] }}
                                        </p>
                                        @if($slider['badge'])
                                            <a href="{{ $slider['badge_link'] }}" class="mt-4 inline-flex items-center gap-2 px-3 py-1 bg-red-500/10 backdrop-blur-md border border-red-500/20 text-red-500 text-[10px] font-black uppercase tracking-widest rounded-lg hover:bg-red-500/20 transition-all active:scale-95">
                                                <i class="fa-solid fa-fire-flame-curved text-[10px]"></i>
                                                {{ $slider['badge'] }}
                                            </a>
                                        @endif
                                    </div>
                                @endif

                                @if($slider['button_text'] && $slider['button_link'])
                                    <div class="opacity-0 translate-y-8 transition-all duration-1000 group-[.swiper-slide-active]:opacity-100 group-[.swiper-slide-active]:translate-y-0 delay-700 pt-4">
                                        <a href="{{ $slider['button_link'] }}" 
                                           class="inline-flex items-center gap-4 px-10 py-5 bg-white text-black font-black rounded-full transition-all hover:bg-yellow-500 hover:scale-105 active:scale-95 shadow-2xl">
                                            {{ $slider['button_text'] }}
                                            <i class="fa-solid fa-arrow-right"></i>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Progress Bar -->
        <div class="absolute bottom-0 left-0 w-full h-1 bg-white/10 z-20">
            <div class="premium-slider-progress h-full bg-yellow-500 w-0"></div>
        </div>

        <!-- Navigation -->
        <div class="premium-swiper-pagination swiper-pagination absolute right-4 top-1/2 -translate-y-1/2 z-20 hidden md:flex flex-col gap-2"></div>
        
        <div class="absolute bottom-8 right-8 flex gap-4 z-20">
            <button class="premium-prev w-12 h-12 flex items-center justify-center rounded-full bg-white/10 hover:bg-yellow-500 hover:text-black backdrop-blur-md border border-white/20 transition-all">
                <i class="fa-solid fa-chevron-up text-sm"></i>
            </button>
            <button class="premium-next w-12 h-12 flex items-center justify-center rounded-full bg-white/10 hover:bg-yellow-500 hover:text-black backdrop-blur-md border border-white/20 transition-all">
                <i class="fa-solid fa-chevron-down text-sm"></i>
            </button>
        </div>
    </div>
</div>

<style>
    .premium-hero-slider .swiper-pagination-bullet {
        width: 4px !important;
        height: 20px !important;
        background: rgba(255, 255, 255, 0.4) !important;
        border-radius: 4px !important;
        opacity: 1 !important;
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1) !important;
        margin: 4px 0 !important;
        display: block !important;
    }
    
    .premium-hero-slider .swiper-pagination-bullet-active {
        height: 40px !important;
        background: #eab308 !important;
        box-shadow: 0 0 15px rgba(234, 179, 8, 0.5) !important;
    }

    /* Dynamic Bullet Scaling */
    .premium-hero-slider .swiper-pagination-bullet-active-main {
        transform: scale(1) !important;
        opacity: 1 !important;
    }
    .premium-hero-slider .swiper-pagination-bullet-active-prev,
    .premium-hero-slider .swiper-pagination-bullet-active-next {
        transform: scale(0.7) !important;
        opacity: 0.5 !important;
    }
    .premium-hero-slider .swiper-pagination-bullet-active-prev-prev,
    .premium-hero-slider .swiper-pagination-bullet-active-next-next {
        transform: scale(0.4) !important;
        opacity: 0.2 !important;
    }
    
    .premium-hero-slider .swiper-slide-active .ken-burns {
        animation: kenBurns 20s ease-out forwards;
    }
    
    @keyframes kenBurns {
        from { transform: scale(1.15); }
        to { transform: scale(1); }
    }
    
    .premium-slider-progress.animate {
        animation: sliderProgress 60s linear forwards;
    }
    
    @keyframes sliderProgress {
        from { width: 0%; }
        to { width: 100%; }
    }
</style>
