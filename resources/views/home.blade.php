<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
    <h1>Home Page</h1>
    @guest
    <a href="/register">Sign Up</a>
    <a href="/login">Login</a>
    @endguest

    <a href="/album/412">Album</a>
</body>
</html>
