@extends('app')

@section('content')
<div class="register-login-page">
    <form action="{{ route('logincheck') }}" method="post">
        <h1>Iniciar sesión</h1>
        @csrf
        <input type="email" name="email" placeholder="Correo electrónico" value="{{ old('email') }}">
        @error('email')
        <p class="error">{{ $message }}</p>
        @enderror
        <input type="password" name="password" placeholder="Contraseña" value="{{ old('password') }}"><br>
        @error('password')
        <p class="error">{{ $message }}</p>
        @enderror
        <a href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
        <button type="submit">Iniciar sesión</button>

    </form>
</div>
@endsection