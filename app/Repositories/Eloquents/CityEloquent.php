<?php
/**
 * Created by PhpStorm.
 * UserRequest: mohammedsobhei
 * Date: 5/2/18
 * Time: 11:43 PM
 */

namespace App\Repositories\Eloquents;

use App\City;
use App\Repositories\Interfaces\Repository;


class CityEloquent implements Repository
{

    private $model;

    public function __construct(City $model)
    {
        $this->model = $model;

    }

    // for cpanel
    function anyData()
    {
        $cities = $this->model->orderByDesc('id');
        return datatables()->of($cities)
            ->filter(function ($query) {
                if (request()->filled('name')) {
                    $query->where('name', 'LIKE', '%' . request()->get('name') . '%');
                }
            })
            ->addColumn('action', function ($city) {
                return '<a href="' . url(admin_constant_url() . '/cities/' . $city->id . '/edit') . '" class="btn btn-sm btn-success purple btn-circle btn-icon-only edit-city-mdl"
                                                                                   title="تعديل">
                                                                                    <i class="fa fa-edit"></i>
                                                                                </a><a href="' . url(admin_constant_url() . '/cities/' . $city->id) . '" class="btn btn-sm btn-danger red btn-circle btn-icon-only delete"
                                                                                   title="حذف">
                                                                                    <i class="fa fa-trash"></i>
                                                                                </a>';
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

        $obj = new City();
        $obj->name = $attributes['name'];
        if ($obj->save())
            return response_api(true, 200, trans('app.created'), $obj);
    }

    function update(array $attributes, $id = null)
    {
        // TODO: Implement update() method.
        $city = $this->model->find($id);
        $city->name = $attributes['name'];
        if ($city->save()) {

            return response_api(true, 200, trans('app.updated'), $city);

        }
        return response_api(false, 422, trans('app.not_updated'));


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
