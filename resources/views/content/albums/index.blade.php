@extends('app')

@section('content')
<div id="title-page">
    <h1>Albumes</h1>
    <p>{{ $total }} resultados</p>
</div>

<div id="container">
    <form action="{{ route('album.index') }}" method="GET" id="form">

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
            ['value' => 'ReleaseDate', 'label' => 'Fecha de lanzamiento'],
            ['value' => 'Name', 'label' => 'Nombre'],
            ['value' => 'RatingTotal', 'label' => 'Popularidad'],
        ]" />

                <x-type
                    label="álbum"
                    :value="request('type')"
                    :options="[
            ['value' => 'Album',        'label' => 'Original'],
            ['value' => 'EP',           'label' => 'EP'],
            ['value' => 'Compilation',  'label' => 'Compilación'],
            ['value' => 'SplitAlbum',   'label' => 'Álbum compartido'],
            ['value' => 'Other',        'label' => 'Otro'],
        ]" />

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

    <div id="albums">
        @foreach ($albums as $album)
        <a href="{{ route('album.show', $album['id']) }}">
            <div class="img-container">
                @if ($album['img'])
                <img src="{{ $album['img'] }}" alt="{{ $album['name'] }}">
                @else
                <x-carbon-no-image class="no-img" />
                @endif
            </div>
            <div class="album-data">
                <p class="album-title">{{ $album['name'] }}</p>
                <p class="album-artists">{{ $album['artists'] }}</p>
            </div>
        </a>
        @endforeach
    </div>
</div>

<x-pagination :page="$page" :pages="$pages" />
@endsection

@push('styles')
@vite(['resources/scss/albums/index.scss'])
@endpush

@push('scripts')
@vite('resources/js/index.js')
@endpush