<?php
/**
 * Created by PhpStorm.
 * UserRequest: mohammedsobhei
 * Date: 5/2/18
 * Time: 11:43 PM
 */

namespace App\Repositories\Eloquents;

use App\Http\Resources\NotificationResource;
use App\Notification;
use App\NotificationReceiver;
use App\Repositories\Interfaces\Repository;
use App\User;
use Carbon\Carbon;

class NotificationEloquent implements Repository
{

    public $model, $receiverModel, $notificationSystem, $user, $device;

    public function __construct(Notification $model, NotificationReceiver $receiverModel,
                                DeviceEloquent $device, User $user, NotificationSystemEloquent $notificationSystem)
    {
        $this->model = $model;
        $this->receiverModel = $receiverModel;
        $this->notificationSystem = $notificationSystem;
        $this->user = $user;
        $this->device = $device;
    }

    function getList(array $attributes)
    {
        $page_size = isset($attributes['page_size']) ? $attributes['page_size'] : max_pagination(10);
        $page_number = isset($attributes['page_number']) ? $attributes['page_number'] : 1;
        $collection = $this->model->where('action', '<>', 'chat');
        $count = $collection->count();

        $page_count = page_count($count, $page_size);
        $page_number = $page_number - 1;
        $page_number = $page_number > $page_count ? $page_number = $page_count - 1 : $page_number;
        $object = $collection->take($page_size)->skip((int)$page_number * $page_size)->orderBy('created_at', 'desc')->get();

        return $object;
    }

    function getAll(array $attributes)
    {
        // TODO: Implement getAll() method.
        $page_size = isset($attributes['page_size']) ? $attributes['page_size'] : max_pagination();
        $page_number = isset($attributes['page_number']) ? $attributes['page_number'] : 1;


        $notification_id = $this->receiverModel->where('receiver_id', auth()->user()->id)->pluck('notification_id');
        $collection = $this->model->where('action', '<>', 'chat')->whereIn('id', $notification_id);
        $count = $collection->count();

        // seen all my notification
        $collection->update(['seen' => 1]);

        $page_count = page_count($count, $page_size);
        $page_number = $page_number - 1;
        $page_number = $page_number > $page_count ? $page_number = $page_count - 1 : $page_number;
        $object = $collection->take($page_size)->skip((int)$page_number * $page_size)->orderBy('created_at', 'desc')->get();

        if (request()->segment(1) == 'api' || request()->ajax()) {
            if (count($object) > 0) {
                return response_api(true, 200, null, NotificationResource::collection($object), $page_count, $page_number);
            }
            return response_api(false, 422, trans('app.not_data_found'), []);
        }
        return $object;
    }

    public function getCountUnseen($receiver_id, $is_response = false)
    {

        $notifications_id = $this->receiverModel->where('receiver_id', $receiver_id)->pluck('notification_id');
        $count_notification = $this->model->whereIn('id', $notifications_id)->where('seen', 0)->count();

        if ($is_response)
            return response_api(true, 200, null, ['count_unseen_notification' => $count_notification]);
        return $count_notification;
    }

    function getById($id)
    {
        // TODO: Implement getById() method.
        return $this->model->find($id);
    }

    function create(array $attributes)
    {
        // TODO: Implement create() method.

        $notification = new Notification();
        $notification->sender_id = $attributes['sender_id'];
        $notification->action = $attributes['action'];
        $notification->action_id = $attributes['action_id'];

        if ($notification->save()) {


            $receiver_notification = new NotificationReceiver();
            $receiver_notification->notification_id = $notification->id;
            $receiver_notification->receiver_id = $attributes['receiver_id'];
            $receiver_notification->save();

            return $notification;
        }

        return null;
    }

    function update(array $attributes, $id = null)
    {
        // TODO: Implement update() method.

    }

    function delete($id)
    {
        // TODO: Implement delete() method.
        $notification = $this->model->find($id['notification_id']);
        if ($notification->delete()) {
            return response_api(true, 200, trans('app.notification_deleted'), []);
        }
        return response_api(false, 422, null, []);

    }

    function postChatNotification(array $attributes)
    {
        $receiver = $this->user->find($attributes['user_id']);
        if (isset($receiver)) {

            $attributes = [
                'sender_id' => auth()->user()->id,
                'action_id' => auth()->user()->id,
                'action' => 'chat',
            ];

            $chat_notification = $this->model->where('sender_id', auth()->user()->id)->where('action_id', $receiver->id)->where('action', 'chat')->first();

            if (isset($chat_notification))
                $notification = $this->save_chat_notification($attributes, $chat_notification->id);
            else
                $notification = $this->save_chat_notification($attributes);

//            $lang = 2; //default en
//            if (isset($receiver->lang_id))
//                $lang = $receiver->lang_id;
//            config()->set(['app.lang_id' => $lang]);

//            $message = $this->notificationSystem->getActionTrans('chat');
            $badge = $this->getCountUnseen($receiver->id);// + $this->unseen_chat_notification($receiver->id);
            $tokens = $this->device->getReceiverToken($receiver->id);//
            $notification = $this->model->find($notification->id);

            $data = $this->notificationSystem->FCM(config('app.name'), $this->notificationSystem->getActionTrans('chat'), $notification, $tokens, $badge, ''); //$sender_name . ' ' .

            if ($data['numberSuccess'] > 0)
                return response_api(true, 200, trans('app.notification_send'), $data);
            return response_api(false, 422, trans('app.notification_not_send'), $data);
        }

        return response_api(false, 422, null, []);
    }

    function unseen_chat_notification($receiver_id)
    {
        return $this->model->where('action_id', $receiver_id)->where('action', 'chat')->where('seen', 0)->count();
    }

    function save_chat_notification(array $attributes, $id = null)
    {
        // TODO: Implement create() method.
        $notification = $this->model->find($id);
        if (!isset($notification))
            $notification = new Notification();
        $notification->sender_id = $attributes['sender_id'];
        $notification->action = $attributes['action'];
        $notification->action_id = $attributes['action_id'];
        $notification->seen = 0;

        if ($notification->save()) {

            return $notification;
        }

        return null;
    }
}
