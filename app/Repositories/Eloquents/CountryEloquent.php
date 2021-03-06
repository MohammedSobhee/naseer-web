<?php
/**
 * Created by PhpStorm.
 * UserRequest: mohammedsobhei
 * Date: 5/2/18
 * Time: 11:43 PM
 */

namespace App\Repositories\Eloquents;

use App\Country;
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
                if (request()->filled('name')) {
                    $query->where('name', 'LIKE', '%' . request()->get('name') . '%');
                }
            })
            ->addColumn('action', function ($country) {
                return '<a href="' . url(admin_constant_url() . '/countries/' . $country->id . '/edit') . '" class="btn btn-sm btn-success purple btn-circle btn-icon-only edit-country-mdl"
                                                                                   title="تعديل">
                                                                                    <i class="fa fa-edit"></i>
                                                                                </a><a href="' . url(admin_constant_url() . '/countries/' . $country->id) . '" class="btn btn-sm btn-danger red btn-circle btn-icon-only delete"
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

        $obj = new Country();
        $obj->name = $attributes['name'];
        if ($obj->save())
            return response_api(true, 200, trans('app.created'), $obj);

    }

    function update(array $attributes, $id = null)
    {
        // TODO: Implement update() method.
        $country = $this->model->find($id);
        $country->name = $attributes['name'];
        if ($country->save()) {

            return response_api(true, 200, trans('app.updated'), $country);

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
