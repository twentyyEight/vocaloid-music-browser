@extends('app')

@section('content')
<h1 class="title-page">CANCIONES</h1>

<div id="page-songs" class="page" data-page="index">

    <!-- Filtros -->
    <x-filters entity="song" :page="$page">

        <!-- Ordenar por -->
        <x-sort
            :value="request('sort')"
            :options="config('filters.song_sort')" />

        <!-- Tipo de canción -->
        <x-type
            label="canción" :value="request('type')"
            :options="config('filters.song_type')" />

        <!-- Generos -->
        <x-tags name="genres" label="Géneros" :value="request('genres', null)" />

        <!-- Artistas -->
        <x-tags name="artists" label="Artistas" :value="request('artists', null)" />

        <!-- Fechas de lanzamientos (antes de y después de) -->
        <x-input-dates :value_before="request('beforeDate')" :value_after="request('afterDate')" />
    </x-filters>

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