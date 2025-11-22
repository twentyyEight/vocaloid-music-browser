<?php

use App\Http\Controllers\API\AlbumController;
use App\Http\Controllers\API\SongController;
use App\Http\Controllers\API\GenreController;
use App\Http\Controllers\API\ArtistController;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;

use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');

// Album Routes
Route::get('/albums', [AlbumController::class, 'index'])->name('album.index');
Route::get('/albums/{id}', [AlbumController::class, 'show'])->name('album.show');
Route::get('/albums/autocomplete/{query}', [AlbumController::class, 'autocomplete']);

// Song Routes
Route::get('/songs', [SongController::class, 'index'])->name('song.index');
Route::get('/songs/{id}', [SongController::class, 'show'])->name('song.show');
Route::get('/songs/autocomplete/{query}', [SongController::class, 'autocomplete']);

// Genre Routes
Route::get('/genres', [GenreController::class, 'index'])->name('genre.index');
Route::get('/genres/{id}', [GenreController::class, 'show'])->name('genre.show');
Route::get('/genres/autocomplete/{query}', [GenreController::class, 'autocomplete']);

// Artist Routes
Route::get('/artists', [ArtistController::class, 'index'])->name('artist.index');
Route::get('/artists/{id}', [ArtistController::class, 'show'])->name('artist.show');
Route::get('/artists/autocomplete/{query}', [ArtistController::class, 'autocomplete']);

Route::get('/users/{id}', [ProfileController::class, 'index'])->name('profile');

/* RUTAS PROTEGIDAS */
Route::middleware(['auth', 'verified'])->group(function () {

    Route::post('/song/{id}', [SongController::class, 'storeFavorite'])->name('song.store');
    Route::delete('/song/{song}', [SongController::class, 'destroyFavorite'])->name('song.delete');

    Route::post('/album/{id}', [AlbumController::class, 'storeFavorite'])->name('album.store');
    Route::delete('/album/{album}', [AlbumController::class, 'destroyFavorite'])->name('album.delete');

    Route::post('/artist/{id}', [ArtistController::class, 'storeFavorite'])->name('artist.store');
    Route::delete('/artist/{artist}', [ArtistController::class, 'destroyFavorite'])->name('artist.delete');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/edit/{id}', [DashboardController::class, 'edit'])->name('dashboard.edit');
    Route::patch('/dashboard/patch/{id}', [DashboardController::class, 'update'])->name('dashboard.patch');
    Route::delete('/dashboard/delete/{id}', [DashboardController::class, 'destroy'])->name('dashboard.delete');
});
