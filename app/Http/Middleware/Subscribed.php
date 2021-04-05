<?php

namespace App\Http\Middleware;

use App\Model\Lesson;
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
            $lesson = $request->route('lesson');
//            dd($lesson);
            if($lesson->premium){
                if($user->subscribed('default')){
                    return $next($request);
                }
                else{
                    return redirect('subscribe');
                }
            }
            else{
                return $next($request);
            }
        }
            return redirect('login');
    }
}
