@extends('app')

@section('content')
<div class="register-login-page">
    <form action="{{ route('registercheck') }}" method="post">
        <h1>Crear cuenta</h1>
        @csrf
        <input type="text" name="name" placeholder="Nombre de usuario" value="{{ old('name') }}">
        @error('name')
        <p class="error">{{ $message }}</p>
        @enderror
        <input type="email" name="email" placeholder="Correo electrónico" value="{{ old('email') }}">
        @error('email')
        <p class="error">{{ $message }}</p>
        @enderror
        <input type="password" name="password" placeholder="Contraseña (mínimo 8 caracteres)" value="{{ old('password') }}">
        @error('password')
        <p class="error">{{ $message }}</p>
        @enderror
        <button type="submit">Registrarse</button>
        <a class="redirect" href="{{ route('login') }}">¿Ya tienes una cuenta? Inicia sesión</a>
    </form>
</div>
@endsection