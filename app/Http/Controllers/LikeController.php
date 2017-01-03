<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Post;
use App\Like;

class LikeController extends Controller
{
    //
    public function isLikedBy($post_id, $user_id)
    {
        
        if (Like::whereUserId($user_id)->wherePostId($post_id)->exists()){
            return 'true';
        }
        return 'false';
    }

    public function like($post_id, $user_id)
    {
        echo $user_id;
        $post = Post::findOrFail($post_id)->first();
        $existing_like = Like::wherePostId($post->id)->whereUserId($user_id)->first();

        if (is_null($existing_like)) {
           $like = new Like();
            $like->user_id = $user_id;
            $like->post_id = $post_id;
            $like->save();
        } else {
           $existing_like->delete();
        }
    }
}
