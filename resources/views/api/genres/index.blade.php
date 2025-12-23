@extends('app')

@section('content')
<div id="container">

    <h1>Géneros</h1>
    <p>{{ $total }} resultados</p>

    <form action="{{ route('genre.index') }}" method="GET">
        <x-input-name :value="request('name', '')" />

        <input type="hidden" name="page" id="page" value="{{ $page }}">
    </form>

    <div id="genres">
        @foreach ($genres as $genre)
        <a href="{{ route('genre.show', $genre['id']) }}">

            @php
            $color = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
            @endphp

            <div class="genre-container" style="background-color: {{ $color }};">
                <p>{{ $genre['name'] }}</p>
            </div>
        </a>
        @endforeach
    </div>

    <x-pagination :page="$page" :pages="$pages" />
</div>
@endsection

@push('styles')
@vite(['resources/scss/genres/index.scss', 'resources/scss/form.scss'])
@endpush

@push('scripts')
@vite('resources/js/index.js')
@endpush