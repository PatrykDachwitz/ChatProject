<?php
declare(strict_types=1);
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Notification;
use App\Http\Resources\Notifications;
use App\Repository\NotificationRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\Store\Notification as NotificationStore;
use App\Http\Requests\Update\Notification as NotificationUpdate;

class NotificationController extends Controller
{
    private $notificationRepository;
    public function __construct(NotificationRepository $notificationRepository) {
        $this->notificationRepository = $notificationRepository;
    }

    private function verificationOwner($id) {
        $notification = $this->notificationRepository->find($id);

        if (Gate::denies('mySelf', [$id])) abort(403);
    }

    public function index() {
        return response(new Notifications(
          $this->notificationRepository->get(Auth::id())
        ));
    }

    public function show(int $id) {
        $notification = $this->notificationRepository->find($id);

        $this->verificationOwner($notification->recipient_id);

        return response(new Notification(
           $notification
        ));
    }

    public function store(NotificationStore $request) {
        $notification = $this->notificationRepository
            ->create(array_merge(
               $request->only([
                   'message',
                   'recipient_id'
               ]), [
                   'sender_id' => Auth::id()
                ]
            ));

        return response(new Notification(
           $notification
        ));
    }

    public function destroy(int $id) {
        $notification = $this->notificationRepository->find($id);

        $this->verificationOwner($notification->recipient_id);

        $this->notificationRepository->destroy($id);

        return redirect(route('api.notifications.index'));
    }

    public function update(NotificationUpdate $request, int $id) {
        $notification = $this->notificationRepository->find($id);

        $this->verificationOwner($notification->sender_id);

        $notification = $this->notificationRepository
            ->update($request->only([
                'message'
            ]), $id);
        return response(new Notification(
            $notification
        ));
    }
}
