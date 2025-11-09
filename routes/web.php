<?php

use App\Http\Controllers\API\AlbumController;
use App\Http\Controllers\API\SongController;
use App\Http\Controllers\API\GenreController;
use App\Http\Controllers\API\ArtistController;

use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\Favorites\FavoriteSongsController;
use App\Http\Controllers\Favorites\FavoriteAlbumsController;
use App\Http\Controllers\Favorites\FavoriteArtistsController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

// Album Routes
Route::get('/album/{id}', [AlbumController::class, 'index']);
Route::get('/api/album/{id}', [AlbumController::class, 'show']); // temporal

// Song Routes
Route::get('/song/{id}', [SongController::class, 'index']);
Route::get('/api/song/{id}', [SongController::class, 'show']); // temporal

// Genre Routes
Route::get('/genre/{id}', [GenreController::class, 'index']);
Route::get('/api/genre/{id}', [GenreController::class, 'show']); // temporal

// Artist Routes
Route::get('/artist/{id}', [ArtistController::class, 'index']);
Route::get('/api/artist/{id}', [ArtistController::class, 'show']); // temporal

// Auth Routes
Route::view('/login', 'login')->name('login');
Route::view('/register', 'register')->name('register');

Route::post('/logincheck', [AuthController::class, 'login'])->name('logincheck');
Route::post('/registercheck', [AuthController::class, 'register'])->name('registercheck');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/redirect', [AuthController::class, 'redirection'])->name('redirect');

Route::get('/user/{id}', [UserController::class, 'index'])->name('user');
Route::get('/api/user/{id}', [UserController::class, 'show']);

// Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::post('/store-song/{id}', [FavoriteSongsController::class, 'store'])->name('store.song');
    Route::post('/store-album/{id}', [FavoriteAlbumsController::class, 'store'])->name('store.album');
    Route::post('/store-artist/{id}', [FavoriteArtistsController::class, 'store'])->name('store.artist');
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin');
});
