@extends('app')

@section('content')

<div id="title-page">
    <h1>Artistas</h1>
    <p>{{ $total }} resultados</p>
</div>
<div id="container">
    <form action="{{ route('artist.index') }}" method="GET" id="form">

        <div id="controls">
            <x-input-name :value="request('name', '')" />
            <button type="button" data-bs-toggle="modal" data-bs-target="#filtersModal" id="open_filters">
                <i class="bi bi-funnel-fill"></i>
            </button>
        </div>

        <div class="modal fade" id="filtersModal" aria-labelledby="exampleModalLabel" aria-hidden="true" tabindex="-1">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Filtros</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
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

                            <div id="switch-type">
                                <label>
                                    <input type="radio" value="producer" class="type-artist" checked>
                                    <span>Productor</span>
                                </label>

                                <label>
                                    <input type="radio" value="vocalist" class="type-artist">
                                    <span>Vocalista</span>
                                </label>
                            </div>
                        </x-type>

                        <x-tags name="genres" label="Géneros" :value="request('genres', null)" />
                    </div>

                    <div class="modal-footer">
                        <button type="submit" id="apply">Aplicar filtros</button>
                        <a href="{{ route('song.index') }}" id="reset">Limpiar filtros</a>
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" name="page" id="page" value="{{ $page }}">
    </form>

    <div id="artists">
        @foreach ($artists as $artist)
        <a href="{{ route('artist.show', $artist['id']) }}">
            <div class="img-container">
                @if ($artist['img'])
                <img src="{{ $artist['img'] }}" alt="{{ $artist['name'] }}">
                @else
                <x-carbon-no-image class="no-img" />
                @endif
            </div>
            <p>{{ $artist['name'] }}</p>
        </a>
        @endforeach
    </div>
</div>

<x-pagination :page="$page" :pages="$pages" />

@endsection

@push('styles')
@vite(['resources/scss/pages/artists/index.scss'])
@endpush

@push('scripts')
@vite('resources/js/index.js')
@endpush