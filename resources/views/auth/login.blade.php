@extends('app')

@section('content')
<div class="register-login-page">
    <form action="{{ route('logincheck') }}" method="post">
        <h1>Iniciar sesión</h1>
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
        <input type="email" name="email" placeholder="Correo electrónico" value="{{ old('email') }}"><br>
        <input type="password" name="password" placeholder="Contraseña" value="{{ old('password') }}"><br>
        <a href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
        <button type="submit">Iniciar sesión</button>

    </form>
</div>
@endsection