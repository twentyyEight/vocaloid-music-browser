@extends('app')

@section('content')
<div id="home-page" class="page" data-page="home">

    @foreach (['success' => 'success', 'error' => 'danger'] as $key => $type)
    @if (session($key))
    <x-alert :type="$type" :message="session($key)" />
    @endif
    @endforeach

    <div id="viewport">
        <div id="squares-up">
            <img src="/images/home/meiko.jpg" alt="">
            <img src="/images/home/kagamine.jpg" alt="">
            <img src="/images/home/gumi.jpg" alt="">
            <img src="/images/home/miku.jpg" alt="">
        </div>

        <div id="squares-down">
            <img src="/images/home/luka.jpg" alt="">
            <img src="/images/home/kaito.jpg" alt="">
            <img src="/images/home/IA.jpg" alt="">
            <img src="/images/home/teto.jpg" alt="">
        </div>
    </div>

    <div id="container-home">
        <h1>Vocaloid <br> Music Browser</h1>
        <h4>Toda la información de VOCALOID en un solo lugar</h4>

        <div id="searcher">
            <input type="text">
            <x-antdesign-loading-3-quarters-o id="loading" />
            <select name="entity" id="entity">
                <option value="songs">Canción</option>
                <option value="albums">Álbum</option>
                <option value="artists">Artista</option>
            </select>
            <button type="button" id="search-btn">
                <i class="bi bi-search"></i>
            </button>
        </div>

        <div id="explore-music">
            <a href="{{ route('song.index') }}" class="explore">
                <p>Explorar <br> canciones</p>
                <i class="bi bi-music-note-beamed"></i>
            </a>

            <a href="{{ route('album.index') }}" class="explore">
                <p>Explorar <br> álbumes</p>
                <i class="bi bi-disc-fill"></i>
            </a>

            <a href="{{ route('artist.index') }}" class="explore">
                <p>Explorar <br> artistas</p>
                <x-mdi-account-music class="bi" />
            </a>
        </div>
    </div>
</div>
@endsection