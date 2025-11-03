<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <form action="{{ route('logincheck') }}" method="post">
        @csrf
        <input type="email" name="email"><br>
        <input type="password" name="password"><br>
        <input type="submit" name="login" value="login">
    </form>
</body>

</html>