<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use App\User;

class WebUser
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
        if( Session::get('user')->auth_type == 'multiple' || Session::get('user')->auth_type == 'normal') {
            return $next($request);
        }
        return redirect('/user/highlights');
    }
}
