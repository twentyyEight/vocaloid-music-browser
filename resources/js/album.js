$(function () {
    $('#tracks-disc-1').show()
    $('#disc-1').css('background-color', '#199ea5')

    $('.btn-tracks').on('click', function () {
        $('.tracks-disc').hide()
        $(`#tracks-${this.id}`).show()

        $('.btn-tracks').css('background-color', 'transparent')
        $(this).css('background-color', '#199ea5')
    })
})