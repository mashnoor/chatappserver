<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;

class TimelineController extends Controller
{
    public function getTimeline($user_id)
    {
        //First Get all the posts
        $user = User::find($user_id);
        $posts = $user->posts;
        $result_array = array();
        foreach ($posts as $post) {
            $temp_array = array();

            $time = $post->created_at;
            $temp_array["text"] = "You have posted something on your timeline!";
            $temp_array["time"] = $time;

            array_push($result_array, $temp_array);
        }
        //Find and Get all the comments
        $comments = $user->comments;
        foreach ($comments as $comment) {
            $temp_array = array();

            $postUserName = Post::find($comment->post_id);
            $postUserName = $postUserName->user->user_name;

            $time = $comment->created_at;
            $temp_array["text"] = "You have commented on a post of " . $postUserName;
            $temp_array["time"] = $time;

            array_push($result_array, $temp_array);
        }



        return $result_array;
    }

}
