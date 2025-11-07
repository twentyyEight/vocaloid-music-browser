<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\SongController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

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

// Auth Routes
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logincheck', [AuthController::class, 'logincheck'])->name('logincheck');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/registercheck', [AuthController::class, 'registercheck'])->name('registercheck');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/redirect', [AuthController::class, 'redirection'])->name('redirect');

Route::get('/user/{id}', [UserController::class, 'index'])->name('user');
Route::get('/api/user/{id}', [UserController::class, 'show']);

// Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::post('/store', [UserController::class, 'store']);
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin');
});
