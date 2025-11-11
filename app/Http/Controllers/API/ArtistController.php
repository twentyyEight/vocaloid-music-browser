<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Services\ArtistService;
use Illuminate\Support\Facades\Auth;
use App\Models\FavoriteArtists;

class ArtistController extends Controller
{
    // temporal
    public function show($id, ArtistService $artistService)
    {
        $artist = $artistService->getArtistById($id);
        return response()->json($artist);
    }

    public function index($id, ArtistService $artistService)
    {
        $artist = $artistService->getArtistById($id);

        if (Auth::check()) {

            $userId = Auth::id();
            $isFavorite = FavoriteArtists::where('user_id', $userId)->where('artist_id', $id)->exists();
        } else {
            $isFavorite = false;
        }

        return view('api.artist', ['artist' => $artist, 'isFavorite' => $isFavorite]);
    }
}
