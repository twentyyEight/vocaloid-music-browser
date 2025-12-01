import { typeHandler } from "./modules/type.js"
import { tagsHandler } from "./modules/tags.js"

$(function () {

    typeHandler()

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

    // Envio de input name
    // si aprieta enter
    $('#name').on('keydown', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            $(this).closest('form').submit();
        }
    });

    // o el boton 'buscar'
    $('#search').on('click', function () {
        $('#name').closest('form').submit();
    });


})