<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\SongController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\UserController;
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

// Login Routes
Route::get('/login', [UserController::class, 'login'])->name('login');
Route::post('login', [UserController::class, 'logincheck'])->name('logincheck');

// Register Routes
Route::get('/signup', [UserController::class, 'signup'])->name('singup');
Route::post('singup', [UserController::class, 'registercheck'])->name('registercheck');

Route::get('redirect', [UserController::class, 'redirectUser'])->name('redirect');

Route::get('logout', [UserController::class, 'logout'])->name('logout');