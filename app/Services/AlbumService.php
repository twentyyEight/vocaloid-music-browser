<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AlbumService
{
    public function getAlbumById($id)
    {
        // Llamada a API y retorna respuesta en json
        $response = Http::get("https://vocadb.net/api/albums/{$id}?fields=Tags,Tracks,WebLinks,PVs,MainPicture&lang=Romaji");
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
        /*$pvs = [];
        foreach ($json['pvs'] as $pv) {
            if ($pv['service'] == 'Youtube' && !$pv['disabled']) {
                $pvs[] = 'https://www.youtube.com/embed/' . $pv['pvId'];

            } elseif ($pv['service'] == 'NicoNicoDouga' && !$pv['disabled']) {

                $pvs[] = 'https://embed.nicovideo.jp/watch/' . $pv['pvId'];
            }
        }*/

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
            //'pv' => empty($pvs) ? null : $pvs
        ];
    }
}
