@extends('app')

@section('content')
<div class="page" data-page="artist" id="page-artist">

    @foreach (['success' => 'success', 'error' => 'danger'] as $key => $type)
    @if (session($key))
    <x-alert :type="$type" :message="session($key)" />
    @endif
    @endforeach

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

    <div id="works-artist">
        @if (!empty(($artist['popular_songs'])))
        <div>
            <h2>Canciones populares</h2>
            <div class="work-artist songs">
                @foreach ($artist['popular_songs'] as $popular_song)
                <a href="{{ route('song.show', $popular_song['id']) }}" class="card-song">
                    <div class="img-container">
                        @if ($popular_song['img'])
                        <img src="{{ $popular_song['img'] }}" alt="{{ $popular_song['name'] }}">
                        @else
                        <x-carbon-no-image class="no-img" />
                        <p>Imagen no encontrada</p>
                        @endif
                    </div>
                    <p>{{ $popular_song['name'] }}</p>
                </a>
                @endforeach
            </div>
            <a href="{{ route('song.index', ['artists[]' => $artist['id'], 'sort' => 'RatingScore', 'type' => 'Original']) }}" class="ver-mas">
                Ver más
                <i class="bi bi-plus"></i>
            </a>
        </div>
        @endif

        @if (!empty(($artist['latest_songs'])))
        <div>
            <h2>Canciones recientes</h2>
            <div class="work-artist songs">
                @foreach ($artist['latest_songs'] as $latest_song)
                <a href="{{ route('song.show', $latest_song['id']) }}" class="card-song">
                    <div class="img-container">
                        @if ($latest_song['img'])
                        <img src="{{ $latest_song['img'] }}" alt="{{ $latest_song['name'] }}">
                        @else
                        <x-carbon-no-image class="no-img" />
                        <p>Imagen no encontrada</p>
                        @endif
                    </div>
                    <p>{{ $latest_song['name'] }}</p>
                </a>
                @endforeach
            </div>
            <a href="{{ route('song.index', ['artists[]' => $artist['id'], 'type' => 'Original']) }}" class="ver-mas">
                Ver más
                <i class="bi bi-plus"></i>
            </a>
        </div>
        @endif

        @if (!empty(($artist['popular_albums'])))
        <div>
            <h2>Álbumes populares</h2>
            <div class="work-artist albums">
                @foreach ($artist['popular_albums'] as $popular_album)
                <a href="{{ route('album.show', $popular_album['id']) }}" class="card-album">
                    <div class="img-container">
                        @if ($popular_album['img'])
                        <img src="{{ $popular_album['img'] }}" alt="{{ $popular_album['name'] }}">
                        @else
                        <x-carbon-no-image class="no-img" />
                        <p>Portada no encontrada</p>
                        @endif
                    </div>
                    <p>{{ $popular_album['name'] }}</p>
                </a>
                @endforeach
            </div>
            <a href="{{ route('album.index', ['artists[]' => $artist['id'], 'sort' => 'RatingTotal' ]) }}" class="ver-mas">
                Ver más
                <i class="bi bi-plus"></i>
            </a>
        </div>
        @endif

        @if (!empty(($artist['latest_albums'])))
        <div>
            <h2>Álbumes recientes</h2>
            <div class="work-artist albums">
                @foreach ($artist['latest_albums'] as $latest_album)
                <a href="{{ route('album.show', $latest_album['id']) }}" class="card-album">
                    <div class="img-container">
                        @if ($latest_album['img'])
                        <img src="{{ $latest_album['img'] }}" alt="{{ $latest_album['name'] }}">
                        @else
                        <x-carbon-no-image class="no-img" />
                        <p>Portada no encontrada</p>
                        @endif
                    </div>
                    <p>{{ $latest_album['name'] }}</p>
                </a>
                @endforeach
            </div>
            <a href="{{ route('album.index', ['artists[]' => $artist['id']]) }}" class="ver-mas">
                Ver más
                <i class="bi bi-plus"></i>
            </a>
        </div>
        @endif
    </div>

</div>
</div>
@endsection