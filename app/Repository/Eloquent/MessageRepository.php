<?php
declare(strict_types=1);
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

    public function get(array $data)
    {
        if(
            !isset($data['filters']['sender'])
            |
            !isset($data['filters']['recipient'])
        ) return [];

        $messages = $this->message->newQuery();

        $messages->whereIn('sender_id', [$data['filters']['sender'], $data['filters']['recipient']]);
        $messages->whereIn('recipient_id', [$data['filters']['sender'], $data['filters']['recipient']]);

        foreach ($data['filters']['created_at'] ?? [] as $filter) {
            $messages->where('created_at',$filter['type'], $filter['value']);
        }
        return $messages
            ->limit($data['limit'] ?? 20)
            ->latest()
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