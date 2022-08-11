<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAlumno
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $userRole = auth()->user()->role;
        if ($userRole === 'alumno') {
            return $next($request);
        }
        else {
            return response()->json(['message' => 'No tienes autorización para ejecutar esta acción, inicia sesión en una cuenta válida'],401);
        }
    }
}
