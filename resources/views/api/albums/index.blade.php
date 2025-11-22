@extends('layouts.app')

@section('content')
<input type="text" placeholder="Buscar album..." id="search">

<p style="display: none;" id="loading">Cargando resultados...</p>

<div class="albums">
    @foreach ($albums as $album)
    <a href="{{ route('album.show', $album['id']) }}">{{ $album['name'] }} ({{ $album['type'] }})</a>
    @endforeach
</div>

<x-pagination :page="$page" :pages="$pages" />
@endsection

@push('scripts')
<script></script>
@endpush