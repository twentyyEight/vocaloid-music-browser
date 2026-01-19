@extends('app')

@section('content')

@if(session('success'))
<p>{{ session('success') }}</p>
@endif

@if(session('error'))
<p>{{ session('error') }}</p>
@endif

<div id="page-song">
    <div id="hero">
        <div id="thumbail-song">
            @if ($song['img'])
            <img src="{{ $song['img'] }}" alt="{{ $song['name'] }}" id="background">
            @else
            <x-carbon-no-image id="no-img" />
            @endif
        </div>

        <div id="video-song">
            @if ($song['pv']['service'] === 'Youtube')
            <iframe src="https://www.youtube.com/embed/{{ $song['pv']['url'] }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen></iframe>
            @else
            <iframe src="https://embed.nicovideo.jp/watch/{{ $song['pv']['url'] }}" frameborder="0"></iframe>
            @endif
        </div>

        <div id="hero-content">
        </div>
    </div>

    <div id="body-song">
        <div id="info-song">
            <h1>{{ $song['name'] }}</h1>
            <h5>{{ $song['artists'] }}</h5>
            <p>{{ $song['type'] }} · {{ $song['date'] }} · {{ $song['duration'] }} min</p>

            @if ($song['genres'])
            <div id="genres-song">
                @foreach ($song['genres'] as $genre)
                <a href="{{ route('genre.show', $genre['id']) }}">
                    {{ $genre['name'] }}
                </a>
                @endforeach
            </div>
            @endif

            <x-favorite-btn entity="song" :id="$song['id']" :isFavorite="$isFavorite" />
        </div>

        <div>
            <h3>Créditos</h3>
            <div class="line"></div>
            <div id="credits">
                @foreach ($song['credits'] as $artist)
                <div class="card-artist">
                    <div class="img-container">
                        @if ($artist['img'])
                        <img src="{{ $artist['img'] }}" alt="{{ $artist['name'] }}">
                        @else
                        <i class="bi bi-person-fill"></i>
                        @endif
                    </div>
                    <div class="credit-artist">
                        <a href="{{ route('artist.show', $artist['id']) }}">
                            <p>{{ $artist['name'] }}</p>
                        </a>
                        <p>{{ $artist['roles'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        @if ($song['albums'])
        <div>
            <div id="header-albums-song">
                <h3>Aparece en</h3>
                <div id="arrows-albums-song">
                    <x-eva-arrow-ios-back-outline id="arrow-left" />
                    <x-eva-arrow-ios-forward-outline id="arrow-right" />
                </div>
            </div>

            <div class="line"></div>
            
            <div id="albums-song">
                @foreach ($song['albums'] as $album)
                <a href="{{ route('album.show', $album['id']) }}">
                    @if ($album['img'])
                    <img src="{{ $album['img'] }}" alt="{{ $album['name'] }}">
                    @else
                    <div class="no-img-container">
                        <x-carbon-no-image class="no-img" />
                    </div>
                    @endif
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

@endsection

@push('styles')
@vite(['resources/scss/pages/songs/show.scss'])
@endpush

@push('scripts')
@vite(['resources/js/song.js'])
@endpush