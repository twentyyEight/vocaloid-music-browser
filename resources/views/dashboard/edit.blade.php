<h1>Edición de datos de usuario</h1>

@if(session('success'))
<p>{{ session('success') }}</p>
@endif

@if(session('error'))
<p>{{ session('error') }}</p>
@endif

<form action="{{ route('dashboard.patch', $user->id) }}" method="POST">
    @csrf
    @method('PATCH')

    <label for="name">Nombre</label>
    <input type="text" name="name" value="{{ $user->name }}">

    <label for="role">Rol</label>
    <select name="role" id="">
        <option value="0" {{ $user->role == 0 ? 'selected' : '' }}>Usuario</option>
        <option value="1" {{ $user->role == 1 ? 'selected' : '' }}>Administrador</option>
    </select>

    <input type="submit" value="Guardar cambios">
</form>