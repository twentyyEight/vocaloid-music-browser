<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $song['name'] }}</title>
</head>

<body>

    @if(session('success'))
    <p>{{ session('success') }}</p>
    @endif

    @if(session('error'))
    <p>{{ session('error') }}</p>
    @endif


    @auth
    <form action="{{ route('store.song', $song['id']) }}" method="POST">
        @csrf
        <button type="submit">Agregar a favoritos</button>
    </form>
    @endauth

    <h1>{{ $song['name'] }}</h1>
    <h3>{{ $song['type'] }}</h3>
    <p>{{ $song['date'] }}</p>

    @if ($song['producers'])
    <div>
        @foreach ($song['producers'] as $producer)
        <a href="/artist/{{ $producer['id'] }}">{{ $producer['name'] }}</a>@if (!$loop->last), @endif
        @endforeach
    </div>
    @endif

    @if ($song['vocalists'])
    <div>
        @foreach ($song['vocalists'] as $vocalist)
        <a href="/artist/{{ $vocalist['id'] }}">{{ $vocalist['name'] }}</a>@if (!$loop->last), @endif
        @endforeach
    </div>
    @endif

    @if ($song['genres'])
    <div>
        @foreach ($song['genres'] as $genre)
        <a href="/genre/{{ $genre['id'] }}">{{ $genre['name'] }}</a>@if (!$loop->last), @endif
        @endforeach
    </div>
    @endif

    @if ($song['albums'])
    <div>
        @foreach ($song['albums'] as $album)
        <a href="/album/{{ $album['id'] }}">
            <img src="{{ $album['img'] }}" alt="{{ $album['name'] }}">
            <p>{{ $album['name'] }}</p>
        </a>
        @endforeach
    </div>
    @endif

    <!-- <script type="module" src="{{ asset('js/song.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script> -->
</body>

</html>