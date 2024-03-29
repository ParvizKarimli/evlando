<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Image;
use App\Bookmark;
use App\Location;
use App\Report;
use Image as ImageLib;

class PostsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show', 'search', 'get_location_suggestions']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->role !== 'mod' && auth()->user()->role !== 'admin')
        {
            return redirect('/');
        }
        $posts = Post::orderBy('id', 'desc')->paginate(20);

        $unseen_reports = Report::where('seen', 0)
                ->orderBy('id', 'desc')
                ->paginate(10);
        $number_of_unseen_reports = Report::where('seen', 0)->count();

        return view('posts.index')->with([
            'posts' => $posts,
            'unseen_reports' => $unseen_reports,
            'number_of_unseen_reports' => $number_of_unseen_reports
        ]);
    }

    public function suspended()
    {
        if(auth()->user()->role !== 'mod' && auth()->user()->role !== 'admin')
        {
            return redirect('dashboard')->with('error', __('pages.unauthorized'));
        }
        $posts = Post::where('suspended', 1)
            ->orderBy('id', 'desc')
            ->paginate(20);

        $unseen_reports = Report::where('seen', 0)
                ->orderBy('id', 'desc')
                ->paginate(10);
        $number_of_unseen_reports = Report::where('seen', 0)->count();

        return view('posts.suspended')->with([
            'posts' => $posts,
            'unseen_reports' => $unseen_reports,
            'number_of_unseen_reports' => $number_of_unseen_reports
        ]);
    }

    public function active()
    {
        if(auth()->user()->role !== 'mod' && auth()->user()->role !== 'admin')
        {
            return redirect('dashboard')->with('error', __('pages.unauthorized'));
        }
        $posts = Post::where('suspended', 0)
            ->orderBy('id', 'desc')
            ->paginate(20);

        $unseen_reports = Report::where('seen', 0)
                ->orderBy('id', 'desc')
                ->paginate(10);
        $number_of_unseen_reports = Report::where('seen', 0)->count();

        return view('posts.active')->with([
            'posts' => $posts,
            'unseen_reports' => $unseen_reports,
            'number_of_unseen_reports' => $number_of_unseen_reports
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(auth()->user()->role === 'admin' || auth()->user()->role === 'mod')
        {
            $unseen_reports = Report::where('seen', 0)
                ->orderBy('id', 'desc')
                ->paginate(10);
            $number_of_unseen_reports = Report::where('seen', 0)->count();
            return view('posts.create')->with([
                'unseen_reports' => $unseen_reports,
                'number_of_unseen_reports' => $number_of_unseen_reports
            ]);
        }

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
        $custom_validation_messages = [
            'location_id.required' => 'The location field is required. Please select from the location suggestions.'
        ];
        $this->validate($request, [
            'location_id' => 'required',
            'type' => 'required|in:sale,rent',
            'property_type' => 'required|in:apartment,house',
            'floor' => 'required|integer|min:1|max:1000',
            'area' => 'required|integer|min:10|max:100000',
            'bedrooms' => 'required|integer|min:1|max:1000',
            'bathrooms' => 'required|integer|min:1|max:100',
            'price' => 'required|integer|min:1|max:1000000000',
            'description' => 'required',
            'cover_image' => 'image|nullable|max:1999'
        ], $custom_validation_messages);

        $number_of_images = e($request->numberOfImages);
        for($i=1; $i<=$number_of_images; $i++) {
            $image_element_name = 'image_' . $i;
            $this->validate($request, [
                $image_element_name => 'mimes:png,jpg,gif,jpeg|max:5000'
            ]);
        }

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
            $request->file('cover_image')->storeAs('public/images/cover_images', $filename_to_store);

            // Create thumbnail file name
            $thumbnail_name_to_store = $filename_salt . '_thumb.' . $file_extension;
            // Create thumbnail and upload to storage
            ImageLib::make('storage/images/cover_images/' . $filename_to_store)
                ->resize(340, 230)
                ->save('storage/images/cover_images/thumbnails/' . $thumbnail_name_to_store);
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
        $post->location_id = $request->input('location_id');
        $post->type = $request->input('type');
        $post->property_type = $request->input('property_type');
        $post->floor = $request->input('floor');
        $post->area = $request->input('area');
        $post->bedrooms = $request->input('bedrooms');
        $post->bathrooms = $request->input('bathrooms');
        $post->price = $request->input('price');
        $post->slug = str_slug(
            $request->input('property_type') .
            ' for ' . $request->input('type') .
            ' floor ' . $request->input('floor') .
            ' beds ' . $request->input('bedrooms') .
            ' baths ' . $request->input('bathrooms') . '-' .
            $request->input('location'),
            '-');
        $post->description = $request->input('description');
        $post->cover_image = $filename_to_store;
        $post->thumbnail = $thumbnail_name_to_store;
        $post->save();

        // Add images
        for($i = 1; $i<=$number_of_images; $i++) {
            $image_element_name = 'image_' . $i;
            if($request->hasFile($image_element_name)) {
                // Get just file extension without file name
                $file_extension = $request->file($image_element_name)->getClientOriginalExtension();
                // File name salt
                $filename_salt = mt_rand() . '_' . time();
                // File name to store in DB
                $filename_to_store = $filename_salt . '.' . $file_extension;
                // Upload image to storage
                $request->file($image_element_name)->storeAs('public/images', $filename_to_store);

                // Create thumbnail file name
                $thumbnail_name_to_store = $filename_salt . '_thumb.' . $file_extension;
                // Create thumbnail of cover image and upload to storage
                ImageLib::make('storage/images/' . $filename_to_store)
                    ->resize(150, 150)
                    ->save('storage/images/thumbnails/' . $thumbnail_name_to_store);

                $image = new Image;
                $image->post_id = $post->id;
                $image->filename = $filename_to_store;
                $image->filename_thumb = $thumbnail_name_to_store;
                $image->save();
            }
        }

        return redirect('/')->with('success', __('posts.created'));
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
        if(empty($post))
        {
            return redirect('/')->with('error', __('posts.not_found'));
        }
        elseif($post->suspended === 1)
        {
            if(auth()->guest() || (auth()->user()->role === 'user' && $post->user_id !== auth()->user()->id))
            {
                return redirect('/')->with('error', __('posts.error_suspended'));
            }
        }
        $images = $post->images;
        $number_of_images = count($images);
        $bookmarked = false;
        if(auth()->user())
        {
            $user_id = auth()->user()->id;
            if(!empty(Bookmark::where('user_id', $user_id)->where('post_id', $post->id)->first()))
            {
                $bookmarked = true;
            }
        }
        return view('posts.show')->with([
            'post' => $post,
            'images' => $images,
            'number_of_images' => $number_of_images,
            'bookmarked' => $bookmarked
        ]);
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
        if(empty($post))
        {
            return redirect('/')->with('error', __('posts.not_found'));
        }

        // Check for correct user
        if(auth()->user()->id !== $post->user_id)
        {
            return redirect('/posts/' . $post->id . '/' . $post->slug)->with('error', __('pages.unauthorized'));
        }

        $images = $post->images;

        if(auth()->user()->role === 'admin' || auth()->user()->role === 'mod')
        {
            $unseen_reports = Report::where('seen', 0)
                ->orderBy('id', 'desc')
                ->paginate(10);
            $number_of_unseen_reports = Report::where('seen', 0)->count();
            return view('posts.edit')->with([
                'post' => $post,
                'images' => $images,
                'unseen_reports' => $unseen_reports,
                'number_of_unseen_reports' => $number_of_unseen_reports
            ]);
        }

        return view('posts.edit')->with(['post' => $post, 'images' => $images]);
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
        $post = Post::find($id);
        if(empty($post))
        {
            return redirect('/')->with('error', __('posts.not_found'));
        }

        $custom_validation_messages = [
            'location_id.required' => 'The location field is required. Please select from the location suggestions.'
        ];
        $this->validate($request, [
            'location_id' => 'required',
            'type' => 'required|in:sale,rent',
            'property_type' => 'required|in:apartment,house',
            'floor' => 'required|integer|min:1|max:1000',
            'area' => 'required|integer|min:10|max:100000',
            'bedrooms' => 'required|integer|min:1|max:1000',
            'bathrooms' => 'required|integer|min:1|max:100',
            'price' => 'required|integer|min:1|max:1000000000',
            'description' => 'required',
            'cover_image' => 'image|nullable|max:1999'
        ], $custom_validation_messages);

        $number_of_images = e($request->numberOfImages);
        for($i=1; $i<=$number_of_images; $i++) {
            $image_element_name = 'image_' . $i;
            $this->validate($request, [
                $image_element_name => 'mimes:png,jpg,gif,jpeg|max:5000'
            ]);
        }

        // Update post
        // Handle File Upload
        if($request->hasFile('cover_image'))
        {
            // Delete old cover image and thumbnail if image is different than noimage
            if($post->cover_image && $post->cover_image !== 'noimage.jpg')
            {
                // Delete old cover image
                unlink('storage/images/cover_images/' . $post->cover_image);

                // Delete old thumbnail
                unlink('storage/images/cover_images/thumbnails/' . $post->thumbnail);
            }

            // Upload new cover image and thumbnail

            // Get just extension without filename
            $file_extension = $request->file('cover_image')->getClientOriginalExtension();
            // File name salt
            $filename_salt = mt_rand() . '_' . time();
            // File name to store in DB
            $filename_to_store = $filename_salt . '.' . $file_extension;
            // Upload image to storage
            $request->file('cover_image')->storeAs('public/images/cover_images', $filename_to_store);

            // Create thumbnail file name
            $thumbnail_name_to_store = $filename_salt . '_thumb.' . $file_extension;
            // Create thumbnail of cover image and upload to storage
            ImageLib::make('storage/images/cover_images/' . $filename_to_store)
                ->resize(340, 230)
                ->save('storage/images/cover_images/thumbnails/' . $thumbnail_name_to_store);
        }

        // Write to DB
        $post->location_id = $request->input('location_id');
        $post->type = $request->input('type');
        $post->property_type = $request->input('property_type');
        $post->floor = $request->input('floor');
        $post->area = $request->input('area');
        $post->bedrooms = $request->input('bedrooms');
        $post->bathrooms = $request->input('bathrooms');
        $post->price = $request->input('price');
        $post->slug = str_slug(
            $request->input('property_type') .
            ' for ' . $request->input('type') .
            ' floor ' . $request->input('floor') .
            ' beds ' . $request->input('bedrooms') .
            ' baths ' . $request->input('bathrooms') . '-' .
            $request->input('location'),
            '-');
        $post->description = $request->input('description');
        if($request->hasFile('cover_image'))
        {
            $post->cover_image = $filename_to_store;
            $post->thumbnail = $thumbnail_name_to_store;
        }
        $post->save();

        // Add images
        for($i = 1; $i<=$number_of_images; $i++) {
            $image_element_name = 'image_' . $i;
            if($request->hasFile($image_element_name)) {
                // Get just file extension without file name
                $file_extension = $request->file($image_element_name)->getClientOriginalExtension();
                // File name salt
                $filename_salt = mt_rand() . '_' . time();
                // File name to store in DB
                $filename_to_store = $filename_salt . '.' . $file_extension;
                // Upload image to storage
                $request->file($image_element_name)->storeAs('public/images', $filename_to_store);

                // Create thumbnail file name
                $thumbnail_name_to_store = $filename_salt . '_thumb.' . $file_extension;
                // Create thumbnail of cover image and upload to storage
                ImageLib::make('storage/images/' . $filename_to_store)
                    ->resize(150, 150)
                    ->save('storage/images/thumbnails/' . $thumbnail_name_to_store);

                $image = new Image;
                $image->post_id = $post->id;
                $image->filename = $filename_to_store;
                $image->filename_thumb = $thumbnail_name_to_store;
                $image->save();
            }
        }

        return redirect('/posts/' . $post->id . '/' . $post->slug)->with('success', __('posts.updated'));
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
        if(empty($post))
        {
            return redirect('/')->with('error', __('posts.not_found'));
        }

        // Check for correct user
        if(auth()->user()->id !== $post->user_id && auth()->user()->role !== 'mod' && auth()->user()->role !== 'admin')
        {
            return redirect('/posts/' . $post->id . '/' . $post->slug)->with('error', __('pages.unauthorized'));
        }

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

        return redirect('/')->with('success', __('posts.removed'));
    }

    public function suspend(Request $request)
    {
        if(auth()->user()->role !== 'mod' && auth()->user()->role !== 'admin')
        {
            return redirect('dashboard')->with('error', __('pages.unauthorized'));
        }
        $post_id = $request->id;
        $post = Post::find($post_id);
        if(empty($post))
        {
            return redirect('/posts')->with('error', __('posts.not_found'));
        }

        if($post->suspended === 0)
        {
            $post->suspended = 1;
            $post->save();
            return redirect()->back()->with('success', __('posts.suspended'));
        }
        elseif($post->suspended === 1)
        {
            $post->suspended = 0;
            $post->save();
            return redirect()->back()->with('success', __('posts.resumed'));
        }
    }

    // Remove Cover Image
    public function remove_cover_image(Request $request)
    {
        $id = $request->input('id');
        $post = Post::find($id);
        if(empty($post))
        {
            return redirect('/')->with('error', __('posts.not_found'));
        }

        if($post->cover_image && $post->cover_image !== 'noimage.jpg')
        {
            // Delete cover image
            unlink('storage/images/cover_images/' . $post->cover_image);

            // Delete thumbnail
            unlink('storage/images/cover_images/thumbnails/' . $post->thumbnail);
        }

        $post->cover_image = 'noimage.jpg';
        $post->thumbnail = 'noimage_thumb.jpg';
        $post->save();

        return redirect('/posts/' . $post->id . '/' . 'edit')->with('success', __('posts.cover_image_removed'));
    }

    // Remove Image
    public function remove_image(Request $request)
    {
        $id = $request->input('id');
        $image = Image::find($id);
        if(empty($image->post))
        {
            return redirect('/')->with('error', __('posts.not_found'));
        }
        if(!empty($image))
        {
            unlink('storage/images/' . $image->filename);
            unlink('storage/images/thumbnails/' . $image->filename_thumb);
        }
        $image->delete();
        return redirect()->back()->with('success', __('posts.image_removed'));
    }

    // Search posts
    public function search(Request $request)
    {
        $types = $request->input('types');
        $property_types = $request->input('property_types');
        $floor_min = $request->input('floor_min');
        $floor_max = $request->input('floor_max');
        $area_min = $request->input('area_min');
        $area_max = $request->input('area_max');
        $bedrooms_min = $request->input('bedrooms_min');
        $bedrooms_max = $request->input('bedrooms_max');
        $bathrooms_min = $request->input('bathrooms_min');
        $bathrooms_max = $request->input('bathrooms_max');
        $price_min = $request->input('price_min');
        $price_max = $request->input('price_max');
        $location_input = $request->input('location');
        if(empty($location_input))
        {
            $location_id = '';
        }
        else
        {
            $location_id = $request->input('location_id');
        }

        if(empty($types))
        {
            $types = ['sale', 'rent'];
        }
        if(empty($property_types))
        {
            $property_types = ['apartment', 'house'];
        }
        if(empty($floor_min))
        {
            $floor_min = 1;
        }
        if(empty($floor_max))
        {
            $floor_max = 1000;
        }
        if(empty($area_min))
        {
            $area_min = 10;
        }
        if(empty($area_max))
        {
            $area_max = 100000;
        }
        if(empty($bedrooms_min))
        {
            $bedrooms_min = 1;
        }
        if(empty($bedrooms_max))
        {
            $bedrooms_max = 1000;
        }
        if(empty($bathrooms_min))
        {
            $bathrooms_min = 1;
        }
        if(empty($bathrooms_max))
        {
            $bathrooms_max = 100;
        }
        if(empty($price_min))
        {
            $price_min = 1;
        }
        if(empty($price_max))
        {
            $price_max = 1000000000;
        }
        // If no location selected, then bring posts from all locations
        if(empty($location_id))
        {
            $posts = Post::where('suspended', 0)
                ->whereIn('type', $types)
                ->whereIn('property_type', $property_types)
                ->whereBetween('floor', [$floor_min, $floor_max])
                ->whereBetween('area', [$area_min, $area_max])
                ->whereBetween('bedrooms', [$bedrooms_min, $bedrooms_max])
                ->whereBetween('bathrooms', [$bathrooms_min, $bathrooms_max])
                ->whereBetween('price', [$price_min, $price_max])
                ->orderBy('id', 'desc')
                ->paginate(10);

            $number_of_active_posts = Post::where('suspended', 0)
                ->whereIn('type', $types)
                ->whereIn('property_type', $property_types)
                ->whereBetween('floor', [$floor_min, $floor_max])
                ->whereBetween('area', [$area_min, $area_max])
                ->whereBetween('bedrooms', [$bedrooms_min, $bedrooms_max])
                ->whereBetween('bathrooms', [$bathrooms_min, $bathrooms_max])
                ->whereBetween('price', [$price_min, $price_max])
                ->orderBy('id', 'desc')
                ->count();
        }
        else
        {
            $posts = Post::where('suspended', 0)
                ->where('location_id', $location_id)
                ->whereIn('type', $types)
                ->whereIn('property_type', $property_types)
                ->whereBetween('floor', [$floor_min, $floor_max])
                ->whereBetween('area', [$area_min, $area_max])
                ->whereBetween('bedrooms', [$bedrooms_min, $bedrooms_max])
                ->whereBetween('bathrooms', [$bathrooms_min, $bathrooms_max])
                ->whereBetween('price', [$price_min, $price_max])
                ->orderBy('id', 'desc')
                ->paginate(10);

            $number_of_active_posts = Post::where('suspended', 0)
                ->where('location_id', $location_id)
                ->whereIn('type', $types)
                ->whereIn('property_type', $property_types)
                ->whereBetween('floor', [$floor_min, $floor_max])
                ->whereBetween('area', [$area_min, $area_max])
                ->whereBetween('bedrooms', [$bedrooms_min, $bedrooms_max])
                ->whereBetween('bathrooms', [$bathrooms_min, $bathrooms_max])
                ->whereBetween('price', [$price_min, $price_max])
                ->orderBy('id', 'desc')
                ->count();
        }

        if(auth()->user())
        {
            $user_id = auth()->user()->id;
            $bookmarked_posts_ids = Bookmark::where('user_id', $user_id)
                ->pluck('post_id')
                ->toArray();

            return view('pages.index')->with([
                'posts' => $posts,
                'bookmarked_posts_ids' => $bookmarked_posts_ids,
                'number_of_active_posts' => $number_of_active_posts
            ]);
        }
        return view('pages.index', ['posts' => $posts, 'number_of_active_posts' => $number_of_active_posts]);
    }

    public function get_location_suggestions(Request $request)
    {
        $location_input_value = $request->input('location_input_value');
        if(!empty($location_input_value))
        {
            $locations = Location::where('city', 'like', $location_input_value . '%')->get();

            foreach($locations as $location)
            {
                echo '<p><a class="location-suggestion-row" title="Click to select the location suggestion" href="" ' .
                'location-id="' .
                $location->id . '">' . $location->city . ', ' . $location->province . ', ' . $location->country .
                '</a></p>';
            }
        }
    }
}
