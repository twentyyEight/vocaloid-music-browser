<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SongService
{
    public function getSongById($id)
    {
        $response = Http::get("https://vocadb.net/api/songs/{$id}?fields=Albums,Artists,PVs,Tags&lang=Romaji");
        $json = $response->json();

        if ($response->failed() || !$response->json()) {
            abort(500, 'Error al obtener datos');
        }

        $producers = [];
        $vocalists = [];
        foreach ($json['artists'] as $artist) {

            if ($artist['categories'] == 'Producer' || $artist['categories'] == 'Circle') {

                $producers[] = [
                    'name' => $artist['name'],
                    'id' => $artist['id']
                ];
            }

            elseif ($artist['categories'] == 'Vocalist') {

                $vocalists[] = [
                    'name' => $artist['name'],
                    'id' => $artist['id']
                ];
            }
        }

        $genres = [];
        foreach ($json['tags'] as $tag) {

            if ($tag['tag']['categoryName'] == 'Genres') {

                $genres[] = [
                    'name' => $tag['tag']['name'],
                    'id' => $tag['tag']['id']
                ];
            }
        }

        $albumIds = collect($json['albums'])->pluck('id');

        // Peticiones concurrentes
        $responses = Http::pool(
            fn($pool) =>
            $albumIds->map(
                fn($albumId) =>
                $pool->as($albumId)->get("https://vocadb.net/api/albums/{$albumId}?fields=MainPicture")
            )->toArray()
        );

        // Procesar resultados
        $albumCovers = [];
        foreach ($responses as $albumId => $res) {
            if ($res->successful()) {
                $albumCovers[] = [
                    'img' => $res['mainPicture']['urlSmallThumb'],
                    'name' => $res['name'],
                    'id' => $albumId,
                ];
            }
        }

        return [
            'name' => $json['name'],
            'date' => $json['publishDate'],
            'type' => $json['songType'],
            'producers' => empty($producers) ? null : $producers,
            'vocalists' => empty($vocalists) ? null : $vocalists,
            'genres' => empty($genres) ? null : $genres,
            'albums' => empty($albumCovers) ? null : $albumCovers
        ];
    }
}
