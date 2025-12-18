import { tagsHandler } from "./modules/tags.js"

$(function () {

    // Maneja el filtro 'Género'
    tagsHandler({
        inputId: '#genres',
        hiddenInputId: '#genres_ids',
        name: 'genres',
        selectedWrapperId: '#selected_genres',
        sessionStorageName: 'selectedGenres',
        loading: '#loading_genres'
    })

    // Maneja el filtro 'Artistas'
    tagsHandler({
        inputId: '#artists',
        hiddenInputId: '#artists_ids',
        name: 'artists',
        selectedWrapperId: '#selected_artists',
        sessionStorageName: 'selectedArtists',
        loading: '#loading_artists'
    })

    // Envio de inputs type date y orden de resultados
    $('input[type="date"], #sort').on('change', function () {
        this.form.submit();
    });


    $('.type').on('change', function () {
        const type = this.value
        console.log(type)

        const $select = $('#options');

        // resetear selección
        $select.val('');

        // ocultar todas menos la primera
        $select.find('option:not(:first)').hide();

        // mostrar solo las que coinciden
        $select.find(`option[data-type="${type}"]`).show();
    })
})