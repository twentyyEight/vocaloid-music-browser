<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <form action="{{ route('registercheck') }}" method="post">
        @csrf
        <input type="text" name="name"><br>
        <input type="email" name="email"><br>
        <input type="password" name="password"><br>
        <input type="submit" name="sign up" value="sign up">
    </form>
</body>
</html>