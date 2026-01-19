@extends('app')

@section('content')
<div id="background-genre" style="--genre-color: {{ $genre['color'] }};">
    @if ($genre['img'])
    <img src="{{ $genre['img'] }}" alt="{{ $genre['name'] }}">
    @endif
    <h1 id="name-genre">{{ $genre['name'] }}</h1>
</div>

<div id="page-genre">

    @if ($genre['songs'])
    <div>
        <div class="header">
            <h2>Canciones del género</h2>
            <a href="{{ route('song.index', ['genres[]' => $genre['id']])}}" target="_blank">Ver más</a>
        </div>
        <div class="line"></div>

        <div id="songs-genre">
            @foreach ($genre['songs'] as $song)
            <a href="{{ route('song.show', $song['id']) }}" class="card-song">

                <div class="img-container">
                    @if ($song['img'])
                    <img src="{{ $song['img'] }}" alt="{{ $song['name'] }}">
                    @else
                    <x-carbon-no-image class="no-img" />
                    @endif
                </div>

                <div class="data">
                    <p class="title">{{ $song['name'] }}</p>
                    <p class="artists">{{ $song['artists'] }}</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif

    @if ($genre['artists'])
    <div>
        <div class="header">
            <h2>Artistas del género</h2>
            <a href="{{ route('artist.index', ['genres[]' => $genre['id']]) }}" target="_blank">Ver más</a>
        </div>
        <div class="line"></div>

        <div id="artists-genre">
            @foreach ($genre['artists'] as $artist)
            <a href="{{ route('artist.show', $artist['id']) }}" class="card-artist">

                <div class="img-container">
                    @if ($artist['img'])
                    <img src="{{ $artist['img'] }}" alt="{{ $artist['name'] }}">
                    @else
                    <i class="bi bi-person-fill"></i>
                    @endif
                </div>

                <p>{{ $artist['name'] }}</p>
            </a>
            @endforeach
        </div>
    </div>
    @endif

    @if ($genre['albums'])
    <div>
        <div class="header">
            <h2>Álbumes del género</h2>
            <a href="{{ route('album.index', ['genres[]' => $genre['id']]) }}" target="_blank">Ver más</a>
        </div>
        <div class="line"></div>

        <div id="albums-genre">
            @foreach ($genre['albums'] as $album)
            <a href="{{ route('album.show', $album['id']) }}" class="card-album">

                <div class="img-container">
                    @if ($album['img'])
                    <img src="{{ $album['img'] }}" alt="{{ $album['name'] }}">
                    @else
                    <x-carbon-no-image class="no-img" />
                    @endif
                </div>

                <div class="data">
                    <p class="title">{{ $album['name'] }}</p>
                    <p class="artists">{{ $album['artists'] }}</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</div>
@endif
@endsection

@push('styles')
@vite(['resources/scss/pages/genres/show.scss'])
@endpush

@push('scripts')
@vite('resources/js/genre.js')
@endpush