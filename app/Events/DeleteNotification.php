<?php

namespace App\Events;

use App\Models\Message;
use App\Repository\MessageRepository;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DeleteNotification
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $filters;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(int $sender, int $recipient)
    {
        $this->filters = [
            'sender_id' => $sender,
            'recipient_id' => $recipient,
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
