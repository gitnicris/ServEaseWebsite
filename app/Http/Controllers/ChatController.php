<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // Show chat list (all users you've messaged or received messages from)
    public function index()
    {
        $userId = Auth::id();

        // Get users the current user has chatted with
        $contacts = User::whereIn('id', function ($query) use ($userId) {
            $query->select('receiver_id')
                  ->from('messages')
                  ->where('sender_id', $userId);
        })
        ->orWhereIn('id', function ($query) use ($userId) {
            $query->select('sender_id')
                  ->from('messages')
                  ->where('receiver_id', $userId);
        })
        ->where('id', '!=', $userId)
        ->get();

        return view('chat.index', compact('contacts'));
    }

    // Show conversation with a specific user
    public function show($id)
    {
        $user = User::findOrFail($id);
        $messages = Message::where(function ($query) use ($id) {
                $query->where('sender_id', Auth::id())
                      ->where('receiver_id', $id);
            })
            ->orWhere(function ($query) use ($id) {
                $query->where('sender_id', $id)
                      ->where('receiver_id', Auth::id());
            })
            ->orderBy('created_at', 'asc')
            ->get();

        return view('chat.show', compact('user', 'messages'));
    }

    // Send a message
    public function store(Request $request, $receiver_id)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $receiver_id,
            'message' => $request->message,
        ]);

        return back();
    }
}
