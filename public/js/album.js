const title = $('title')
const id = $('#album').attr("data-id")
const cover = $('#cover')
const nameYear = $('#name_year')
const type = $('#type')
const producers = $('#producers')
const genres = $('#genres')
const buyLinks = $('#buy-links')
const tracks = $('#tracks')

function setAlbumData(id) {
    $.ajax({
        url: `/api/album/${id}`,
        type: 'GET',
        success: function (album) {

            // Titulo pagina
            title.text(album.name)

            // Portada album
            cover.attr({
                src: album.cover,
                alt: album.name
            });

            // Nombre y año lanzamiento album
            nameYear.text(album.name + ' (' + album.year + ')')

            // Tipo de disco (album, sencillo, EP, etc)
            type.text(album.type)

            // Artista del album
            producers.text(album.producers)

            // Género(s) del album
            genres.text(album.genres.join(', '));

            // Links para comprar y/o escuchar el album
            album.links.forEach(link => {
                buyLinks.append(`<a href="${link.url}">${link.name}</a>`)
            });

            // Tracks del album
            album.tracks.forEach(track => {
                tracks.append(`<li>${track.name}<br>${track.producers}</li>`)
            })

        },
        error: function (error) {
            console.log(error)
        }
    }
    )
}

$(function () {
    setAlbumData(id)
})