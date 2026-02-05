<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ArtistService
{
    public function getArtistById($id)
    {
        $response = Http::get(
            "https://vocadb.net/api/artists/{$id}",
            [
                'fields' => 'Description,MainPicture,Tags,WebLinks',
                'relations' => 'PopularAlbums,PopularSongs,LatestAlbums,LatestSongs',
                'lang' => 'Romaji'
            ]
        );
        $json = $response->json();

        if ($response->failed() || !$response->json()) {
            abort(500, 'Error al obtener datos');
        }

        // Generos
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

        // Álbumes populares
        $popular_albums = [];
        foreach ($json['relations']['popularAlbums'] as $album) {
            $popular_albums[] = [
                'name' => $album['name'],
                'img' => $album['mainPicture']['urlOriginal'] ?? null,
                'id' => $album['id']
            ];
        }

        // Albumes recientes
        $latest_albums = [];
        foreach ($json['relations']['latestAlbums'] as $album) {
            $latest_albums[] = [
                'name' => $album['name'],
                'img' => $album['mainPicture']['urlOriginal'] ?? null,
                'id' => $album['id']
            ];
        }

        // Canciones populares
        $popular_songs = [];
        foreach ($json['relations']['popularSongs'] as $song) {
            $popular_songs[] = [
                'name' => $song['name'],
                'img' => $song['mainPicture']['urlOriginal'] ?? null,
                'id' => $song['id']
            ];
        }

        // Canciones recientes
        $latest_songs = [];
        foreach ($json['relations']['latestSongs'] as $song) {
            $latest_songs[] = [
                'name' => $song['name'],
                'img' => $song['mainPicture']['urlOriginal'] ?? null,
                'id' => $song['id']
            ];
        }

        // Redes sociales
        $links = [];
        foreach ($json['webLinks'] as $link) {

            if ($link['category'] == 'Official' || $link['category'] == 'Commercial') {

                $links[] = [
                    'name' => $link['description'],
                    'url' => $link['url']
                ];
            }
        }

        return [
            'id' => $json['id'] ?? null,
            'name' => $json['name'] ?? null,
            'type' => $json['artistType'] ?? null,
            'img' => $json['mainPicture']['urlThumb'] ?? null,
            'genres' => empty($genres) ? null : $genres,
            'popular_songs' => empty($popular_songs) ? null : $popular_songs,
            'latest_songs' => empty($latest_songs) ? null : $latest_songs,
            'popular_albums' => empty($popular_albums) ? null : $popular_albums,
            'latest_albums' => empty($latest_albums) ? null : $latest_albums,
            'links' => empty($links) ? null : $links
        ];
    }

    public function autocomplete($query)
    {
        $res = Http::get('https://vocadb.net/api/artists', [
            'nameMatchMode' => 'StartsWith',
            'artistTypes' => 'Circle, Producer, Vocaloid, UTAU, CeVIO, OtherVoiceSynthesizer, OtherVocalist, OtherGroup, OtherIndividual, Utaite, Band, Vocalist, Character, SynthesizerV, NEUTRINO, VoiSona, NewType, Voiceroid, VOICEVOX, ACEVirtualSinger, AIVOICE',
            'maxResults' => 10,
            'sort' => 'FollowerCount',
            'query' => $query,
            'lang' => 'Romaji',
            'allowBaseVoicebanks' => 'false'
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

    public function getArtists($page, $type, $sort, $genres, $name)
    {
        $start = ($page - 1) * 100;

        $parameters = [
            'artistTypes' => $type,
            'maxResults' => 100,
            'sort' => $sort,
            'start' => $start,
            'lang' => 'Romaji',
            'allowBaseVoicebanks' => 'false',
            'getTotalCount' => 'true',
            'tagId[]' => [],
            'query' => $name,
            'nameMatchMode' => 'StartsWith',
            'fields' => 'MainPicture'
        ];

        if (!empty($genres)) {
            foreach ($genres as $genre) {
                $parameters['tagId[]'][] = $genre;
            }
        }

        $res = Http::get('https://vocadb.net/api/artists', $parameters);

        $items = $res['items'];
        $artists = [];

        foreach ($items as $item) {

            if ($item['artistType'] !== 'Illustrator' && $item['artistType'] !== 'Animator') {
                $artists[] = [
                    'id' => $item['id'],
                    'name' => $item['name'],
                    'img' => $item['mainPicture']['urlOriginal'] ?? null,
                ];
            }
        }

        $total = $res['totalCount'];

        return [
            'artists' => $artists,
            'pages' => ceil($total / 100),
            'total' => $total
        ];
    }
}
