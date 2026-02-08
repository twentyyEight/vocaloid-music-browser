@extends('app')

@section('content')
<div id="profile-page" class="page" data-page="profile">
    @foreach (['success' => 'success', 'error' => 'danger'] as $key => $type)
    @if (session($key))
    <x-alert :type="$type" :message="session($key)" />
    @endif
    @endforeach

    <h1 id="name">{{ $user['name'] }}</h1>

    @if (!count($songs) == 0)
    <div>
        <div class="header">
            <h2>Canciones favoritas</h2>
            @if ($isUserProfile)
            <button type="button" class="edit songs">
                Editar lista
                <i class="bi bi-pencil-fill"></i>
            </button>
            @endif
        </div>

        <div class="carousel">
            <i class="bi bi-caret-left-fill"></i>

            <div id="songs-profile">
                @foreach ($songs as $song)
                <a href="{{ route('song.show', $song['song_id']) }}" class="card-song">

                    <div class="img-container">
                        <img src="{{ $song['img'] }}" alt="{{ $song['name'] }}">
                    </div>

                    <div class="data">
                        <p class="title">{{ $song['name'] }}</p>
                        <p class="artists">{{ $song['artists'] }}</p>
                    </div>

                    <form action="{{ route('song.delete', $song['song_id']) }}" method="POST" class="songs">
                        @csrf
                        @method('DELETE')
                        <button type="submit"><i class="bi bi-x"></i></button>
                    </form>
                </a>
                @endforeach
            </div>

            <i class="bi bi-caret-right-fill"></i>
        </div>
    </div>
    @endif

    @if (!count($albums) == 0)
    <div>

        <div class="header">
            <h2>Albumes favoritos</h2>
            @if ($isUserProfile)
            <button type="button" class="edit albums">
                Editar lista
                <i class="bi bi-pencil-fill"></i>
            </button>
            @endif
        </div>

        <div class="carousel">
            <i class="bi bi-caret-left-fill"></i>

            <div id="albums-profile">
                @foreach ($albums as $album)
                <a href="{{ route('album.show', $album['album_id']) }}" class="card-album">
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

                    <form action="{{ route('album.delete', $album['album_id']) }}" method="POST" class="albums">
                        @csrf
                        @method('DELETE')
                        <button type="submit">
                            <i class="bi bi-x"></i>
                        </button>
                    </form>
                </a>
                @endforeach
            </div>

            <i class="bi bi-caret-right-fill"></i>
        </div>
    </div>
    @endif

    @if (!count($artists) == 0)
    <div>
        <div class="header">
            <h2>Artistas favoritos</h2>
            @if ($isUserProfile)
            <button type="button" class="edit artists">
                Editar lista
                <i class="bi bi-pencil-fill"></i>
            </button>
            @endif
        </div>
        <div class="carousel">
            <i class="bi bi-caret-left-fill"></i>
            <div id="artists-profile">
                @foreach ($artists as $artist)
                <a href="{{ route('artist.show', $artist['artist_id']) }}" class="card-artist">
                    <div class="img-container">
                        @if ($artist['img'])
                        <img src="{{ $artist['img'] }}" alt="{{ $artist['name'] }}">
                        @else
                        <i class="bi bi-person-fill"></i>
                        @endif
                    </div>
                    <p>{{ $artist['name'] }}</p>
                    <form action="{{ route('artist.delete', $artist['artist_id']) }}" method="POST" class="artists">
                        @csrf
                        @method('DELETE')
                        <button type="submit">
                            <i class="bi bi-x"></i>
                        </button>
                    </form>
                </a>
                @endforeach
            </div>
            <i class="bi bi-caret-right-fill"></i>
        </div>
    </div>
</div>
@endif
@endsection