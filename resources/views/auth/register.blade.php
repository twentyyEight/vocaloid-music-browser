@extends('app')

@section('content')
<div class="register-login-page">
    <form action="{{ route('registercheck') }}" method="post">
        <h1>Crear cuenta</h1>
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
        <input type="text" name="name" placeholder="Nombre de usuario" value="{{ old('name') }}"><br>
        <input type="email" name="email" placeholder="Correo electrónico" value="{{ old('email') }}"><br>
        <input type="password" name="password" placeholder="Contraseña (mínimo 8 caracteres)" value="{{ old('password') }}"><br>
        <button type="submit">Registrarse</button>
    </form>
</div>
@endsection