<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if(Session::has('token')) {
            if( strtotime(Session::get('token')['expired_date']) > strtotime(date('Y-m-d H:i:is')) ) {
                return redirect('/');
            }
            return $next($request);
        }

        return $next($request);
    }
}
