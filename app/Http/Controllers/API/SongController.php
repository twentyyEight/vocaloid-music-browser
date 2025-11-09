<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Services\SongService;

class SongController extends Controller
{

    // nombrar como show dps
    public function index($id, SongService $songService)
    {
        $song = $songService->getSongById($id);
        return view('song', ['song' => $song]);
    }

    // temporal
    public function show($id, SongService $songService)
    {
        $song = $songService->getSongById($id);
        return $song;
    }
}
