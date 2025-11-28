@extends('layouts.app')

@section('content')
<form action="{{ route('album.index') }}" method="GET" id="filters">

    <input type="text" placeholder="Buscar por nombre..." name="name" id="name" value="{{ request('name') }}">
    <button type="button" id="search">Buscar</button>

    <h3>Tipo de álbum</h3>
    <input type="hidden" id="type" name="type" value="{{ request('type')}}">

    <button type="button" class="type" value="Unknown">Todos</button>
    <button type="button" class="type" value="Album">Album original</button>
    <button type="button" class="type" value="EP">EP</button>
    <button type="button" class="type" value="Compilation">Compilación</button>
    <button type="button" class="type" value="SplitAlbum">Album compartido</button>
    <button type="button" class="type" value="Other">Otro</button>

    <h3>Género</h3>
    <input type="hidden" id="genres_ids" value='@json(request("genres", []))'>
    <input type="text" id="genres">
    <p style="display: none;" class="loading_genres">Buscando...</p>
    <div id="selected_genres"></div>

    <h3>Artista</h3>
    <input type="hidden" id="artists_ids" value='@json(request("artists", []))'>
    <input type="text" id="artists">
    <p style="display: none;" class="loading_artists">Buscando...</p>
    <div id="selected_artists"></div>

    <label for="beforeDate">Publicada antes de:</label>
    <input type="date" name="beforeDate" placeholder="Ingresa una fecha" value="{{ request('beforeDate') }}">

    <label for="afterDate">Publicada después de:</label>
    <input type="date" name="afterDate" placeholder="Ingresa una fecha" value="{{ request('afterDate') }}">

    <label for="sort">Ordenar por:</label>
    <select name="sort" id="sort">
        <option value="ReleaseDate" {{ request('sort') == 'ReleaseDate' ? 'selected' : '' }}>Fecha de lanzamiento</option>
        <option value="Name" {{ request('sort') == 'Name' ? 'selected' : '' }}>Nombre</option>
        <option value="RatingTotal" {{ request('sort') == 'RatingTotal' ? 'selected' : '' }}>Popularidad</option>
    </select>
</form>

<h2 id="loading">Cargando...</h2>

<div id="albums" style="display: none;">
    @foreach ($albums as $album)
    <a href="{{ route('album.show', $album['id']) }}">{{ $album['name'] }}</a>
    @endforeach
</div>

<x-pagination :page="$page" :pages="$pages" />
@endsection

@push('scripts')
<script type="module" src="{{ asset('js/albums_filters/index.js') }}"></script>
@endpush