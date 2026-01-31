import { links } from "./modules/links";

$(function () {

    // Color y logos de links
    $('.links-album').each(function () {

        Array.from(this.children).forEach(link => {
            const link_name = link.innerText

            const match = links.find(l =>
                l.name.toLowerCase() === link_name.toLowerCase()
                || link_name.toLowerCase().includes(l.name.toLowerCase())
            )

            if (match) {
                $(link).css({
                    backgroundColor: match.background,
                    color: match.color
                })
                $(link).prepend(match.icon)
            }
        })
    })

    // Mover btn 'fav'
    $(window).on('load resize', function () {
        if ($(this).innerWidth() > 992) {
            $('.fav, .delete.fav').prependTo('#cover-links-album')
        } else {
            $('.fav, .delete.fav').prependTo('#btns-album')
        }
    })


    function toggleSection(activeBtn, activeSection, inactiveBtn, inactiveSection) {
        $(activeSection).show()
        $(inactiveSection).hide()

        $(activeBtn).css('border-bottom', '2px solid #199ea5')
        $(inactiveBtn).css('border-bottom', 'transparent')
    }

    $('#btn-tracks-album').on('click', function () {
        toggleSection(this, '#tracks', '#btn-video-album', '#video-album')
    })

    $('#btn-video-album').on('click', function () {
        toggleSection(this, '#video-album', '#btn-tracks-album', '#tracks')
    })

    // Btns Tracks
    $('#tracks-disc-1').show()
    $('#disc-1').css('background-color', '#136b70')

    $('.btn-tracks').on('click', function () {
        $('.tracks-disc').hide()
        $(`#tracks-${this.id}`).show()

        $('.btn-tracks').css('background-color', 'transparent')
        $(this).css('background-color', '#136b70')
    })
})