<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;

class MessageSent implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct(Message $message)
    {
        $this->message = $message->load('sender');
    }

    public function broadcastOn()
{
    // match routes/channels.php and your JS: "booking.{bookingId}"
    return new PrivateChannel('booking.' . $this->message->booking_id);
}


    public function broadcastWith()
    {
        return [
            'id' => $this->message->id,
            'booking_id' => $this->message->booking_id,
            'sender_id' => $this->message->sender_id,
            'sender_name' => $this->message->sender->name ?? null,
            'message' => $this->message->message,
            'created_at' => $this->message->created_at->toDateTimeString(),
        ];
    }

    public function broadcastAs()
    {
        return 'MessageSent';
    }
}
