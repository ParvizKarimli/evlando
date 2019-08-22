<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Report;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = auth()->user()->id;
        $posts = Post::where('user_id', '=', $user_id)
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('dashboard')->with('posts', $posts);
    }

    public function adminpanel()
    {
        if(auth()->user()->role === 'admin' || auth()->user()->role === 'mod')
        {
            $unseen_reports = Report::where('seen', 0)
                ->orderBy('id', 'desc')
                ->get();
            return view('adminpanel')->with('unseen_reports', $unseen_reports);
        }

        return view('adminpanel');
    }
}
