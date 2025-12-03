@extends('app')

@section('content')
<div id="container">

    <h1>Géneros</h1>

    <form action="{{ route('genre.index') }}" method="GET">
        <input type="text" placeholder="Buscar por nombre..." name="query">
        <button type="submit">Buscar</button>
    </form>

    <div id="genres">
        @foreach ($genres as $genre)
        <a href="{{ route('genre.show', $genre['id']) }}">

            @if ($genre['img'])
            <div id="genre-container">
                <img src="{{ $genre['img'] }}" alt="{{ $genre['name'] }}">
                <p id="genre-name">{{ $genre['name'] }}</p>
            </div>
            @else
            @php
            $color = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
            @endphp

            <div id="genre-container" style="background-color: {{ $color }};">
                <p id="genre-name">{{ $genre['name'] }}</p>
            </div>
            @endif
        </a>
        @endforeach
    </div>

    <x-pagination :page="$page" :pages="$pages" />
</div>
@endsection

@vite('resources/js/index.js')
@vite(['resources/css/genres.css'])