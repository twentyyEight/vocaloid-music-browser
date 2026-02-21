<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;

class SongService
{
    public function getSongById($id)
    {
        try {

            // Llamada a API con queries
            $response = Http::get("https://vocadb.net/api/songs/{$id}", [
                'fields' => 'Albums,Artists,PVs,Tags,MainPicture,Lyrics,CultureCodes',
                'lang' => 'Romaji'
            ]);

            $json = $response->json();

            // En caso de que la canción sea un cover, remix, etc, se busca su versión original
            $original = null;
            if (isset($json['originalVersionId'])) {

                $original_id = $json['originalVersionId'];
                $res = Http::get("https://vocadb.net/api/songs/{$original_id}", ['lang' => 'Romaji']);
                $json_original = $res->json();

                $original = [
                    'id' => $original_id,
                    'name' => $json_original['name'],
                    'artists' => $json_original['artistString']
                ];
            }

            // Tipo de canción
            $type = $json['songType'] === 'Original' ? 'Canción original' : $json['songType'];

            // Artistas y sus roles
            $credits = [];

            foreach ($json['artists'] as $artist) {

                $artist_type = $artist['artist']['artistType'] ?? null;
                $categories = $artist['categories'] ?? null;
                $artist_roles = $artist['roles'] ?? null;

                // Filtrar ilustradores / animadores
                if (
                    in_array($artist_type, ['Illustrator', 'Animator'], true) ||
                    str_contains($categories, 'Illustrator') ||
                    str_contains($categories, 'Animator')
                ) {
                    continue;
                }

                // Determinar roles reales
                $roles = $artist_roles === 'Default'
                    ? $categories
                    : $artist_roles;

                foreach (array_map('trim', explode(',', $roles)) as $role_name) {

                    if ($role_name === null) {
                        continue;
                    }

                    $credits[$role_name][] = [
                        'id'   => $artist['artist']['id'],
                        'name' => $artist['name'],
                    ];
                }
            }

            ksort($credits);

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

            // Fecha de publicación
            $date = $json['publishDate'] ? date('d-m-Y', strtotime($json['publishDate'])) : null;

            // Duración
            $min = floor($json["lengthSeconds"] / 60);
            $sec = $json["lengthSeconds"] % 60;
            $format = sprintf('%02d:%02d', $min, $sec);

            function nameCultureCode(array $codes): string
            {
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

                $names_langs = [];

                foreach ($codes as $code) {
                    if (isset($cultureCodes[$code])) {
                        $names_langs[] = $cultureCodes[$code];
                    }
                }

                return implode(', ', $names_langs);
            }

            // Idioma(s)
            $langs = $json['cultureCodes'] ? nameCultureCode($json['cultureCodes']) : null;

            // Letra(s)
            $lyrics = [];
            foreach ($json['lyrics'] as $lyric) {

                $lyrics[] = [
                    'languages' => nameCultureCode($json['cultureCodes']),
                    'type' => $lyric['translationType'],
                    'lyric' => $lyric['value'],
                    'id' => $lyric['id']
                ];
            }

            return [
                'id' => $json['id'] ?? null,
                'name' => $json['name'] ?? null,
                'date' => $date,
                'type' => $type ?? null,
                'artists' => $json['artistString'] ?? null,
                'credits' => empty($credits) ? null : $credits,
                'genres' => empty($genres) ? null : $genres,
                'albums' => empty($albumCovers) ? null : $albumCovers,
                'img' => $json['mainPicture']['urlOriginal'] ?? null,
                'pv' => $video ?? null,
                'duration' => $format ?? null,
                'languages' => $langs,
                'lyrics' => $lyrics,
                'original' => $original
            ];
        } catch (RequestException $e) {

            logger()->error($e->getMessage());

            if ($e->response->status() === 404) {
                abort(404, 'No se ha encontrado la canción');
            }

            abort(500, 'Error al obtener la canción.');
        }
    }

    public function getSongs($page, $name, $type, $genres, $artists, $beforeDate, $afterDate, $sort)
    {
        try {
            $start = ($page - 1) * 100;

            $parameters = [
                'maxResults' => 99,
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
        } catch (RequestException $e) {

            logger()->error($e->getMessage());
            abort(500, 'Error al obtener las canciones.');
        }
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
