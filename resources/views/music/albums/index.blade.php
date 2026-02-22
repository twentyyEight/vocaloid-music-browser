@extends('app')

@section('content')
<h1 class="title-page">ALBUMES</h1>

<div class="page" data-page="index" id="page-albums">

    <!-- Filtros -->
    <x-filters entity="album" :page="$page">

        <!-- Ordenar por -->
        <x-sort
            :value="request('sort')"
            :options="config('filters.album_sort')" />

        <!-- Tipo de álbum -->
        <x-type
            label="álbum"
            :value="request('type')"
            :options="config('filters.album_type')" />

        <!-- Generos -->
        <x-tags name="genres" label="Géneros" :value="request('genres', null)" />

        <!-- Artistas -->
        <x-tags name="artists" label="Artistas" :value="request('artists', null)" />

        <!-- Fechas de lanzamientos (antes de y después de) -->
        <x-input-dates :value_before="request('beforeDate')" :value_after="request('afterDate')" />
    </x-filters>

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