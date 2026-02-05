@extends('app')

@section('content')
<h1 class="title-page">ALBUMES</h1>

<div class="page" data-page="index" id="page-albums">
    <form action="{{ route('album.index') }}" method="GET" id="form">

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
                            :options="[
                                ['value' => 'ReleaseDate', 'label' => 'Más recientes'],
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

                    <div class="modal-footer">
                        <button type="submit" id="apply">Aplicar filtros</button>
                        <a href="{{ route('song.index') }}" id="reset">Limpiar filtros</a>
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" name="page" id="page" value="{{ $page }}">
    </form>

    <div id="albums">
        @foreach ($albums as $album)
        <a href="{{ route('album.show', $album['id']) }}" class="card-album">
            <div class="img-container">
                @if ($album['img'])
                <img src="{{ $album['img'] }}" alt="{{ $album['name'] }}">
                @else
                <x-carbon-no-image class="no-img" />
                @endif
            </div>
            <div class="data">
                <p class="title">{{ $album['name'] }}</p>
                <p class="artists">{{ $album['artists'] }}</p>
            </div>
        </a>
        @endforeach
    </div>
</div>

<x-pagination :page="$page" :pages="$pages" />
@endsection