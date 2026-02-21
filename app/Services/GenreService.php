<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;

class GenreService
{
    public function getGenreById($id)
    {
        try {
            // Llamada a API
            $responses = Http::pool(fn($pool) => [

                // Info. el género
                $pool->as('genre')->get("https://vocadb.net/api/tags/{$id}", [
                    'fields' => 'Description,MainPicture',
                    'lang' => 'Romaji'
                ]),

                // Canciones del género
                $pool->as('songs')->get("https://vocadb.net/api/songs", [
                    'tagId[]' => $id,
                    'maxResults' => 6,
                    'sort' => 'RatingScore',
                    'fields' => 'MainPicture',
                    'lang' => 'Romaji'
                ]),

                // Artistas populares del género
                $pool->as('artists')->get("https://vocadb.net/api/artists", [
                    'artistTypes' => 'Producer',
                    'tagId[]' => $id,
                    'maxResults' => 10,
                    'sort' => 'FollowerCount',
                    'fields' => 'MainPicture',
                    'lang' => 'Romaji'
                ]),

                // Albumes populares del género
                $pool->as('albums')->get("https://vocadb.net/api/albums", [
                    'discTypes' => 'Album',
                    'tagId[]' => $id,
                    'maxResults' => 8,
                    'sort' => 'RatingTotal',
                    'fields' => 'MainPicture',
                    'lang' => 'Romaji'
                ]),
            ]);

            $resultados = [
                'genre' => $responses['genre']->json(),
                'songs' => $responses['songs']->json(),
                'artists' => $responses['artists']->json(),
                'albums' => $responses['albums']->json(),
            ];

            $json = response()->json($resultados);
            $res = $json->original;

            // Canciones
            $songs = [];
            foreach ($res['songs']['items'] as $song) {

                $songs[] = [
                    'name' => $song['name'],
                    'artists' => $song["artistString"],
                    'img' => $song['mainPicture']['urlOriginal'] ?? null,
                    'id' => $song['id']
                ];
            }

            // Artistas
            $artists = [];
            foreach ($res['artists']['items'] as $artist) {

                $artists[] = [
                    'name' => $artist['name'],
                    'img' => $artist['mainPicture']['urlThumb'] ?? null,
                    'id' => $artist['id']
                ];
            }

            // Albumes
            $albums = [];
            foreach ($res['albums']['items'] as $album) {

                $albums[] = [
                    'name' => $album['name'],
                    'artists' => $album["artistString"],
                    'img' => $album['mainPicture']['urlThumb'] ?? null,
                    'id' => $album['id'],
                ];
            }

            // Color
            $color = '#' . substr(md5($id), 0, 6);

            return [
                'id' => $res['genre']['id'],
                'name' => $res['genre']['name'] ?? null,
                'img' => $res['genre']['mainPicture']['urlOriginal'] ?? null,
                'songs' => empty($songs) ? null : $songs,
                'albums' => empty($albums) ? null : $albums,
                'artists' => empty($artists) ? null : $artists,
                'color' => $color
            ];
        } catch (RequestException $e) {

            logger()->error($e->getMessage());

            if ($e->response->status() === 404) {
                abort(404, 'No se ha encontrado la canción');
            }

            abort(500, 'Error al obtener la canción.');
        }
    }

    public function getGenres($page, $query)
    {
        try {
            $start = ($page - 1) * 100;

            $res = Http::get("https://vocadb.net/api/tags", [
                'categoryName' => 'Genres',
                'maxResults' => 100,
                'start' => $start,
                'lang' => 'Romaji',
                'fields' => 'MainPicture',
                'query' => $query,
                'nameMatchMode' => 'StartsWith',
                'getTotalCount' => 'true'
            ]);

            $items = $res['items'];
            $genres = [];

            foreach ($items as $item) {
                $genres[] = [
                    'id' => $item['id'],
                    'name' => $item['name'],
                    'img' => $item['mainPicture']['urlOriginal'] ?? null,
                    'color' => '#' . substr(md5($item['id']), 0, 6)
                ];
            }

            $total = $res['totalCount'];

            return [
                'genres' => $genres,
                'pages' => ceil($total / 100),
                'total' => $total
            ];
        } catch (RequestException $e) {

            logger()->error($e->getMessage());
            abort(500, 'Error al obtener las canciones.');
        }
    }
}
