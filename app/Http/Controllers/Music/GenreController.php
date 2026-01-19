<?php

namespace App\Http\Controllers\Music;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Services\GenreService;
use Illuminate\Support\Facades\Http;

class GenreController extends Controller
{

    public function index(GenreService $genreService, Request $request)
    {
        $page = $request->get('page', 1);

        $query = $request->input('name', '');

        $data = $genreService->getGenres($page, $query);
        $genres = $data['genres'];
        $pages = $data['pages'];
        $total = $data['total'];

        return view('music.genres.index', compact('genres', 'pages', 'page', 'total'));
    }

    public function show($id, GenreService $genreService)
    {
        $genre = $genreService->getGenreById($id);

        return view('music.genres.show', ['genre' => $genre]);
    }

    public function autocomplete($query, GenreService $genreService)
    {
        $sugg = $genreService->autocomplete($query);
        return $sugg;
    }
}
