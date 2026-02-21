$(function () {

    $('#background-modal-dashboard').hide() // Modal oculto para editar usuario

    let id, name, email, role

    /* Abrir modal de edición de usuario */
    $('.btn-dashboard.edit').on('click', function () {

        $('#page-dashboard').css('filter', 'blur(10px)')
        $('#background-modal-dashboard').show()

        id = $(this).data('id')
        name = $(this).data('name')
        email = $(this).data('email')
        role = Number($(this).data('role'))

        console.log(typeof role)

        // Rellenar el formulario del modal con los datos
        $('#name-user').val(name)
        $('#email-user').val(email)
        $('#role-user').val(role)
        $('#form-edit-user').attr('action', `/dashboard/patch/${id}`)
    })

    /* Cerrar modal de edición de usuario */
    $('.btn-close').on('click', function () {
        $('#page-dashboard').css('filter', '')
        $('#background-modal-dashboard').hide()

        id, name, email, role = null
    })

    /* Si hay un mensaje de error en la edición de usuario, se muestra el modal */
    const has_errors = $('.edit-error')[0].classList[1]

    if (has_errors === 'true') {
        $('#page-dashboard').css('filter', 'blur(10px)')
        $('#background-modal-dashboard').show()
    }
})