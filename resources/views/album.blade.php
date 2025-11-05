<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title></title>
</head>

<body>
    <div id="album" data-id="{{ $id }}">

        <button>Agregar a favoritos</button>

        <img id="cover" src="" alt="" width="300" height="300">
        <h1 id="name_year"></h1>
        <h3 id="type"></h3>
        <p id="producers"></p>
        <p id="genres"></p>
        <div id="buy-links"></div>
        <ul id="tracks"></ul>
    </div>

    <script type="module" src="{{ asset('js/album.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</body>

</html>