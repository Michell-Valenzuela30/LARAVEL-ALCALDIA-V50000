<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\Response;

class InstallationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Si ya está instalado y trata de acceder al asistente de instalación
        if (File::exists(storage_path('.installed')) && $request->is('install*')) {
            return redirect('/');
        }
        
        // Si no está instalado y trata de acceder a rutas que no son de instalación
        if (!File::exists(storage_path('.installed')) && !$request->is('install*')) {
            return redirect()->route('installation.welcome');
        }
        
        return $next($request);
    }
}
