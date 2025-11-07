<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SongService;

class SongController extends Controller
{

    protected $songService;

    public function __construct(SongService $songService)
    {
        $this->songService = $songService;
    }

    public function index($id)
    {
        return view('song', ['id' => $id]);
    }

    public function show($id)
    {
        $song = $this->songService->getSongById($id);
        return response()->json($song);
    }
}
