<?php

return [

    // Canciones
    'song_sort' => [
        'PublishDate' => 'Más reciente',
        'Name' => 'Nombre',
        'RatingScore' => 'Popularidad'
    ],

    'song_type' => [
        'Original' => 'Original',
        'Remaster' => 'Remasterización',
        'Remix' => 'Remix',
        'Cover' => 'Cover',
        'Arragement' => 'Arreglo',
        'Instrumental' => 'Instrumental',
        'Mashup' => 'Mashup',
        'Rearragement' => 'Rearreglo',
        'Other' => 'Otro',
        'Unspecified' => 'Sin especificar'
    ],

    // Artistas
    'artist_sort' => [
        'FollowerCount' => 'Popularidad',
        'Name' => 'Nombre',
    ],

    'artist_type' => [

        'producer' => [
            null => 'Todos',
            'Producer' => 'Productor musical',
            'CoverArtist' => 'Artista de covers',
            'Circle' => 'Círculo',
            'OtherGroup' => 'Otros grupos',
        ],

        'vocalist' => [
            null => 'Todos',
            'Vocaloid' => 'Vocaloid',
            'UTAU' => 'UTAU',
            'SynthesizerV' => 'Synthesizer V',
            'CeVIO' => 'CeVIO',
            'NEUTRINO' => 'NEUTRINO',
            'VoiSona' => 'VoiSona',
            'NewType' => 'NewType',
            'Voiceroid' => 'Voiceroid',
            'VOICEVOX' => 'VOICEVOX',
            'ACEVirtualSinger' => 'ACE Virtual Singer',
            'AIVOICE' => 'AI VOICE',
            'OtherVoiceSynthesizer' => 'Otros sintetizadores de voz',
            'OtherVocalist' => 'Otros vocalistas',
        ]
    ],

    // Albumes
    'album_sort' => [
        'ReleaseDate' => 'Más recientes',
        'Name' => 'Nombre',
        'RatingTotal' => 'Popularidad',
    ],

    'album_type' => [
        'Album' => 'Original',
        'EP' => 'EP',
        'Compilation' => 'Compilación',
        'SplitAlbum' => 'Álbum compartido',
        'Other' => 'Otro',
    ]
];
