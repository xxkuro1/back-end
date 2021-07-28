<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use UserHelper;

class UserController extends Controller
{
    public function registration(Request $request){
        $registration  = UserHelper::Registration($request);
        return response()->json($registration->original);
    }

    public function login(Request $request){
        $login = UserHelper::login($request);
        return response()->json($login->original);
    }

    public function createPosts(Request $request){
        $posts = UserHelper::createPost($request);
        return response()->json($posts->original);
    }

    public function allPosts(){
        $all = UserHelper::allPosts();
        return response()->json($all->original);
    }

    public function deleteData($id){
        $posts = UserHelper::deleteData($id);
        return response()->json($posts->original);
    }
}
