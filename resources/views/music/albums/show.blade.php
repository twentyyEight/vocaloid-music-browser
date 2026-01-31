@extends('app')

@section('content')
<div class="page" data-page="album" id="page-album">
    @if(session('success'))
    <p>{{ session('success') }}</p>
    @endif

    @if(session('error'))
    <p>{{ session('error') }}</p>
    @endif

    <div id="cover-links-album">
        <!-- <x-favorite-btn entity="album" :id="$album['id']" :isFavorite="$isFavorite" /> -->

        @if ($album['img'])
        <img src="{{ $album['img'] }}" alt="{{ $album['name'] }}">
        @endif

        <div id="btns-album">
            <x-favorite-btn entity="album" :id="$album['id']" :isFavorite="$isFavorite" />

            @if ($album['links'])
            <button type="button" data-bs-toggle="modal" data-bs-target="#linksModal" id="btn-links">
                Escucha o compra el álbum
            </button>

            <div class="modal fade" id="linksModal" aria-labelledby="exampleModalLabel" aria-hidden="true" tabindex="-1">
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Escucha o compra el álbum en:</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body links-album">
                            @foreach ($album['links'] as $link)
                            <a href="{{ $link['url'] }}">{{ $link['name'] }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>

        @if ($album['links'])
        <div id="container-links-album">
            <h5>Escucha o compra este álbum:</h5>
            <div class="links-album">
                @foreach ($album['links'] as $link)
                <a href="{{ $link['url'] }}">{{ $link['name'] }}</a>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <div id="data-album">
        <h1>{{ $album['name'] }}</h1>
        <h2>{{ $album['artists'] }}</h2>
        <p>{{ $album['type'] }}</p>

        @if ($album['genres'])
        <div id="genres-album">
            @foreach ($album['genres'] as $genre)
            <a href="{{ route('genre.show', $genre['id']) }}">{{ $genre['name'] }}</a>
            @endforeach
        </div>
        @endif

        <div id="options-album">
            <button type="button" id="btn-tracks-album">Tracks</button>
            <button type="button" id="btn-video-album">Video promocional</button>
        </div>

        @if ($album['tracks'])
        <div id="tracks">
            <div id="btns-discs">
                @foreach ($album['tracks'] as $disc)
                <button id="disc-{{ $loop->iteration }}" class="btn-tracks">Disco {{ $loop->iteration }}</button>
                @endforeach
            </div>

            @foreach ($album['tracks'] as $disc)
            <ol type="1" id="tracks-disc-{{ $loop->iteration }}" class="tracks-disc">
                @foreach ($disc as $track)
                @if ($track['id'])
                <li>
                    <a href="{{ route('song.show', $track['id']) }}">
                        <p><span class="name-track">{{ $track['name'] }}</span><span>{{ $track['duration'] }}</span></p>
                        <p class="track-artist">{{ $track['artists'] }}</p>
                    </a>
                </li>
                @endif
                @endforeach
            </ol>
            @endforeach
        </div>
        @endif

        @if ($album['pv'])
        <div id="video-album">
            @if ($album['pv']['service'] === 'NicoNicoDouga')
            <iframe src="https://embed.nicovideo.jp/watch/{{ $album['pv']['url'] }}" frameborder="0"></iframe>
            @else
            <iframe src="https://www.youtube.com/embed/{{ $album['pv']['url'] }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"></iframe>
            @endif
        </div>
        @endif
    </div>
</div>
@endsection