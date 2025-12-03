$(function () {

    $('#close, #explorar-dropdown, #nav-content').hide()

    /* Abrir navbar en mobiles */
    let isNavOpen = false

    $('.nav-icon').on('click', function () {

        isNavOpen = !isNavOpen

        if (isNavOpen) {
            $('#close').show()
            $('#menu').hide()
        } else {
            $('#close').hide()
            $('#menu').show()
        }

        $('#nav-content').slideToggle(200)
    })

    /* Abrir 'Explorar' dropdown */
    $('#explorar').on('click', function () {
        $('#explorar-dropdown').slideToggle(200)
    })
})