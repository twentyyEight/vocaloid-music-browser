<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Mail;

Route::get('/test-mail', function () {
    Mail::raw('Correo de prueba desde Railway', function ($msg) {
        $msg->to('tu_correo@gmail.com')
            ->subject('Test Gmail SMTP');
    });

    return 'Correo enviado';
});

Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

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