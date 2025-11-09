<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FavoriteSongs extends Model
{
    protected $fillable = [
        'song_id',
        'name',
        'artists',
        'img',
        'user_id',
    ];
}
