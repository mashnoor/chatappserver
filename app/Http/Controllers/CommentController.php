<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class CommentController extends Controller
{
    //

    public function postcomment(Request $request)
    {


        $user = User::where('user_phone', '=', $request["number"])->first();
        return $request["test"];
    }
}
