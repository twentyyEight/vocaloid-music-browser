@extends('app')

@section('content')
<div class="password-page">

    <form action="{{ route('password.update') }}" method="POST">
        <h1>Restablecer contraseña</h1>
        @csrf

        @error('error')
        <div class="alert alert-danger" role="alert">
            <div>
                {{ $message }}
            </div>
        </div>
        @enderror

        <input type="hidden" name="token" value="{{ $token }}">
        <input type="email" name="email" placeholder="Ingresa tu correo" required>
        @error('email')
        <p class="error">{{ $message }}</p>
        @enderror
        <input type="password" name="password" placeholder="Nueva contraseña" required>
        @error('password')
        <p class="error">{{ $message }}</p>
        @enderror
        <input type="password" name="password_confirmation" placeholder="Confirmar contraseña" required>
        @error('password')
        <p class="error">{{ $message }}</p>
        @enderror
        <button type="submit">Restablecer contraseña</button>
    </form>
</div>
@endsection