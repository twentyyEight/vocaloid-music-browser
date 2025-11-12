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

    public function index($id)
    {
        $genre = $this->genreService->getGenreById($id);
        return view('api.genre', ['genre' => $genre]);
    }
}
