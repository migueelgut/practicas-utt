<?php

use App\Http\Controllers\AcademicoController;
use App\Http\Controllers\Auth\AdminTwoFactorController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Práctica 1.1: Verificación de 3 etapas para Administrador
Route::middleware('guest')->group(function () {
    Route::get('/verificacion-admin', [AdminTwoFactorController::class, 'show'])
        ->middleware('signed')
        ->name('admin.2fa.show');

    Route::post('/verificacion-admin', [AdminTwoFactorController::class, 'verify'])
        ->name('admin.2fa.verify');
});

Route::middleware(['auth'])->group(function () {
    // Práctica 1.2: CRUD de Usuarios
    Route::middleware(['role:Administrador,Empleado'])->group(function () {
        Route::get('/usuarios', [UserManagementController::class, 'index'])->name('usuarios.index');
        Route::get('/usuarios/crear', [UserManagementController::class, 'create'])->name('usuarios.create');
        Route::post('/usuarios', [UserManagementController::class, 'store'])->name('usuarios.store');
        Route::get('/usuarios/{usuario}', [UserManagementController::class, 'show'])->name('usuarios.show');
        Route::get('/usuarios/{usuario}/editar', [UserManagementController::class, 'edit'])->name('usuarios.edit');
        Route::put('/usuarios/{usuario}', [UserManagementController::class, 'update'])->name('usuarios.update');
    });

    Route::middleware(['role:Administrador'])->group(function () {
        Route::delete('/usuarios/{usuario}', [UserManagementController::class, 'destroy'])->name('usuarios.destroy');
        Route::patch('/usuarios/{id}/restaurar', [UserManagementController::class, 'restore'])->name('usuarios.restore');
        Route::delete('/usuarios/{id}/forzar', [UserManagementController::class, 'forceDelete'])->name('usuarios.force-delete');
    });

    // Práctica 1.3: Sistema Académico
    Route::middleware(['role:Administrador,Profesor,Alumno'])->group(function () {
        Route::get('/academico', [AcademicoController::class, 'index'])->name('academico.index');
    });

    Route::middleware(['role:Administrador,Profesor'])->group(function () {
        Route::get('/academico/crear', [AcademicoController::class, 'create'])->name('academico.create');
        Route::post('/academico', [AcademicoController::class, 'store'])->name('academico.store');
        Route::get('/academico/{academico}/editar', [AcademicoController::class, 'edit'])->name('academico.edit');
        Route::put('/academico/{academico}', [AcademicoController::class, 'update'])->name('academico.update');
        Route::delete('/academico/{academico}', [AcademicoController::class, 'destroy'])->name('academico.destroy');
    });

    // Práctica 1.4: Gestión de Productos
    Route::middleware(['role:Administrador,Empleado'])->group(function () {
        Route::get('/productos', [ProductoController::class, 'index'])->name('productos.index');
    });

    Route::middleware(['role:Administrador'])->group(function () {
        Route::get('/productos/crear', [ProductoController::class, 'create'])->name('productos.create');
        Route::post('/productos', [ProductoController::class, 'store'])->name('productos.store');
        Route::get('/productos/{producto}/editar', [ProductoController::class, 'edit'])->name('productos.edit');
        Route::put('/productos/{producto}', [ProductoController::class, 'update'])->name('productos.update');
        Route::delete('/productos/{producto}', [ProductoController::class, 'destroy'])->name('productos.destroy');
    });
});

require __DIR__.'/settings.php';