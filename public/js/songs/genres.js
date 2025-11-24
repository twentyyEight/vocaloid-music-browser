export function genresHandler() {

    let selectedGenres = [];

    const stored = sessionStorage.getItem('selectedGenres');
    if (stored) {
        selectedGenres = JSON.parse(stored);
        renderSelectedGenres();
    }

    $('#genres').autocomplete({
        source: function (request, response) {
            $.ajax({
                url: `/genres/autocomplete/${request.term}`,
                success: function (data) {
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


            sessionStorage.setItem('selectedGenres', JSON.stringify(selectedGenres));

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

    $('.remove-genre').click(function () {
        const id = $(this).attr('id')
        selectedGenres = selectedGenres.filter(g => g.id != id)
        sessionStorage.setItem('selectedGenres', JSON.stringify(selectedGenres))
        renderSelectedGenres()
    })
}

