<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Services\SongService;
use App\Services\ArtistService;
use App\Services\GenreService;
use App\Models\FavoriteSongs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Http;

class SongController extends Controller
{

    public function index(SongService $songService, Request $request)
    {
        // Obtener datos de formulario
        $page = $request->get('page', 1);
        $name = $request->input('name', null);
        $types = $request->input('types') ?: 'Unspecified,Original,Remaster,Remix,Cover,Arrangement,Instrumental,Mashup,Other,Rearrangement';
        
        $genres = $request->input('genres') ?: [];

        $artists = $request->input('artists') ?: [];
        $beforeDate = $request->input('beforeDate', null);
        $afterDate = $request->input('afterDate', null);

        // Llamado a API con datos del formulario
        $data = $songService->getSongs($page, $name, $types, $genres, $artists, $beforeDate, $afterDate);

        // Recepción datos API
        $songs = $data['songs'];
        $pages = $data['pages'];

        #dd($request->all());
        return view('api.songs.index', compact('songs', 'pages', 'page', 'genres', 'types'));
    }

    public function show($id, SongService $songService)
    {
        $song = $songService->getSongById($id);

        if (Auth::check()) {

            $userId = Auth::id();
            $isFavorite = FavoriteSongs::where('user_id', $userId)->where('song_id', $id)->exists();
        } else {
            $isFavorite = false;
        }

        return view('api.songs.show', ['song' => $song, 'isFavorite' => $isFavorite]);
    }

    public function storeFavorite($id, SongService $songService)
    {
        try {
            $userId = Auth::id();

            $song = $songService->getSongById($id);

            FavoriteSongs::create([
                'user_id' => $userId,
                'song_id' => $id,
                'name' => $song['name'],
                'artists' => $song['artists'],
                'img' => $song['img']
            ]);

            return back()->with('success', 'Guardado exitoso');
        } catch (\Exception $e) {

            Log::error($e->getMessage());
            return back()->with('error', 'Error al guardar');
        }
    }

    public function destroyFavorite($songId)
    {

        $userId = Auth::id();

        $deleted = FavoriteSongs::where('user_id', $userId)
            ->where('song_id', $songId)
            ->delete();


        if ($deleted === 0) {
            return back()->with('error', 'Error al eliminar la canción.');
        }

        return back()->with('success', 'Canción eliminada correctamente.');
    }

    public function autocomplete($query, SongService $songService)
    {
        $sugg = $songService->autocomplete($query);
        return $sugg;
    }
}
