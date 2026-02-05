<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SongService
{
    public function getSongById($id)
    {
        $response = Http::get("https://vocadb.net/api/songs/{$id}", [
            'fields' => 'Albums,Artists,PVs,Tags,MainPicture,Lyrics,CultureCodes',
            'lang' => 'Romaji'
        ]);

        if ($response->failed() || !$response->json()) {
            abort(500, 'Error al obtener datos');
        }

        $json = $response->json();

        $original = null;
        if (isset($json['originalVersionId'])) {

            $originalId = $json['originalVersionId'];
            $res = Http::get("https://vocadb.net/api/songs/{$originalId}", ['lang' => 'Romaji']);
            $json_original = $res->json();

            $original = [
                'id' => $originalId,
                'name' => $json_original['name'],
                'artists' => $json_original['artistString']
            ];
        }

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
        $roles = [];

        foreach ($json['artists'] as $artist) {

            if (
                ($artist['artist']['artistType'] ?? null) !== 'Illustrator'
                && ($artist['artist']['artistType'] ?? null) !== 'Animator'
                && ($artist['categories'] ?? null) !== 'Illustrator'
                && ($artist['categories'] ?? null) !== 'Animator'
            ) {

                if ($artist['roles'] === 'Default') {
                    $roles = array_merge(
                        $roles,
                        array_map('trim', explode(',', $artist['categories']))
                    );
                } else {
                    $roles = array_merge(
                        $roles,
                        array_map('trim', explode(',', $artist['roles']))
                    );
                }
            }
        }

        $roles = array_fill_keys(array_unique($roles), []);

        foreach ($roles as $rolNombre => &$artistas) {
            foreach ($json['artists'] as $artist) {

                if (
                    str_contains($artist['roles'], $rolNombre) ||
                    str_contains($artist['categories'], $rolNombre)
                ) {
                    $artistas[] = [
                        'id' => $artist['artist']['id'], 
                        'name' => $artist['name']
                    ];
                }
            }
        }

        ksort($roles);

        // Géneros
        $genres = [];
        foreach ($json['tags'] as $tag) {

            if ($tag['tag']['categoryName'] == 'Genres') {

                $genres[] = [
                    'name' => trim($tag['tag']['name']),
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
        $min = floor($json["lengthSeconds"] / 60);
        $sec = $json["lengthSeconds"] % 60;

        $format = sprintf('%02d:%02d', $min, $sec);

        // Idioma(s)
        $cultureCodes = [
            'ja' => 'Japonés',
            'ha' => 'Romaji',
            '' => 'Romaji',
            'en' => 'Inglés',
            'zh' => 'Chino',
            'nl' => 'Holandés',
            'tl' => 'Filipino',
            'fi' => 'Finlandés',
            'fr' => 'Francés',
            'de' => 'Alemán',
            'id' => 'Indonesio',
            'it' => 'Italiano',
            'ko' => 'Coreano',
            'no' => 'Noruego',
            'pl' => 'Polaco',
            'pt' => 'Portugues',
            'ru' => 'Ruso',
            'es' => 'Español',
            'sv' => 'Sueco',
            'th' => 'Tailandés'
        ];

        $langs = [];

        foreach ($json['cultureCodes'] as $code) {
            if (isset($cultureCodes[$code])) {
                $langs[] = $cultureCodes[$code];
            }
        }

        // Letra
        $lyrics = [];
        foreach ($json['lyrics'] as $lyric) {

            $langs_lyric = [];

            foreach ($lyric['cultureCodes'] as $code) {
                if (isset($cultureCodes[$code])) {
                    $langs_lyric[] = $cultureCodes[$code];
                }
            }

            $lyrics[] = [
                'languages' => implode(', ', $langs_lyric),
                'type' => $lyric['translationType'],
                'lyric' => $lyric['value'],
                'id' => $lyric['id']
            ];
        }

        return [
            'id' => $json['id'] ?? null,
            'name' => $json['name'] ?? null,
            'date' => $date ?? null,
            'type' => $type ?? null,
            'artists' => $json['artistString'] ?? null,
            'credits' => empty($roles) ? null : $roles,
            'genres' => empty($genres) ? null : $genres,
            'albums' => empty($albumCovers) ? null : $albumCovers,
            'img' => $json['mainPicture']['urlOriginal'] ?? null,
            'pv' => $video ?? null,
            'duration' => $format ?? null,
            'languages' => $langs,
            'lyrics' => $lyrics,
            'original' => $original
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
