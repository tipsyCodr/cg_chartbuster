import "./bootstrap";
// import Swiper JS
import Swiper from 'swiper';
import { Navigation, Pagination, Thumbs, Autoplay } from 'swiper/modules';
// import Swiper styles
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

// Register Swiper modules
Swiper.use([Navigation, Pagination, Thumbs, Autoplay]);

document.addEventListener('DOMContentLoaded', () => {
    // Premium Hero Slider
    const premiumHeroSlider = new Swiper('.premium-hero-slider', {
        modules: [Navigation, Pagination, Autoplay],
        direction: 'vertical',
        speed: 1000,
        loop: true,
        autoplay: {
            delay: 10000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.premium-swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.premium-next',
            prevEl: '.premium-prev',
        },
        effect: 'slide',
        on: {
            init: function() {
                const progress = document.querySelector('.premium-slider-progress');
                if (progress) {
                    progress.classList.remove('animate');
                    void progress.offsetWidth;
                    progress.classList.add('animate');
                }
            },
            slideChange: function() {
                const progress = document.querySelector('.premium-slider-progress');
                if (progress) {
                    progress.classList.remove('animate');
                    void progress.offsetWidth;
                    progress.classList.add('animate');
                }
            }
        }
    });

    // Initialize Hero Slider if it exists
    const heroSlider = new Swiper('.hero-slider', {
        modules: [Pagination, Autoplay],
        pagination: {
            el: '.swiper-pagination',
            clickable: true
        },
        loop: true,
        autoplay: {
            delay: 2000,
            disableOnInteraction: false,
        },
        slidesPerView: 1,
        spaceBetween: 0,
        observer: true,
        observeParents: true,
    });
    const thumbnailSlider = new Swiper('.thumbnail-slider', {
        modules: [Navigation, Thumbs],
        slidesPerView: 4,
        spaceBetween: 10,
        centeredSlides: false,
        loop: true,
        slideToClickedSlide: true,
        direction: 'vertical',
        watchSlidesProgress: true,
        navigation: {
            nextEl: '.thumbnail-swiper-button-next',
            prevEl: '.thumbnail-swiper-button-prev'
        },
        observer: true, // Add this to force Swiper to recalculate after DOM changes
        observeParents: true, // Add this to observe parent elements
        breakpoints: {
            768: {
                slidesPerView: 4,
            }
        }
    });

    // Then initialize the main slider
    const mainSlider = new Swiper('.main-slider', {
        modules: [Navigation, Pagination, Thumbs, Autoplay],
        navigation: {
            nextEl: '.swiper-next',
            prevEl: '.swiper-prev',
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true
        },
        loop: true,
        loopedSlides: 10, // Match with thumbnail slider
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        lazy: {
            loadOnTransitionStart: true,
            loadPrevNext: true,
        },
        slidesPerView: 1,
        spaceBetween: 15,
        observer: true, // Add this to force Swiper to recalculate after DOM changes
        observeParents: true, // Add this to observe parent elements
        thumbs: {
            swiper: thumbnailSlider
        }
    });

    // Better synchronization approach
    mainSlider.on('slideChangeTransitionEnd', function () {
        if (thumbnailSlider && !thumbnailSlider.destroyed) {
            let realIndex = this.realIndex;
            thumbnailSlider.slideToLoop(realIndex, 300, true);
        }
    });

    thumbnailSlider.on('click', function () {
        if (mainSlider && !mainSlider.destroyed) {
            let clickedIndex = thumbnailSlider.clickedIndex;
            if (clickedIndex !== undefined) {
                // Use slideToLoop for proper handling in loop mode
                mainSlider.slideToLoop(clickedIndex, 300, true);
            }
        }
    });

    // Optional: restart autoplay after user interaction
    thumbnailSlider.on('click', function () {
        mainSlider.autoplay.start();
    });

    // Initialize Movie, Song, and Artist Sliders
    const commonSliderOptions = {
        slidesPerView: 2,
        spaceBetween: 20,
        breakpoints: {
            640: { slidesPerView: 3, spaceBetween: 30 },
            1024: { slidesPerView: 5, spaceBetween: 40 },
            1280: { slidesPerView: 6, spaceBetween: 50 },
        },
        observer: true,
        observeParents: true,
    };

    new Swiper('.movie-slider', {
        ...commonSliderOptions,
        navigation: {
            nextEl: '.movie-next',
            prevEl: '.movie-prev',
        },
    });
    new Swiper('.song-slider', {
        ...commonSliderOptions,
        navigation: {
            nextEl: '.song-next',
            prevEl: '.song-prev',
        },
    });
    new Swiper('.tvshow-slider', {
        ...commonSliderOptions,
        navigation: {
            nextEl: '.tvshow-next',
            prevEl: '.tvshow-prev',
        },
    });
    new Swiper('.artist-slider', {
        ...commonSliderOptions,
        slidesPerView: 2,
        breakpoints: {
            640: { slidesPerView: 3, spaceBetween: 15 },
            1024: { slidesPerView: 4, spaceBetween: 20 },
            1280: { slidesPerView: 5, spaceBetween: 25 },
        },
        navigation: {
            nextEl: '.artist-next',
            prevEl: '.artist-prev',
        },
    });

    const artistMediaSliderOptions = {
        slidesPerView: 2,
        spaceBetween: 16,
        breakpoints: {
            640: { slidesPerView: 3, spaceBetween: 20 },
            1024: { slidesPerView: 3, spaceBetween: 24 },
            1280: { slidesPerView: 4, spaceBetween: 24 },
        },
        observer: true,
        observeParents: true,
    };

    new Swiper('.artist-movie-slider', {
        ...artistMediaSliderOptions,
        navigation: {
            nextEl: '.artist-movie-next',
            prevEl: '.artist-movie-prev',
        },
    });

    new Swiper('.artist-song-slider', {
        ...artistMediaSliderOptions,
        navigation: {
            nextEl: '.artist-song-next',
            prevEl: '.artist-song-prev',
        },
    });

    new Swiper('.artist-tvshow-slider', {
        ...artistMediaSliderOptions,
        navigation: {
            nextEl: '.artist-tvshow-next',
            prevEl: '.artist-tvshow-prev',
        },
    });
});
