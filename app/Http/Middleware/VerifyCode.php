<?php

namespace App\Http\Middleware;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Closure;

class VerifyCode
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

        if (Auth::guard()->check()) {  // if he already registered and have account

            if(Auth::user() -> password_verified_at == null){

                return redirect(RouteServiceProvider::VERIFIED);

            }

        }
        return $next($request);
    }
}
