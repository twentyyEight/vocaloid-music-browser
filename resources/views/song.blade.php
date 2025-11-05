<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title></title>
</head>

<body>
    <div id="song" data-id="{{ $id }}">

        @auth
        <button>Agregar a favoritos</button>
        @endauth

        <h1 id="name"></h1>
        <h3 id="type"></h3>
        <p id="release-date"></p>
        <p id="producers"></p>
        <p id="vocalists"></p>
        <p id="genres"></p>
        <div id="albums"></div>

    </div>


    <h1 id="error" style="color: red; display: none;">Error al buscar la canción</h1>

    <script type="module" src="{{ asset('js/song.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</body>

</html>