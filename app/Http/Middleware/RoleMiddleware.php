<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Vérifier si connecté
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Vérifier le rôle
        if (Auth::user()->role !== $role) {
            return redirect('/');
        }

        return $next($request);
    }
}