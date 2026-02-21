@extends('app')

@section('content')
<h1 class="title-page">CANCIONES</h1>

<div id="page-songs" class="page" data-page="index">

    <!-- Filtros -->
    <form action="{{ route('song.index') }}" method="GET" class="filters">

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
                            :options="config('filters.song_sort')" />

                        <x-type
                            label="canción" :value="request('type')"
                            :options="config('filters.song_type')" />

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
    @if (!empty($songs))
    <div id="songs">
        @foreach ($songs as $song)
        <a href="{{ route('song.show', $song['id']) }}" class="card-song">

            <div class="img-container">
                @if ($song['img'])
                <img src="{{ $song['img'] }}" alt="{{ $song['name'] }}">
                @else
                <x-carbon-no-image class="no-img" />
                <p>Imagen no encontrada</p>
                @endif
            </div>

            <div class="data">
                <p class="title">{{ $song['name'] }}</p>
                <p class="artists">{{ $song['artists'] }}</p>
            </div>
        </a>
        @endforeach
    </div>
    @else
    <div class="empty">
        <img src="images/not-found.png" alt="miku not found">
        <h2>No se han encontrado resultados</h2>
    </div>
    @endif
</div>
<x-pagination :page="$page" :pages="$pages" />
@endsection