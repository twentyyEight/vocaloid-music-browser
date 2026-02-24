import { links } from "../modules/links";
import { closeAlert } from "../modules/close-alert";

$(function () {

    // Color links (redes sociales)
    $('#links-artist').each(function () {

        Array.from(this.children).forEach(link => {
            const link_name = link.innerText

            const match = links.find(l =>
                l.name.toLowerCase() === link_name.toLowerCase()
                || link_name.toLowerCase().includes(l.name.toLowerCase())
            )

            if (match) {
                if (match.background.startsWith('linear-gradient')) {
                    $(link).css({
                        backgroundImage: match.background,
                        color: match.color
                    });
                } else {
                    $(link).css({
                        backgroundColor: match.background,
                        color: match.color
                    });
                }
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

    closeAlert()
})