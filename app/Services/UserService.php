<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function getUserById($id)
    {
        $user = User::select('name', 'favorite_songs', 'favorite_albums', 'favorite_artists')->find($id);

        if (!$user) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        return response()->json($user);
    }
}
