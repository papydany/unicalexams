<?php

namespace App\Http\Middleware;

use Closure;

class Checkreg
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
       if (!$request->session()->has('pds_login_user')) {
           
            return redirect('/pds_enter_pin');
        }

        return $next($request);
    }
}
