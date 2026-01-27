@extends('app')

@section('content')
<div class="title-page">
    <h1>GÉNEROS</h1>
    <p>{{ $total }} resultados</p>
</div>

<div id="page-genres">

    <form action="{{ route('genre.index') }}" method="GET" id="form">
        <x-input-name :value="request('name', '')" />

        <input type="hidden" name="page" id="page" value="{{ $page }}">
    </form>

    <div id="genres">
        @foreach ($genres as $genre)
        <a href="{{ route('genre.show', $genre['id']) }}">
            <div class="genre-container" style="--genre-color: {{ $genre['color'] }};">
                @if ($genre['img'])
                <img src="{{ $genre['img'] }}" alt="{{ $genre['name'] }}">
                @endif
                <p>{{ $genre['name'] }}</p>
            </div>
        </a>
        @endforeach
    </div>
</div>
<x-pagination :page="$page" :pages="$pages" />
@endsection

@push('scripts')
@vite('resources/js/index.js')
@endpush