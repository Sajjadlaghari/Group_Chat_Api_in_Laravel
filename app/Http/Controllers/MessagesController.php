<?php

namespace App\Http\Controllers;
use App\Models\Message;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class MessagesController extends Controller
{
    public function get_all_messages(){


        $messages=Message::with('user')->get();
        return response()->json(['Data'=>$messages]);        
    }

    public function send_message(Request $request){
        
        //  dd($request->post());
        $validator=Validator::make($request->all(),[
            'message' => 'required',
            'user_id' => 'required',
        ]);

        if($validator->fails())
        {
            $errors=$validator->errors();
            return response()->json(['error'=>$errors,'status'=>false]);
        }

        $message = new Message;

        if ($request->hasFile('image_path')) {
            $randomize = rand(111111, 999999);
            $extension = $request->file('image_path')->getClientOriginalExtension();
            $filename = $randomize . '.' . $extension;
            $image = $request->file('image_path')->move('public/', $filename);
            $message->image_path =$image;
        }

        $message->user_id = $request['user_id'];
        $message->message = $request['message'];
        // $message->image_path = $request['image_path'];

     


        if ($message->save()) {
            return response()->json([
                'status' => true,
                'message'=>'Message Sent'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Message did Not Send'
            ]);
        }
    }
}
