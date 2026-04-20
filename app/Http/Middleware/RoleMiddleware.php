<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
      /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles  //
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // if user not login 
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to access this page.');
        }

        // if the user role is among the allowed roles 
        if (in_array(auth()->user()->role, $roles)) {
            return $next($request);
        }

        // if the user is not authorized 
        return redirect()->route('shop.catalog')->with('error', 'You do not have permission to access this page.');
    }
}