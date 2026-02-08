export function carousel(container) {

    const wrapper = container.closest('.carousel')
    const prev = wrapper.find('.bi-caret-left-fill')
    const next = wrapper.find('.bi-caret-right-fill')
    const arrows = prev.add(next)

    function updateArrowsState() {
        const scrollLeft = container.scrollLeft()
        const maxScroll = container[0].scrollWidth - container.outerWidth()

        prev.css('opacity', scrollLeft <= 1 ? 0.5 : 1)
        next.css('opacity', scrollLeft >= maxScroll - 1 ? 0.5 : 1)
    }

    function arrowsVisibility() {
        if (
            container[0].scrollWidth <= container[0].clientWidth ||
            $(window).width() <= 992
        ) {
            arrows.hide()
        } else {
            arrows.show()
            updateArrowsState()
        }
    }

    next.on('click', () => {
        const maxScroll = container[0].scrollWidth - container.outerWidth()
        const target = Math.min(
            container.scrollLeft() + container.outerWidth(),
            maxScroll
        )
        container.animate({ scrollLeft: target }, 300)
    })

    prev.on('click', () => {
        const target = Math.max(
            container.scrollLeft() - container.outerWidth(),
            0
        )
        container.animate({ scrollLeft: target }, 300)
    })

    arrowsVisibility()
    container.on('scroll', updateArrowsState)
    $(window).on('resize', arrowsVisibility)
}
