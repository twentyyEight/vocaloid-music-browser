import { tagsHandler } from "./tags.js"

export function filters() {

    // Maneja el filtro 'Género'
    tagsHandler({
        name: 'genres',
        sessionStorageName: 'selectedGenres',
    })

    // Maneja el filtro 'Artistas'
    tagsHandler({
        name: 'artists',
        sessionStorageName: 'selectedArtists',
    })

    // Maneja el filtro 'Tipo de artista'
    const buttons_types = $('.type-artist')
    const options_types = $('#types option').clone();

    function changeOptionType(type) {
        $('#types').empty();

        options_types.filter(function () {
            return $(this).data('type') == type;
        }).clone().appendTo('#types');
    }

    changeOptionType('producer')

    buttons_types.on('click', function () {
        let type = $(this)[0].classList[1]
        changeOptionType(type)
    })

    buttons_types.on('click', function () {
        buttons_types.removeClass('active');
        $(this).addClass('active');
    });

    // Maneja el envio del value de los select
    $('#types').on('change', function () {
        $('#type').val(this.value)
    })

    // Maneja la posición de los filtros en moviles y pc
    function filterPosition() {
        if ($(window).width() >= 992) {
            $('.open_filters, .btn-close').hide()
            $('.modal-header').insertBefore('.controls')
            $('#filters_modal')
                .removeClass('modal fade')
                .show()
        } else {
            $('.modal-header').insertBefore('.modal-body')
            $('#filters_modal').addClass('modal fade')
            $('.open_filters, .btn-close').show()
        }
    }

    filterPosition()

    $(window).on('resize', function () {
        filterPosition()
    });
}