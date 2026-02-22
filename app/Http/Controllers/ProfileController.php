<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\FavoriteSongs;
use App\Models\FavoriteAlbums;
use App\Models\FavoriteArtists;
use Throwable;

class ProfileController extends Controller
{

    public function index($id)
    {
        try {
            $user = User::select('id', 'name')->findOrFail($id);
            
            $isUserProfile = Auth::id() == $id;

            $songs = FavoriteSongs::select('song_id', 'name', 'artists', 'img')
                ->where('user_id', '=', $id)
                ->get();

            $albums = FavoriteAlbums::select('album_id', 'name', 'artists', 'img')
                ->where('user_id', '=', $id)
                ->get();

            $artists = FavoriteArtists::select('artist_id', 'name', 'img')
                ->where('user_id', '=', $id)
                ->get();

            return view('profile', compact('user', 'isUserProfile', 'songs', 'albums', 'artists'));
            
        } catch (Throwable $e) {
            Log::error('Error al cargar perfil: ' . $e->getMessage(), ['exception' => $e]);

            return redirect()->route('home')->with(['error' => 'Perfil no encontrado']);
        }
    }
}
