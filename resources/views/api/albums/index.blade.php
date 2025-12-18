@extends('app')

@section('content')
<form action="{{ route('album.index') }}" method="GET" id="filters">

    <input type="text" placeholder="Buscar por nombre..." name="name" id="name" value="{{ request('name') }}">
    <button type="button" id="search">Buscar</button>

    <label for="type">Tipo de álbum</label>
    <input type="hidden" id="type" name="type" value="{{ request('type')}}">

    <select name="type" id="type">
        <option value=""></option>
        <option value="Album" {{ request('type') == 'Album' ? 'selected' : '' }}>Original</option>
        <option value="EP" {{ request('type') == 'EP' ? 'selected' : '' }}>EP</option>
        <option value="Compilation" {{ request('type') == 'Compilation' ? 'selected' : '' }}>Compilación</option>
        <option value="SplitAlbum" {{ request('type') == 'SplitAlbum' ? 'selected' : '' }}>Álbum compartido</option>
        <option value="Other" {{ request('type') == 'Other' ? 'selected' : '' }}>Otro</option>
    </select>

    <h3>Género</h3>
    <input type="hidden" id="genres_ids" value='@json(request("genres", null))'>
    <input type="text" id="genres">
    <p style="display: none;" id="loading_genres">Buscando...</p>
    <div id="selected_genres"></div>

    <h3>Artista</h3>
    <input type="hidden" id="artists_ids" value='@json(request("artists", null))'>
    <input type="text" id="artists">
    <p style="display: none;" id="loading_artists">Buscando...</p>
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

<div id="albums">
    @foreach ($albums as $album)
    <a href="{{ route('album.show', $album['id']) }}">{{ $album['name'] }}</a>
    @endforeach
</div>

<x-pagination :page="$page" :pages="$pages" />
@endsection

@vite('resources/js/index.js')