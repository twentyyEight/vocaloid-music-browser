<?php

use App\Http\Controllers\API\AlbumController;
use App\Http\Controllers\API\SongController;
use App\Http\Controllers\API\GenreController;
use App\Http\Controllers\API\ArtistController;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\Favorites\FavoriteSongsController;
use App\Http\Controllers\Favorites\FavoriteAlbumsController;
use App\Http\Controllers\Favorites\FavoriteArtistsController;

use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');

// Album Routes
Route::get('/album/{id}', [AlbumController::class, 'index'])->name('album');
Route::get('/api/album/{id}', [AlbumController::class, 'show']); // temporal

// Song Routes
Route::get('/song/{id}', [SongController::class, 'index'])->name('song');
Route::get('/api/song/{id}', [SongController::class, 'show']); // temporal

// Genre Routes
Route::get('/genre/{id}', [GenreController::class, 'index'])->name('genre');
Route::get('/api/genre/{id}', [GenreController::class, 'show']); // temporal

// Artist Routes
Route::get('/artist/{id}', [ArtistController::class, 'index'])->name('artist');
Route::get('/api/artist/{id}', [ArtistController::class, 'show']); // temporal

// Auth Routes
Route::view('/login', 'auth.login')->name('login');
Route::view('/register', 'auth.register')->name('register');

Route::post('/logincheck', [AuthController::class, 'login'])->name('logincheck');
Route::post('/registercheck', [AuthController::class, 'register'])->name('registercheck');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/redirect', [AuthController::class, 'redirection'])->name('redirect');

Route::get('/user/{id}', [ProfileController::class, 'index'])->name('profile');
Route::get('/api/user/{id}', [ProfileController::class, 'show']);

// Protected Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/store-song/{id}', [FavoriteSongsController::class, 'store'])->name('store.song');
    Route::post('/store-album/{id}', [FavoriteAlbumsController::class, 'store'])->name('store.album');
    Route::post('/store-artist/{id}', [FavoriteArtistsController::class, 'store'])->name('store.artist');

    Route::delete('/delete-song/{song}', [FavoriteSongsController::class, 'destroy'])->name('destroy.song');
    Route::delete('/delete-album/{album}', [FavoriteAlbumsController::class, 'destroy'])->name('destroy.album');
    Route::delete('/delete-artist/{artist}', [FavoriteArtistsController::class, 'destroy'])->name('destroy.artist');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/edit/{id}', [DashboardController::class, 'edit'])->name('dashboard.edit');
    Route::patch('/dashboard/patch/{id}', [DashboardController::class, 'update'])->name('dashboard.patch');
    Route::delete('/dashboard/delete/{id}', [DashboardController::class, 'destroy'])->name('dashboard.delete');
});

/* VERIFICACION EMAIL */

// Vista con aviso de verificacion
Route::view('/email/verify', 'auth.verify-email')->name('verification.notice');

// Ruta para cumplir verificacion
Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])->middleware(['auth', 'signed'])->name('verification.verify');

// Reenvio de enlace
Route::post('/email/verification-notification', [AuthController::class, 'sendEmailVerificationLink'])->middleware(['auth', 'throttle:6,1'])->name('verification.send');


/* REESTABLECER CONTRASEÑA */

// Vista con formulario para ingresar correo
Route::view('/forgot-password', 'auth.forgot-password')->middleware('guest')->name('password.request');

// Valida email y envia solicitud para restablecer contraseña
Route::post('/forgot-password', [AuthController::class, 'sendPasswordResetLink'])->middleware('guest')->name('password.email');

// Vista con formulario con campos para email, contraseña, confirmación de contraseña y token oculto
Route::get('/reset-password/{token}', [AuthController::class, 'resetPasswordForm'])->middleware('guest')->name('password.reset');

// Gestiona formulario anterior - actualiza la contraseña en BD
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->middleware('guest')->name('password.update');
