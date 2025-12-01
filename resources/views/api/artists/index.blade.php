@extends('layouts.app')

@section('content')
<form action="{{ route('artist.index') }}" method="GET" id="filters">
    <input type="text" name="name" placeholder="Buscar por nombre..." id="name" value="{{ request('name') }}">
    <button type="button" id="search">Buscar</button>

    <h2>Tipo de artista</h2>

    <label for="producers">Productores</label>
    <select class="type">
        <option value=""></option>
        <option value="Producer" {{ request('type') == 'Producer' ? 'selected' : '' }}>Productor musical</option>
        <option value="CoverArtist" {{ request('type') == 'CoverArtist' ? 'selected' : '' }}>Artista de covers</option>
        <option value="Circle" {{ request('type') == 'Circle' ? 'selected' : '' }}>Círculo</option>
        <option value="OtherGroup" {{ request('type') == 'OtherGroup' ? 'selected' : '' }}>Otros grupos</option>
    </select>

    <label for="vocalist">Vocalistas</label>
    <select class="type">
        <option value=""></option>
        <option value="Vocaloid" {{ request('type') == 'Vocaloid' ? 'selected' : '' }}>Vocaloid</option>
        <option value="UTAU" {{ request('type') == 'UTAU' ? 'selected' : '' }}>UTAU</option>
        <option value="SynthesizerV" {{ request('type') == 'SynthesizerV' ? 'selected' : '' }}>Synthesizer V</option>
        <option value="CeVIO" {{ request('type') == 'CeVIO' ? 'selected' : '' }}>CeVIO</option>
        <option value="NEUTRINO" {{ request('type') == 'NEUTRINO' ? 'selected' : '' }}>NEUTRINO</option>
        <option value="VoiSona" {{ request('type') == 'VoiSona' ? 'selected' : '' }}>VoiSona</option>
        <option value="NewType" {{ request('v') == 'NewType' ? 'selected' : '' }}>NewType</option>
        <option value="Voiceroid" {{ request('vocalist') == 'Voiceroid' ? 'selected' : '' }}>Voiceroid</option>
        <option value="VOICEVOX" {{ request('vocalist') == 'VOICEVOX' ? 'selected' : '' }}>VOICEVOX</option>
        <option value="ACEVirtualSinger" {{ request('vocalist') == 'ACEVirtualSinger' ? 'selected' : '' }}>ACE Virtual Singer</option>
        <option value="AIVOICE" {{ request('vocalist') == 'AIVOICE' ? 'selected' : '' }}>AI VOICE</option>
        <option value="OtherVoiceSynthesizer" {{ request('vocalist') == 'OtherVoiceSynthesizer' ? 'selected' : '' }}>Otros sintetizadores de voz</option>
        <option value="OtherVocalist" {{ request('vocalist') == 'OtherVocalist' ? 'selected' : '' }}>Otros vocalistas</option>
    </select>

    <input type="hidden" name="type" id="type_hidden" value="{{ request('type') }}">

    <h2>Género</h2>
    <input type="hidden" id="genres_ids" value='@json(request("genres", []))'>
    <input type="text" id="genres">
    <p style="display: none;" id="loading_genres">Buscando...</p>
    <div id="selected_genres"></div>

    <label for="sort">Ordenar por:</label>
    <select name="sort" id="sort">
        <option value="FollowerCount" {{ request('sort') == 'RatingTotal' ? 'selected' : '' }}>Popularidad</option>
        <option value="Name" {{ request('sort') == 'Name' ? 'selected' : '' }}>Nombre</option>
    </select>
</form>

<div class="artists">
    @foreach ($artists as $artist)
    <a href="{{ route('artist.show', $artist['id']) }}">{{ $artist['name'] }}</a>
    @endforeach
</div>

<x-pagination :page="$page" :pages="$pages" />
@endsection

@push('scripts')
<script type="module" src="{{ asset('js/artists_filters/index.js') }}"></script>
@endpush