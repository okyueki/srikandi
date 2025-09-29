/* file-details styles */

(function () {
    'use strict';
  
    // swiper with pagination
    var swiper = new Swiper(".pagination", {
        pagination: {
          el: ".swiper-pagination",
          clickable: true,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        autoplay: {
            delay: 1500,
            disableOnInteraction: false
        },
        slidesPerView: 1,
        loop: true,
        spaceBetween: 20,
        breakpoints: {
          420: {
            slidesPerView: 2,
          },
          500: {
            slidesPerView: 2,
          },
          700: {
            slidesPerView: 3,
          },
          992: {
            slidesPerView: 3,
          },
          1400: {
            slidesPerView: 4,
          },
        },
    });
  
  })();