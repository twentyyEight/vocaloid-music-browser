<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SongService
{
    public function getSongById($id)
    {
        $response = Http::get("https://vocadb.net/api/songs/{$id}?fields=Albums,Artists,PVs,Tags,WebLinks&lang=Romaji");
        $json = $response->json();

        $date = date('d-m-Y', strtotime($json['publishDate']));

        $producers = [];
        $vocalists = [];
        foreach ($json['artists'] as $artist) {

            if ($artist['categories'] == 'Producer') {
                array_push($producers, $artist['name']);
            }

            if ($artist['categories'] == 'Vocalist') {
                array_push($vocalists, $artist['name']);
            }
        }

        $genres = [];
        foreach ($json['tags'] as $tag) {

            if ($tag['tag']['categoryName'] == 'Genres') {
                array_push($genres, $tag['tag']['name']);
            }
        }

        $links = [];
        foreach ($json['webLinks'] as $link) {

            if ($link['category'] == 'Commercial' && !$link['disabled']) {
                array_push($links, [
                    'name' => $link['description'],
                    'url' => $link['url']
                ]);
            }
        }

        return [
            'name' => $json['name'],
            'date' => $date,
            'type' => $json['songType'],
            'producers' => empty($producers) ? null : $producers,
            'vocalists' => $vocalists ? null : $vocalists,
            'genres' => empty($genres) ? null : $genres,
            'links' => empty($links) ? null : $links
        ];
    }
}
