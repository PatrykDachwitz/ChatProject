<?php

namespace App\Listeners;

use App\Repository\NotificationRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotificationRegister
{
    private $notificationRepository;
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

    private function findNotification(array $filters) {
        if (isset($filters['message'])) unset($filters['message']);

        return ($this->notificationRepository->findByFilters($filters))->id ?? 0;
    }
    private function clearNotificationNotice(array $filters) {
       $idNotification = $this->findNotification($filters);

        if ($idNotification > 0) {
            $this->notificationRepository->destroy(
                $idNotification
            );
        }
    }

    public function handle($event)
    {
        $this->clearNotificationNotice($event->notificationData);
        $this->notificationRepository->create($event->notificationData);
    }
}
