@extends('app')

@section('content')

<h1 class="title-page">ARTISTAS</h1>

<div id="page-artists" data-page="index" class="page">

    <!-- Filtros -->
    <x-filters entity="artist" :page="$page">

        <!-- Ordenar por -->
        <x-sort
            :value="request('sort')"
            :options="config('filters.artist_sort')" />

        <!-- Tipo de artista -->
        <x-type
            label="artista"
            :value="request('type')"
            :options="config('filters.artist_type')">

            <div id="switch-type">
                <button type="button" class="type-artist producer active">Productor</button>
                <button type="button" class="type-artist vocalist">Vocalista</button>
            </div>
        </x-type>

        <!-- Generos -->
        <x-tags name="genres" label="Géneros" :value="request('genres', null)" />
    </x-filters>

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