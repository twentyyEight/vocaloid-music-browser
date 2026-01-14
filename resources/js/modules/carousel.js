export function carousel() {
    const container = $('#container-albums-song')
    const prev = $('#arrow-left')
    const next = $('#arrow-right')
    const arrows = $('#arrows-albums-song')

    // Color de las flechas
    function updateArrowsState() {
        const scrollLeft = container.scrollLeft()
        const maxScroll = container[0].scrollWidth - container.outerWidth()

        prev.css('filter', scrollLeft <= 1 ? 'opacity(0.5)' : 'opacity(1)')
        next.css('filter', scrollLeft >= maxScroll - 1 ? 'opacity(0.5)' : 'opacity(1)')
    }

    // Aparición de las flechas
    function updateArrowsVisibility() {
        if (container[0].scrollWidth <= container.outerWidth() || $(window).width() < 992) {
            arrows.hide()
        } else {
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

    updateArrowsVisibility()
    updateArrowsState()
    // load solo funciona en window, img y iframe

    container.on('scroll', updateArrowsState)
    $(window).on('resize', updateArrowsVisibility)
}