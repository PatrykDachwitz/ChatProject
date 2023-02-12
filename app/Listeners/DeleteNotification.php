<?php

namespace App\Listeners;

use App\Models\notification;
use App\Repository\MessageRepository;
use App\Repository\NotificationRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DeleteNotification
{
    private $notificationRepository, $notification;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(NotificationRepository $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */

    private function getNotification($event) {
        $this->notification = $this->notificationRepository->findByFilters($event->filters);
    }

    private function deleteNotification() {
        if ($this->notification instanceof notification) {
            $this->notificationRepository->destroy(
                $this->notification->id
            );
        }
    }

    public function handle($event)
    {
        $this->getNotification($event);
        $this->deleteNotification();
    }
}
