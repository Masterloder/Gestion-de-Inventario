<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAutorizacion
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->autorizacion == 1) {
            if (Auth::user()->configuracion_seguridad_completa == 0 ) {
            return redirect()->route('preguntas_secretas');
        } else {

                return $next($request);
            }
        }

        // 1. Cerramos la sesión del usuario
        Auth::logout();

        // 2. Invalidamos la sesión actual y regeneramos el token CSRF por seguridad
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // 3. Lanzamos el error 403
        abort(403, 'Acceso no autorizado.');
    }
}
