$(function () {

    $('#close, #explorar-dropdown').hide()

    /* Abrir navbar en mobiles */
    let isNavOpen = false

    $('.nav-icon').on('click', function () {

        isNavOpen = !isNavOpen

        if (isNavOpen) {
            $('#close').show()
            $('#menu').hide()
            $('#nav-content').slideDown(200)
        } else {
            $('#close').hide()
            $('#menu').show()
            $('#nav-content').slideUp(200)
        }
    })

    /* Abrir 'Explorar' dropdown */
    $('#explorar').on('click', function () {
        $('#explorar-dropdown').slideToggle(200)
    })
})