<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $user['name'] }} profile</title>
</head>

<body>
    @extends('layouts.app')

    @section('content')

    @if(session('success'))
    <p>{{ session('success') }}</p>
    @endif

    @if(session('error'))
    <p>{{ session('error') }}</p>
    @endif

    <h1 id="name">{{ $user['name'] }}</h1>

    @if ($isUserProfile)
    <button type="button">Acción especial</button>
    @endif

    @if (!count($songs) == 0)
    <h2>Canciones favoritas:</h2>
    <div>
        @foreach ($songs as $song)
        <a href="{{ route('song', $song['song_id']) }}">
            <img src="{{ $song['img'] }}" alt="{{ $song['name'] }}">
            <p>{{ $song['name'] }}</p>
            <p>{{ $song['artists'] }}</p>
        </a>
        <form action="{{ route('destroy.song', $song['song_id']) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit">Eliminar</button>
        </form>
        @endforeach
    </div>
    @endif

    @if (!count($albums) == 0)
    <h2>Albumes favoritos:</h2>
    <div>
        @foreach ($albums as $album)
        <a href="{{ route('album', $album['album_id']) }}">
            <img src="{{ $album['img'] }}" alt="{{ $album['name'] }}">
            <p>{{ $album['name'] }}</p>
            <p>{{ $album['artists'] }}</p>
        </a>
        <form action="{{ route('destroy.album', $album['album_id']) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit">Eliminar</button>
        </form>
        @endforeach
    </div>
    @endif

    @if (!count($artists) == 0)
    <h2>Artistas favoritos:</h2>
    <div>
        @foreach ($artists as $artist)
        <a href="{{ route('artist', $artist['artist_id']) }}">
            <img src="{{ $artist['img'] }}" alt="{{ $artist['name'] }}">
            <p>{{ $artist['name'] }}</p>
        </a>
        @endforeach
        <form action="{{ route('destroy.artist', $artist['artist_id']) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit">Eliminar</button>
        </form>
    </div>
    @endif
    @endsection
</body>

</html>