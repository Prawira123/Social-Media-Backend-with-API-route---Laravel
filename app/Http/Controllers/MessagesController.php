<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;

class MessagesController extends Controller
{

    public function index(){
        $messages = Message::get();

        return response()->json([
            'success' => true,
            'data' => $messages
        ], 200);
    }
    public function show($id){
        $message = Message::find($id)->first();

        return response()->json([
            'success' => true,
            'data' => $message
        ], 200);
    }
    public function getMessages(int $user_id){

        $messages = Message::where('receiver_id', $user_id)->get();

        return response()->json([
            'success' => true,
            'data' => $messages
        ], 200);
    }

    public function store(Request $request){

        $user = JWTAuth::parseToken()->authenticate();
        
         $validator = Validator::make($request->all(), [
            'receiver_id' => 'required',
            'message_content' => 'required|string|max:255'
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'messages' => $validator->errors()
            ], 400);
        }

        Message::create([
            'sender_id' => $user->id,
            'receiver_id' => $request->receiver_id,
            'message_content' => $request->message_content
        ]);

        return response()->json([
            'success' => true,
            'messages' => 'Post created successfully',
            'data' => $this->index()
        ], 201);
    }

    public function destroy($id){
        $message = Message::find($id);
        $message->delete();

        return response()->json([
            'success' => true,
            'messages' => 'Message deleted successfully',
            'data' => $this->index()
        ]);
    }
}
