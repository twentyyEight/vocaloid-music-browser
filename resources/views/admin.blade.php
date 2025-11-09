<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
</head>

<body>
    <h1>AdminPage</h1>

    <table>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role }}</td>
                <td>{{ $user->created_at }}</td>
                <td>{{ $user->updated_at }}</td>
                <td><input type="checkbox" name="checkbox" id="{{ $user->id }}"></td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('logout') }}">Log out</a>
</body>

</html>