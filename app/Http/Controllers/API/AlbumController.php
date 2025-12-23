<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Services\AlbumService;
use Illuminate\Support\Facades\Auth;
use App\Models\FavoriteAlbums;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Http;

class AlbumController extends Controller
{

    public function index(AlbumService $albumService, Request $request)
    {
        $page = $request->get('page', 1);
        $name = $request->input('name', null);
        $type = $request->input('type', 'Unknown');
        $genres = $request->input('genres') ?: [];
        $artists = $request->input('artists') ?: [];
        $beforeDate = $request->input('beforeDate', null);
        $afterDate = $request->input('afterDate', null);
        $sort = $request->input('sort', 'ReleaseDate');

        $data = $albumService->getAlbums($page, $name, $type, $genres, $artists, $beforeDate, $afterDate, $sort);

        $albums = $data['albums'];
        $pages = $data['pages'];
        $total = $data['total'];

        return view('api.albums.index', compact('albums', 'page', 'pages', 'total'));
    }

    public function show($id, AlbumService $albumService)
    {
        $album = $albumService->getAlbumById($id);

        if (Auth::check()) {

            $userId = Auth::id();
            $isFavorite = FavoriteAlbums::where('user_id', $userId)->where('album_id', $id)->exists();
        } else {
            $isFavorite = false;
        }

        return view('api.albums.show', ['album' => $album, 'isFavorite' => $isFavorite]);
    }

    public function storeFavorite($id, AlbumService $albumService)
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

    public function destroyFavorite($albumId)
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

    public function autocomplete($query, AlbumService $albumService)
    {
        $sugg = $albumService->autocomplete($query);
        return $sugg;
    }
}
