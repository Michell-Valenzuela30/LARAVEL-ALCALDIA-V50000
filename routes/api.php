<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Rutas públicas
Route::post('/login', [AuthController::class, 'login'])->name('api.login');

// Middleware de autenticación Sanctum
Route::middleware('auth:sanctum')->group(function () {

    // Perfil y logout del usuario autenticado
    Route::get('/perfil', [AuthController::class, 'perfil'])->name('api.perfil');
    Route::post('/logout', [AuthController::class, 'logout'])->name('api.logout');

    // Rutas protegidas para usuarios con roles root o admin
    Route::middleware('role:root,admin')->group(function () {
        Route::get('/usuarios', [UserController::class, 'index'])->name('api.usuarios.index');
        Route::post('/usuarios', [UserController::class, 'store'])->name('api.usuarios.store');
        Route::get('/usuarios/{user}', [UserController::class, 'show'])->name('api.usuarios.show');
        Route::match(['put', 'patch'], '/usuarios/{user}', [UserController::class, 'update'])->name('api.usuarios.update');
        Route::delete('/usuarios/{user}', [UserController::class, 'destroy'])->name('api.usuarios.destroy');
    });
});

// Manejar rutas no encontradas para evitar errores HTML
Route::fallback(function () {
    return response()->json(['message' => 'Ruta no encontrada'], 404);
});
