@extends('layouts.app')

@section('content')
<form action="{{ route('song.index') }}" method="GET">

    <input type="text" placeholder="Buscar canción..." name="name" value="{{ request('name') }}">

    <h3>Tipo de canción</h3>
    <input type="hidden" id="types" name="types" value="{{ request('types')}}">

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
    <input type="text" id="genres">
    <div id="selected_genres"></div>

    <h3>Artista</h3>
    <input type="text" id="artists">
    <div id="selected_artists"></div>

    <label for="beforeDate">Publicada antes de:</label>
    <input type="date" name="beforeDate" placeholder="Ingresa una fecha" value="{{ request('beforeDate') }}">

    <label for="afterDate">Publicada después de:</label>
    <input type="date" name="afterDate" placeholder="Ingresa una fecha" value="{{ request('afterDate') }}">

    <button type="submit">Buscar</button>
</form>

<div class="songs">
    @foreach ($songs as $song)
    <a href="{{ route('song.show', $song['id']) }}">{{ $song['name'] }}</a>
    @endforeach
</div>

<x-pagination :page="$page" :pages="$pages" />
@endsection

@push('scripts')
<script type="module" src="{{ asset('js/songs/index.js') }}"></script>
@endpush