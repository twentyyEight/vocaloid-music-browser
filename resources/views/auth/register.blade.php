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
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <input type="text" name="name" placeholder="username" value="{{ old('name') }}"><br>
        <input type="email" name="email" placeholder="email" value="{{ old('email') }}"><br>
        <input type="password" name="password" placeholder="password" value="{{ old('password') }}"><br>
        <input type="submit" name="sign up" value="sign up">
    </form>
</body>

</html>