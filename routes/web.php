<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatastroController;

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
        Route::get('/catastro', [CatastroController::class, 'index'])->name('admin.catastro.index');
    });
});

// Rutas de instalación
require __DIR__ . '/installation.php';

// Rutas de Autenticación
require __DIR__ . '/auth.php';
