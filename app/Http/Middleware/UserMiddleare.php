<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserMiddleare
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::check() && Auth::user()->Banned)
        {
            $banned = Auth::user()->Banned == '1';
            Auth::logout();

            if($banned == 1)
            {
                $message = 'Account deactivated. Kindly contact administrator.';
            }
            return redirect()->route('login')                
                ->withErrors(['email' =>'Account deactivated. Kindly contact administrator.']);
        }
        return $next($request);
    }
}
