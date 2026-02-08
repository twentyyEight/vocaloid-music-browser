import { carousel } from "./modules/carousel";

$(function () {

    /* Activar opción para eliminar canción / álbum /artista de 'favoritos' */
    $('.edit').on('click', function () {
        const entity = this.classList[1]
        const form = $(`form.${entity}`).toggle();

        if (form[0].style.display === 'flex') {
            $(this).html('Cerrar edición <i class="bi bi-x"></i>')
        } else {
            $(this).html('Editar lista <i class="bi bi-pencil-fill"></i>')
        }
    })

    if ($('#songs-profile').length !== 0) carousel($('#songs-profile'))
    if ($('#albums-profile').length !== 0) carousel($('#albums-profile'))
    if ($('#artists-profile').length !== 0) carousel($('#artists-profile'))
})