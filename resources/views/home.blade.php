@extends('app')

@section('content')
<h1>Home Page</h1>

<button type="button" value="songs" style="background-color: red;">Canción</button>
<button type="button" value="albums">Album</button>
<button type="button" value="artists">Artista</button>
<button type="button" value="genres">Genero</button>

<input type="text" id="search">
<p style="display: none;">Buscando...</p>

@endsection