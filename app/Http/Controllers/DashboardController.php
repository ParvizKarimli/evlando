<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

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
        $posts = Post::where('user_id', '=', $user_id)->orderBy('id', 'desc')->paginate(10);

        return view('dashboard')->with('posts', $posts);
    }

    public function adminpanel()
    {
        echo 'There will be a beautiful admin panel here soon...';
    }
}
