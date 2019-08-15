<?php

namespace App\Http\Middleware;

use Closure;

class CheckBanned
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
        if(auth()->check() && auth()->user()->banned)
        {
            auth()->logout();

            $message = "Your account has been banned.";

            return redirect()->route('login')->with('error', $message);
        }

        return $next($request);
    }
}
