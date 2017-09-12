<?php

namespace App\Http\Middleware;

use Closure;

class Checkudg
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
        if (!$request->session()->has('u_login_user')) {
           
            return redirect('/enter_pin');
        }

        return $next($request);
    }
}
