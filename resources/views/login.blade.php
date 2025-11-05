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

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <input type="email" name="email" placeholder="email" value="{{ old('email') }}"><br>
        <input type="password" name="password" placeholder="password" value="{{ old('password') }}"><br>
        <input type="submit" name="login" value="login">
    </form>
</body>

</html>