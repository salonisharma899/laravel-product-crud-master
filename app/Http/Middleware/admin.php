<?php

namespace App\Http\Middleware;

use Closure;

class admin
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

        /*
        * User Roles
        * is_permission = 1 for Admin
        *is_permission = 0 for User
        */
        if (\Auth::user()->is_permission == 1) 
        {
           return $next($request);
        }
        else
        {
           abort(401, 'You dont have access to this page');
        }

        return redirect('home');
    }
}
