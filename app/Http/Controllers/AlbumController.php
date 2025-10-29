<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AlbumService;

class AlbumController extends Controller
{

    protected $albumService;

    public function __construct(AlbumService $albumService)
    {
        $this->albumService = $albumService;
    }

    public function show($id)
    {
        $album = $this->albumService->getAlbumById($id);
        return response()->json($album);
    }


    public function index($id)
    {
        return view('album', ['id' => $id]);
    }
}
