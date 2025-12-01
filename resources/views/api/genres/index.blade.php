@extends('layouts.app')

@section('content')
<form action="{{ route('genre.index') }}" method="GET">
    <input type="text" placeholder="Buscar género..." name="query">
    <button type="submit">Buscar</button>
</form>

<div class="genres">
    @foreach ($genres as $genre)
    <a href="{{ route('genre.show', $genre['id']) }}">{{ $genre['name'] }}</a>
    @endforeach
</div>

<x-pagination :page="$page" :pages="$pages" />
@endsection