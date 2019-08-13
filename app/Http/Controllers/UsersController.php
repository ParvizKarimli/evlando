<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Bookmark;

class UsersController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->role !== 'admin')
        {
            return redirect('dashboard')->with('error', 'Unauthorized Page');
        }
        $users = User::orderBy('id', 'desc')->paginate(20);
        return view('users.index')->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        if(empty($user))
        {
            return redirect('/users')->with('error', 'User Not Found');
        }

        $posts = Post::where('user_id', $id)
            ->orderBy('id', 'desc')
            ->paginate(10);
        if(auth()->user())
        {
            $user_id = auth()->user()->id;
            $bookmarked_posts_ids = Bookmark::where('user_id', $user_id)
                ->pluck('post_id')
                ->toArray();

            return view('users.show')->with(['user' => $user, 'posts' => $posts, 'bookmarked_posts_ids' => $bookmarked_posts_ids]);
        }
        return view('users.show')->with(['user' => $user, 'posts' => $posts]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
