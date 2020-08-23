<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\Notification\DeleteRequest;
use App\Http\Requests\Api\Notification\GetRequest;
use App\Http\Requests\Api\Notification\RefreshRequest;
use App\Repositories\Eloquents\DeviceEloquent;
use App\Repositories\Eloquents\NotificationEloquent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    //
    private $notification,$device;

    public function __construct(NotificationEloquent $notificationEloquent,DeviceEloquent $deviceEloquent)
    {
        parent::__construct();
        $this->notification = $notificationEloquent;
        $this->device = $deviceEloquent;
    }

    public function getNotifications(GetRequest $request)
    {
        return $this->notification->getAll($request->all());
    }

    public function delete(DeleteRequest $request)
    {
        return $this->notification->delete($request->only('notification_id'));
    }

    public function getUnseenNotification()
    {
        return $this->notification->getCountUnseen(auth()->user()->id,true);
    }

    public function postChatNotification(Request $request)
    {
        return $this->notification->postChatNotification($request->all());
    }

    public function refreshFcmToken(RefreshRequest $request)
    {
        return $this->device->refreshFcmToken($request->all());
    }
}
