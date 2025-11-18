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
                $type = 'Original Album';
                break;

            case 'Compilation':
                $type = 'Compilation Album';
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
            if ($link['category'] == 'Commercial' && !$link['disabled']) {
                $links[] = [
                    'name' => $link['description'],
                    'url' => $link['url']
                ];
            }
        }

        // Tracks album
        $tracks = [];
        foreach ($json['tracks'] as $track) {
            $tracks[] = [
                'id' => $track['song']['id'],
                'name' => $track['name'],
                'artists' => $track['song']["artistString"]
            ];
        }

        // Video promocional album
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
            'id' => $json['id'],
            'img' => $json['mainPicture']['urlThumb'] ?? null,
            'name' => $json['name'] ?? null,
            'year' => $json['releaseDate']['year'] ?? null,
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
            'nameMatchMode' => 'Auto',
            'discTypes' => 'Unknown, Album, Single, EP, SplitAlbum, Compilation, Fanmade, Instrumental, Other',
            'maxResults' => 10,
            'sort' => 'RatingAverage',
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

    public function getAlbums($page)
    {
        $start = ($page - 1) * 100;

        $res = Http::get('https://vocadb.net/api/albums', [
            'discTypes' => 'Unknown, Album, Single, EP, SplitAlbum, Compilation, Fanmade, Instrumental, Other',
            'maxResults' => 100,
            'sort' => 'RatingAverage',
            'start' => $start,
            'lang' => 'Romaji',
        ]);

        return $res['items'];
    }

    public function pagination()
    {
        $res = Http::get("https://vocadb.net/api/artists", [
            'maxResults'     => 1,
            'getTotalCount'  => 'true',
            'discTypes' => 'Unknown, Album, Single, EP, SplitAlbum, Compilation, Fanmade, Instrumental, Other'
        ]);

        $total = $res['totalCount'];

        return ceil($total / 100);
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
                'img' => $n['mainPicture']['urlOriginal']
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
