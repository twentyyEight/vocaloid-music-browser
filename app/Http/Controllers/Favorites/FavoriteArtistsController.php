<?php

namespace App\Http\Controllers\Favorites;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Services\ArtistService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\FavoriteArtists;

class FavoriteArtistsController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store($id, ArtistService $artistService)
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
