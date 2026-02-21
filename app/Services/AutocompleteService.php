<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Log;

class AutocompleteService
{
    public function autocomplete($entity, $query, $entity_params): array
    {
        try {

            $default_params = [
                'nameMatchMode' => 'StartsWith',
                'maxResults' => 5,
                'query' => $query,
                'lang' => 'Romaji',
            ];

            $params = array_merge($default_params, $entity_params);

            $res = Http::get("https://vocadb.net/api/{$entity}", $params);

            $sugg = [];

            foreach ($res['items'] as $item) {
                $sugg[] = [
                    'label' => $item['name'],
                    'id' => $item['id']
                ];
            }

            return $sugg;
        } catch (RequestException $e) {

            Log::error('Error al obtener sugerencias: ' . $e->getMessage(), ['exception' => $e]);

            return [
                'error' => true,
                'message' => 'Error al obtener sugerencias'
            ];
        }
    }
}
