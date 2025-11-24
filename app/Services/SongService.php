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

        $responses = Http::pool(
            fn($pool) =>
            $albumIds->map(
                fn($albumId) =>
                $pool->as($albumId)->get("https://vocadb.net/api/albums/{$albumId}?fields=MainPicture")
            )->toArray()
        );

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

        $prioridades = [
            ['Youtube',      'Original'],
            ['NicoNicoDouga', 'Original'],
            ['Youtube',      'Reprint'],
            ['NicoNicoDouga', 'Reprint'],
        ];

        $video = null;

        foreach ($prioridades as $prio) {
            foreach ($json['pvs'] as $pv) {
                if ($pv['service'] === $prio[0] && $pv['pvType'] === $prio[1]) {
                    $video = $pv['url'];
                    break 2;
                }
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
            'img' => $json['mainPicture']['urlOriginal'] ?? null,
            'pv' => $video ?? null
        ];
    }

    public function getSongs($page, $name, $types, $genres, $artists, $beforeDate, $afterDate)
    {
        $start = ($page - 1) * 100;

        $parameters = [
            'maxResults' => 100,
            'start' => $start,
            'lang' => 'Romaji',
            'getTotalCount' => 'true',
            'query' => $name,
            'nameMatchMode' => 'Auto',
            'sort' => 'PublishDate',
            'songTypes' => $types,
            'tagId[]' => [],
            'artistId[]' => [],
            'beforeDate' => $beforeDate,
            'afterDate' => $afterDate
        ];

        if (!empty($genres)) {
            foreach ($genres as $genre) {
                $parameters['tagId[]'][] = $genre;
            }
        }

        if (!empty($artists)) {
            foreach ($artists as $id) {
                $parameters['artistId[]'][] = $id;
            }
        }

        $res = Http::get("https://vocadb.net/api/songs", $parameters);

        $items = $res['items'];
        $songs = [];

        foreach ($items as $item) {
            $songs[] = [
                'id' => $item['id'],
                'name' => $item['name'],
                'artists' => $item['artistString'],
                'img' => $item['mainPicture']['urlOriginal'] ?? null,
                'type' => $item['songType']
            ];
        }

        $total = $res['totalCount'];

        return [
            'songs' => $songs,
            'pages' => ceil($total / 100)
        ];
    }

    public function autocomplete($query)
    {
        $res = Http::get('https://vocadb.net/api/songs', [
            'nameMatchMode' => 'Auto',
            'maxResults' => 10,
            'query' => $query,
            'lang' => 'Romaji',

            'sort' => 'RatingScore',
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

    public function getNewAndTopSongs()
    {
        $responses = Http::pool(fn($pool) => [

            $pool->as('new')->get('https://vocadb.net/api/songs/highlighted', [
                'languagePreference' => 'Romaji',
                'fields' => 'PVs, MainPicture'
            ]),

            $pool->as('top')->get("https://vocadb.net/api/songs/top-rated", [
                'languagePreference' => 'Romaji',
                'filterBy' => 'Popularity',
                'fields' => 'MainPicture'
            ]),
        ]);

        $new = $responses['new']->json();
        $top = $responses['top']->json();

        $newSongs = [];
        foreach ($new as $n) {
            $newSongs[] = [
                'name' => $n['name'],
                'artists' => $n["artistString"],
                'img' => $n['mainPicture']['urlOriginal'],
                'id' => $n['id']
            ];
        }

        $topSongs = [];
        foreach ($top as $t) {
            $topSongs[] = [
                'name' => $t['name'],
                'artists' => $t['artistString'],
                'id' => $t['id'],
                'img' => $t['mainPicture']['urlOriginal']
            ];
        }

        return [
            'topSongs' => $topSongs,
            'newSongs' => $newSongs
        ];
    }
}
