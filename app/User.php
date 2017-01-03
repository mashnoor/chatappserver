<?php

namespace App;

use Hootlex\Friendships\Traits\Friendable;
use Illuminate\Database\Eloquent\Model;
use App\Like;

class User extends Model
{
    //
    use Friendable;


    public function posts()
    {
        return $this->hasMany(Post::class);

    }
    public function likes()
    {
        return $this->belongsToMany('App\Post', 'likes', 'user_id', 'post_id');
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);

    }


}

