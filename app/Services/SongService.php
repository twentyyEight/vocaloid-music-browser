<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SongService
{
    public function getSongById($id)
    {
        $response = Http::get("https://vocadb.net/api/songs/{$id}", [
            'fields' => 'Albums,Artists,PVs,Tags,MainPicture',
            'lang' => 'Romaji'
        ]);

        if ($response->failed() || !$response->json()) {
            abort(500, 'Error al obtener datos');
        }

        $json = $response->json();

        $type = null;
        switch ($json['songType']) {

            case 'Original':
                $type = 'Original Song';
                break;

            default:
                $type = $json['songType'];
        }

        $producers = [];
        $vocalists = [];
        foreach ($json['artists'] as $artist) {

            if (str_contains($artist['categories'], 'Producer') || str_contains($artist['categories'], 'Circle')) {

                $producers[] = [
                    'name' => $artist['name'],
                    'id' => $artist['artist']['id']
                ];
            } elseif ($artist['categories'] == 'Vocalist') {

                $vocalists[] = [
                    'name' => $artist['name'],
                    'id' => $artist['artist']['id']
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
            'id' => $json['id'] ?? null,
            'name' => $json['name'] ?? null,
            'date' => $json['publishDate'] ?? null,
            'type' => $type ?? null,
            'artists' => $json['artistString'] ?? null,
            'producers' => empty($producers) ? null : $producers,
            'vocalists' => empty($vocalists) ? null : $vocalists,
            'genres' => empty($genres) ? null : $genres,
            'albums' => empty($albumCovers) ? null : $albumCovers,
            'img' => $json['mainPicture']['urlOriginal'] ?? null
        ];
    }

    public function getSongs($page)
    {
        $start = ($page - 1) * 100;

        $res = Http::get("https://vocadb.net/api/songs", [
            'maxResults' => 100,
            'start' => $start,
            'lang' => 'Romaji',
            'songType' => 'Unspecified, Original, Remaster, Remix, Cover, Arrangement, Instrumental, Mashup, Live, Other, Rearrangement'
        ]);

        return $res['items'];
    }

    public function pagination()
    {
        $res = Http::get("https://vocadb.net/api/songs", [
            'maxResults'     => 1,
            'getTotalCount'  => 'true',
            'songType' => 'Unspecified, Original, Remaster, Remix, Cover, Arrangement, Instrumental, Mashup, Live, Other, Rearrangement'
        ]);

        $total = $res['totalCount'];

        return ceil($total / 100);
    }

    public function autocomplete($query)
    {
        $res = Http::get('https://vocadb.net/api/songs', [
            'nameMatchMode' => 'Auto',
            'maxResults' => 10,
            'sort' => 'RatingScore',
            'query' => $query,
            'lang' => 'Romaji'
        ]);

        $sugg = [];

        foreach ($res['items'] as $item) {
            $sugg[] = [
                'label' => $item['name'],
                'id' => $item['id']
            ];
        }

        return $sugg;
    }
}
