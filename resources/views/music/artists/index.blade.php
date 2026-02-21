@extends('app')

@section('content')

<h1 class="title-page">ARTISTAS</h1>

<div id="page-artists" data-page="index" class="page">

    <!-- Filtros -->
    <form action="{{ route('artist.index') }}" method="GET" class="filters">

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
                            :options="config('filters.artist_sort')" />

                        <x-type
                            label="artista"
                            :value="request('type')"
                            :options="config('filters.artist_type')">

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

    <!-- Resultados -->
    @if (!empty($artists))
    <div id="artists">
        @foreach ($artists as $artist)
        <a href="{{ route('artist.show', $artist['id']) }}" class="card-artist">
            <div class="img-container">
                @if ($artist['img'])
                <img src="{{ $artist['img'] }}" alt="{{ $artist['name'] }}">
                @else
                <i class="bi bi-person-fill"></i>
                <p class="text-no-img">Imagen no disponible</p>
                @endif
            </div>
            <p class="name-artist">{{ $artist['name'] }}</p>
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