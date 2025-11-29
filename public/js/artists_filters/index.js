import { genresHandler } from "./genres.js";

$(function () {

    // Muestra mensaje 'Cargando...'
    $(window).on('load', function () {
        $('#loading').hide();
        $('#artists').show();
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

    // Envio de producers y vocalist
    $('.type').on('change', function () {
        const value = $(this).val()
        $('#type_hidden').val(value)
        $(this).closest('form').submit();
    });

    // Orden de los artistas
    $('#sort').on('change', function () {
        $(this).closest('form').submit();
    })

    genresHandler()
})