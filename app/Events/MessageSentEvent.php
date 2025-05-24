<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;

class MessageSentEvent implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    /**
     * @var Message
     */
    public $message;

    /**
     * @param Message $message
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * @return Channel
     */
    public function broadcastOn(): Channel
    {
        return new PrivateChannel('chat.' . $this->message->user_id);
    }

    /**
     * @return string
     */
    public function broadcastAs()
    {
        return 'message.received';
    }

    /**
     * @return array
     */
    public function broadcastWith(): array
    {
        return [
            'id' => $this->message->id,
            'message' => $this->message->message,
            'response' => $this->message->response,
            'user_id' => $this->message->user_id,
            'created_at' => $this->message->created_at->toDateTimeString(),
            'updated_at' => $this->message->updated_at->toDateTimeString(),
        ];
    }
}
