<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function images()
    {
        return $this->hasMany('App\Image');
    }

    public function bookmarks()
    {
        return $this->hasMany('App\Bookmark');
    }

    public function location()
    {
        return $this->belongsTo('App\Location');
    }

    public function reports()
    {
        return $this->hasMany('App\Report');
    }
}
