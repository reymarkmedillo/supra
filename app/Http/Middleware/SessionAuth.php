<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use App\User;

class SessionAuth
{
    public function __construct(User $user) {
        $this->user = $user;
    }

    /**
     * Handle an incoming request.
     * FOR WEB USERS ONLY
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Session::has('token')) {
            if( strtotime(Session::get('token')['expired_date']) > strtotime(date('Y-m-d H:i:s')) ) {
                return $next($request);
            }
        }
        Session::flush();
        return redirect('/signin');
    }
}
