<?php
/**
 * Created by PhpStorm.
 * UserRequest: mohammedsobhei
 * Date: 5/2/18
 * Time: 11:43 PM
 */

namespace App\Repositories\Eloquents;

use App\Repositories\Interfaces\Repository;
use App\Setting;


class SettingEloquent implements Repository
{

    private $model;

    public function __construct(Setting $model)
    {
        $this->model = $model;

    }

    function getAll(array $attributes)
    {
        // TODO: Implement getAll() method.
        return $this->model->all();
    }

    function getById($id)
    {
        if (request()->segment(1) == 'api') {
            // TODO: Implement getById() method.
            $obj = $this->model->find($id);
            if (isset($obj))
                return response_api(true, 200, null, $obj);
            return response_api(false, 422, trans('app.not_data_found'), []);
        }
        return $this->model->find($id);

    }

    function create(array $attributes)
    {
        // TODO: Implement create() method.
    }

    function update(array $attributes, $id = null)
    {
        // TODO: Implement update() method.
        $setting = $this->model->first();
        $setting->contract = $attributes['contract'];
        $setting->terms = $attributes['terms'];
        $setting->expire_offer = $attributes['expire_offer'];
        if ($setting->save()) {

            return response_api(true, 200, trans('app.updated'), $setting);

        }
        return response_api(false, 422, trans('app.not_updated'));


    }

    function delete($id)
    {
        // TODO: Implement delete() method.
    }
}
