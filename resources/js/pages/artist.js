import { links_artists } from "../modules/links_artistis";
import { closeAlert } from "../modules/close-alert";

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

    if ($('div.songs').length === 1) {
        const sort_song = $('div.songs')[0].classList[1]
        $(`button.songs`).hide()
        $(`button.songs.${sort_song}`)
            .show()
            .css('background-color', '#199ea5')
        $(`div.songs.${sort_song}`).css('display', 'grid')
    }

    if ($('div.albums').length === 1) {
        const sort_album = $('div.albums')[0].classList[1]
        $(`button.albums`).hide()
        $(`button.albums.${sort_album}`)
            .show()
            .css('background-color', '#199ea5')
        $(`div.albums.${sort_album}`).css('display', 'grid')
    }

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

    closeAlert()
})