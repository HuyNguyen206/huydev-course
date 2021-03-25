<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Administration
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
        if(Auth::check()){
            if(Auth::user()->isAdmin()){
                session()->flash('success', "You are authorize to access this page");
                return $next($request);
            }else{
                session()->flash('error', "You aren't authorize to access this page");
                return redirect('/');
            }
        }else{
            return redirect('/');
        }

    }
}
