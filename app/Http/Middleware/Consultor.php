<?php

namespace App\Http\Middleware;

use Closure;

class Consultor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!(Auth::user()->id_rol == 3)) {
            return new RedirectResponse(url('/consultartickets'));
        }
        return $next($request);
    }
}
