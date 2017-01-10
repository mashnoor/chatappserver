<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use Carbon\Carbon;
use Faker\Provider\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Response;
use App\Like;

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


         $audio_file = Input::file('audio');
        //$audio_file->move(base_path() . "/uploads/" , $post->name . "." . $audio_file->getClientOriginalExtension());
        Storage::put(
            'uploads/'.$post->name,
            file_get_contents($audio_file->getRealPath())
        );

        $post->mime = $audio_file->getClientMimeType();
        $post->txtpost = $request->txtpost;
        $user->posts()->save($post);

        return "yo";



    }


    public function add_userimage($number)
    {

      





        $image_file = Input::file('userimage');
        //$audio_file->move(base_path() . "/uploads/" , $post->name . "." . $audio_file->getClientOriginalExtension());
        Storage::put(
            'userimages/'.$number,
            file_get_contents($image_file->getRealPath())
        );


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
        $user_name = $request->user_name;
   

        if(User::where('user_phone', '=', $user_Phone)->exists())
        {
            return 'Cant add';
        }

        $user = new User();
        $user->user_phone = $user_Phone;
        $user->user_name = $user_name;
        $user->save();
        return $user;



    }

    public function getfile($filename)
    {

        $post = Post::where('name', '=', $filename)->first();

        $file = Storage::get('/uploads/' . $filename);

        return (new Response($file, 200))
            ->header('Content-Type', $post->mime);
    }

    public function getimage($filename)
    {



        $file = Storage::get('/userimages/' . $filename);

        return (new Response($file, 200))
            ->header('Content-Type', 'image/jpeg');
    }

    public function login($user_phone)
    {
        $user = User::where('user_phone', '=', $user_phone)->first();
        if($user==null)
        {
            return 'error';
        }
        return $user;
    }

    public function isLikedBy($post_id, $user_id)
    {

        if (Like::whereUserId($user_id)->wherePostId($post_id)->exists()){
            return true;
        }
        return false;
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

            $tmp["userPhone"] = $curr_frnd->user_phone;
            $latestpost = Post::where('user_id', '=', $curr_frnd->id)->orderBy('created_at', 'desc')->first();
            if($latestpost!=null)
            {
                //$tmp["post_id"] = $latestpost->name;
                $post_id =  $latestpost->name;
                $tmp["id"] = (string)$latestpost->id;

                $tmp["voiceFile"] = $post_id;
               //$tmp["time"] = Carbon::parse($latestpost->created_at)->format("d/m/Y");
                $tmp["time"] = $latestpost->created_at->diffForHumans();
                $tmp["userName"] = $curr_frnd->user_name;
                $tmp["txtPost"] = $latestpost->txtpost;
                if($this->isLikedBy($tmp["id"], $user->id))
                {
                    $tmp["liked"] = true;
                }
                else
                {
                    $tmp["liked"] = false;
                }


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

    public function getFriends($number)
    {
         $user = User::where('user_phone', '=', $number)->first();
         $friends = $user->getFriends();
         return $friends;
    }

    public function getallposts($number)
    {
        $user = User::where('user_phone', '=', $number)->first();
        $user_posts = Post::where('user_id', '=', $user->id)->orderBy('created_at', 'desc')->get();

        return $user_posts;
    }




}
