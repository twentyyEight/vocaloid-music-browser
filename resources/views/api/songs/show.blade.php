<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $song['name'] }}</title>
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

    <x-delete-btn type='hola'></x-delete-btn>

    @auth
    @if (!$isFavorite)
    <form action="{{ route('song.store', $song['id']) }}" method="POST">
        @csrf
        <button type="submit">Agregar a favoritos</button>
    </form>
    @else
    <form action="{{ route('song.delete', $song['id']) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit">Eliminar de favoritos</button>
    </form>
    @endif
    @endauth

    <p>{{ $song['pv'] }}</p>

    <h1>{{ $song['name'] }}</h1>
    <h3>{{ $song['type'] }}</h3>
    <p>{{ $song['date'] }}</p>

    @if ($song['producers'])
    <div>
        @foreach ($song['producers'] as $producer)
        <a href="{{ route('artist.show', $producer['id']) }}">{{ $producer['name'] }}</a>@if (!$loop->last), @endif
        @endforeach
    </div>
    @endif

    @if ($song['vocalists'])
    <div>
        @foreach ($song['vocalists'] as $vocalist)
        <a href="{{ route('artist.show', $vocalist['id']) }}">{{ $vocalist['name'] }}</a>@if (!$loop->last), @endif
        @endforeach
    </div>
    @endif

    @if ($song['genres'])
    <div>
        @foreach ($song['genres'] as $genre)
        <a href="{{ route('genre.show', $genre['id']) }}">{{ $genre['name'] }}</a>@if (!$loop->last), @endif
        @endforeach
    </div>
    @endif

    @if ($song['albums'])
    <div>
        @foreach ($song['albums'] as $album)
        <a href="{{ route('album.show', $album['id']) }}">
            <img src="{{ $album['img'] }}" alt="{{ $album['name'] }}">
            <p>{{ $album['name'] }}</p>
        </a>
        @endforeach
    </div>
    @endif
    @endsection
</body>

</html>