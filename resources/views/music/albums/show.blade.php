@extends('app')

@section('content')
<div id="container">
    @if(session('success'))
    <p>{{ session('success') }}</p>
    @endif

    @if(session('error'))
    <p>{{ session('error') }}</p>
    @endif

    <div id="album">
        <img src="{{ $album['img'] }}" alt="{{ $album['name'] }}">

        <div id="album-info">
            <h1>{{ $album['name'] }}</h1>
            <h2>{{ $album['artists'] }}</h2>
            <p><span id="album-type">{{ $album['type'] }}</span> • {{ $album['date'] }}</p>
            @if ($album['genres'])
            <div>
                @foreach ($album['genres'] as $genre)
                <a href="{{ route('genre.show', $genre['id']) }}">{{ $genre['name'] }}</a>@if (!$loop->last), @endif
                @endforeach
            </div>
            @endif

            @if ($album['links'])
            <button type="button" data-bs-toggle="modal" data-bs-target="#linksModal" id="btn-links">
                Escúchalo o cómpralo
            </button>

            <div class="modal fade" id="linksModal" aria-labelledby="exampleModalLabel" aria-hidden="true" tabindex="-1">
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Escucha o compra en:</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            @foreach ($album['links'] as $link)
                            <a href="{{ $link['url'] }}">{{ $link['name'] }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <x-favorite-btn entity="album" :id="$album['id']" :isFavorite="$isFavorite" />
        </div>
    </div>

    @if ($album['tracks'])
        <div id="tracks">
            <h3>Tracks</h3>
            <ol type="1">
                @foreach ($album['tracks'] as $track)
                <li>
                    <a href="{{ route('song.show', $track['id']) }}">
                        {{ $track['name'] }}
                        <br>
                        <span class="track-artist">{{ $track['artists'] }}</span>
                    </a>
                </li>
                @endforeach
            </ol>
        </div>
    @endif

    @if ($album['pv'])
        <h3>Video promocional</h3>
        @if (substr($album['pv'], 0, 2) === 'sm')
        <iframe src="https://embed.nicovideo.jp/watch/{{ $album['pv'] }}" frameborder="0"></iframe>
        @else
        <iframe src="https://www.youtube.com/embed/{{ $album['pv'] }}" frameborder="0"></iframe>
        @endif
    @endif
</div>
@endsection

@push('styles')
@vite(['resources/scss/pages/albums/show.scss'])
@endpush

@push('scripts')
@vite('resources/js/index.js')
@endpush