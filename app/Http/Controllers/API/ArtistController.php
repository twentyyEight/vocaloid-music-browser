<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Services\ArtistService;

class ArtistController extends Controller
{

    protected $artistService;

    public function __construct(ArtistService $artistService)
    {
        $this->artistService = $artistService;
    }

    // temporal
    public function show($id)
    {
        $artist = $this->artistService->getArtistById($id);
        return response()->json($artist);
    }

    public function index($id)
    {
        $artist = $this->artistService->getArtistById($id);
        return view('artist', ['artist' => $artist]);
    }
}
