const id = $('body').attr('data-id')
const title = $('title')
const image = $('img')
const name = $('#name')
const description = $('#description')
const songs = $('#songs')
const artists = $('#artists')
const albums = $('#albums')

function setGenreData(id) {
    $.ajax({
        url: `/api/genre/${id}`,
        type: 'GET',
        success: function (genre) {

            // Titulo pagina
            title.text(genre.name)

            // Imagen genero
            image.attr('src', genre.img)

            // Nombre genero
            name.text(genre.name)

            // Descripcion genero
            description.text(genre.description)

            // Canciones populares del genero
            genre.songs.forEach(song => {

                const a = $('<a>').attr('href', '/song/' + song.id)

                const img = $('<img>').attr('src', song.img)

                const name = $('<h4>').text(song.name)

                const artists = $('<p>').text(song.artists)

                a.append(img, name, artists)
                songs.append(a)
            });

            // Artistas populares del genero
            genre.artists.forEach(artist => {

                const a = $('<a>').attr('href', '/artist/' + artist.id)

                const img = $('<img>').attr('src', artist.img)

                const name = $('<h4>').text(artist.name)

                a.append(img, name)
                artists.append(a)
            });

            // Albumes populares del genero
            genre.albums.forEach(album => {

                const a = $('<a>').attr('href', '/album/' + album.id)

                const img = $('<img>').attr('src', album.img)

                const name = $('<h4>').text(album.name)

                const artists = $('<p>').text(album.artists)

                a.append(img, name, artists)
                albums.append(a)
            });



        },
        error: function (error) {
            console.log(error)
        }
    }
    )
}

$(function () {
    setGenreData(id)
})
