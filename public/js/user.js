const id = $('body').attr('data-id')
const name = $('#name')
const songs = $('#songs')
const albums = $('#albums')
const artists = $('#artists')

function setUserData(id) {
    $.ajax({
        url: `/api/user/${id}`,
        type: 'GET',
        success: function (user) {

            console.log(user)

            name.text(user.name)

            const songsList = JSON.parse(user.favorite_songs);

            songsList?.forEach(song => {

                const a = $('<a>')
                    .attr('href', '/song/' + song.id)
                    .html(`<p>${song.name}<br>${song.artists}</p>`)

                songs.append(a)
            })

            const albumsList = JSON.parse(user.favorite_albums);

            albumsList?.forEach(album => {

                const a = $('<a>')
                    .attr('href', '/album/' + album.id)

                const img = $('<img>')
                    .attr('src', album.cover)

                const p = $('<p>').html(`<p>${album.name}<br>${album.artists}</p>`)

                a.append(img, p)
                albums.append(a)
            })

            const artistsList = JSON.parse(user.favorite_artists);

            artistsList?.forEach(artist => {

                const a = $('<a>')
                    .attr('href', '/artist/' + artist.id)

                const img = $('<img>')
                    .attr('src', artist.img)
                    .text(artist.name)

                a.append(img)
                artists.append(a)
            })
        },
        error: function (error) {
            console.log(error)
        }
    }
    )
}

$(function () {
    setUserData(id)
})