<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User</title>
</head>

<body data-id="{{ $id }}">
    <h1 id="name"></h1>

    <h2>Favorite Songs:</h2>
    <div id="songs"></div>

    <h2>Favorite Albums:</h2>
    <div id="albums"></div>

    <h2>Favorite Artists:</h2>
    <div id="artists"></div>

    @auth
    <a href="{{ route('logout') }}">Log out</a>
    @endauth

    <script type="module" src="{{ asset('js/user.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</body>

</html>