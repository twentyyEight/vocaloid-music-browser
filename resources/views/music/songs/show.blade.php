@extends('app')

@section('content')

@if(session('success'))
<p>{{ session('success') }}</p>
@endif

@if(session('error'))
<p>{{ session('error') }}</p>
@endif
<div id="page-song">

    <div id="background">
        <img src="{{ $song['img'] }}" alt="">
    </div>

    <div id="container-song">
        <div id="video-albums-song">

            <div id="video-song">
                @if ($song['pv']['service'] === 'Youtube')
                <iframe src="https://www.youtube.com/embed/{{ $song['pv']['url'] }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen></iframe>
                @else
                <iframe src="https://embed.nicovideo.jp/watch/{{ $song['pv']['url'] }}" frameborder="0"></iframe>
                @endif
            </div>

            @if ($song['albums'])
            <div id="albums-song">
                <h4>Aparece en:</h4>
                <div id="container-albums">
                    <i class="bi bi-caret-left-fill"></i>

                    <div id="covers-albums-song">
                        @foreach ($song['albums'] as $album)
                        <a href="{{ route('album.show', $album['id']) }}">
                            @if ($album['img'])
                            <img src="{{ $album['img'] }}" alt="">
                            @else
                            <div class="no-img-container">
                                <x-carbon-no-image class="no-img" />
                            </div>
                            @endif
                        </a>
                        @endforeach
                    </div>

                    <i class="bi bi-caret-right-fill"></i>
                </div>
            </div>
            @endif
        </div>

        <div id="data-song">
            <h1>{{ $song['name'] }}</h1>
            <h4>{{ $song['artists'] }}</h4>
            <h5>{{ $song['type'] }}</h5>

            <div id="options-song">
                <button type="button" id="btn-info-song">Información</button>
                <button type="button" id="btn-lyrics-song">Letra</button>
            </div>

            <div id="info-song">
                <div>
                    <p><span class="label">Fecha de lanzamiento</span><span>{{ $song['date'] }}</span></p>
                    <p><span>Duración</span><span>{{ $song['duration'] }} min</span></p>
                    <p><span>Idioma(s)</span><span>{{ implode(', ', $song['languages']) }}</span></p>
                </div>

                <div>
                    <h5>Créditos</h5>
                    @foreach ($song['credits'] as $role => $artists)
                    <div class="credit">
                        <h6>{{ $role }}</h6>
                        @foreach ($artists as $artist)
                        <a href="{{ route('genre.show', $artist['id']) }}">{{ $artist['name'] }}</a>@if (!$loop->last), @endif
                        @endforeach
                    </div>
                    @endforeach
                </div>

                @if ($song['genres'])
                <div>
                    <h5>Géneros</h5>
                    <div id="genres-song">
                        @foreach ($song['genres'] as $genre)
                        <a href="{{ route('genre.show', $genre['id']) }}">
                            {{ $genre['name'] }}
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            @if ($song['lyrics'])
            <div id="lyrics-song">
                <div id="btns-lyrics-song">
                    @foreach ($song['lyrics'] as $lyric)
                    <button id="{{ $lyric['id'] }}" class="btn-lyric">{{ $lyric['languages'] }}</button>
                    @endforeach
                </div>

                @foreach ($song['lyrics'] as $lyric)
                <p id="lyric-{{ $lyric['id'] }}" class="lyric">{!! nl2br(e($lyric['lyric']), false) !!}</p>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>

@endsection

@push('styles')
@vite(['resources/scss/pages/songs/show.scss'])
@endpush

@push('scripts')
@vite(['resources/js/song.js'])
@endpush