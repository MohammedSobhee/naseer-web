<?php
/**
 * Created by PhpStorm.
 * UserRequest: mohammedsobhei
 * Date: 5/2/18
 * Time: 11:43 PM
 */

namespace App\Repositories\Eloquents;

use LaravelFCM\Facades\FCM;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;

class NotificationSystemEloquent
{

    private $devices_id;


    public function sendNotification($sender_id, $receiver_id, $action_id, $action, $type, $data_id, $title = null, $another = []) //$object
    {


        if ($sender_id != $receiver_id) {

            $tokens = DeviceToken::getReceiverToken($receiver_id);//
            $this->devices_id = DeviceToken::getDevices($receiver_id);

            if (count($tokens) > 0 || count($tokens) > 0) {

                $attributes = [
                    'sender_id' => $sender_id,
                    'receiver_id' => $receiver_id,
                    'type' => $type,
                    'data_id' => $data_id,
                    'action_id' => $action_id,
                    'action' => $action
                ];

                $notification = $this->create($attributes);

                $receiver = User::find($receiver_id);
                //send fcm message according receiver language
                app()->setLocale($receiver->Language->iso); // De
//                $message = $this->getActionTrans($action);
                $data = [];
                if ($type == 'team') {
                    $team = Team::find($action_id);
                    $sender = auth()->user()->full_name;
                    $league = null;
                    if (isset($another['league_id'])) {
                        $league = League::find($another['league_id']);
                    }
                    if (isset($another['team_id'])) {
                        $team = Team::find($another['team_id']);
                    }
                    $team_name = '';
                    if (isset($team))
                        $team_name = $team->name;
                    $league_name = '';
                    if (isset($league))
                        $league_name = $league->name;

                    $data = ['user' => $sender, 'team' => $team_name, 'league' => $league_name];
                } elseif ($type == 'league') {
                    $league = League::find($action_id);
                    $sender = auth()->user()->full_name;
                    $team = null;
                    if (isset($another['team_id'])) {
                        $team = Team::find($another['team_id']);
                    }

                    $team_name = '';
                    if (isset($team))
                        $team_name = $team->name;
                    $league_name = '';
                    if (isset($league))
                        $league_name = $league->name;

                    $data = ['team' => $team_name, 'user' => $sender, 'league' => $league_name];
                }



                $message = trans(notification_trans() . '.' . $action, $data);

                $object = new \stdClass();
                $object->message = $message;
                $notification->message = $object;

                $title = isset($title) ? $title : config('app.name');

                $notification = Notification::find($notification->id);
                $notification->text = $message;
                $notification->save();
                $notification->title = $title;
                $badge = 0;//$this->getCountUnseen($receiver_id);
                try {
                    $data_message = $message;
                    sleep(5);

                    if (count($tokens[0]) > 0 || count($tokens[1]) > 0 || count($this->devices_id) > 0)
                        $fcm_object = $this->FCM($title, $data_message, $notification, $tokens, $badge);

                    $lang = 'en'; // default language system
                    if (request()->hasHeader('lang'))
                        $lang = request()->header('lang');
                    app()->setLocale($lang);
                } catch (\Throwable $e) { // For PHP 7
                    // handle $e
                } catch (\Exception $e) { // For PHP 5
                    //

                }
            }
        }
    }

    public function FCM($title, $body, $data, $tokens, $badge)
    {
        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60 * 20);

        $notificationBuilder = new PayloadNotificationBuilder($title);
        $notificationBuilder->setBody($body)
            ->setSound('default')->setBadge($badge);

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData(['data' => $data]);

//
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

    function create(array $attributes)
    {
        // TODO: Implement create() method.

        $notification = new Notification();
        $notification->sender_id = $attributes['sender_id'];
        $notification->action = $attributes['action'];
        $notification->action_id = $attributes['action_id'];
        $notification->type = $attributes['type'];
        $notification->data_id = $attributes['data_id'];
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
