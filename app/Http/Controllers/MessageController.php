<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display a list of all conversations (for both customer and provider)
     */
    public function indexList()
    {
        $user = Auth::user();

        // Fetch all bookings where the user is either provider or customer
        $conversations = Booking::where(function ($query) use ($user) {
            $query->where('customer_id', $user->id)
                  ->orWhere('provider_id', $user->id);
        })
        ->with(['customer', 'provider', 'messages' => function ($query) {
            $query->latest()->take(1); // Get latest message for preview
        }])
        ->latest()
        ->get();

        return view('messages.index', compact('conversations'));
    }

    /**
     * Show a single chat thread for a booking
     */
    public function index($bookingId)
    {
        $booking = Booking::with(['service', 'customer', 'provider'])->findOrFail($bookingId);

        // Ensure the user belongs to this chat
        if (Auth::id() !== $booking->customer_id && Auth::id() !== $booking->provider_id) {
            abort(403, 'Unauthorized access to this conversation.');
        }

        $messages = Message::where('booking_id', $bookingId)
            ->orderBy('created_at', 'asc')
            ->get();

        return view('messages.chat', compact('booking', 'messages'));
    }

    /**
     * Send a message between customer and provider
     */
    public function send(Request $request, $bookingId)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $booking = Booking::findOrFail($bookingId);

        // Ensure the sender is either the customer or provider in this booking
        if (Auth::id() !== $booking->customer_id && Auth::id() !== $booking->provider_id) {
            abort(403, 'Unauthorized sender.');
        }

        $receiverId = Auth::id() === $booking->customer_id
            ? $booking->provider_id
            : $booking->customer_id;

        Message::create([
            'booking_id' => $booking->id,
            'sender_id' => Auth::id(),
            'receiver_id' => $receiverId,
            'message' => $request->message,
        ]);

        return redirect()->back()->with('success', 'Message sent successfully!');
    }
}
