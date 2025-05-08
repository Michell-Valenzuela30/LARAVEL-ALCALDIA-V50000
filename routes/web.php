<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CedulaCatastralController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Ruta de inicio que redirige según el estado de autenticación
Route::get('/', function () {
    return view('welcome');
});

// Rutas protegidas por autenticación
Route::middleware(['auth'])->group(function () {

    // Rutas que solo pueden acceder root o admin
    Route::middleware(['role:root,admin'])->group(function () {
        // Rutas para Cédulas Catastrales
        Route::prefix('cedulas')->name('cedulas.')->group(function () {
            Route::get('/', [CedulaCatastralController::class, 'index'])->name('index');
            Route::post('/store', [CedulaCatastralController::class, 'store'])->name('store');
            Route::get('/{id}', [CedulaCatastralController::class, 'show'])->name('show');
            Route::delete('/{id}', [CedulaCatastralController::class, 'destroy'])->name('destroy');
            Route::get('/buscar', [CedulaCatastralController::class, 'buscar'])->name('buscar');
        });
    });
});

// Rutas de instalación
require __DIR__ . '/installation.php';

// Rutas de Autenticación
require __DIR__ . '/auth.php';
