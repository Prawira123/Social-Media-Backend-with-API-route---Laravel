<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;

class CommentsController extends Controller
{
    public function index(){
        $comments = Comment::get();

        return response()->json([
            'success' => true,
            'data' => $comments
        ], 200);
    }

    public function store(Request $request){
        $user = JWTAuth::parseToken()->authenticate();

        $validate = Validator::make($request->all(), [
            'post_id' => 'required',
            'content' => 'required|string|max:255'
        ]);

        if($validate->fails()){
            return response()->json([
                'success' => false,
                'messages' => $validate->errors()
            ], 400);
        }

        Comment::create([
            'user_id' => $user->id,
            'post_id' => $request->post_id,
            'content' => $request->content
        ]);

        return response()->json([
            'success' => true,
            'messages' => 'Comment created successfully',
            'data' => $this->index()
        ], 201);
    }

    public function destroy($id){
        $comment = Comment::find($id);
        $comment->delete();

        return response()->json([
            'success' => true,
            'messages' => 'Comment deleted successfully',
            'data' => $this->index()
        ]);
    }
}
