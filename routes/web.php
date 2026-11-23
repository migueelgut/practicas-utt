<?php

use App\Http\Controllers\Auth\AdminTwoFactorController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Rutas Práctica 1.1: Verificación de 3 etapas para Administrador[cite: 1, 2]
Route::middleware('guest')->group(function () {
    Route::get('/verificacion-admin', [AdminTwoFactorController::class, 'show'])
        ->middleware('signed')
        ->name('admin.2fa.show');

    Route::post('/verificacion-admin', [AdminTwoFactorController::class, 'verify'])
        ->name('admin.2fa.verify');
});

require __DIR__.'/settings.php';