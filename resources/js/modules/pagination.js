export function pagination() {
    $('.pagination').on('click', '.page-link', function () {
        const page = $(this).data('page');

        if (!page) return;

        $('#page').val(page);
        $('#form').trigger('submit')
    });
}