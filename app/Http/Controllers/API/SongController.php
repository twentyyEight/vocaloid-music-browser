<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Services\SongService;
use App\Models\FavoriteSongs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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

    public function store($id, SongService $songService)
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

    public function destroy($songId)
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
}
