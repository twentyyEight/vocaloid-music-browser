@extends('app')

@section('content')
<h1>Home Page</h1>

<button type="button" value="songs" style="background-color: red;">Canción</button>
<button type="button" value="albums">Album</button>
<button type="button" value="artists">Artista</button>
<button type="button" value="genres">Genero</button>

<input type="text" id="search">
<p style="display: none;">Buscando...</p>

@endsection

@push('scripts')
<script>
    $(function() {

        let resource = 'songs'

        $('button').click(function() {
            resource = $(this).val()
            $('button').css('background-color', '')
            $(this).css('background-color', 'red')
        })

        $('#search').autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: `/${resource}/autocomplete/${request.term}`,
                    beforeSend: function() {
                        $('p').show()
                    },
                    success: function(data) {
                        $('p').hide()
                        response(data);
                    },
                    error: function(error) {
                        console.error(error)
                        response([])
                    }
                });
            },
            select: function(event, ui) {
                location.href = `/${resource}/` + ui.item.id;
            }
        })
    });
</script>
@endpush