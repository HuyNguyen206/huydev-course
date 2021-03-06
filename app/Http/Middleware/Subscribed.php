<?php

namespace App\Http\Middleware;

use Closure;

class Subscribed
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
        $user = auth()->user();
        if($user){
                if($user->subscribed('default')){
                    return $next($request);
                }
                else{
                    return redirect('subscribe');
                }
        }
        return redirect('login');
    }
}
