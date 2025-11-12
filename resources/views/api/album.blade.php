<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $album['name'] }}</title>
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
    <form action="{{ route('album.store', $album['id']) }}" method="POST">
        @csrf
        <button type="submit">Agregar a favoritos</button>
    </form>
    @else
    <form action="{{ route('album.delete', $album['id']) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit">Eliminar de favoritos</button>
    </form>
    @endif
    @endauth

    <img src="{{ $album['img'] }}" alt="{{ $album['name'] }}">
    <h1>{{ $album['name'] }} ({{ $album['year']}})</h1>
    <h3>{{ $album['type'] }}</h3>
    <h4>{{ $album['artists'] }}</h4>

    @if ($album['genres'])
    <div>
        @foreach ($album['genres'] as $genre)
        <a href="{{ route('genre', $genre['id']) }}">{{ $genre['name'] }}</a>@if (!$loop->last), @endif
        @endforeach
    </div>
    @endif

    @if ($album['links'])
    <div>
        @foreach ($album['links'] as $link)
        <a href="{{ $link['url'] }}">{{ $link['name'] }}</a>
        @endforeach
    </div>
    @endif

    @if ($album['tracks'])
    <ul>
        @foreach ($album['tracks'] as $track)
        <li><a href="{{ route('song', $track['id']) }}">{{ $track['name'] }}<br>{{ $track['artists'] }}</a></li>
        @endforeach
    </ul>
    @endif
</body>

</html>