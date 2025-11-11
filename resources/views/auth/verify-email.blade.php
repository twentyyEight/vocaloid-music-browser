<h1>Verificación de correo</h1>
<p>Se ha enviado un enlace de verificación a tu correo.</p>

<form method="POST" action="{{ route('verification.send') }}">
    @csrf
    <button type="submit">Reenviar enlace</button>
</form>

