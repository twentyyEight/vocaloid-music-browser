<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $artist['name'] }}</title>
</head>

<body>

    @if(session('success'))
    <p>{{ session('success') }}</p>
    @endif

    @if(session('error'))
    <p>{{ session('error') }}</p>
    @endif

    @auth
    @if (!$isFavorite)
    <form action="{{ route('artist.store', $artist['id']) }}" method="POST">
        @csrf
        <button type="submit">Agregar a favoritos</button>
    </form>
    @else
    <form action="{{ route('artist.delete', $artist['id']) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit">Eliminar de favoritos</button>
    </form>
    @endif
    @endauth

    <img src="{{ $artist['img'] }}" alt="{{ $artist['name'] }}">
    <h1>{{ $artist['name'] }}</h1>
    <h3>{{ $artist['type'] }}</h3>
    <p>{{ $artist['description'] }}</p>

    @if ($artist['genres'])
    <div>
        @foreach ($artist['genres'] as $genre)
        <a href="{{ route('genre.show', $genre['id']) }}">{{ $genre['name'] }}</a>@if (!$loop->last), @endif
        @endforeach
    </div>
    @endif

    @if ($artist['songs'])
    <div>
        @foreach ($artist['songs'] as $song)
        <a href="{{ route('song.show', $song['id']) }}">{{ $song['name'] }}</a>
        @endforeach
    </div>
    @endif

    @if ($artist['albums'])
    <div>
        @foreach ($artist['albums'] as $album)
        <a href="{{ route('album.show', $album['id']) }}">
            <img src="{{ $album['img'] }}" alt="{{ $album['name'] }}">
            <p>{{ $album['name'] }}</p>
        </a>
        @endforeach
    </div>
    @endif
</body>

</html>