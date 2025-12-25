@extends('app')

@section('content')
<div id="container">
    <div id="title-page">
        <h1>Artistas</h1>
        <p>{{ $total }} resultados</p>
    </div>

    <form action="{{ route('artist.index') }}" method="GET" id="form">

        <div id="controls">
            <x-input-name :value="request('name', '')" />

            <button type="button" id="open_filters">
                <i class="bi bi-funnel-fill"></i>
            </button>
        </div>

        <div id="overlay"></div>
        <div id="filters">

            <div id="filters-header">
                <h2>Filtros</h2>
                <i class="bi bi-x-lg" id="close_filters"></i>
            </div>

            <div id="filters-body">
                <x-sort
                    :value="request('sort')"
                    :options="[
            ['value' => 'FollowerCount', 'label' => 'Popularidad'],
            ['value' => 'Name', 'label' => 'Nombre'],
        ]" />
                <x-type
                    label="artista"
                    :value="request('type')"
                    :options="[
            ['value' => 'Producer', 'label' => 'Productor musical', 'data' => 'producer'],
            ['value' => 'CoverArtist', 'label' => 'Artista de covers', 'data' => 'producer'],
            ['value' => 'Circle', 'label' => 'Círculo', 'data' => 'producer'],
            ['value' => 'OtherGroup', 'label' => 'Otros grupos', 'data' => 'producer'],

            ['value' => 'Vocaloid', 'label' => 'Vocaloid', 'data' => 'vocalist'],
            ['value' => 'UTAU', 'label' => 'UTAU', 'data' => 'vocalist'],
            ['value' => 'SynthesizerV', 'label' => 'Synthesizer V', 'data' => 'vocalist'],
            ['value' => 'CeVIO', 'label' => 'CeVIO', 'data' => 'vocalist'],
            ['value' => 'NEUTRINO', 'label' => 'NEUTRINO', 'data' => 'vocalist'],
            ['value' => 'VoiSona', 'label' => 'VoiSona', 'data' => 'vocalist'],
            ['value' => 'NewType', 'label' => 'NewType', 'data' => 'vocalist'],
            ['value' => 'Voiceroid', 'label' => 'Voiceroid', 'data' => 'vocalist'],
            ['value' => 'VOICEVOX', 'label' => 'VOICEVOX', 'data' => 'vocalist'],
            ['value' => 'ACEVirtualSinger', 'label' => 'ACE Virtual Singer', 'data' => 'vocalist'],
            ['value' => 'AIVOICE', 'label' => 'AI VOICE', 'data' => 'vocalist'],
            ['value' => 'OtherVoiceSynthesizer', 'label' => 'Otros sintetizadores de voz', 'data' => 'vocalist'],
            ['value' => 'OtherVocalist', 'label' => 'Otros vocalistas', 'data' => 'vocalist'],
        ]">
                    <label>
                        <input type="radio" value="producer" class="type-artist" checked>
                        Productor
                    </label>

                    <label>
                        <input type="radio" value="vocalist" class="type-artist">
                        Vocalista
                    </label>
                </x-type>

                <x-tags name="genres" label="Géneros" :value="request('genres', null)" />

                <div id="filters-btns">
                    <button type="submit">Aplicar filtros</button>
                    <a href="{{ route('song.index') }}">Limpiar filtros</a>
                </div>
            </div>
        </div>

        <input type="hidden" name="page" id="page" value="{{ $page }}">
    </form>

    <div id="artists">
        @foreach ($artists as $artist)
        <a href="{{ route('artist.show', $artist['id']) }}">
            <div class="artist-img">
                <img src="{{ $artist['img'] }}" alt="{{ $artist['name'] }}">
            </div>
            <p>{{ $artist['name'] }}</p>
        </a>
        @endforeach
    </div>

    <x-pagination :page="$page" :pages="$pages" />
</div>
@endsection

@push('styles')
@vite(['resources/scss/artists/index.scss', 'resources/scss/form.scss'])
@endpush

@push('scripts')
@vite('resources/js/index.js')
@endpush