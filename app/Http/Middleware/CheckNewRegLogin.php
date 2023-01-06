<?php

namespace App\Http\Middleware;

use Closure;

class CheckNewRegLogin
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
        if (!$request->session()->has('currentSession')) {
           
            return redirect('newRegLogin');
        }

        return $next($request);
    }
}
