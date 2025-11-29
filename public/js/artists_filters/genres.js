export function genresHandler() {

    let selectedGenres = [];
    const inputValue = JSON.parse($('#genres_ids').val())

    if (inputValue.length) {

        const stored = sessionStorage.getItem('selectedGenresArtists');
        selectedGenres = JSON.parse(stored);
        renderSelectedGenres();

    } else {
        sessionStorage.removeItem('selectedGenresArtists')

    }

    $('#genres').autocomplete({
        source: function (request, response) {
            $.ajax({
                url: `/genres/autocomplete/${request.term}`,
                beforeSend: function () {
                    $('.loading_genres').show()
                },
                success: function (data) {
                    $('.loading_genres').hide()
                    response(data);
                },
                error: function (error) {
                    console.error(error);
                    response([]);
                }
            });
        },
        select: function (event, ui) {

            const genre = {
                id: ui.item.id,
                name: ui.item.label
            };

            if (!selectedGenres.find(g => g.id === genre.id)) {
                selectedGenres.push(genre);
            }

            renderSelectedGenres();

            sessionStorage.setItem('selectedGenresArtists', JSON.stringify(selectedGenres));

            $('#filters').submit()

            $('#genres').val('');
            return false;
        }
    });

    function renderSelectedGenres() {
        $('#selected_genres').empty();

        selectedGenres.forEach(g => {

            $('#selected_genres').append(
                `
                <div>
                    <input type="hidden" name="genres[]" value="${g.id}">
                    <p>${g.name}</p>
                    <button type="button" class="remove-genre" id=${g.id}>X</button>
                </div>
                `
            )
        });
    }

    $(document).on('click', '.remove-genre', function () {
        const id = $(this).attr('id')
        selectedGenres = selectedGenres.filter(g => g.id != id)
        sessionStorage.setItem('selectedGenresArtists', JSON.stringify(selectedGenres))
        renderSelectedGenres()
        $('#filters').submit()
    })
}

