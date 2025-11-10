<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\FavoriteSongs;
use App\Models\FavoriteAlbums;
use App\Models\FavoriteArtists;

class ProfileController extends Controller
{

    public function index($id)
    {
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
    }

    public function show($id)
    {
        //
    }

    public function store(Request $request)
    {
        //
    }
}
