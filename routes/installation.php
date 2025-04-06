<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InstallationController;
use App\Http\Controllers\Installation\ThemeController;

/*
|--------------------------------------------------------------------------
| Rutas de instalación
|--------------------------------------------------------------------------
|
| Estas rutas solo son accesibles cuando la aplicación no está instalada.
|
*/

Route::middleware(['web', 'installation'])->prefix('install')->group(function () {
    Route::get('/', [InstallationController::class, 'welcome'])->name('installation.welcome');
    Route::get('/requirements', [InstallationController::class, 'requirements'])->name('installation.requirements');
    Route::get('/database', [InstallationController::class, 'database'])->name('installation.database');
    Route::post('/database', [InstallationController::class, 'saveDatabase'])->name('installation.database.save');
    Route::get('/user', [InstallationController::class, 'user'])->name('installation.user');
    Route::post('/user', [InstallationController::class, 'saveUser'])->name('installation.user.save');
    Route::get('/finish', [InstallationController::class, 'finish'])->name('installation.finish');
    Route::post('/finish', [InstallationController::class, 'saveFinish'])->name('installation.finish.save');
    Route::post('/set-theme', [ThemeController::class, 'setTheme'])->name('installation.setTheme');
    Route::post('/test-connection', [InstallationController::class, 'testConnection'])->name('installation.testConnection');
});