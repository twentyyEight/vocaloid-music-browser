<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AlbumService
{
    public function getAlbumById($id)
    {
        // Llamada a API y retorna respuesta en json
        $response = Http::get("https://vocadb.net/api/albums/{$id}", [
            'fields' => 'Tags,Tracks,WebLinks,PVs,MainPicture',
            'lang' => 'Romaji'
        ]);
        $json = $response->json();

        // Respuesta en caso de error
        if ($response->failed() || !$response->json()) {
            abort(500, 'Error al obtener datos');
        }

        $type = null;
        switch ($json['discType']) {

            case 'Album':
                $type = 'Álbum Original';
                break;

            case 'Compilation':
                $type = 'Álbum Compilatorio';
                break;

            case 'SplitAlbum':
                $type = 'Álbum Compartido';
                break;

            default:
                $type = $json['discType'];
        }

        // Genero(s) album
        $genres = [];
        foreach ($json['tags'] as $tag) {
            if ($tag['tag']['categoryName'] == 'Genres') {
                $genres[] = [
                    'id' => $tag['tag']['id'],
                    'name' => $tag['tag']['name']
                ];
            }
        }

        // Links para escuchar y/o comprar album
        $links = [];
        foreach ($json['webLinks'] as $link) {
            if (
                !$link['disabled'] &&
                ($link['category'] == 'Commercial' || $link['category'] == 'Official')
                && ($link['description'] !== 'Website' && $link['description'] !== 'Pixiv')
            ) {
                $links[] = [
                    'name' => $link['description'],
                    'url' => $link['url']
                ];
            }
        }

        // Tracks album
        $tracks = [];

        foreach ($json['tracks'] as $track) {

            $min = floor($track['song']['lengthSeconds'] / 60);
            $sec = $track['song']['lengthSeconds'] % 60;
            $duration = sprintf('%02d:%02d', $min, $sec);

            $disc = $track['discNumber'] - 1;

            $tracks[$disc][] = [
                'id' => $track['song']['id'] ?? null,
                'name' => $track['name'],
                'artists' => $track['song']["artistString"] ?? null,
                'duration' => $duration,
                'type' => $track['song']['songType']
            ];
        }

        // Video promocional album
        $prioridades = [
            ['Youtube',      'Original'],
            ['NicoNicoDouga', 'Original'],
            ['Youtube',      'Reprint'],
            ['NicoNicoDouga', 'Other'],
            ['NicoNicoDouga', 'Reprint'],
        ];

        $video = null;

        foreach ($prioridades as $prio) {
            foreach ($json['pvs'] as $pv) {
                if ($pv['service'] === $prio[0] && $pv['pvType'] === $prio[1]) {
                    $video = [
                        'url' =>  $pv['pvId'],
                        'service' => $pv['service']
                    ];
                    break 2;
                }
            }
        }

        // Fecha de lanzamiento
        $date = null;

        if ($json['releaseDate']['isEmpty'] === false) {

            $date .= $json['releaseDate']['day'] . '-';
            $date .= str_pad($json['releaseDate']['month'], 2, '0', STR_PAD_LEFT) . '-';
            $date .= $json['releaseDate']['year'];
        }

        return [
            'id' => $json['id'],
            'img' => $json['mainPicture']['urlOriginal'] ?? null,
            'name' => $json['name'] ?? null,
            'date' => $date,
            'type' => $type ?? null,
            'artists' => $json["artistString"] ?? null,
            'genres' => empty($genres) ? null : $genres,
            'links' => empty($links) ? null : $links,
            'tracks' => empty($tracks) ? null : $tracks,
            'pv' => $video
        ];
    }

    public function autocomplete($query)
    {
        $res = Http::get('https://vocadb.net/api/albums', [
            'nameMatchMode' => 'StartsWith',
            'discTypes' => 'Unknown',
            'maxResults' => 10,
            'sort' => 'RatingAverage',
            'query' => $query,
            'lang' => 'Romaji',
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

    public function getAlbums($page, $name, $type, $genres, $artists, $beforeDate, $afterDate, $sort)
    {
        $start = ($page - 1) * 100;

        $parameters = [
            'discTypes' => $type,
            'maxResults' => 100,
            'sort' => $sort,
            'start' => $start,
            'lang' => 'Romaji',
            'getTotalCount' => 'true',
            'fields' => 'MainPicture',
            'tagId[]' => [],
            'artistId[]' => [],
            'beforeDate' => $beforeDate,
            'afterDate' => $afterDate,
            'query' => $name,
            'nameMatchMode' => 'StartsWith'
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

        $res = Http::get('https://vocadb.net/api/albums', $parameters);

        #dd($res);

        $items = $res['items'];
        $albums = [];

        foreach ($items as $item) {
            $albums[] = [
                'id' => $item['id'],
                'name' => $item['name'],
                'artists' => $item['artistString'],
                'img' => $item['mainPicture']['urlOriginal'] ?? null,
                'type' => $item['discType']
            ];
        }

        $total = $res['totalCount'];

        return [
            'albums' => $albums,
            'pages' => ceil($total / 100),
            'total' => $total
        ];
    }

    public function getNewAndTopAlbums()
    {
        $responses = Http::pool(fn($pool) => [
            $pool->as('new')->get("https://vocadb.net/api/albums/new", ['languagePreference' => 'Romaji']),
            $pool->as('top')->get("https://vocadb.net/api/albums/top", [
                'languagePreference' => 'Romaji',
                'fields' => 'MainPicture'
            ]),
        ]);

        $new = $responses['new']->json();
        $top = $responses['top']->json();

        $newAlbums = [];
        foreach ($new as $n) {
            $newAlbums[] = [
                'id' => $n['id'],
                'name' => $n['name'],
                'artists' => $n['artistString'],
                #'img' => $n['mainPicture']['urlOriginal']
            ];
        }

        $topAlbums = [];
        foreach ($top as $t) {
            $topAlbums[] = [
                'id' => $t['id'],
                'name' => $t['name'],
                'artists' => $t['artistString'],
                'img' => $t['mainPicture']['urlOriginal']
            ];
        }

        return [
            'topAlbums' => $topAlbums,
            'newAlbums' => $newAlbums
        ];
    }
}
