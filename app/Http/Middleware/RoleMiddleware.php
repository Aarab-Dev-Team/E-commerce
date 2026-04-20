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
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next , $role): Response
    {

        if( auth()->user() && auth()->user()->role ===  $role){
                return $next($request);
        }

        return redirect('/shop')->with('error' , "You do not have permission to access this page .") ;  
    }
}
