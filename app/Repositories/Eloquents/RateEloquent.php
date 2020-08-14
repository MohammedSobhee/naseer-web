<?php
/**
 * Created by PhpStorm.
 * UserRequest: mohammedsobhei
 * Date: 5/2/18
 * Time: 11:43 PM
 */

namespace App\Repositories\Eloquents;

use App\Rate;
use App\Repositories\Interfaces\Repository;

class RateEloquent implements Repository
{

    private $model;

    public function __construct(Rate $model)
    {
        $this->model = $model;
    }

    function getAll(array $attributes)
    {

        // TODO: Implement getAll() method.

    }

    function getById($id)
    {
        // TODO: Implement getById() method.
    }

    function create(array $attributes)
    {
        // TODO: Implement create() method.

        $rate = Rate::where('user_id', auth()->user()->id)->where('request_id', $attributes['request_id'])->first();
        if (!isset($rate))
            $rate = new Rate();
        $rate->user_id = auth()->user()->id;
        $rate->service_provider_id = $attributes['service_provider_id'];
        $rate->request_id = $attributes['request_id'];
        $rate->rate = $attributes['rate'];
        if ($rate->save()) {
            //rate_product
//            $this->notificationSystem->sendNotification(auth()->user()->id, $product->merchant_id, $attributes['action_id'], 'rate_product');

            return response_api(true, 200, 'تم التقييم', $rate);
        }
        return response_api(false, 422, null, []);

    }

    function update(array $attributes, $id = null)
    {
        // TODO: Implement update() method.
    }

    function delete($id)
    {
        // TODO: Implement delete() method.
    }
}
