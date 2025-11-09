<?php

namespace App\Http\Controllers\Favorites;
use App\Http\Controllers\Controller;

use App\Models\FavoriteSongs;
use App\Services\SongService;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class FavoriteSongsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FavoriteSongs $favoriteSongs)
    {
        //
    }
}
