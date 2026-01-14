import { carousel } from './modules/carousel.js'

$(function () {

    function carouselInitialized(bool) {
        if (bool) carousel()
        else return
    }

    function arrowsVisibility() {
        if ($(window).width() > 992) {
            $('#video-song, #info-song').appendTo('#hero-content')
            carouselInitialized(true)

        } else {
            $('#video-song').insertBefore('#hero-content')
            $('#info-song').insertBefore('#credits')
            carouselInitialized(false)
        }
    }

    $(window).on('load resize', function () {
        arrowsVisibility()
    })
})