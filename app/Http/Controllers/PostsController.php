<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;

class PostsController extends Controller
{

    public function __construct()
    {
    }

    public function index(){
        $posts = Post::with(['user', 'comments', 'likes'])->get();

        return response()->json([
            'success' => true,
            'data' => $posts
        ], 200);
    }

    public function show($id){
        $post = Post::find($id)->first();

        return response()->json([
            'success' => true,
            'data' => $post
        ]);
    }

    public function store(Request $request){ 

        $user = JWTAuth::parseToken()->authenticate();
        
        $validator = Validator::make($request->all(), [
            'content' => 'required|string|max:255',
            'image_url' => 'nullable'
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'messages' => $validator->errors()
            ], 400);
        }

        Post::create([
            'user_id' => $user->id,
            'content' => $request->content,
            'image_url' => $request->image_url
        ]);

        return response()->json([
            'success' => true,
            'messages' => 'Post created successfully',
            'data' => $this->index()
        ], 201);
    }

    public function update(Request $request, $id){

         $validator = Validator::make($request->all(), [
            'content' => 'required|string|max:255',
            'image_url' => 'nullable'
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'messages' => $validator->errors()
            ], 400);
        }

        $post = Post::find($id);
        
        $post->update([
            'content' => $request['content'],
            'image_url' => $request['image_url']
        ]);

        return response()->json([
            'success' => true,
            'messages' => 'Post updated successfully',
            'data' => $this->index()
        ]);
    }

    public function destroy($id){
        $post = Post::find($id);
        $post->delete();

        return response()->json([
            'success' => true,
            'messages' => 'Post deleted successfully',
            'data' => $this->index()
        ]);
    }
}
