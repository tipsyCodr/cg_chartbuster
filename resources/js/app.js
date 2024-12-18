import "./bootstrap";
import Alpine from "alpinejs";
// import Swiper JS
import Swiper from 'swiper';
import { Navigation, Pagination } from 'swiper/modules';
// import Swiper styles
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    const swiper = new Swiper(
        '.movie-swiper',
        {
            modules: [Navigation, Pagination],
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true
            },
            direction: 'horizontal',
            loop: true,
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
    const mainSLider = new Swiper(
        '.main-slider',
        {
            modules: [Navigation, Pagination],
            // navigation: {
            //     nextEl: '.swiper-button-next',
            //     prevEl: '.swiper-button-prev',
            // },
            pagination: {
                el: '.swiper-pagination',
                clickable: true
            },
            direction: 'horizontal',
            loop: true,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },lazy: {
                loadOnTransitionStart: true,
                loadPrevNext: true,
            },
            slidesPerView: 1,
            spaceBetween: 15,
            centeredSlides: false,
            
        }
    );
});