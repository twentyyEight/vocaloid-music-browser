export function artistsHandler() {

    let selectedArtists = []

    const stored = sessionStorage.getItem('selectedArtists');
    if (stored) {
        selectedArtists = JSON.parse(stored);
        renderSelectedArtists();
    }

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

            if (!selectedArtists.find(a => a.id === artist.id)) {
                selectedArtists.push(artist)
            }

            renderSelectedArtists()

            sessionStorage.setItem('selectedArtists', JSON.stringify(selectedArtists));

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

    $('.remove-artist').click(function () {
        const id = $(this).attr('id')
        selectedArtists = selectedArtists.filter(g => g.id != id)
        sessionStorage.setItem('selectedArtists', JSON.stringify(selectedArtists));
        renderSelectedArtists()
    })
}