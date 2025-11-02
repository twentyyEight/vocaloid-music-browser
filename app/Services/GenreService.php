<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GenreService
{
    public function getGenreById($id)
    {
        // Llamada a API y retorna respuesta en json
        $responses = Http::pool(fn($pool) => [
            $pool->as('genre')->get("https://vocadb.net/api/tags/{$id}?fields=Description,MainPicture&lang=Romaji"),
            $pool->as('songs')->get("https://vocadb.net/api/songs?songTypes=Original&tagId%5B%5D={$id}&status=Approved&maxResults=10&sort=RatingScore&fields=MainPicture&lang=Romaji"),
            $pool->as('artists')->get("https://vocadb.net/api/artists?artistTypes=Producers&tagId%5B%5D={$id}&status=Approved&maxResults=10&sort=FollowerCount&fields=MainPicture&lang=Romaji"),
            $pool->as('albums')->get("https://vocadb.net/api/albums?discTypes=Album&tagId%5B%5D={$id}&status=Approved&maxResults=10&sort=RatingTotal&fields=MainPicture&lang=Romaji"),
        ]);

        // Manejo de errores
        foreach ($responses as $key => $response) {
            if ($response->failed()) {
                abort(502, "Error en la llamada a la API: {$key}");
            }
        }

        $resultados = [
            'genre' => $responses['genre']->json(),
            'songs' => $responses['songs']->json(),
            'artists' => $responses['artists']->json(),
            'albums' => $responses['albums']->json(),
        ];

        $json = response()->json($resultados);
        $res = $json->original;

        $songs = [];
        foreach ($res['songs']['items'] as $song) {

            $songs[] = [
                'name' => $song['name'],
                'artists' => $song["artistString"],
                'img' => $song['mainPicture']['urlThumb'],
                'id' => $song['id']
            ];
        }

        $artists = [];
        foreach ($res['artists']['items'] as $artist) {

            $artists[] = [
                'name' => $artist['name'],
                'img' => $artist['mainPicture']['urlThumb'],
                'id' => $artist['id']
            ];
        }

        $albums = [];
        foreach ($res['albums']['items'] as $album) {

            $albums[] = [
                'name' => $album['name'],
                'artists' => $album["artistString"],
                'img' => $album['mainPicture']['urlThumb'],
                'id' => $album['id']
            ];
        }

        return [
            'name' => $res['genre']['name'],
            'description' => $res['genre']['description'],
            'img' => $res['genre']['mainPicture']['urlOriginal'],
            'songs' => empty($songs) ? null : $songs,
            'albums' => empty($albums) ? null : $albums,
            'artists' => empty($artists) ? null : $artists
        ];
    }
}
