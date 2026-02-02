@extends('app')

@section('content')
<div class="title-page">
    <h1>CANCIONES</h1>
</div>

<div id="page-songs" class="page" data-page="index">

    <!-- Filtros -->
    <form action="{{ route('song.index') }}" method="GET" id="form">

        <div id="controls">
            <x-input-name :value="request('name', '')" />
            <button type="button" data-bs-toggle="modal" data-bs-target="#filtersModal" id="open_filters">
                Filtros
                <i class="bi bi-funnel-fill"></i>
            </button>
        </div>

        <div class="modal fade" id="filtersModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">

                    <div class="modal-header">
                        <h4 class="modal-title">Filtros</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <x-sort
                            :value="request('sort')"
                            :options="[
                        ['value' => 'PublishDate', 'label' => 'Más reciente'],
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

                    <div class="modal-footer">
                        <button type="submit" id="apply">Aplicar filtros</button>
                        <a href="{{ route('song.index') }}" id="reset">Limpiar filtros</a>
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" name="page" id="page" value="{{ $page }}">
    </form>

    <!-- Resultados -->
    <div id="songs">
        @foreach ($songs as $song)
        <a href="{{ route('song.show', $song['id']) }}" class="card-song">

            <div class="img-container">
                @if ($song['img'])
                <img src="{{ $song['img'] }}" alt="{{ $song['name'] }}">
                @else
                <x-carbon-no-image class="no-img" />
                @endif
            </div>

            <div class="data">
                <p class="title">{{ $song['name'] }}</p>
                <p class="artists">{{ $song['artists'] }}</p>
            </div>
        </a>
        @endforeach
    </div>
</div>
<x-pagination :page="$page" :pages="$pages" />
@endsection