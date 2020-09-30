<?php
/**
 * Created by PhpStorm.
 * UserRequest: mohammedsobhei
 * Date: 5/2/18
 * Time: 11:43 PM
 */

namespace App\Repositories\Eloquents;

use App\DeviceToken;
use App\Notification;
use App\NotificationReceiver;
//use App\Reason;
use App\Talent;
use App\User;

use LaravelFCM\Facades\FCM;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use LaravelFCM\Message\Topics;

class NotificationSystemEloquent
{

    private $devices_id;


    public function sendNotification($sender_id, $receiver_id, $action_id, $action, $another = null) //$object
    {
        if ($sender_id != $receiver_id) {

            $tokens = DeviceToken::getReceiverToken($receiver_id);//

            $this->devices_id = DeviceToken::getDevices($receiver_id);


            if (count($tokens) > 0) {

                $attributes = [
                    'sender_id' => $sender_id,
                    'receiver_id' => $receiver_id,
                    'action_id' => $action_id,
                    'action' => $action
                ];
                $notification = $this->create($attributes);

                $message = $this->getActionTrans($action);
//
//                $object = new \stdClass();
//                $object->message = $message;
//                $notification->message = $object;

                $badge = $this->getCountUnseen($receiver_id);

                try {
                    if (count($tokens[0]) > 0 || count($tokens[1]) > 0 || count($this->devices_id) > 0)

                        $fcm_object = $this->FCM(config('app.name'), $message, $notification, $tokens, $badge, $action);
                } catch (\Throwable $e) { // For PHP 7
                    // handle $e
                } catch (\Exception $e) { // For PHP 5
                    // handle $e

                }
            }
        }
    }

    public function FCM($title, $body, $data, $tokens, $badge, $action)
    {

        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60 * 20);

        $notificationBuilder = new PayloadNotificationBuilder($title);
        $notificationBuilder->setBody($body)
            ->setSound('default')->setBadge($badge);
        $data->title = $title;

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData(['data' => $data]);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        if (count($tokens[0]) > 0) {
            // You must change it to get your tokens
            // android
            $downstreamResponse = FCM::sendTo($tokens[0], $option, null, $data);

        }
        if (count($tokens[1]) > 0) {
            //ios
            $downstreamResponse = FCM::sendTo($tokens[1], $option, $notification, $data);
        }

        //return Array - you must remove all this tokens in your database
        $downstreamResponse->tokensToDelete();

        //return Array (key : oldToken, value : new token - you must change the token in your database )
        $downstreamResponse->tokensToModify();

        //return Array - you should try to resend the message to the tokens in the array
        $downstreamResponse->tokensToRetry();

        // return Array (key:token, value:error) - in production you should remove from your database the tokens present in this array
        $downstreamResponse->tokensWithError();

        // return Array (key:token, value:error) - in production you should remove from your database the tokens
        $object = [
            'numberSuccess' => $downstreamResponse->numberSuccess(),
            'numberFailure' => $downstreamResponse->numberFailure(),
            'numberModification' => $downstreamResponse->numberModification(),
        ];

        return $object;
    }

    public function getActionTrans($action)
    {

        switch ($action) {
            case 'new_order':
                return trans(notification_trans() . '.new_order');
            case 'assigned_driver':
                return trans(notification_trans() . '.assigned_driver'); // //
            case 'completed_order':
                return trans(notification_trans() . '.completed_order');
            case 'canceled_order':
                return trans(notification_trans() . '.canceled_order');
            case 'new_offer':
                return trans(notification_trans() . '.new_offer');
            default:
                return trans(notification_trans() . '.chat'); //chat user // action_id : auth id
        }
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

    public function getCountUnseen($receiver_id)
    {
        $notifications_id = NotificationReceiver::where('receiver_id', $receiver_id)->pluck('notification_id');
        return Notification::whereIn('id', $notifications_id)->where('seen', 0)->count();
    }
}
