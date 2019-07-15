<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Image;

class PostsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('id', 'desc')->paginate(10);
        return view('posts.index')->with('posts', $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'cover_image' => 'image|nullable|max:1999'
        ]);

        // Handle File Upload
        if($request->hasFile('cover_image'))
        {
            // Get just file extension without file name
            $file_extension = $request->file('cover_image')->getClientOriginalExtension();
            // File name salt
            $filename_salt = mt_rand() . '_' . time();
            // File name to store in DB
            $filename_to_store = $filename_salt . '.' . $file_extension;
            // Upload image to storage
            $request->file('cover_image')->storeAs('public/images', $filename_to_store);

            // Create thumbnail file name
            $thumbnail_name_to_store = $filename_salt . '_thumb.' . $file_extension;
            // Create thumbnail and upload to storage
            Image::make('storage/images/' . $filename_to_store)
                ->resize(340, 230)
                ->save('storage/images/thumbnails/' . $thumbnail_name_to_store);
        }
        else
        {
            // If no file selected
            $filename_to_store = 'noimage.jpg';
            $thumbnail_name_to_store = 'noimage_thumb.jpg';
        }

        // Create post and write to DB
        $post = new Post;
        $post->user_id = auth()->user()->id;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->cover_image = $filename_to_store;
        $post->thumbnail = $thumbnail_name_to_store;
        $post->save();

        return redirect('posts')->with('success', 'Post Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        $images = $post->images;
        $number_of_images = count($images);
        return view('posts.show')->with(['post' => $post, 'images' => $images, 'number_of_images' => $number_of_images]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);

        // Check for correct user
        if(auth()->user()->id !== $post->user_id)
        {
            return redirect('posts')->with('error', 'Unauthorized Page');
        }

        return view('posts.edit')->with('post', $post);
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
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'cover_image' => 'image|nullable|max:1999'
        ]);

        // Update post
        $post = Post::find($id);

        // Handle File Upload
        if($request->hasFile('cover_image'))
        {
            // Delete old cover image and thumbnail if image is different than noimage
            if($post->cover_image && $post->cover_image !== 'noimage.jpg')
            {
                // Delete old cover image
                unlink('storage/images/' . $post->cover_image);

                // Delete old thumbnail
                unlink('storage/images/thumbnails/' . $post->thumbnail);
            }

            // Upload new cover image and thumbnail

            // Get just extension without filename
            $file_extension = $request->file('cover_image')->getClientOriginalExtension();
            // File name salt
            $filename_salt = mt_rand() . '_' . time();
            // File name to store in DB
            $filename_to_store = $filename_salt . '.' . $file_extension;
            // Upload image to storage
            $request->file('cover_image')->storeAs('public/images', $filename_to_store);

            // Create thumbnail file name
            $thumbnail_name_to_store = $filename_salt . '_thumb.' . $file_extension;
            // Create thumbnail of cover image and upload to storage
            Image::make('storage/images/' . $filename_to_store)
                ->resize(340, 230)
                ->save('storage/images/thumbnails/' . $thumbnail_name_to_store);
        }

        // Write to DB
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        if($request->hasFile('cover_image'))
        {
            $post->cover_image = $filename_to_store;
            $post->thumbnail = $thumbnail_name_to_store;
        }
        $post->save();

        return redirect('posts/' . $post->id)->with('success', 'Post Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);

        // Check for correct user
        if(auth()->user()->id !== $post->user_id)
        {
            return redirect('posts')->with('error', 'Unauthorized Page');
        }

        if($post->cover_image && $post->cover_image !== 'noimage.jpg')
        {
            // Delete cover image
            unlink('storage/images/' . $post->cover_image);

            // Delete thumbnail
            unlink('storage/images/thumbnails/' . $post->thumbnail);
        }

        // Delete from DB
        $post->delete();

        return redirect('posts')->with('success', 'Post Removed');
    }

    // Remove Cover Image
    public function remove_cover_image(Request $request)
    {
        $id = $request->input('id');
        $post = Post::find($id);
        if(!empty($post))
        {
            if($post->cover_image && $post->cover_image !== 'noimage.jpg')
            {
                // Delete cover image
                unlink('storage/images/' . $post->cover_image);

                // Delete thumbnail
                unlink('storage/images/thumbnails/' . $post->thumbnail);
            }

            $post->cover_image = 'noimage.jpg';
            $post->thumbnail = 'noimage_thumb.jpg';
            $post->save();

            return redirect('posts/' . $post->id . '/' . 'edit')->with('success', 'Cover Image Removed');
        }
        else
        {
            return redirect('posts')->with('error', 'Post Not Found');
        }
    }
}
