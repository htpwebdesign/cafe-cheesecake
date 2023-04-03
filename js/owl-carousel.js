jQuery(document).ready(function($) {
    $('.home-carousel').owlCarousel({
        items: 1,
        loop: true,
        margin: 0,
        nav: true,
        dots: false,
        autoplay: true,
        autoplayTimeout: 3000,
        autoplaySpeed:1000,
        responsive: {
            768: {
                items: 1
            },
            992: {
                items: 1
            }
        }
    });
});
