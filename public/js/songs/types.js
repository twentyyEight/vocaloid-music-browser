export function typesHandler() {

    let selectedTypes = $('#types').val()

    if (!selectedTypes) {
        selectedTypes = []

    } else {

        selectedTypes = selectedTypes.split(",")

        $('.type').each(function () {
            const value = $(this).val()

            if (selectedTypes.includes(value)) {
                $(this).css('background-color', 'red')
            }
        })
    }

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
        $('#types').val(types)
    })

} 