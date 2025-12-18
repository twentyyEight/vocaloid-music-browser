export function tagsHandler({
    inputId,
    hiddenInputId,
    name,
    selectedWrapperId,
    sessionStorageName,
    loading
}) {

    let selectedItems = []
    const inputValue = JSON.parse($(hiddenInputId).val() ?? null)

    if (inputValue) {
        const stored = sessionStorage.getItem(sessionStorageName);
        selectedItems = JSON.parse(stored);
        renderSelectedItems();

    } else {
        sessionStorage.removeItem(sessionStorageName)
    }

    $(inputId).autocomplete({
        source: function (request, response) {
            $.ajax({
                url: `/${name}/autocomplete/${request.term}`,
                beforeSend: function () {
                    $(loading).show()
                },
                success: function (data) {
                    $(loading).hide()
                    response(data);
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

            if (!selectedItems.find(i => i.id === item.id)) {
                selectedItems.push(item)
            }

            renderSelectedItems()

            sessionStorage.setItem(sessionStorageName, JSON.stringify(selectedItems));

            $('#filters').submit()

            $(inputId).val('')
            return false
        }
    })

    function renderSelectedItems() {

        $(selectedWrapperId).empty()

        selectedItems.forEach(i => {

            $(selectedWrapperId).append(
                `
                <div>
                    <input type="hidden" name="${name}[]" value="${i.id}">
                    <p>${i.name}</p>
                    <button type="button" class="remove" id=${i.id}>X</button>
                </div>
                `
            )
        });
    }

    $(document).on('click', '.remove', function () {

        const id = $(this).attr('id')
        selectedItems = selectedItems.filter(i => i.id != id)
        sessionStorage.setItem(sessionStorageName, JSON.stringify(selectedItems));
        renderSelectedItems()
        $('#filters').submit()
    })
}