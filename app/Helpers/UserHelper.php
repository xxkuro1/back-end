<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

class UserHelper {
    public static function  Registration(Request $request){
        $validation =Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required'

        ]);
        if($validation->fails()){
            return response()->json($validation->errors(),202);
        }
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json($user);
    }

    public static function login(Request $request){
        if(Auth::attempt([
            'email'=> $request->email,
            'password'=>$request->password
        ])){
            $user = Auth::user();

            $resArr= [];
            $resArr['access_token']=$user->createToken('access_token')->accessToken;
            $resArr['id']  =  $user->id;
            return response()->json($resArr,200);
        }else{
            return response()->json(['error'=>'Unauthorized Access'],203);
        }
    }

    public static function createPost(Request $request){
        $validation = Validator::make($request->all(),[
            'description'=>'required'


        ]);
        if($validation->fails()){
            return response()->json($validation->errors(),202);
        }

        //$user= Auth::user();
        $resArr = [];
        //$resArr['id'] = $user->id;
        $date = new DateTime();
        $posts = new Post;
        $posts->user_id = $request->user_id;
        $posts->description = $request->description;
        $posts->posted= $date->format('Y-m-d H:i:s');
        $posts->save();
        
        return response()->json($posts);

    }

    public static function allPosts(){

        $all  = DB::table('posts')
        ->select('description','name','user_id','posts.id','posts.posted')
        ->join('users','posts.user_id','=','users.id')
        ->get();
        return response()->json($all);
    }

    public static function deleteData($id){
        $posts = Post::find($id);
        $posts->delete();
        return response()->json($posts);
    }

}



?>