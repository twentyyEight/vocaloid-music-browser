export function tagsHandler({
    name,
    sessionStorageName,
}) {

    let selectedTags = [] // aloja el id de los tags seleccionados

    // Muestra el nombre de los tags seleccionados
    function renderSelectedTags() {

        $(`.selected_tags.${name}`).empty()

        selectedTags.forEach(tag => {

            $(`.selected_tags.${name}`).append(
                `
                <div class="tag">
                    <input type="hidden" name="${name}[]" value="${tag.id}">
                    <p>${tag.name}</p>
                    <button class="remove_tag" id=${tag.id}>
                        <i class="bi bi-x"></i>
                    </button>
                </div>
                `
            )
        });
    }

    // Busca el nombre del tag por medio de la API
    async function namingTags(tags) {

        let endpoint = name === 'genres' ? 'tags' : 'artists'

        for (const t of tags) {
            if (!t.name) {
                let data = await $.ajax({
                    url: `https://vocadb.net/api/${endpoint}/${t.id}?lang=Romaji`,
                    type: 'GET',
                    contentType: 'application/json'
                })

                t.name = data.name
            }
        }

        renderSelectedTags()
    }

    // Elimina el tag seleccionado
    $(document).on('click', '.remove_tag', function () {

        const id = $(this).attr('id')
        selectedTags = selectedTags.filter(i => i.id != id)
        sessionStorage.setItem(sessionStorageName, JSON.stringify(selectedTags));
        renderSelectedTags()
    })

    /* TAGS INGRESADOS EN LA URL */

    // array tipo string de los ids de los tags
    const inputValue = $(`#${name}_ids`).val()

    // transforma el array-string anterior a un array
    const tags_ids = inputValue === '[]' || inputValue === undefined ? null : JSON.parse(inputValue)

    // si el tags_ids contiene ids...
    if (tags_ids) {

        // Se busca en la memoria de la sesión si hay otros ids guardados (que hayan sido seleccionados anteriormente)
        const tagsStored = sessionStorage.getItem(sessionStorageName)

        // En caso de haberlos, se guardan en el array 'selectedTags'
        selectedTags = tagsStored ? JSON.parse(tagsStored) : []

        // Verificamos si alguno de los ids de los tags seleccionados se repiten en 'selectedTags'
        // Si es el caso, se elimina. Si no, se guarda 
        tags_ids.forEach(id => {
            if (!selectedTags.find(t => t.id === Number(id))) {
                selectedTags.push({ id: id, name: null })
            }
        })

        // Como el array contiene solo ids, se buscan sus nombres por medio de la API
        namingTags(selectedTags)

    } 
    // Si tags_ids NO tiene ids...
    else {

        // se vacia la memoria de la sesion
        sessionStorage.removeItem(sessionStorageName)
    }

    /* TAGS INGRESADOS EN FORM 'FILTROS' */
    $(`#${name}`).autocomplete({
        source: function (request, response) {
            $.ajax({
                url: `/${name}/autocomplete/${request.term}`,
                beforeSend: function () {
                    $(`.loading.${name}`).show()
                },
                success: function (data) {
                    response(data);
                },
                complete: function () {
                    $(`.loading.${name}`).hide()
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

            // Si el id del tag seleccionado no se encuentra en 'selectedTags' significa que no fue elegido antes
            if (!selectedTags.find(i => i.id === item.id)) {
                selectedTags.push(item)
            }

            // Mostramos el nombre del tag en la interfaz
            renderSelectedTags()

            // Guardamos los tags seleccionados en la memoria de la sesión como un string
            sessionStorage.setItem(sessionStorageName, JSON.stringify(selectedTags));

            // Esto permite que el input quede en blanco una vez seleccionado un tag
            $(`#${name}`).val('')
            return false
        }
    })
}