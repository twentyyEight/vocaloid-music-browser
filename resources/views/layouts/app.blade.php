<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vocaloid Music Browser</title>
</head>

<body>
    <nav style="background-color: gray;">
        <ul>
            @guest
            <li><a href="{{ route('register') }}">Registro</a></li>
            <li><a href="{{ route('login') }}">Iniciar Sesión</a></li>
            @endguest

            @auth
            <li>
                <a href="{{ route('logout') }}">Log out</a>
            </li>
            @endauth
        </ul>
    </nav>

    @yield('content')

</body>

</html>