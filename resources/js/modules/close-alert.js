export function closeAlert() {

    /* Desvanecimiento */
    setTimeout(() => {
        $('.alert')
            .removeClass('d-flex')
            .fadeOut(300);
    }, 3000);

    /* Cierra recuadro al clickear X */
    $('.btn-close').on('click', function () {
        $('.alert').addClass('d-none')
    })
}