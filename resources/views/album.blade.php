<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <form action="{{ route('store.album', $album['id']) }}" method="POST">
        @csrf
        <button type="submit">Agregar a favoritos</button>
    </form>
    @endauth

    <img src="{{ $album['img'] }}" alt="{{ $album['name'] }}">
    <h1>{{ $album['name'] }} ({{ $album['year']}})</h1>
    <h3>{{ $album['type'] }}</h3>
    <h4>{{ $album['artists'] }}</h4>

    <div>
        @foreach ($album['genres'] as $genre)
        <a href="/genre/{{ $genre['id'] }}">{{ $genre['name'] }}</a>@if (!$loop->last), @endif
        @endforeach
    </div>

    <div>
        @foreach ($album['links'] as $link)
        <a href="{{ $link['url'] }}">{{ $link['name'] }}</a>
        @endforeach
    </div>

    <ul>
        @foreach ($album['tracks'] as $track)
        <li><a href="/song/{{ $track['id'] }}">{{ $track['name'] }}<br>{{ $track['artists'] }}</a></li>
        @endforeach
    </ul>
</body>

</html>