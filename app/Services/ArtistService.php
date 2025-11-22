<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ArtistService
{
    public function getArtistById($id)
    {
        $response = Http::get("https://vocadb.net/api/artists/{$id}?fields=Description,MainPicture,Tags,WebLinks&relations=PopularAlbums,PopularSongs&lang=Romaji");
        $json = $response->json();

        if ($response->failed() || !$response->json()) {
            abort(500, 'Error al obtener datos');
        }

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

        $popularAlbums = [];
        foreach ($json['relations']['popularAlbums'] as $album) {
            $popularAlbums[] = [
                'name' => $album['name'],
                'img' => $album['mainPicture']['urlThumb'],
                'id' => $album['id']
            ];
        }

        $popularSongs = [];
        foreach ($json['relations']['popularSongs'] as $song) {
            $popularSongs[] = [
                'name' => $song['name'],
                'img' => $song['mainPicture']['urlThumb'],
                'id' => $song['id']
            ];
        }

        $links = [];
        foreach ($json['webLinks'] as $link) {

            if ($link['category'] == 'Official') {

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
            'description' => $json['description'] ?? null,
            'img' => $json['mainPicture']['urlThumb'] ?? null,
            'genres' => empty($genres) ? null : $genres,
            'songs' => empty($popularSongs) ? null : $popularSongs,
            'albums' => empty($popularAlbums) ? null : $popularAlbums
        ];
    }

    public function autocomplete($query)
    {
        $res = Http::get('https://vocadb.net/api/artists', [
            'nameMatchMode' => 'Auto',
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

    public function getArtists($page)
    {
        $start = ($page - 1) * 100;

        $res = Http::get('https://vocadb.net/api/artists', [
            'artistTypes' => 'Circle, Producer, Vocaloid, UTAU, CeVIO, OtherVoiceSynthesizer, OtherVocalist, OtherGroup, OtherIndividual, Utaite, Band, Vocalist, Character, SynthesizerV, NEUTRINO, VoiSona, NewType, Voiceroid, VOICEVOX, ACEVirtualSinger, AIVOICE',
            'maxResults' => 100,
            'sort' => 'FollowerCount',
            'start' => $start,
            'lang' => 'Romaji',
            'allowBaseVoicebanks' => 'false',
            'getTotalCount' => 'true'
        ]);

        $items = $res['items'];
        $artists = [];

        foreach ($items as $item) {
            $artists[] = [
                'id' => $item['id'],
                'name' => $item['name'],
                'img' => $item['mainPicture']['urlOriginal'] ?? null,
            ];
        }

        $total = $res['totalCount'];

        return [
            'artists' => $artists,
            'pages' => ceil($total / 100)
        ];

        return $res['items'];
    }
}
