<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>

<body data-id="{{ $id }}">
    <img src="" alt="">
    <h1 id="name"></h1>
    <p id="description"></p>

    <div id="songs"></div>
    <div id="artists"></div>
    <div id="albums"></div>

    <script type="module" src="{{ asset('js/genre.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</body>

</html>