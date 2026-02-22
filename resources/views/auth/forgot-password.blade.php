@extends('app')

@section('content')
<div class="password-page">

    <form action="{{ route('password.email') }}" method="POST">
        <h1>Recuperar contraseña</h1>
        @csrf

        @error('error')
        <div class="alert alert-danger" role="alert">
            <div>
                {{ $message }}
            </div>
        </div>
        @enderror

        @if (session('status'))
        <div class="alert alert-success" role="alert">
            <p>Correo enviado con éxito</p>
        </div>
        @endif

        <input type="email" name="email" placeholder="Ingresa tu correo" required>
        @error('email')
        <p class="error">{{ $message }}</p>
        @enderror
        <button type="submit">Enviar link de restablecimiento</button>
    </form>
</div>
@endsection