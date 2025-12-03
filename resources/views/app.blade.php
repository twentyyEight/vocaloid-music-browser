<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vocaloid Music Browser</title>
</head>

<body>
    <nav>
        <div id="nav-header">
            <a href="{{ route('home') }}">vocaloid music browser</a>

            <img src="{{ asset('images/menu.png') }}" alt="menu" id="menu" class="nav-icon">
            <img src="{{ asset('images/x.png') }}" alt="close" id="close" class="nav-icon">
        </div>

        <ul id="nav-content">
            @guest
            <li class="nav-item"><a href="{{ route('register') }}">Registro</a></li>
            <li class="nav-item"><a href="{{ route('login') }}">Iniciar Sesión</a></li>
            @endguest

            @auth
            <li class="nav-item"><a href="{{ route('profile', ['id' => auth()->id()]) }}">Perfil</a></li>
            <li class="nav-item"><a href="{{ route('logout') }}">Log out</a></li>
            @endauth

            <li id="explorar">
                <a class="nav-item" href="#" id="explorar-header">
                    <span>Explorar</span>
                    <img src="{{ asset('images/flecha.png') }}" alt="down" id="arrow">
                </a>
                <ul id="explorar-dropdown">
                    <a href="{{ route('song.index') }}">Canciones</a>
                    <a href="{{ route('album.index') }}">Albumes</a>
                    <a href="{{ route('artist.index') }}">Artistas</a>
                    <a href="{{ route('genre.index') }}">Géneros</a>
                </ul>
            </li>
        </ul>
    </nav>
    @yield('content')

    @vite(['resources/js/app.js', 'resources/js/nav.js', 'resources/scss/nav.scss'])
</body>

</html>