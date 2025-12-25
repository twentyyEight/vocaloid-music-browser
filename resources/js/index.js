import { tagsHandler } from "./modules/tags.js"

$(function () {

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
    if (checked) {
        updateSelectByRadio(checked);
    }

    // Maneja el envio del value de los select
    $('#types').on('change', function () {
        $('#type').val(this.value)
    })

    // Maneja la paginación
    $('.pagination').on('click', '.page-link', function () {
        const page = $(this).data('page');

        if (!page) return;

        $('#page').val(page);
        $('#form').trigger('submit')
    });

    // Maneja la aparición de los filtros en moviles

    $('#filters, #overlay').hide();

    $('#open_filters').on('click', function () {
        $('#filters, #overlay').show();
        $('body').css('overflow', 'hidden');
    })

    $('#close_filters').on('click', function () {
        $('#filters, #overlay').hide();
        $('body').css('overflow', 'auto');
    })
})