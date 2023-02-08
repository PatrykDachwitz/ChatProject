<?php

namespace App\Repository\Eloquent;

use App\Models\Message;
use App\Repository\MessageRepository as MessageRepositoryInterface;

class MessageRepository implements MessageRepositoryInterface
{
    protected $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public function get(int $id)
    {
        return $this->message
            ->scopeRecipientsMessage($id)
            ->get();
    }

    public function find(int $id)
    {
        return $this->message->find($id);
    }

    public function create(array $data)
    {
        return $this->message->create($data);
    }

    public function update(array $data, int $id)
    {
        $message = $this->message->find($id) ?? new $this->message();

        $message->message = $data['message'] ?? $message->message;
        $message->readed = $data['readed'] ?? $message->readed;
        $message->sender_id = $data['sender_id'] ?? $message->sender_id;
        $message->recipient_id = $data['recipient_id'] ?? $message->recipient_id;
        $message->save();

        return $message;
    }
}