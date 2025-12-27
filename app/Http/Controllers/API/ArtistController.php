<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Services\ArtistService;
use Illuminate\Support\Facades\Auth;
use App\Models\FavoriteArtists;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Http;

class ArtistController extends Controller
{
    public function index(ArtistService $artistService, Request $request)
    {
        $page = $request->get('page', 1);
        $name = $request->input('name', null);
        $type = $request->input('type', null);
        $sort = $request->input('sort', 'FollowerCount');
        $genres = $request->input('genres') ?: [];

        $data = $artistService->getArtists($page, $type, $sort, $genres, $name);

        $artists = $data['artists'];
        $pages = $data['pages'];
        $total = $data['total'];

        return view('content.artists.index', compact('artists', 'page', 'pages', 'total'));
    }

    public function show($id, ArtistService $artistService)
    {
        $artist = $artistService->getArtistById($id);

        if (Auth::check()) {

            $userId = Auth::id();
            $isFavorite = FavoriteArtists::where('user_id', $userId)->where('artist_id', $id)->exists();
        } else {
            $isFavorite = false;
        }

        return view('api.artists.show', ['artist' => $artist, 'isFavorite' => $isFavorite]);
    }

    public function storeFavorite($id, ArtistService $artistService)
    {
        try {
            $userId = Auth::id();

            $artist = $artistService->getArtistById($id);

            FavoriteArtists::create([
                'user_id' => $userId,
                'artist_id' => $id,
                'name' => $artist['name'],
                'img' => $artist['img']
            ]);

            return back()->with('success', 'Guardado exitoso');
        } catch (\Exception $e) {

            Log::error($e->getMessage());
            return back()->with('error', 'Error al guardar');
        }
    }

    public function destroyFavorite($artistId)
    {
        $userId = Auth::id();

        $deleted = FavoriteArtists::where('user_id', $userId)
            ->where('artist_id', $artistId)
            ->delete();


        if ($deleted === 0) {
            return back()->with('error', 'Error al eliminar el artista.');
        }

        return back()->with('success', 'Artista eliminado correctamente.');
    }

    public function autocomplete($query, ArtistService $artistService)
    {
        $sugg = $artistService->autocomplete($query);
        return $sugg;
    }
}
