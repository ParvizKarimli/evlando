<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bookmark;

class BookmarksController extends Controller
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
        $user_id = auth()->user()->id;
        $bookmarks = Bookmark::join('posts', 'bookmarks.post_id', '=', 'posts.id')
            ->select('bookmarks.id as id', 'bookmarks.post_id as post_id')
            ->where('bookmarks.user_id', $user_id)
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view('bookmarks.index')->with('bookmarks', $bookmarks);
    }

    // Add or remove bookmark
    public function bookmark(Request $request)
    {
        $post_id = $request->input('post_id');
        $user_id = auth()->user()->id;

        if(empty(Bookmark::where('user_id', $user_id)->where('post_id', $post_id)->first()))
        {
            $bookmark = new Bookmark;
            $bookmark->user_id = $user_id;
            $bookmark->post_id = $post_id;
            $bookmark->save();
        }
        else
        {
            $bookmark = Bookmark::where('user_id', $user_id)->where('post_id', $post_id)->first();
            $bookmark->delete();
        }
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
        //
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
        $bookmark = Bookmark::find($id);
        if(empty($bookmark))
        {
            return redirect('/bookmarks')->with('error', 'Bookmark Not Found');
        }

        // Check for correct user
        if(auth()->user()->id !== $bookmark->user_id)
        {
            return redirect('bookmarks')->with('error', 'Unauthorized Page');
        }

        $bookmark->delete();

        return redirect('bookmarks')->with('success', 'Bookmark Removed');
    }

    // For sale
    public function sale()
    {
        $user_id = auth()->user()->id;
        $bookmarks = Bookmark::join('posts', 'bookmarks.post_id', '=', 'posts.id')
            ->select('bookmarks.id as id', 'bookmarks.post_id as post_id')
            ->where('bookmarks.user_id', $user_id)
            ->where('type', 'sale')
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view('bookmarks.sale')->with('bookmarks', $bookmarks);
    }

    // For rent
    public function rent()
    {
        $user_id = auth()->user()->id;
        $bookmarks = Bookmark::join('posts', 'bookmarks.post_id', '=', 'posts.id')
            ->select('bookmarks.id as id', 'bookmarks.post_id as post_id')
            ->where('bookmarks.user_id', $user_id)
            ->where('type', 'rent')
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view('bookmarks.rent')->with('bookmarks', $bookmarks);
    }
}
