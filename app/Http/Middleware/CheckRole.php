<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Manejar la solicitud entrante.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed  ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Si no hay usuario autenticado
        if (!$request->user()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'No autenticado'], 401);
            }
            return redirect()->to('/login'); // Redirección absoluta para evitar errores
        }

        // Verificar si el usuario tiene el rol adecuado
        foreach ($roles as $role) {
            if ($request->user()->hasRole($role)) {
                return $next($request);
            }
        }

        // Si es una API, responder con JSON en lugar de redirigir a una vista
        if ($request->expectsJson()) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        return redirect()->to('/acceso-restringido'); // Redirigir a una página de acceso denegado
    }
}
