@extends('layouts.app')

@section('content')
<input type="text" placeholder="Buscar artista..." id="search">

<p style="display: none;" id="loading">Cargando resultados...</p>

<div class="artists">
    @foreach ($artists as $artist)
    <a href="{{ route('artist.show', $artist['id']) }}">{{ $artist['name'] }}</a>
    @endforeach
</div>

<x-pagination :page="$page" :pages="$pages" />
@endsection

@push('scripts')
<script></script>
@endpush