<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Like;

class Post extends Model
{
    //
    protected $fillable = ['name'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function likes()
    {
        return $this->belongsToMany('App\User', 'likes');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }


}
