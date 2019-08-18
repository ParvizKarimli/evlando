<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Bookmark;

class PagesController extends Controller
{
    public function index()
    {
        $posts = Post::where('suspended', 0)
            ->orderBy('id', 'desc')
            ->paginate(10);
        if(auth()->user())
        {
            $user_id = auth()->user()->id;
            $bookmarked_posts_ids = Bookmark::where('user_id', $user_id)
                ->pluck('post_id')
                ->toArray();

            return view('pages.index')->with(['posts' => $posts, 'bookmarked_posts_ids' => $bookmarked_posts_ids]);
        }
        return view('pages.index')->with('posts', $posts);
    }

    public function about()
    {
        return view('pages.about');
    }
}
