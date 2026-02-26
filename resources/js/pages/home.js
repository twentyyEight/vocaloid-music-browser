$(function () {

    /* DEPENDIENDO DE LA OPTION SELECCIONADA EN SELECT, CAMBIA EL PLACEHOLDER DEL INPUT */
    let entity = $('#entity')[0].value
    let name_entity = $('#entity').find('option:selected').text()

    function updatePlaceholder() {
        $('input').attr('placeholder', `Buscar ${name_entity.toLowerCase()}`)
    }

    $('#entity').on('change', function () {
        entity = this.value
        name_entity = $(this).find('option:selected').text()
        updatePlaceholder()
    })

    updatePlaceholder()

    /* SUGERENCIAS DE BÚSQUEDA */
    $('input').autocomplete({
        delay: 1500,
        source: function (request, response) {
            $.ajax({
                url: `/${entity}/autocomplete/${request.term}`,
                beforeSend: function () {
                    $('#loading').show()
                },
                success: function (data) {
                    $('#loading').hide()
                    response(data);
                },
                error: function (error) {
                    console.error(error)
                    $('#loading').hide()
                    response([])
                }
            });
        },
        select: function (event, ui) {
            window.location.href = `/${entity}/${ui.item.id}`
        }
    })

    /* BÚSQUEDA AL DAR ENTER EN INPUT */
    $('input').on('keypress', function (event) {
        if (event.which === 13) {
            event.preventDefault()
            const query = $(this).val()
            window.location.href = `/${entity}?name=${query}`
        }
    })

    /* BOTÓN LUPA */
    $('#search-btn').on('click', function () {
        const query = $('input').val()
        window.location.href = `/${entity}?name=${query}`
    })

    /* ANIMACIÓN CUADROS */
    const container_up = $('#squares-up')
    const imgs_up = container_up.children('img')
    imgs_up.slice(0, 2).clone().appendTo(container_up)

    const container_down = $('#squares-down')
    container_down.children('img').slice(0, 2).clone().appendTo(container_down)

    let width = imgs_up.first().outerWidth(true)

    let index_up = 0
    let index_down = 0

    function recalcWidth() {
        width = imgs_up.first().outerWidth(true);

        container_up.css({
            transition: 'none',
            transform: 'translateX(0px)'
        });

        container_down.css({
            transition: 'none',
            transform: 'translateX(0px)'
        });

        index_up = 0;
        index_down = 0;
    }

    function scrollLeft(index, container) {
        index++

        container.css({
            transition: 'transform 0.3s ease',
            transform: `translateX(-${index * width}px)`
        });

        if (index === 4) {
            container.one('transitionend', () => {
                container.css({
                    transition: 'none',
                    transform: 'translateX(0px)'
                })
            });

            return 0
        }

        return index
    }

    let toggle = true;

    setInterval(() => {
        if (toggle) {
            index_up = scrollLeft(index_up, container_up);
        } else {
            index_down = scrollLeft(index_down, container_down);
        }
        toggle = !toggle;
    }, 5000);

    let resizeTimer;

    $(window).on('resize', () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(recalcWidth, 150);
    });
})