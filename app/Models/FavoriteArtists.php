<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FavoriteArtists extends Model
{
    protected $fillable = [
        'artist_id',
        'name',
        'img',
        'user_id',
    ];
}
