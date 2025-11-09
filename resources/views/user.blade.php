<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User</title>
</head>

<body>

    <h1 id="name">{{ $user['name'] }}</h1>

    @if ($isUserProfile)
    <button type="button">Acción especial</button>
    @endif

    <h2>Favorite Songs:</h2>
    <div>
        {{ $songs }}
    </div>

    <h2>Favorite Albums:</h2>
    <div></div>

    <h2>Favorite Artists:</h2>
    <div></div>

    @auth
    <a href="{{ route('logout') }}">Log out</a>
    @endauth

    <!-- <script type="module" src="{{ asset('js/user.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script> -->
</body>

</html>