<?php

use App\Http\Controllers\Auth\AdminTwoFactorController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Práctica 1.1: Verificación de 3 etapas para Administrador[cite: 1, 2]
Route::middleware('guest')->group(function () {
    Route::get('/verificacion-admin', [AdminTwoFactorController::class, 'show'])
        ->middleware('signed')
        ->name('admin.2fa.show');

    Route::post('/verificacion-admin', [AdminTwoFactorController::class, 'verify'])
        ->name('admin.2fa.verify');
});

// Práctica 1.2: CRUD de Usuarios con permisos basados en roles
Route::middleware(['auth'])->group(function () {
    // Operaciones permitidas para Administrador y Empleado
    Route::middleware(['role:Administrador,Empleado'])->group(function () {
        Route::get('/usuarios', [UserManagementController::class, 'index'])->name('usuarios.index');
        Route::get('/usuarios/crear', [UserManagementController::class, 'create'])->name('usuarios.create');
        Route::post('/usuarios', [UserManagementController::class, 'store'])->name('usuarios.store');
        Route::get('/usuarios/{usuario}', [UserManagementController::class, 'show'])->name('usuarios.show');
        Route::get('/usuarios/{usuario}/editar', [UserManagementController::class, 'edit'])->name('usuarios.edit');
        Route::put('/usuarios/{usuario}', [UserManagementController::class, 'update'])->name('usuarios.update');
    });

    // Operaciones exclusivas del Administrador (Soft Delete, Restore y Force Delete)[cite: 3]
    Route::middleware(['role:Administrador'])->group(function () {
        Route::delete('/usuarios/{usuario}', [UserManagementController::class, 'destroy'])->name('usuarios.destroy');
        Route::patch('/usuarios/{id}/restaurar', [UserManagementController::class, 'restore'])->name('usuarios.restore');
        Route::delete('/usuarios/{id}/forzar', [UserManagementController::class, 'forceDelete'])->name('usuarios.force-delete');
    });
});

require __DIR__.'/settings.php';