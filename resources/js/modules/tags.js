export function tagsHandler({
    inputId,
    hiddenInputId,
    name,
    selectedWrapperId,
    sessionStorageName,
    loading
}) {

    let selectedTags = []

    const inputValue = $(hiddenInputId).val()
    const tags_ids = inputValue === '[]' || inputValue === undefined ? null : JSON.parse(inputValue)

    if (tags_ids) {

        const tagsStored = sessionStorage.getItem(sessionStorageName)
        selectedTags = tagsStored ? JSON.parse(tagsStored) : []

        tags_ids.forEach(id => {
            if (!selectedTags.find(t => t.id === Number(id))) {
                selectedTags.push({ id: id, name: null })
            }
        })

        namingTags(selectedTags)

    } else {
        sessionStorage.removeItem(sessionStorageName)
    }

    // Cuando selecciona el tag en el form
    $(inputId).autocomplete({
        source: function (request, response) {
            $.ajax({
                url: `/${name}/autocomplete/${request.term}`,
                beforeSend: function () {
                    $(loading).show()
                },
                success: function (data) {
                    response(data);
                },
                complete: function () {
                    $(loading).hide()
                },
                error: function (error) {
                    console.error(error)
                    response([])
                }
            });
        },
        select: function (event, ui) {

            const item = {
                id: ui.item.id,
                name: ui.item.label
            }

            if (!selectedTags.find(i => i.id === item.id)) {
                selectedTags.push(item)
            }

            renderSelectedItems()

            sessionStorage.setItem(sessionStorageName, JSON.stringify(selectedTags));

            $(inputId).val('')
            return false
        }
    })

    async function namingTags(tags) {

        if (name === 'genres') {
            for (const t of tags) {
                if (!t.name) {
                    let data = await $.ajax({
                        url: `https://vocadb.net/api/tags/${t.id}`,
                        type: 'GET',
                        contentType: 'application/json'
                    })

                    t.name = data.name
                }
            }
        } else {
            for (const t of tags) {
                if (!t.name) {
                    let data = await $.ajax({
                        url: `https://vocadb.net/api/artists/${t.id}?lang=Romaji`,
                        type: 'GET',
                        contentType: 'application/json'
                    })

                    t.name = data.name
                }
            }
        }


        renderSelectedItems()
    }

    function renderSelectedItems() {

        $(selectedWrapperId).empty()

        selectedTags.forEach(i => {

            $(selectedWrapperId).append(
                `
                <div class="tag">
                    <input type="hidden" name="${name}[]" value="${i.id}">
                    <p>${i.name}</p>
                    <button class="remove_tag" id=${i.id}>
                        <i class="bi bi-x"></i>
                    </button>
                </div>
                `
            )
        });
    }

    $(document).on('click', '.remove_tag', function () {

        const id = $(this).attr('id')
        selectedTags = selectedTags.filter(i => i.id != id)
        sessionStorage.setItem(sessionStorageName, JSON.stringify(selectedTags));
        renderSelectedItems()
    })
}