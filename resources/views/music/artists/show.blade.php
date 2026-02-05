@extends('app')

@section('content')
<div class="page" data-page="artist" id="page-artist">
    @if(session('success'))
    <p>{{ session('success') }}</p>
    @endif

    @if(session('error'))
    <p>{{ session('error') }}</p>
    @endif

    <div id="info-artist">
        @if ($artist['img'])
        <img src="{{ $artist['img'] }}" alt="{{ $artist['name'] }}">
        @else
        <div id="no-img-artist">
            <i class="bi bi-person-fill"></i>
        </div>
        @endif

        <h3>{{ $artist['name'] }}</h3>
        <h4 id="type-artist">{{ $artist['type'] }}</h4>

        <div id="btns-artist">
            <x-favorite-btn entity="artist" :id="$artist['id']" :isFavorite="$isFavorite" />
            <button id="btn-links-artist" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Redes sociales
            </button>
        </div>

        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Sigue a {{ $artist['name'] }}</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="links-artist">
                        @foreach($artist['links'] as $link)
                        <a href="{{ $link['url'] }}">{{ $link['name'] }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        @if ($artist['genres'])
        <h5>Géneros</h5>
        <div id="genres-artist">
            @foreach ($artist['genres'] as $genre)
            <a href="{{ route('genre.show', $genre['id']) }}">{{ $genre['name'] }}</a>@if (!$loop->last), @endif
            @endforeach
        </div>
        @endif
    </div>

    <div id="music-artist">

        @if ($artist['popular_songs'] || $artist['latest_songs'])
        <div class="header">
            <h4>Canciones</h4>

            <div class="switch">
                <div class="switch-indicator-songs"></div>

                <button type="button" class="songs popular">Populares</button>
                <button type="button" class="songs latest">Recientes</button>
            </div>

            <a href="{{ route('song.index', ['artists[]' => $artist['id']]) }}">Ver todas sus canciones</i></a>
        </div>
        @endif

        <div id="songs-artist">

            @if ($artist['popular_songs'])
            <div class="songs popular">
                @foreach (array_chunk($artist['popular_songs'], 4) as $group)
                <div class="songs-row">
                    @foreach ($group as $song)
                    <div class="card-song">
                        @if (!empty($song['img']))
                        <div class="img-container">
                            <img src="{{ $song['img'] }}" alt="{{ $song['name'] }}">
                        </div>
                        @endif

                        <a href="{{ route('song.show', $song['id']) }}">
                            {{ $song['name'] }}
                        </a>
                    </div>
                    @endforeach
                </div>
                @endforeach
            </div>
            @endif

            @if ($artist['latest_songs'])
            <div class="songs latest">
                @foreach (array_chunk($artist['latest_songs'], 4) as $group)
                <div class="songs-row">
                    @foreach ($group as $song)
                    <div class="card-song">
                        <div class="img-container">
                            @if (!empty($song['img']))
                            <img src="{{ $song['img'] }}" alt="{{ $song['name'] }}">
                            @else
                            <x-carbon-no-image class="no-img" />
                            @endif
                        </div>

                        <a href="{{ route('song.show', $song['id']) }}">
                            {{ $song['name'] }}
                        </a>
                    </div>
                    @endforeach
                </div>
                @endforeach
            </div>
            @endif
        </div>

        @if ($artist['popular_albums'] || $artist['latest_albums'])
        <div class="header">
            <h4>Albumes</h4>

            <div class="switch">
                <div class="switch-indicator-albums"></div>

                <button type="button" class="albums popular">Populares</button>
                <button type="button" class="albums latest">Recientes</button>
            </div>

            <a href="{{ route('album.index', ['artists[]' => $artist['id']]) }}">Ver todos sus álbumes</a>
        </div>
        @endif

        <div id="albums-artist">

            @if ($artist['popular_albums'])
            <div class="albums popular">
                @foreach ($artist['popular_albums'] as $album)
                <div class="card-album">
                    @if (!empty($album['img']))
                    <div class="img-container">
                        <img src="{{ $album['img'] }}" alt="{{ $album['name'] }}">
                    </div>
                    @endif

                    <a href="{{ route('album.show', $album['id']) }}">
                        {{ $album['name'] }}
                    </a>
                </div>
                @endforeach
            </div>
            @endif

            @if ($artist['latest_albums'])
            <div class="albums latest">
                @foreach ($artist['latest_albums'] as $album)
                <div class="card-album">
                    @if (!empty($album['img']))
                    <div class="img-container">
                        <img src="{{ $album['img'] }}" alt="{{ $album['name'] }}">
                    </div>
                    @endif

                    <a href="{{ route('album.show', $album['id']) }}">
                        {{ $album['name'] }}
                    </a>
                </div>
                @endforeach
            </div>
            @endif
        </div>

    </div>

</div>
</div>
@endsection