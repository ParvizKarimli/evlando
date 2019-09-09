<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        elseif($request->lang === 'en')
        {
            \App::setLocale('en');
        }
        elseif($request->lang === 'az')
        {
            \App::setLocale('az');
        }

        return back()->with('success', 'Language changed to ' . \App::getLocale());
    }
}
