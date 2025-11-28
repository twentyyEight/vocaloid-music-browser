export function artistsHandler() {

    let selectedArtists = []
    const inputValue = JSON.parse($('#artists_ids').val())

    if (inputValue.length) {

        const stored = sessionStorage.getItem('selectedArtistsAlbums');
        selectedArtists = JSON.parse(stored);
        renderSelectedArtists();

    } else {
        sessionStorage.removeItem('selectedArtistsAlbums')
    }

    $('#artists').autocomplete({
        source: function (request, response) {
            $.ajax({
                url: `/artists/autocomplete/${request.term}`,
                beforeSend: function () {
                    $('.loading_artists').show()
                    $(':submit').prop('disabled', true)
                },
                success: function (data) {

                    $('.loading_artists').hide()
                    $(':submit').prop('disabled', false)
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

            if (!selectedArtists.find(a => a.id === artist.id)) {
                selectedArtists.push(artist)
            }

            renderSelectedArtists()

            sessionStorage.setItem('selectedArtistsAlbums', JSON.stringify(selectedArtists));

            $('#filters').submit()
            
            $('#artists').val('')
            return false
        }
    })

    function renderSelectedArtists() {

        $('#selected_artists').empty()

        selectedArtists.forEach(a => {

            $('#selected_artists').append(
                `
                <div>
                    <input type="hidden" name="artists[]" value="${a.id}">
                    <p>${a.name}</p>
                    <button type="button" class="remove-artist" id=${a.id}>X</button>
                </div>
                `
            )
        });
    }

    $(document).on('click', '.remove-artist', function () {
        const id = $(this).attr('id')
        selectedArtists = selectedArtists.filter(g => g.id != id)
        sessionStorage.setItem('selectedArtistsAlbums', JSON.stringify(selectedArtists));
        renderSelectedArtists()
        $('#filters').submit()
    })
}