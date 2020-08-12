<?php
/**
 * Created by PhpStorm.
 * UserRequest: mohammedsobhei
 * Date: 5/2/18
 * Time: 11:43 PM
 */

namespace App\Repositories\Eloquents;

use App\DeviceToken;
use App\Repositories\Interfaces\Repository;

class DeviceEloquent implements Repository
{

    private $model;

    public function __construct(DeviceToken $model)
    {
        $this->model = $model;
    }

    function getReceiverToken($receiver_id)
    {
        $token_android = $this->model->where('user_id', $receiver_id)->where('status', 'on')->where('type', 'android')->pluck('device_token')->toArray();
        $token_ios = $this->model->where('user_id', $receiver_id)->where('status', 'on')->where('type', 'ios')->pluck('device_token')->toArray();
        return [$token_android, $token_ios];
    }


    function refreshFcmToken(array $attributes)
    {
        $device = $this->model->where('user_id', auth()->user()->id)->where('device_id', $attributes['device_id'])->first();
        if (isset($device)) {
            $device->device_token = $attributes['device_token'];

            if ($device->save()) {
                return response_api(true, 200, trans('app.success'), []);
            }

        }
        return response_api(false, 422, trans('app.not_data_found'), []);
    }

    function getAll(array $attributes)
    {
        // TODO: Implement getAll() method.
    }

    //
    function getById($id)
    {
        // TODO: Implement getById() method.
    }

    //
    function create(array $attributes)
    {
        // TODO: Implement create() method.

    }

    //update
    function update(array $attributes, $id = null)
    {
        // TODO: Implement create() method.

    }

    // delete
    function delete($id)
    {
        // TODO: Implement delete() method.
    }

}
