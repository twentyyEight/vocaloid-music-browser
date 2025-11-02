const id = $('body').attr('data-id')
const title = $('title')
const image = $('img')
const name = $('#name')
const type = $('#type')
const description = $('#description')
const genres = $('#genres')
const songs = $('#songs')
const albums = $('#albums')

function setArtistData(id) {
    $.ajax({
        url: `/api/artist/${id}`,
        type: 'GET',
        success: function (artist) {

            title.text(artist.name)

            image.attr('src', artist.img)

            name.text(artist.name)

            description.text(artist.description)

            artist.songs.forEach(song => {

                const a = $('<a>').attr('href', '/song/' + song.id)

                const img = $('<img>').attr('src', song.img)

                const name = $('<h4>').text(song.name)

                a.append(img, name)
                songs.append(a)
            });

            // Albumes populares del genero
            artist.albums.forEach(album => {

                const a = $('<a>').attr('href', '/album/' + album.id)

                const img = $('<img>').attr('src', album.img)

                const name = $('<h4>').text(album.name)

                a.append(img, name)
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
    setArtistData(id)
})