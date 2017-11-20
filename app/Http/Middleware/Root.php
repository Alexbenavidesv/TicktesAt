<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Closure;

class Root
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
        if (!(Auth::user()->id_rol == 1)) {
            if(Auth::user()->id_rol==2) {
                return new RedirectResponse(url('/crear_ticket'));
            }
            if(Auth::user()->id_rol==3) {
                return new RedirectResponse(url('/consultar_ticket'));
            }
        }
        return $next($request);
    }
}
