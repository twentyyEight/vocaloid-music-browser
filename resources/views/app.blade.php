<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vocaloid Music Browser</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Syriac:wght@100..900&display=swap" rel="stylesheet">

    <link rel="stylesheet"
        href="{{ Vite::asset('node_modules/jquery-ui/dist/themes/base/jquery-ui.min.css') }}">

    @vite([
    'resources/js/app.js'
    ])

    @stack('styles')
    @stack('scripts')

</head>

<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('home') }}">vocaloid music browser</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse ms-auto" id="navbarNavDropdown">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Explorar
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('song.index') }}">Canciones</a></li>
                            <li><a class="dropdown-item" href="{{ route('album.index') }}">Albumes</a></li>
                            <li><a class="dropdown-item" href="{{ route('artist.index') }}">Artistas</a></li>
                            <li><a class="dropdown-item" href="{{ route('genre.index') }}">Géneros</a></li>
                        </ul>
                    </li>
                    @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Iniciar Sesión</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Registrarse</a>
                    </li>
                    @endguest

                    @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('profile', ['id' => auth()->id()]) }}">Perfil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}">Cerrar Sesión</a>
                    </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div id="content">
        @yield('content')
    </div>

    <script src="{{ Vite::asset('node_modules/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ Vite::asset('node_modules/jquery-ui/dist/jquery-ui.min.js') }}"></script>

</body>

</html>