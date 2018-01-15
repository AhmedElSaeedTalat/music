<?php

namespace App\Http\Middleware;

use App\User;
use Auth;
use Closure;

class checkAuth
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
        $response = $next($request);
        $user = new User;
        if(!Auth::check()){
             return redirect('http://localhost:8000/login');
        }
        if(auth()->user()->role === 'vendor' ){
          return redirect('http://localhost:8000/login');
        } else {
            return $response;
        }
    }
}
