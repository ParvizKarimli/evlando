<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Bookmark;
use App\Image;

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
        $user = User::find($id);
        if(empty($user))
        {
            return redirect('/dashboard')->with('error', 'User Not Found');
        }
        elseif($user->id !== auth()->user()->id)
        {
            return redirect('/dashboard')->with('error', 'Unauthorized Page');
        }

        return view('users.edit');
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
        $user = User::find($id);
        if(empty($user))
        {
            return redirect('/dashboard')->with('error', 'User Not Found');
        }
        elseif($user->id !== auth()->user()->id)
        {
            return redirect('/dashboard')->with('error', 'Unauthorized Page');
        }

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'required|min:6|confirmed'
        ]);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->save();

        return redirect('/dashboard')->with('success', 'User Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Chech if the logged in user is admin or
        // the user wants to delete itself.
        // Add 0 to string ($id comes from the url so it's a string) and
        // PHP will automatically convert it to number
        if(auth()->user()->role !== 'admin' && $id + 0 !== auth()->user()->id)
        {
            return redirect('dashboard')->with('error', 'Unauthorized Page');
        }

        $user = User::find($id);
        if(empty($user))
        {
            return redirect('/users')->with('error', 'User Not Found');
        }
        elseif($user->role === 'admin')
        {
            return redirect('/users')->with('error', 'Admin Cannot Be Deleted');
        }

        // Delete posts of the user to be deleted
        $posts = Post::where('user_id', $id)->cursor();
        foreach($posts as $post)
        {
            if($post->cover_image && $post->cover_image !== 'noimage.jpg')
            {
                // Delete cover image
                unlink('storage/images/cover_images/' . $post->cover_image);

                // Delete thumbnail
                unlink('storage/images/cover_images/thumbnails/' . $post->thumbnail);
            }

            $images = $post->images;
            foreach($images as $image)
            {
                unlink('storage/images/' . $image->filename);
                unlink('storage/images/thumbnails/' . $image->filename_thumb);
            }

            Image::where('post_id', $post->id)->delete();

            Bookmark::where('post_id', $post->id)->delete();

            // Delete from DB
            $post->delete();
        }

        $user->delete();

        return redirect('users')->with('success', 'User Removed');
    }

    public function ban(Request $request)
    {
        if(auth()->user()->role !== 'admin')
        {
            return redirect('/dashboard')->with('error', 'Unauthorized Page');
        }

        $id = $request->id;
        $user = User::find($id);
        if(empty($user))
        {
            return redirect('/users')->with('error', 'User Not Found');
        }
        elseif($user->role === 'admin')
        {
            return redirect('/users')->with('error', 'Admin Cannot Be Banned');
        }

        if($user->banned === 0)
        {
            $user->banned = 1;
            $user->save();
            return redirect('/users')->with('success', 'User Banned');
        }
        elseif($user->banned === 1)
        {
            $user->banned = 0;
            $user->save();
            return redirect('/users')->with('success', 'User Resumed');
        }
    }

    public function banned()
    {
        if(auth()->user()->role !== 'admin')
        {
            return redirect('dashboard')->with('error', 'Unauthorized Page');
        }
        $users = User::where('banned', 1)
            ->orderBy('id', 'desc')
            ->paginate(20);
        return view('users.index')->with('users', $users);
    }

    public function active()
    {
        if(auth()->user()->role !== 'admin')
        {
            return redirect('dashboard')->with('error', 'Unauthorized Page');
        }
        $users = User::where('banned', 0)
            ->orderBy('id', 'desc')
            ->paginate(20);
        return view('users.index')->with('users', $users);
    }
}
