<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ArtistService
{
    public function getArtistById($id)
    {
        $response = Http::get("https://vocadb.net/api/artists/{$id}?fields=Description,MainPicture,Tags,WebLinks&relations=PopularAlbums,PopularSongs&lang=Romaji");
        $json = $response->json();

        if ($response->failed() || !$response->json()) {
            abort(500, 'Error al obtener datos');
        }

        $genres = [];
        foreach ($json['tags'] as $t) {
            $tag = $t['tag'];

            if ($tag['categoryName'] == 'Genres') {
                $genres[] = [
                    'name' => $tag['name'],
                    'id' => $tag['id']
                ];
            }
        }

        $popularAlbums = [];
        foreach ($json['relations']['popularAlbums'] as $album) {
            $popularAlbums[] = [
                'name' => $album['name'],
                'img' => $album['mainPicture']['urlThumb'],
                'id' => $album['id']
            ];
        }

        $popularSongs = [];
        foreach ($json['relations']['popularSongs'] as $song) {
            $popularSongs[] = [
                'name' => $song['name'],
                'img' => $song['mainPicture']['urlThumb'],
                'id' => $song['id']
            ];
        }

        $links = [];
        foreach ($json['webLinks'] as $link) {

            if ($link['category'] == 'Official') {
                
                $links[] = [
                    'name' => $link['description'],
                    'url' => $link['url']
                ];
            }
        }

        return [
            'name' => $json['name'],
            'type' => $json['artistType'],
            'description' => $json['description'],
            'img' => $json['mainPicture']['urlThumb'],
            'genres' => empty($genres) ? null : $genres,
            'songs' => empty($popularSongs) ? null : $popularSongs,
            'albums' => empty($popularAlbums) ? null : $popularAlbums
        ];
    }
}
