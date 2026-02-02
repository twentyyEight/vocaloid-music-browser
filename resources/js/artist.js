import { links_artists } from "./modules/links_artistis";

$(function () {

    // Color links (redes sociales)
    $('#links-artist').each(function () {

        Array.from(this.children).forEach(link => {
            const link_name = link.innerText

            const match = links_artists.find(l =>
                l.name.toLowerCase() === link_name.toLowerCase()
                || link_name.toLowerCase().includes(l.name.toLowerCase())
            )

            if (match) {
                $(link).css({
                    backgroundColor: match.background,
                    color: match.color
                })
                //$(link).prepend(match.icon)
            }
        })
    })

    // Btn populares y recientes
    $('.switch button').on('click', function () {

        const classes = this.classList
        const entity = classes[0]
        const sort = classes[1]

        const index = $(this).index() - 1
        const indicator = $(`.switch-indicator-${entity}`)
        indicator.css('transform', `translateX(${index * 100}%)`)
        $('.switch button').removeClass('active')
        $(this).addClass('active')

        $(`div.${entity}`).hide()
        $(`div.${entity}.${sort}`).css('display', 'grid')
    })
})