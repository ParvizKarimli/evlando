<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class LanguagesController extends Controller
{
    public function set(Request $request)
    {
        if(empty($request->lang))
        {
            return back()->with('error', 'No Language Selected');
        }
        elseif($request->lang !== 'en' && $request->lang !== 'az')
        {
            return back()->with('error', 'Undefined Language');
        }
        else
        {
            //\App::setLocale($request->lang);
            //\Config::set('app.locale', $request->lang);
            if(auth()->guest())
            {
                session(['current_lang' => $request->lang]);
            }
            elseif(auth()->check())
            {
                $user_id = auth()->id();
                $user = User::find($user_id);
                $user->lang = $request->lang;
                $user->save();
            }
            return back();
        }
    }
}
