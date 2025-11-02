<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\SongController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\ArtistController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Album Routes
Route::get('/album/{id}', [AlbumController::class, 'index']);
Route::get('/api/album/{id}', [AlbumController::class, 'show']);

// Song Routes
Route::get('/song/{id}', [SongController::class, 'index']);
Route::get('/api/song/{id}', [SongController::class, 'show']);

// Genre Routes
Route::get('/genre/{id}', [GenreController::class, 'index']);
Route::get('/api/genre/{id}', [GenreController::class, 'show']);

// Artist Routes
Route::get('/artist/{id}', [ArtistController::class, 'index']);
Route::get('/api/artist/{id}', [ArtistController::class, 'show']);