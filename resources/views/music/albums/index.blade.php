@extends('app')

@section('content')
<h1 class="title-page">ALBUMES</h1>

<div class="page" data-page="index" id="page-albums">

    <!-- Filtros -->
    <form action="{{ route('album.index') }}" method="GET" class="filters">

        <div id="controls">
            <x-input-name :value="request('name', '')" />

            <button type="button" data-bs-toggle="modal" data-bs-target="#filtersModal" id="open_filters">
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
                            :options="config('filters.album_sort')" />

                        <x-type
                            label="álbum"
                            :value="request('type')"
                            :options="config('filters.album_type')" />

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
    @if (!empty($albums))
    <div id="albums">
        @foreach ($albums as $album)
        <a href="{{ route('album.show', $album['id']) }}" class="card-album">
            <div class="img-container">
                @if ($album['img'])
                <img src="{{ $album['img'] }}" alt="{{ $album['name'] }}">
                @else
                <x-carbon-no-image class="icon-no-img" />
                <p>Portada no <br> disponible</p>
                @endif
            </div>
            <div class="data">
                <p class="title">{{ $album['name'] }}</p>
                <p class="artists">{{ $album['artists'] }}</p>
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