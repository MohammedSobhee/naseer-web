<?php
/**
 * Created by PhpStorm.
 * UserRequest: mohammedsobhei
 * Date: 5/2/18
 * Time: 11:43 PM
 */

namespace App\Repositories\Eloquents;

use App\Country;
use App\Http\Resources\CountryResource;
use App\Repositories\Interfaces\Repository;


class CountryEloquent implements Repository
{

    private $model;

    public function __construct(Country $model)
    {
        $this->model = $model;

    }

    // for cpanel
    function anyData()
    {
        $countries = $this->model->orderByDesc('id');
        return datatables()->of($countries)
            ->filter(function ($query) {
            })
            ->addColumn('action', function ($city) {

            })->addIndexColumn()
            ->rawColumns(['action'])->toJson();
    }

    function export()
    {


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

//        $obj = new City();
//        $obj->name_ar = $attributes['name_ar'];
//        $obj->name_en = $attributes['name_en'];
//        if ($obj->save())
//            return response_api(true, 200, trans('app.created'), $obj);
    }

    function update(array $attributes, $id = null)
    {
        // TODO: Implement update() method.
//        $city = $this->model->find($id);
//        $city->name_ar = $attributes['name_ar'];
//        $city->name_en = $attributes['name_en'];
//
//        if ($city->save()) {
//
//            return response_api(true, 200, trans('app.updated'), $city);
//
//        }
//        return response_api(false, 422, trans('app.not_updated'));


    }

    function delete($id)
    {
        // TODO: Implement delete() method.
        $obj = $this->model->find($id);
        if (isset($obj) && $obj->delete()) {
            return response_api(true, 200, trans('app.deleted'), []);
        }
        return response_api(false, 422, null, []);

    }
}
