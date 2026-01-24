export function carousel() {
    const container = $('#covers-albums-song')
    const totalContainer = $('#container-albums')
    const prev = $('.bi-caret-left-fill')
    const next = $('.bi-caret-right-fill')
    const arrows = $('.bi-caret-left-fill, .bi-caret-right-fill')

    // Color de las flechas
    function updateArrowsState() {

        const scrollLeft = container.scrollLeft()
        const maxScroll = container[0].scrollWidth - container.outerWidth()

        prev.css('filter', scrollLeft <= 1 ? 'opacity(0.5)' : 'opacity(1)')
        next.css('filter', scrollLeft >= maxScroll - 1 ? 'opacity(0.5)' : 'opacity(1)')
    }

    // Aparición de las flechas
    function arrowsVisibility() {
        if (container[0].scrollWidth <= totalContainer.width()) {
            arrows.hide()
        }
        else {
            arrows.show()
            updateArrowsState()
        }
    }

    // Movimiento del carousel
    next.on('click', function () {
        const maxScroll = container[0].scrollWidth - container.outerWidth()
        const target = Math.min(container.scrollLeft() + container.outerWidth(), maxScroll)
        container.animate({ scrollLeft: target }, 300)
    })

    prev.on('click', function () {
        const target = Math.max(container.scrollLeft() - container.outerWidth(), 0)
        container.animate({ scrollLeft: target }, 300)
    })

    arrowsVisibility()

    container.on('scroll', updateArrowsState)
    $(window).on('resize', arrowsVisibility)
}