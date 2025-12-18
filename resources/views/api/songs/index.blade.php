@extends('app')

@section('content')
<form action="{{ route('song.index') }}" method="GET" id="filters">

    <input type="text" placeholder="Buscar por nombre..." name="name" id="name" value="{{ request('name') }}">
    <button type="button" id="search">Buscar</button>

    <h3>Tipo de canción</h3>
    <label for="type">Tipo de canción</label>
    <input type="hidden" id="type" name="type" value="{{ request('type')}}">

    <select name="type" id="type">
        <option value=""></option>
        <option value="Original" {{ request('type') == 'Original' ? 'selected' : '' }}>Original</option>
        <option value="Remaster" {{ request('type') == 'Remaster' ? 'selected' : '' }}>Remasterización</option>
        <option value="Remix" {{ request('type') == 'Remix' ? 'selected' : '' }}>Remix</option>
        <option value="Cover" {{ request('type') == 'Cover' ? 'selected' : '' }}>Cover</option>
        <option value="Arragement" {{ request('type') == 'Arragement' ? 'selected' : '' }}>Arreglo</option>
        <option value="Instrumental" {{ request('type') == 'Instrumental' ? 'selected' : '' }}>Instrumental</option>
        <option value="Mashup" {{ request('type') == 'Mashup' ? 'selected' : '' }}>Mashup</option>
        <option value="Rearragement" {{ request('type') == 'Rearragement' ? 'selected' : '' }}>Rearreglo</option>
        <option value="Other" {{ request('type') == 'Other' ? 'selected' : '' }}>Otro</option>
        <option value="Unspecified" {{ request('type') == 'Unspecified' ? 'selected' : '' }}>Sin especificar</option>
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
        <option value="PublishDate" {{ request('sort') == 'PublishDate' ? 'selected' : '' }}>Fecha de lanzamiento</option>
        <option value="Name" {{ request('sort') == 'Name' ? 'selected' : '' }}>Nombre</option>
        <option value="RatingScore" {{ request('sort') == 'RatingScore' ? 'selected' : '' }}>Popularidad</option>
    </select>
</form>

<div id="songs">
    @foreach ($songs as $song)
    <a href="{{ route('song.show', $song['id']) }}">{{ $song['name'] }}</a>
    @endforeach
</div>

<x-pagination :page="$page" :pages="$pages" />
@endsection

@vite('resources/js/index.js')