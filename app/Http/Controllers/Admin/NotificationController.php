<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Notification\SendPublicRequest;
use App\Notification;
use App\Repositories\Eloquents\NotificationEloquent;
use Illuminate\Http\Request;

class NotificationController extends Controller
{

    private $notification;

    public function __construct(NotificationEloquent $notificationEloquent)
    {
        $this->notification = $notificationEloquent;
    }

    // Begin category operation
    public function index()
    {

        $data = [
            'main_title' => 'اشعارات تثقيفية',
            'icon' => 'fa fa-bell',
        ];
        return view(admin_settings_vw() . '.push_notifications', $data);
    }

    public function anyData()
    {
        return $this->notification->anyData();
    }

    public function delete($id)
    {
        return $this->notification->delete($id);
    }

    public function sendPublicNotification(SendPublicRequest $request)
    {
        return $this->notification->sendPublicNotification($request->all());
    }
}
