const id = $('#song').attr("data-id")
const title = $('title')
const name = $('#name')
const type = $('#type')
const date = $('#release-date')
const producers = $('#producers')
const vocalists = $('#vocalists')
const genres = $('#genres')
const albums = $('#albums')
const btn = $('button')

let artists

function setSongData(id) {
    $.ajax({
        url: `/api/song/${id}`,
        type: 'GET',
        success: function (song) {

            // Titulo pagina
            title.text(song.name)

            // Nombre de la canción
            name.text(song.name)

            // Tipo de canción (original, cover, remix, etc)
            type.text(song.type)

            // Fecha de lanzamiento de la canción
            const fecha = new Date(song.date);
            const releaseDate = fecha.toLocaleDateString()
            date.text(releaseDate);

            // Productor(es) de la canción
            song.producers?.forEach(p => {
                const link = $("<a>")
                    .attr("href", "/artist/" + p.id)
                    .text(p.name);
                producers.append(link);
            });

            // Vocalistas de la canción
            song.vocalists?.forEach(v => {
                const link = $("<a>")
                    .attr("href", "/artist/" + v.id)
                    .text(v.name);
                vocalists.append(link);
            });

            // Genero(s) de la canción
            song.genres?.forEach(g => {
                const link = $("<a>")
                    .attr("href", "/genre/" + g.id)
                    .text(g.name);
                genres.append(link);
            });

            // Albumes donde aparece la cancion
            song.albums?.forEach(a => {
                const link = $("<a>")
                    .attr("href", "/album/" + a.id)

                const img = $('<img>')
                    .attr('src', a.img)

                link.append(img)
                albums.append(link);
            })

            artists = song.artists

        },
        error: function (error) {
            console.log(error)
        }
    }
    )
}

function saveSongData() {

    const data = {
        'id': id,
        'name': name.text(),
        'artists': artists,
        'type': 'song'
    }

    $.ajax({
        type: 'POST',
        url: '/store',
        data: { data: data },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (respuesta) {
            console.log(respuesta);
        },
        error: function (error) {
            console.error(error)
        }
    })
}

$(function () {
    setSongData(id)
    btn.click(saveSongData)
})