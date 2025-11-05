<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title></title>
</head>

<body data-id="{{ $id }}">

    <button>Agregar a favoritos</button>

    <img src="" alt="">
    <h1 id="name"></h1>
    <h3 id="type"></h3>
    <p id="description"></p>
    <p id="genres"></p>

    <div id="songs"></div>
    <div id="albums"></div>

    <script type="module" src="{{ asset('js/artist.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</body>

</html>