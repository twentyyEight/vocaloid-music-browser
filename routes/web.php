<?php

use App\Http\Controllers\API\AlbumController;
use App\Http\Controllers\API\SongController;
use App\Http\Controllers\API\GenreController;
use App\Http\Controllers\API\ArtistController;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;

use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');

// Album Routes
Route::get('/album/{id}', [AlbumController::class, 'index'])->name('album.show');

// Song Routes
Route::get('/song/{id}', [SongController::class, 'index'])->name('song.show');

// Genre Routes
Route::get('/genre/{id}', [GenreController::class, 'index'])->name('genre.show');

// Artist Routes
Route::get('/artist/{id}', [ArtistController::class, 'index'])->name('artist.show');

// Auth Routes
Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/user/{id}', [ProfileController::class, 'index'])->name('profile');

/* RUTAS PROTEGIDAS */
Route::middleware(['auth', 'verified'])->group(function () {

    Route::post('/song/{id}', [SongController::class, 'store'])->name('song.store');
    Route::delete('/song/{song}', [SongController::class, 'destroy'])->name('song.delete');

    Route::post('/album/{id}', [AlbumController::class, 'store'])->name('album.store');
    Route::delete('/album/{album}', [AlbumController::class, 'destroy'])->name('album.delete');

    Route::post('/artist/{id}', [ArtistController::class, 'store'])->name('artist.store');
    Route::delete('/artist/{artist}', [ArtistController::class, 'destroy'])->name('artist.delete');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/edit/{id}', [DashboardController::class, 'edit'])->name('dashboard.edit');
    Route::patch('/dashboard/patch/{id}', [DashboardController::class, 'update'])->name('dashboard.patch');
    Route::delete('/dashboard/delete/{id}', [DashboardController::class, 'destroy'])->name('dashboard.delete');
});

/* VERIFICACION EMAIL */
Route::view('/email/verify', 'auth.verify-email')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])->middleware(['auth', 'signed'])->name('verification.verify');
Route::post('/email/verification-notification', [AuthController::class, 'sendEmailVerificationLink'])->middleware(['auth', 'throttle:6,1'])->name('verification.send');


Route::middleware('guest')->group(function () {

    /* RUTAS AUTH */
    Route::view('/login', 'auth.login')->name('login');
    Route::view('/register', 'auth.register')->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('logincheck');
    Route::post('/register', [AuthController::class, 'register'])->name('registercheck');
    Route::get('/redirect', [AuthController::class, 'redirection'])->name('redirect');

    /* REESTABLECER CONTRASEÑA */
    Route::view('/forgot-password', 'auth.forgot-password')->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendPasswordResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'resetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});
