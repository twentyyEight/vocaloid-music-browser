<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AlbumService
{
    public function getAlbumById($id)
    {
        $response = Http::get("https://vocadb.net/api/albums/{$id}?fields=Tags,Tracks,WebLinks,PVs,MainPicture&lang=Romaji");
        $json = $response->json();

        if ($response->failed() || !$response->json()) {
            abort(500, 'Error al obtener datos');
        }

        $genres = [];
        foreach ($json['tags'] as $tag) {
            if ($tag['tag']['categoryName'] == 'Genres') {
                $genres[] = $tag['tag']['name'];
            }
        }

        $links = [];
        foreach ($json['webLinks'] as $link) {
            if ($link['category'] == 'Commercial' && !$link['disabled']) {
                $links[] = [
                    'name' => $link['description'],
                    'url' => $link['url']
                ];
            }
        }

        $tracks = [];
        foreach ($json['tracks'] as $track) {
            $tracks[] = [
                'name' => $track['name'],
                'producers' => $track['song']["artistString"]
            ];
        }

        return [
            'cover' => $json['mainPicture']['urlOriginal'] ?? null,
            'name' => $json['name'] ?? null,
            'year' => $json['releaseDate']['year'] ?? null,
            'type' => $json['discType'] ?? null,
            'producers' => $json["artistString"] ?? null,
            'genres' => empty($genres) ? null : $genres,
            'links' => empty($links) ? null : $links,
            'tracks' => empty($tracks) ? null : $tracks
        ];
    }
}
