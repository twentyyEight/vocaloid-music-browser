import { carousel } from "./modules/carousel";

$(function () {

    function toggleSongSection(activeBtn, activeSection, inactiveBtn, inactiveSection) {
        $(activeSection).show()
        $(inactiveSection).hide()

        $(activeBtn).css('border-bottom', '2px solid #199ea5')
        $(inactiveBtn).css('border-bottom', 'transparent')
    }

    $('#btn-info-song').on('click', function () {
        toggleSongSection(this, '#info-song', '#btn-lyrics-song', '#lyrics-song')
    })

    $('#btn-lyrics-song').on('click', function () {
        toggleSongSection(this, '#lyrics-song', '#btn-info-song', '#info-song')
    })

    const idFirstLyric = $('#btns-lyrics-song')[0].firstElementChild.id
    $(`#${idFirstLyric}`).css('background-color', '#199ea5')
    $(`#lyric-${idFirstLyric}`).show()

    $('.btn-lyric').on('click', function () {
        $('.lyric').hide()
        $('.btn-lyric').css('background-color', 'transparent')
        $(this).css('background-color', '#199ea5')
        $(`#lyric-${this.id}`).show()
    })

    $(window).on('load', carousel)
})