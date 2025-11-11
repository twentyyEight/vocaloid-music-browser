<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Services\SongService;
use App\Models\FavoriteSongs;
use Illuminate\Support\Facades\Auth;

class SongController extends Controller
{

    // nombrar como show dps
    public function index($id, SongService $songService)
    {
        $song = $songService->getSongById($id);

        if (Auth::check()) {

            $userId = Auth::id();
            $isFavorite = FavoriteSongs::where('user_id', $userId)->where('song_id', $id)->exists();
            
        } else {
            $isFavorite = false;
        }

        return view('api.song', ['song' => $song, 'isFavorite' => $isFavorite]);
    }

    // temporal
    public function show($id, SongService $songService)
    {
        $song = $songService->getSongById($id);
        return $song;
    }
}
