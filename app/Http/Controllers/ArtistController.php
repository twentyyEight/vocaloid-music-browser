<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ArtistService;

class ArtistController extends Controller
{

    protected $artistService;

    public function __construct(ArtistService $artistService)
    {
        $this->artistService = $artistService;
    }

    public function show($id)
    {
        $artist = $this->artistService->getArtistById($id);
        return response()->json($artist);
    }

    public function index($id)
    {
        return view('artist', ['id' => $id]);
    }
}
