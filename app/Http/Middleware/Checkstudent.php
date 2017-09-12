<?php

namespace App\Http\Middleware;

use Closure;

class Checkstudent
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
       if (!$request->session()->has('login_user')) {
            // user value cannot be found in session
            return redirect('/std_login');
        }

        return $next($request);
    }
}
