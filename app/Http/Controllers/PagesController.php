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
        $number_of_active_posts = Post::where('suspended', 0)->count();
        if(auth()->user())
        {
            $user_id = auth()->user()->id;
            $bookmarked_posts_ids = Bookmark::where('user_id', $user_id)
                ->pluck('post_id')
                ->toArray();

            return view('pages.index')->with([
                'posts' => $posts,
                'number_of_active_posts' => $number_of_active_posts,
                'bookmarked_posts_ids' => $bookmarked_posts_ids
            ]);
        }
        return view('pages.index')->with([
            'posts' => $posts,
            'number_of_active_posts' => $number_of_active_posts
        ]);
    }

    public function about()
    {
        return view('pages.about');
    }
}
