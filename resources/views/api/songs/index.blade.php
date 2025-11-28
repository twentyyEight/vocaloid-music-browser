@extends('layouts.app')

@section('content')
<form action="{{ route('song.index') }}" method="GET" id="filters">

    <input type="text" placeholder="Buscar por nombre..." name="name" id="name" value="{{ request('name') }}">
    <button type="button" id="search">Buscar</button>

    <h3>Tipo de canción</h3>
    <input type="hidden" id="type" name="type" value="{{ request('type')}}">

    <button type="button" class="type" value="Unspecified,Original,Remaster,Remix,Cover,Arrangement,Instrumental,Mashup,Other,Rearrangement">Todos</button>
    <button type="button" class="type" value="Original">Canción original</button>
    <button type="button" class="type" value="Remaster">Remasterización</button>
    <button type="button" class="type" value="Remix">Remix</button>
    <button type="button" class="type" value="Cover">Cover</button>
    <button type="button" class="type" value="Arragement">Arreglo</button>
    <button type="button" class="type" value="Instrumental">Instrumental</button>
    <button type="button" class="type" value="Mashup">Mashup</button>
    <button type="button" class="type" value="Rearragement">Rearreglo</button>
    <button type="button" class="type" value="Other">Otro</button>
    <button type="button" class="type" value="Unspecified">Sin especificar</button>

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
        <option value="PublishDate" {{ request('sort') == 'PublishDate' ? 'selected' : '' }}>Fecha de lanzamiento</option>
        <option value="Name" {{ request('sort') == 'Name' ? 'selected' : '' }}>Nombre</option>
        <option value="RatingScore" {{ request('sort') == 'RatingScore' ? 'selected' : '' }}>Popularidad</option>
    </select>
</form>

<h2 id="loading">Cargando...</h2>

<div id="songs" style="display: none;">
    @foreach ($songs as $song)
    <a href="{{ route('song.show', $song['id']) }}">{{ $song['name'] }}</a>
    @endforeach
</div>

<x-pagination :page="$page" :pages="$pages" />
@endsection

@push('scripts')
<script type="module" src="{{ asset('js/songs_filters/index.js') }}"></script>
@endpush