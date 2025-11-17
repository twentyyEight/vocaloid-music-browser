<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Services\GenreService;
use Illuminate\Support\Facades\Http;

class GenreController extends Controller
{

    public function index(GenreService $genreService, Request $request)
    {
        $page = $request->get('page', 1);

        $genres = $genreService->getGenres($page);

        $pages = $genreService->pagination();

        return view('api.genres.index', compact('genres', 'page', 'pages'));
    }

    public function show($id, GenreService $genreService)
    {
        $genre = $genreService->getGenreById($id);
        return view('api.genres.show', ['genre' => $genre]);
    }

    public function autocomplete($query, GenreService $genreService)
    {
        $sugg = $genreService->autocomplete($query);
        return $sugg;
    }
}
