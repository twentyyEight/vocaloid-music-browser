$(function () {

    let selectedTypes = [];
    $('.type').click(function () {

        const value = $(this).val()
        const index = selectedTypes.indexOf(value)

        if (index === -1) {
            selectedTypes.push(value)
            $(this).css('background-color', 'red')
        } else {
            selectedTypes.splice(index, 1)
            $(this).css('background-color', '')
        }

        const types = selectedTypes.join(',')
        $('#type').val(types)
    })

    let selectedGenres = []
    $('#genres').autocomplete({
        source: function (request, response) {
            $.ajax({
                url: `/genres/autocomplete/${request.term}`,
                success: function (data) {
                    response(data);
                },
                error: function (error) {
                    console.error(error)
                    response([])
                }
            });
        },
        select: function (event, ui) {

            const genre = {
                id: ui.item.id, 
                name: ui.item.label
            }
            const index = selectedGenres.indexOf(genre)

            if (index === -1) {
                selectedGenres.push(genre)
            }

            $('#selected_genres').empty()

            selectedGenres.forEach(genre => {
                $('#selected_genres').append(`<input type="hidden" name="genres[]" value=${genre.id}>`)
                $('#selected_genres').append(`<p>${genre.name}</p>`)
            });

            $('#genres').val('')
            return false
        }
    })

    let selectedArtists = []
    $('#artists').autocomplete({
        source: function (request, response) {
            $.ajax({
                url: `/artists/autocomplete/${request.term}`,
                success: function (data) {
                    response(data);
                },
                error: function (error) {
                    console.error(error)
                    response([])
                }
            });
        },
        select: function (event, ui) {

            const artist = {
                id: ui.item.id, 
                name: ui.item.label
            }
            const index = selectedGenres.indexOf(artist)

            if (index === -1) {
                selectedArtists.push(artist)
            }

            $('#selected_artists').empty()

            selectedArtists.forEach(artist => {
                $('#selected_artists').append(`<input type="hidden" name="artists[]" value=${artist.id}>`)
                $('#selected_artists').append(`<p>${artist.name}</p>`)
            });

            $('#artists').val('')
            return false
        }
    })
})