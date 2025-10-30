<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;

class LikesController extends Controller
{
    public function index(){
        $likes = Like::all();

        return response()->json([
            'success' => true,
            'data' => $likes    
        ]);
    }

    public function store(Request $request){

        $user = JWTAuth::parseToken()->authenticate();

        $validate = Validator::make($request->all(), [
            'post_id' => 'required', 
        ]);

        if($validate->fails()){
            return response()->json([
                'success' => false,
                'messages' => $validate->errors()
            ], 400);
        }

        Like::create([
            'user_id' => $user->id,
            'post_id' => $request->post_id,
        ]);

        return response()->json([
            'success' => true,
            'messages' => 'Comment created successfully',
            'data' => $this->index()
        ]);
    }

    public function destroy($id){
        $like = Like::find($id);
        $like->delete();    

        return response()->json([
            'success' => true,
            'messages' => 'Like deleted successfully',
            'data' => $this->index()
        ]);
    }
}
