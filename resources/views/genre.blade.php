<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>

<body>

    <img src="{{ $genre['img'] }}" alt="{{ $genre['name'] }}">
    <h1 id="name">{{ $genre['name'] }}</h1>
    <p id="description">{{ $genre['description'] }}</p>

    <div id="songs">
        @foreach ($genre['songs'] as $song)
        <a href="/song/{{ $song['id'] }}">
            <img src="{{ $song['img'] }}" alt="{{ $song['name'] }}">
            <p>{{ $song['name'] }}</p>
        </a>
        @endforeach
    </div>
    <div id="artists">
        @foreach ($genre['artists'] as $artist)
        <a href="/artist/{{ $artist['id'] }}">
            <img src="{{ $artist['img'] }}" alt="{{ $artist['name'] }}">
            <p>{{ $artist['name'] }}</p>
        </a>
        @endforeach
    </div>
    <div id="albums">
        @foreach ($genre['albums'] as $album)
        <a href="/album/{{ $album['id'] }}">
            <img src="{{ $album['img'] }}" alt="{{ $album['name'] }}">
            <p>{{ $album['name'] }}</p>
        </a>
        @endforeach
    </div>

    <!-- <script type="module" src="{{ asset('js/genre.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script> -->
</body>

</html>