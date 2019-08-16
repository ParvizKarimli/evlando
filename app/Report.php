<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User', 'reported_user_id');
    }

    public function post()
    {
        return $this->belongsTo('App\Post');
    }
}
