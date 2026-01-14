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

        // Tipo de canción
        $type = null;
        switch ($json['songType']) {

            case 'Original':
                $type = 'Canción original';
                break;

            default:
                $type = $json['songType'];
        }

        // Artistas
        $credits = [];
        foreach ($json['artists'] as $artist) {

            if ($artist['artist']['artistType'] !== 'Illustrator' && $artist['artist']['artistType'] !== 'Animator' && $artist['categories'] !== 'Illustrator' && $artist['categories'] !== 'Animator') {

                $roles = null;

                if ($artist['roles'] === 'Default') {
                    $roles = $artist['categories'];
                } else {
                    $roles = $artist['roles'];
                }

                $credits[] = [
                    'id' => $artist['artist']['id'],
                    'name' => $artist['name'],
                    'roles' => $roles,
                    'img' => null
                ];
            }
        }

        $creditsIds = collect($credits)->pluck('id');

        $res = Http::pool(
            fn($pool) =>
            $creditsIds->map(
                fn($creditsId) =>
                $pool->as($creditsId)->get("https://vocadb.net/api/artists/{$creditsId}?fields=MainPicture")
            )->toArray()
        );

        foreach ($res as $creditsId => $r) {
            if ($r->successful()) {
                foreach ($credits as &$credit) {
                    if ($credit['id'] === $creditsId) {
                        $credit['img'] = $r['mainPicture']['urlSmallThumb'] ?? null;
                    }
                }
                unset($credit);
            }
        }

        // Géneros
        $genres = [];
        foreach ($json['tags'] as $tag) {

            if ($tag['tag']['categoryName'] == 'Genres') {

                $genres[] = [
                    'name' => $tag['tag']['name'],
                    'id' => $tag['tag']['id']
                ];
            }
        }

        // Albumes de la canción
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
                    'img' => $res['mainPicture']['urlSmallThumb'] ?? null,
                    'name' => $res['name'],
                    'id' => $albumId,
                ];
            }
        }

        // Video
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
                    $video = [
                        'url' => $pv['pvId'],
                        'service' => $pv['service']
                    ];
                    break 2;
                }
            }
        }

        // Fecha de lanzamiento
        $date = date('d-m-Y', strtotime($json['publishDate']));

        // Duración
        $segs = $json["lengthSeconds"];

        $min = floor($segs / 60);
        $sec = $segs % 60;

        $format = sprintf('%02d:%02d', $min, $sec);


        return [
            'id' => $json['id'] ?? null,
            'name' => $json['name'] ?? null,
            'date' => $date ?? null,
            'type' => $type ?? null,
            'artists' => $json['artistString'] ?? null,
            'credits' => empty($credits) ? null : $credits,
            'genres' => empty($genres) ? null : $genres,
            'albums' => empty($albumCovers) ? null : $albumCovers,
            'img' => $json['mainPicture']['urlOriginal'] ?? null,
            'pv' => $video ?? null,
            'duration' => $format ?? null
        ];
    }

    public function getSongs($page, $name, $type, $genres, $artists, $beforeDate, $afterDate, $sort)
    {
        $start = ($page - 1) * 100;

        $parameters = [
            'maxResults' => 100,
            'start' => $start,
            'lang' => 'Romaji',
            'getTotalCount' => 'true',
            'query' => $name,
            'nameMatchMode' => 'StartsWith',
            'sort' => $sort,
            'songTypes' => $type,
            'tagId[]' => [],
            'artistId[]' => [],
            'beforeDate' => $beforeDate,
            'afterDate' => $afterDate,
            'fields' => 'MainPicture'
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
            ];
        }

        $total = $res['totalCount'];

        return [
            'songs' => $songs,
            'pages' => ceil($total / 100),
            'total' => $total
        ];
    }

    public function autocomplete($query)
    {
        $res = Http::get('https://vocadb.net/api/songs', [
            'nameMatchMode' => 'StartsWith',
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
            'top' => $topSongs,
            'new' => $newSongs
        ];
    }
}
