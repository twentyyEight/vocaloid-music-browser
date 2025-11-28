import { typeHandler } from "./type.js";
import { genresHandler } from "./genres.js";
import { artistsHandler } from "./artists.js";

$(function () {

    // Muestra mensaje 'Cargando...'
    $(window).on('load', function () {
        $('#loading').hide();
        $('#songs').show();
    });

    // Envio de input name
    // si aprieta enter
    $('#name').on('keypress', function (e) {
        if (e.key === 'Enter') { 
            e.preventDefault();
            $(this).closest('form').submit();
        }
    });

    // o el boton 'buscar'
    $('#search').on('click', function () {
        $('#name').closest('form').submit();
    });

    typeHandler()
    genresHandler()
    artistsHandler()

    // Envio de inputs type date
    $('input[type="date"]').on('change', function () {
        $(this).closest('form').submit();
    });

    // Orden de las canciones
    $('#sort').on('change', function () {
        $(this).closest('form').submit();
    })
})