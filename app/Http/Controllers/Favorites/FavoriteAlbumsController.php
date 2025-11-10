<?php

namespace App\Http\Controllers\Favorites;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Services\AlbumService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\FavoriteAlbums;

class FavoriteAlbumsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store($id, AlbumService $albumService)
    {
        try {
            $userId = Auth::id();

            $album = $albumService->getAlbumById($id);

            FavoriteAlbums::create([
                'user_id' => $userId,
                'album_id' => $id,
                'name' => $album['name'],
                'artists' => $album['artists'],
                'img' => $album['img']
            ]);

            return back()->with('success', 'Guardado exitoso');
        } catch (\Exception $e) {

            Log::error($e->getMessage());
            return back()->with('error', 'Error al guardar');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($albumId)
    {
        $userId = Auth::id();

        $deleted = FavoriteAlbums::where('user_id', $userId)
            ->where('album_id', $albumId)
            ->delete();


        if ($deleted === 0) {
            return back()->with('error', 'Error al eliminar el album.');
        }

        return back()->with('success', 'Album eliminado correctamente.');
    }
}
