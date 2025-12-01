<?php

namespace App\Http\Controllers;

use App\Services\SongService;
use App\Services\AlbumService;

class HomeController extends Controller
{
    public function index(SongService $songService, AlbumService $albumService) 
    {
        $songs = $songService->getNewAndTopSongs();
        $albums = $albumService->getNewAndTopAlbums();

        return view('home', compact($songs, $albums));
    }
}
