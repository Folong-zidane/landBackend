<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function send(Request $request)
    {
        $message = Message::create([
            'sender_id' => $request->user()->id,
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);

        return response()->json(['message' => 'Message envoyé', 'data' => $message]);
    }

    public function index()
    {
        $messages = Message::where('receiver_id', auth()->id())->orWhere('sender_id', auth()->id())->get();
        return response()->json($messages);
    }
    // app/Http/Controllers/MessageController.php
public function getUserConversations()
{
    $conversations = Conversation::where('user_id', auth()->id())->with('messages')->get();
    return response()->json($conversations);
}

public function getAdminConversations()
{
    $conversations = Conversation::where('admin_id', auth()->id())->with('messages')->get();
    return response()->json($conversations);
}

}
