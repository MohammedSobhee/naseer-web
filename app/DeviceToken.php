<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeviceToken extends Model
{
    //
    use SoftDeletes;

    protected $casts = ['user_id' => 'integer'];

    static function getReceiverToken($receiver_id)
    {
        $token_android = self::where('user_id', $receiver_id)->where('type', 'android')->pluck('device_token')->toArray();
        $token_ios = self::where('user_id', $receiver_id)->where('type', 'ios')->pluck('device_token')->toArray();

        return [$token_android, $token_ios];
    }

    static function getDevices($receiver_id)
    {
        $devices = [];
        $device_android_id = self::where('user_id', $receiver_id)->where('type', 'android')->orderByDesc('updated_at')->first();
        $device_ios_id = self::where('user_id', $receiver_id)->where('type', 'ios')->orderByDesc('updated_at')->first();

        if ($device_android_id) {
            $devices [] = $device_android_id->device_id;
        }
        if ($device_ios_id) {
            $devices [] = $device_ios_id->device_id;
        }
        return $devices;
    }
    static function getReceiverTokenArray($receiver_ids)
    {
        $token_android = self::whereIn('user_id', $receiver_ids)->where('status', 'on')->where('type', 'android')->pluck('device_token')->toArray();
        $token_ios = self::whereIn('user_id', $receiver_ids)->where('status', 'on')->where('type', 'ios')->pluck('device_token')->toArray();

        return [$token_android, $token_ios];
    }

    static function getDevicesArray($receiver_ids)
    {
        $devices = [];
        $device_android_id = self::whereIn('user_id', $receiver_ids)->where('status', 'on')->where('type', 'android')->orderByDesc('updated_at')->first();
        $device_ios_id = self::whereIn('user_id', $receiver_ids)->where('status', 'on')->where('type', 'ios')->orderByDesc('updated_at')->first();

        if ($device_android_id) {
            $devices [] = $device_android_id->device_id;
        }
        if ($device_ios_id) {
            $devices [] = $device_ios_id->device_id;
        }
        return $devices;
    }
}
