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

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    const topMovieSwiper = new Swiper(
        '.top-movie-swiper',
        {
            modules: [Navigation, Pagination, Autoplay],
            navigation: {
                nextEl: '.top-movie-swiper-button-next',
                prevEl: '.top-movie-swiper-button-prev',
            },
            pagination: {
                el: '.top-movie-swiper-pagination',
                clickable: true
            },
            direction: 'horizontal',
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },lazy: {
                loadOnTransitionStart: true,
                loadPrevNext: true,
            },
            slidesPerView: 'auto',
            spaceBetween: 15,
            centeredSlides: false,
            breakpoints: {
                0: {
                    slidesPerView: 1.1,
                    spaceBetween: 10,
                },
                480: {
                    slidesPerView: 2.1,
                    spaceBetween: 15,
                },
                640: {
                    slidesPerView: 3.1,
                    spaceBetween: 20,
                },
                1024: {
                    slidesPerView: 4.1,
                    spaceBetween: 25,
                },
            },
        }
    );
    const similarMovieSwiper = new Swiper(
        '.similar-movie-swiper',
        {
            modules: [Navigation, Pagination, Autoplay],
            navigation: {
                nextEl: '.similar-movie-swiper-button-next',
                prevEl: '.similar-movie-swiper-button-prev',
            },
            pagination: {
                el: '.similar-movie-swiper-pagination',
                clickable: true
            },
            direction: 'horizontal',
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },lazy: {
                loadOnTransitionStart: true,
                loadPrevNext: true,
            },
            slidesPerView: 'auto',
            spaceBetween: 15,
            centeredSlides: false,
            breakpoints: {
                0: {
                    slidesPerView: 1.1,
                    spaceBetween: 10,
                },
                480: {
                    slidesPerView: 2.1,
                    spaceBetween: 15,
                },
                640: {
                    slidesPerView: 3.1,
                    spaceBetween: 20,
                },
                1024: {
                    slidesPerView: 4.1,
                    spaceBetween: 25,
                },
            },
        }
    );
    const topArtistsSwiper = new Swiper(
        '.top-artists-swiper',
        {
            modules: [Navigation, Pagination, Autoplay],
            navigation: {
                nextEl: '.top-artists-swiper-button-next',
                prevEl: '.top-artists-swiper-button-prev',
            },
            pagination: {
                el: '.top-artists-swiper-pagination',
                clickable: true
            },
            direction: 'horizontal',
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },lazy: {
                loadOnTransitionStart: true,
                loadPrevNext: true,
            },
            slidesPerView: 'auto',
            spaceBetween: 15,
            centeredSlides: false,
            breakpoints: {
                0: {
                    slidesPerView: 1.1,
                    spaceBetween: 10,
                },
                480: {
                    slidesPerView: 2.1,
                    spaceBetween: 15,
                },
                640: {
                    slidesPerView: 3.1,
                    spaceBetween: 20,
                },
                1024: {
                    slidesPerView: 4.1,
                    spaceBetween: 25,
                },
            },
        }
    );

    const thumbnailSlider = new Swiper(
        '.thumbnail-slider',
        {
            modules: [Navigation, Thumbs],
            spaceBetween: 10,
            slidesPerView: 3,
            direction: 'vertical',
            watchSlidesProgress: true,
            navigation: {
                nextEl: '.thumbnail-swiper-button-next',
                prevEl: '.thumbnail-swiper-button-prev'
            },
            breakpoints: {
                // When window width is >= 768px
                768: {
                    slidesPerView: 4,
                }
            },
            on: {
                click: function (swiper, event) {
                    mainSLider.slideTo(swiper.clickedIndex);
                }
            }
        }
    );

    const mainSLider = new Swiper(
        '.main-slider',
        {
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
            direction: 'horizontal',
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
            centeredSlides: false,
            thumbs: {
                swiper: thumbnailSlider,
                slideThumbActiveClass: 'swiper-slide-thumb-active'
            },
            on: {
                slideChange: function () {
                    // Manually update thumbnail slider to ensure it follows main slider
                    const activeIndex = this.activeIndex;
                    const totalSlides = this.slides.length;
                    
                    // Adjust for loop mode
                    const adjustedIndex = activeIndex % totalSlides;
                    
                    // Scroll to the corresponding thumbnail
                    thumbnailSlider.slideTo(adjustedIndex, 300);
                }
            }
        }
    );
});