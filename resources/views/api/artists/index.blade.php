@extends('app')

@section('content')
<form action="{{ route('artist.index') }}" method="GET" id="filters">
    <input type="text" name="name" placeholder="Buscar por nombre..." id="name" value="{{ request('name') }}">
    <button type="submit">Buscar</button>

    <h2>Tipo de artista</h2>
    <label>
        <input type="radio" name="type" value="producer" class="type">
        Productor
    </label>

    <label>
        <input type="radio" name="type" value="vocalist" class="type">
        Vocalista
    </label>

    <select id="options">
        <option value=""></option>

        <option value="Producer" data-type="producer" {{ request('type') == 'Producer' ? 'selected' : '' }}>Productor musical</option>
        <option value="CoverArtist" data-type="producer" {{ request('type') == 'CoverArtist' ? 'selected' : '' }}>Artista de covers</option>
        <option value="Circle" data-type="producer" {{ request('type') == 'Circle' ? 'selected' : '' }}>Círculo</option>
        <option value="OtherGroup" data-type="producer" {{ request('type') == 'OtherGroup' ? 'selected' : '' }}>Otros grupos</option>

        <option value="Vocaloid" data-type="vocalist" {{ request('type') == 'Vocaloid' ? 'selected' : '' }}>Vocaloid</option>
        <option value="UTAU" data-type="vocalist" {{ request('type') == 'UTAU' ? 'selected' : '' }}>UTAU</option>
        <option value="SynthesizerV" data-type="vocalist" {{ request('type') == 'SynthesizerV' ? 'selected' : '' }}>Synthesizer V</option>
        <option value="CeVIO" data-type="vocalist" {{ request('type') == 'CeVIO' ? 'selected' : '' }}>CeVIO</option>
        <option value="NEUTRINO" data-type="vocalist" {{ request('type') == 'NEUTRINO' ? 'selected' : '' }}>NEUTRINO</option>
        <option value="VoiSona" data-type="vocalist" {{ request('type') == 'VoiSona' ? 'selected' : '' }}>VoiSona</option>
        <option value="NewType" data-type="vocalist" {{ request('v') == 'NewType' ? 'selected' : '' }}>NewType</option>
        <option value="Voiceroid" data-type="vocalist" {{ request('vocalist') == 'Voiceroid' ? 'selected' : '' }}>Voiceroid</option>
        <option value="VOICEVOX" data-type="vocalist" {{ request('vocalist') == 'VOICEVOX' ? 'selected' : '' }}>VOICEVOX</option>
        <option value="ACEVirtualSinger" data-type="vocalist" {{ request('vocalist') == 'ACEVirtualSinger' ? 'selected' : '' }}>ACE Virtual Singer</option>
        <option value="AIVOICE" data-type="vocalist" {{ request('vocalist') == 'AIVOICE' ? 'selected' : '' }}>AI VOICE</option>
        <option value="OtherVoiceSynthesizer" data-type="vocalist" {{ request('vocalist') == 'OtherVoiceSynthesizer' ? 'selected' : '' }}>Otros sintetizadores de voz</option>
        <option value="OtherVocalist" data-type="vocalist" {{ request('vocalist') == 'OtherVocalist' ? 'selected' : '' }}>Otros vocalistas</option>
    </select>

    <input type="hidden" name="type" id="type_hidden" value="{{ request('type') }}">

    <h2>Género</h2>
    <input type="hidden" id="genres_ids" value='@json(request("genres", null))'>
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

@vite('resources/js/index.js')