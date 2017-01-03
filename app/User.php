<?php

namespace App;

use Hootlex\Friendships\Traits\Friendable;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    //
    use Friendable;


    public function posts()
    {
        return $this->hasMany(Post::class);

    }
    public function comments()
    {
        return $this->hasMany(Comment::class);

    }


}

