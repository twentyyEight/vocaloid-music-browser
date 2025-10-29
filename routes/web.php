<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\SongController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/album/{id}', [AlbumController::class, 'index']);

Route::get('/api/album/{id}', [AlbumController::class, 'show']);

Route::get('/song/{id}', [SongController::class, 'index']);

Route::get('/api/song/{id}', [SongController::class, 'show']);
