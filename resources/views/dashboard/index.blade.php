@extends('app')

@section('content')
<div id="page-dashboard" class="page" data-page="dashboard">
    <h1>Administración de usuarios</h1>

    @foreach (['success' => 'success', 'error' => 'danger'] as $key => $type)
    @if (session($key))
    <x-alert :type="$type" :message="session($key)" />
    @endif
    @endforeach

    <div id="container-table">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Creación</th>
                    <th>Actualización</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    @if ($user->role == 0)
                    <td>Usuario</td>
                    @else
                    <td>Administrador</td>
                    @endif
                    <td>{{ $user->created_at }}</td>
                    <td>{{ $user->updated_at }}</td>

                    <td id="btns-dashboard">
                        <button type="button" class="btn-dashboard edit" data-id="{{ $user->id }}" data-name="{{ $user->name }}" data-email="{{ $user->email }}" data-role="{{ $user->role }}">
                            <i class="bi bi-pencil-fill"></i>
                            <span>Editar</span>
                        </button>

                        <form action="{{ route('dashboard.delete', $user->id) }}" method="POST" class="btn-dashboard delete">
                            @csrf
                            @method('DELETE')
                            <i class="bi bi-trash3-fill"></i>
                            <button type="submit">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

<!-- Edit user modal -->
<div id="background-modal-dashboard">
    <div id="modal-dashboard">

        <div style="display: none;" class="edit-error {{ $errors->any() ? 'true' : 'false' }}"></div>

        <form action="" method="POST" id="form-edit-user">
            @csrf
            @method('PATCH')

            <div id="header-form">
                <h1>Editar usuario</h1>
                <button type="button" class="btn-close" aria-label="Close"></button>
            </div>

            <label for="name">Nombre</label>
            <input type="text" name="name" value="{{ $user->name }}" id="name-user">
            @error('name')
            <p class="error">{{ $message }}</p>
            @enderror

            <label for="email">Email</label>
            <input type="email" name="email" value="{{ $user->email }}" id="email-user">
            @error('email')
            <p class="error">{{ $message }}</p>
            @enderror

            <label for="role">Rol</label>
            <select name="role" id="role-user">
                <option value="0" {{ $user->role == 0 ? 'selected' : '' }}>Usuario</option>
                <option value="1" {{ $user->role == 1 ? 'selected' : '' }}>Administrador</option>
            </select>
            @error('role')
            <p class="error">{{ $message }}</p>
            @enderror

            <input type="submit" value="Guardar cambios" id="btn-edit-user">
        </form>
    </div>
</div>