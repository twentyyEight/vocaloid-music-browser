import { tagsHandler } from "./tags.js"

export function filters() {

    // Maneja el filtro 'Género'
    tagsHandler({
        inputId: '#genres',
        hiddenInputId: '#genres_ids',
        name: 'genres',
        sessionStorageName: 'selectedGenres',
        loading: '#loading_genres',
        selectedWrapperId: '#selected_genres'
    })

    // Maneja el filtro 'Artistas'
    tagsHandler({
        inputId: '#artists',
        hiddenInputId: '#artists_ids',
        name: 'artists',
        sessionStorageName: 'selectedArtists',
        loading: '#loading_artists',
        selectedWrapperId: '#selected_artists'
    })

    // Maneja las opciones a mostrar en 'Tipo de artista'
    function updateSelectByRadio(type) {
        const $select = $('#types');

        $select.val('');
        $select.find('option:not(:first)').hide();
        $select.find(`option[data-type="${type}"]`).show();
    }

    $(document).on('change', '.type-artist', function () {
        $('.type-artist').not(this).prop('checked', false); // permite seleccionar solo un radio, ya que ellos no utilizan 'name'
        updateSelectByRadio(this.value);
    });

    const checked = $('.type-artist:checked').val();
    if (checked) updateSelectByRadio(checked);

    // Maneja el envio del value de los select
    $('#types').on('change', function () { $('#type').val(this.value) })

    // Maneja la posición de los filtros en moviles y pc
    function filterPosition() {
        if ($(window).width() >= 768) {
            $('#open_filters, .btn-close').hide()
            $('.modal-header').insertBefore('#controls')
            $('#filtersModal')
                .removeClass('modal fade')
                .show()
        } else {
            $('.modal-header').insertBefore('.modal-body')
            $('#filtersModal').addClass('modal fade')
            $('#open_filters, .btn-close').show()
        }
    }

    filterPosition()

    $(window).on('resize', function () {
        filterPosition()
    });
}