<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Services\GenreService;

class GenreController extends Controller
{
    protected $genreService;

    public function __construct(GenreService $genreService)
    {
        $this->genreService = $genreService;
    }

    // temporal
    public function show($id, GenreService $genreService)
    {
        $genre = $genreService->getGenreById($id);
        return response()->json($genre);
    }

    public function index($id)
    {
        $genre = $this->genreService->getGenreById($id);
        return view('genre', ['genre' => $genre]);
    }
}
