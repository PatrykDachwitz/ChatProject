<?php

namespace App\Http\Controllers\Api;

use App\Events\DeleteNotification;
use App\Events\MessageNotice;
use App\Http\Controllers\Controller;
use App\Http\Resources\Message;
use App\Http\Resources\Messages;
use App\Repository\MessageRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\Store\Message as MessageStore;
use App\Http\Requests\Update\Message as MessageUpdate;
use App\Http\Requests\Filters\Message as MessageFilters;

class MessageController extends Controller
{
    private $messageRepository;

    public function __construct(MessageRepository $messageRepository) {
        $this->messageRepository = $messageRepository;
    }

    public function index(MessageFilters $request){
        $sender = $request->only('filters')['filters']['sender'];
        $recipient = $request->only('filters')['filters']['recipient'];

        if (Gate::denies('mySelf', $sender) & Gate::denies('mySelf', $recipient)) abort(403);

        event(new DeleteNotification($sender, $recipient));

        return response(new Messages(
           $this->messageRepository->get($request->all())
        ));
    }

    public function show(int $id) {
        $message = $this->messageRepository->find($id);

        if (Gate::denies('recipientsMessage', [$message])) abort(403);

        return response(new Message(
            $message
        ));
    }

    public function store(MessageStore $request) {
        $clearData = $request->only([
            'readed',
            'message',
            'recipient_id'
        ]);
        $clearData['sender_id'] = Auth::id();

        $message = $this->messageRepository->create($clearData);

        event(new MessageNotice($message));

        return response(new Message(
           $message
        ));
    }

    public function update(MessageUpdate $request, int $id) {
        $message = $this->messageRepository->find($id);

        if (Gate::denies('mySelf', [$message->sender_id])) abort(403);
        $message = $this->messageRepository->update($request->only([
            'readed',
            'message',
        ]), $id);

        event(new MessageNotice($message));
        return response(new Message($message));

    }
}
