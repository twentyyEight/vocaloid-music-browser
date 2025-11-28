export function typeHandler() {

    let selectedType = $('#type').val()

    if (selectedType) {
        $('.type').each(function () {
            const value = $(this).val()

            if (selectedType == value) {
                $(this).css('background-color', 'red')
            }
        })

    } else {
        $('.type[value="Unknown"]')
            .css('background-color', 'red')
    }

    $('.type').click(function () {

        const value = $(this).val()

        $('.type').css('background-color', '')
        $(this).css('background-color', 'red')

        $('#type').val(value)
        $(this).closest('form').submit()
    })

} 