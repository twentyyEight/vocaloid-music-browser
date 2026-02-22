@extends('app')

@section('content')
<div class="register-login-page">
    <form action="{{ route('logincheck') }}" method="post">
        @csrf

        <h1>Iniciar sesión</h1>

        @error('login')
        <div class="alert alert-danger" role="alert">
            <div>
                {{ $message }}
            </div>
        </div>
        @enderror

        @if (session('status'))
        <div class="alert alert-success" role="alert">
            <p>Contraseña restablecida con éxito</p>
        </div>
        @endif

        <input type="email" name="email" placeholder="Correo electrónico" value="{{ old('email') }}" required>
        @error('email')
        <p class="error">{{ $message }}</p>
        @enderror

        <input type="password" name="password" placeholder="Contraseña" value="{{ old('password') }}" required>
        @error('password')
        <p class="error">{{ $message }}</p>
        @enderror

        <a id="forgot-password" href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>

        <button type="submit">Iniciar sesión</button>

        <a class="redirect" href="{{ route('register') }}">¿No tienes una cuenta? Regístraste</a>

    </form>
</div>
@endsection