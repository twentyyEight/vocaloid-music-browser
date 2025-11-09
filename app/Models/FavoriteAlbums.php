<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FavoriteAlbums extends Model
{
    protected $fillable = [
        'album_id',
        'name',
        'artists',
        'img',
        'user_id',
    ];
}
