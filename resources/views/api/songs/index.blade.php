@extends('app')

@section('content')
<div id="title-page">
    <h1>Canciones</h1>
    <p>{{ $total }} resultados</p>
</div>
<div id="browse">
    <form action="{{ route('song.index') }}" method="GET" id="form">

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
            ['value' => 'PublishDate', 'label' => 'Fecha de lanzamiento'],
            ['value' => 'Name', 'label' => 'Nombre'],
            ['value' => 'RatingScore', 'label' => 'Popularidad']]" />

                <x-type
                    label="canción" :value="request('type')"
                    :options="[
            ['value' => 'Original',        'label' => 'Original'],
            ['value' => 'Remaster',        'label' => 'Remasterización'],
            ['value' => 'Remix',           'label' => 'Remix'],
            ['value' => 'Cover',           'label' => 'Cover'],
            ['value' => 'Arragement',      'label' => 'Arreglo'],
            ['value' => 'Instrumental',    'label' => 'Instrumental'],
            ['value' => 'Mashup',          'label' => 'Mashup'],
            ['value' => 'Rearragement',    'label' => 'Rearreglo'],
            ['value' => 'Other',           'label' => 'Otro'],
            ['value' => 'Unspecified',     'label' => 'Sin especificar']]" />

                <x-tags name="genres" label="Géneros" :value="request('genres', null)" />

                <x-tags name="artists" label="Artistas" :value="request('artists', null)" />

                <x-input-dates :value_before="request('beforeDate')" :value_after="request('afterDate')" />
            </div>

            <div id="filters-btns">
                <button type="submit" id="apply">Aplicar filtros</button>
                <a href="{{ route('song.index') }}" id="reset">Limpiar filtros</a>
            </div>
        </div>

        <input type="hidden" name="page" id="page" value="{{ $page }}">
    </form>

    <div id="songs">
        @foreach ($songs as $song)
        <a href="{{ route('song.show', $song['id']) }}">
            @if ($song['img'])
            <div class="img-container">
                <img src="{{ $song['img'] }}" alt="{{ $song['name'] }}">
            </div>
            @else
            <div class="icon-container">
                <i class="bi bi-card-image"></i>
            </div>
            @endif
            <div class="song-data">
                <p class="song-title">{{ $song['name'] }}</p>
                <p class="song-artists">{{ $song['artists'] }}</p>
            </div>
        </a>
        @endforeach
    </div>
</div>
<x-pagination :page="$page" :pages="$pages" />
@endsection

@push('styles')
@vite(['resources/scss/songs/index.scss', 'resources/scss/form.scss'])
@endpush

@push('scripts')
@vite('resources/js/index.js')
@endpush