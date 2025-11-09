<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title></title>
</head>

<body>

    @if(session('success'))
    <p>{{ session('success') }}</p>
    @endif

    @if(session('error'))
    <p>{{ session('error') }}</p>
    @endif


    @auth
    <form action="{{ route('store.artist', $artist['id']) }}" method="POST">
        @csrf
        <button type="submit">Agregar a favoritos</button>
    </form>
    @endauth

    <img src="{{ $artist['img'] }}" alt="{{ $artist['name'] }}">
    <h1>{{ $artist['name'] }}</h1>
    <h3>{{ $artist['type'] }}</h3>
    <p>{{ $artist['description'] }}</p>

    <div>
        @foreach ($artist['genres'] as $genre)
        <a href="/genre/{{ $genre['id'] }}">{{ $genre['name'] }}</a>@if (!$loop->last), @endif
        @endforeach
    </div>

    <div>
        @foreach ($artist['songs'] as $song)
        <a href="/song/{{ $song['id'] }}">{{ $song['name'] }}</a>
        @endforeach
    </div>

    <div>
        @foreach ($artist['albums'] as $album)
        <a href="/album/{{ $album['id'] }}">
            <img src="{{ $album['img'] }}" alt="{{ $album['name'] }}">
            <p>{{ $album['name'] }}</p>
        </a>
        @endforeach
    </div>
</body>

</html>