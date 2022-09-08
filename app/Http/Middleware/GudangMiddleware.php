<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class GudangMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if((Auth::user()->level != '3')&&(Auth::user()->status != "Aktif")){
            return \Redirect()->to('/');
        }
        return $next($request);
    }
}
