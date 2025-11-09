<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Services\AlbumService;

class AlbumController extends Controller
{

    public function index($id, AlbumService $albumService)
    {
        $album = $albumService->getAlbumById($id);
        return view('album', ['album' => $album]);
    }

    // temporal
    public function show($id, AlbumService $albumService)
    {
        $album = $albumService->getAlbumById($id);
        return $album;
    }
}
