<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use Faker\Provider\Uuid;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;

class UserController extends Controller
{


    public function addFriends(Request $request, $number)
    {
        $user_list = $request->list;

        $curr_user = User::where('user_phone', '=', $number)->first();
       

        $lists = json_decode($user_list, true);




        foreach ($lists as $list)
        {
            $userno = $list["number"];
            $frnd_user = User::where('user_phone', '=', $userno)->first();
            if ($frnd_user!=null)
            {
                $this->make_friend($curr_user, $frnd_user);
            }
            //$this->add_user($userno);
        }
        return "Mission Done";

    }




    public function make_friend(User $user_1, User $user_2)
    {




        $user_1->beFriend($user_2);

        $user_2->acceptFriendRequest($user_1);

        return "Success";

    }

    public function add_post(Request $request, $number)
    {

        $user = User::where('user_phone', '=', $number)->first();



        $post = new Post();
        $post->name = Uuid::uuid();
        $user->posts()->save($post);


         $audio_file = Input::file('audio');
        $audio_file->move(base_path() . "/uploads/" , $post->name . $audio_file->getClientOriginalExtension());
        return "yo";



    }

    public function add_user($number)
    {
        $user = new User();
        $user->user_phone = $number;
        $user->save();
    }

    public function adduser(Request $request)
    {
        $user_Phone = $request->user_phone;

        if(User::where('user_phone', '=', $user_Phone)->exists())
        {
            return 'Cant add';
        }

        $user = new User();
        $user->user_phone = $user_Phone;
        $user->save();
        return "hi";



    }

    public function getLatestPosts($number)
    {
        $user = User::where('user_phone', '=', $number)->first();

        $friends = json_decode($user->getFriends(), true);
        $allLatestPosts = array();


        foreach ($friends as $friend)
        {

            $curr_frnd = User::find($friend['id']);
            $tmp = array();

            $tmp["number"] = $curr_frnd->user_phone;
            $latestpost = Post::where('user_id', '=', $curr_frnd->id)->orderBy('created_at', 'desc')->first();
            if($latestpost!=null)
            {
                //$tmp["post_id"] = $latestpost->name;
                $post_id =  $latestpost->name;

                $tmp["post_id"] = $post_id;
                array_push($allLatestPosts, $tmp);
                //return $post_id;
            }
            else
            {
                //return 'nulk';
            }






        }

        return json_encode($allLatestPosts);



    }




}
