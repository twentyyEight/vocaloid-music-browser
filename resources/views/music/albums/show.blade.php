@extends('app')

@section('content')
<div id="page-album">
    @if(session('success'))
    <p>{{ session('success') }}</p>
    @endif

    @if(session('error'))
    <p>{{ session('error') }}</p>
    @endif

    <div id="info-album">
        <img src="{{ $album['img'] }}" alt="{{ $album['name'] }}">

        <div id="data-album">
            <h1>{{ $album['name'] }}</h1>
            <h2>{{ $album['artists'] }}</h2>
            <p>{{ $album['type'] }}</p>

            @if ($album['genres'])
            <div>
                @foreach ($album['genres'] as $genre)
                <a href="{{ route('genre.show', $genre['id']) }}">{{ $genre['name'] }}</a>@if (!$loop->last), @endif
                @endforeach
            </div>
            @endif

            <div id="options-album">
                <button>Tracks</button>
                <button>Video promocional</button>
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
                            {{ $track['name'] }}
                            <br>
                            <span class="track-artist">{{ $track['artists'] }}</span>
                        </a>
                    </li>
                    @endif
                    @endforeach
                </ol>
                @endforeach
            </div>
            @endif

            <!-- @if ($album['pv'])
            <div id="video-album">
                @if ($album['pv']['service'] === 'NicoNicoDouga')
                <iframe src="https://embed.nicovideo.jp/watch/{{ $album['pv']['url'] }}" frameborder="0"></iframe>
                @else
                <iframe src="https://www.youtube.com/embed/{{ $album['pv']['url'] }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"></iframe>
                @endif
            </div>
            @endif -->

            <div id="btns-album">
                @if ($album['links'])
                <!-- <button type="button" data-bs-toggle="modal" data-bs-target="#linksModal" id="btn-links">
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
                </div> -->
                @endif

                <x-favorite-btn entity="album" :id="$album['id']" :isFavorite="$isFavorite" />
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@vite(['resources/js/album.js'])
@endpush