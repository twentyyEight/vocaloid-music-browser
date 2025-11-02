<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GenreService;

class GenreController extends Controller
{
    protected $genreService;

    public function __construct(GenreService $genreService)
    {
        $this->genreService = $genreService;
    }

    public function show($id)
    {
        $genre = $this->genreService->getGenreById($id);
        return response()->json($genre);
    }

    public function index($id)
    {
        return view('genre', ['id' => $id]);
    }
}
