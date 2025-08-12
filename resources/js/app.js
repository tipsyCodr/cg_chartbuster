import "./bootstrap";
import Alpine from "alpinejs";
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
    // First initialize the thumbnail slider
    const thumbnailSlider = new Swiper('.thumbnail-slider', {
        modules: [Navigation, Thumbs],
        slidesPerView: 4, // Set a fixed number of slides
        spaceBetween: 10,
        centeredSlides: true,
        loop: true,
        loopedSlides: 10, // Set to number of slides you have or more
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


});