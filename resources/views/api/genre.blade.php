<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $genre['name'] }}</title>
</head>

<body>

    <img src="{{ $genre['img'] }}" alt="{{ $genre['name'] }}">
    <h1 id="name">{{ $genre['name'] }}</h1>
    <p id="description">{{ $genre['description'] }}</p>

    @if ($genre['songs'])
    <div>
        @foreach ($genre['songs'] as $song)
        <a href="{{ route('song', $song['id']) }}">
            <img src="{{ $song['img'] }}" alt="{{ $song['name'] }}">
            <p>{{ $song['name'] }}</p>
        </a>
        @endforeach
    </div>
    @endif

    @if ($genre['artists'])
    <div>
        @foreach ($genre['artists'] as $artist)
        <a href="{{ route('artist', $artist['id']) }}">
            <img src="{{ $artist['img'] }}" alt="{{ $artist['name'] }}">
            <p>{{ $artist['name'] }}</p>
        </a>
        @endforeach
    </div>
    @endif

    @if ($genre['albums'])
    <div>
        @foreach ($genre['albums'] as $album)
        <a href="{{ route('album', $album['id']) }}">
            <img src="{{ $album['img'] }}" alt="{{ $album['name'] }}">
            <p>{{ $album['name'] }}</p>
        </a>
        @endforeach
    </div>
    @endif
</body>
</html>