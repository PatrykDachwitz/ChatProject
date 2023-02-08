<?php
declare(strict_types=1);
namespace App\Repository\Eloquent;
use App\Models\notification;
use App\Repository\NotificationRepository as NotificationRepositoryInterface;

class NotificationRepository implements NotificationRepositoryInterface
{

    protected $notification, $id;

    public function __construct(notification $notification) {
        $this->notification = $notification;
    }

    public function create(array $data) {
        return $this->notification->create($data);
    }

    public function find(int $id)
    {
        return $this->notification->find($id);
    }

    public function destroy(int $id)
    {
        return $this->notification
            ->find($id)
            ->delete();
    }

    public function update(array $data, int $id)
    {
        $notification = $this->notification->find($id);

        $notification->message = $data['message'] ?? $notification->message;
        $notification->sender_id = $data['sender_id'] ?? $notification->sender_id;
        $notification->recipient_id = $data['recipient_id'] ?? $notification->recipient_id;
        $notification->save();

        return $notification;
    }

    public function get(int $id)
    {
        $this->id = $id;
        return $this->notification
            ->scopeRecipient($id)
            ->get();
    }
}