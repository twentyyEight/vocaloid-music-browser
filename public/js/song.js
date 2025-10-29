import { getSongById } from "./api.js";

document.addEventListener('DOMContentLoaded', async () => {

    const id = $('#song').attr("data-id")
    const $title = $('title')
    const $name = $('#name')
    const $type = $('#type')
    const $date = $('#release-date')
    const $producers = $('#producers')
    const $vocalists = $('#vocalists')
    const $genres = $('#genres')
    const $links = $('#links')

    try {
        const song = await getSongById(id);

        // Titulo pagina
        $title.text(song.name)

        // Nombre de la canción
        $name.text(song.name)

        // Tipo de canción (original, cover, remix, etc)
        $type.text(song.type)

        // Productor(es) de la canción
        $producers.text(song.producers.join(', '))

        // Vocalistas de la canción
        $vocalists.text(song.vocalists.join(', '))

        // Genero(s) de la canción
        $genres.text(song.genres.join(', '))

        // Fecha de lanzamiento de la canción
        $date.text(song.date)

        // Links para escuchar la cancion
        $links.text(song.links.join(', '))


    } catch (err) {

        console.error(err)
    }
});