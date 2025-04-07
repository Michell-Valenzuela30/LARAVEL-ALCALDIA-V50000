<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginViewController;
use App\Http\Controllers\UserViewController;
use App\Http\Controllers\Installation\ThemeController;
use App\Http\Controllers\ProfileViewController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

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

// Rutas de autenticación para vistas
Route::get('/login', [LoginViewController::class, 'show'])->name('login');

// Mostrar formulario de solicitud de reseteo (olvidé mi contraseña)
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');

// Enviar el correo con el token de reseteo
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

// Mostrar formulario para ingresar nueva contraseña
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');

// Procesar el reseteo de contraseña
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

// Rutas protegidas por autenticación
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Ruta para vista de acceso restringido
    Route::view('/acceso-restringido', 'errors.acceso-restringido')->name('acceso.restringido');

    // Rutas de perfil
    Route::get('/perfil', [ProfileViewController::class, 'show'])->name('perfil.show');
    Route::put('/perfil', [ProfileViewController::class, 'update'])->name('perfil.update');

    // Rutas que solo pueden acceder root o admin
    Route::middleware(['role:root,admin'])->group(function () {
        Route::get('/usuarios', [UserViewController::class, 'index'])->name('usuarios.index');

        Route::get('/configuracion', [ConfigurationController::class, 'index'])->name('configuration.index');
        Route::put('/configuracion', [ConfigurationController::class, 'update'])->name('configuration.update');
        Route::put('/configuracion/smtp', [ConfigurationController::class, 'updateSmtp'])->name('configuration.update.smtp');
    });

    // Otra ruta protegida sin restricción adicional
    Route::post('/theme/set', [ThemeController::class, 'setTheme'])->name('theme.set');
});
