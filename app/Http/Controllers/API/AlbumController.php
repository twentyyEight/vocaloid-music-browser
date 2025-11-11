<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Services\AlbumService;
use Illuminate\Support\Facades\Auth;
use App\Models\FavoriteAlbums;

class AlbumController extends Controller
{

    public function index($id, AlbumService $albumService)
    {
        $album = $albumService->getAlbumById($id);

        if (Auth::check()) {

            $userId = Auth::id();
            $isFavorite = FavoriteAlbums::where('user_id', $userId)->where('album_id', $id)->exists();
        } else {
            $isFavorite = false;
        }

        return view('api.album', ['album' => $album, 'isFavorite' => $isFavorite]);
    }

    // temporal
    public function show($id, AlbumService $albumService)
    {
        $album = $albumService->getAlbumById($id);
        return $album;
    }
}
