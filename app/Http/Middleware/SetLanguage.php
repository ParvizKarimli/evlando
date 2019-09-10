<?php

namespace App\Http\Middleware;

use Closure;

class SetLanguage
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
        if(auth()->guest())
        {
            if(session()->has('current_lang'))
            {
                \App::setLocale(session('current_lang'));
            }
        }
        elseif(auth()->check())
        {
            $user_id = auth()->id();
            $user = \App\User::find($user_id);
            $user_lang = $user->lang;
            \App::setLocale($user_lang);
        }

        return $next($request);
    }
}
