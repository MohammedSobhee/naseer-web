<?php
/**
 * Created by PhpStorm.
 * UserRequest: mohammedsobhei
 * Date: 5/2/18
 * Time: 11:43 PM
 */

namespace App\Repositories\Eloquents;

use App\Repositories\Interfaces\Repository;
use App\ServiceProviderType;


class ServiceProviderTypeEloquent implements Repository
{

    private $model;

    public function __construct(ServiceProviderType $model)
    {
        $this->model = $model;

    }

    // for cpanel
    function anyData()
    {
        $data = $this->model->orderByDesc('id');
        return datatables()->of($data)
            ->filter(function ($query) {
                if (request()->filled('name')) {
                    $query->where('name', 'LIKE', '%' . request()->get('name') . '%');
                }
            })
            ->addColumn('action', function ($service_provider_type) {
                return '<a href="' . url(admin_constant_url() . '/service-provider-types/' . $service_provider_type->id . '/edit') . '" class="btn btn-sm btn-success purple btn-circle btn-icon-only edit-service-provider-type-mdl"
                                                                                   title="تعديل">
                                                                                    <i class="fa fa-edit"></i>
                                                                                </a><a href="' . url(admin_constant_url() . '/service-provider-types/' . $service_provider_type->id) . '" class="btn btn-sm btn-danger red btn-circle btn-icon-only delete"
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
        $service_provider_type = new ServiceProviderType();
        $service_provider_type->name = $attributes['name'];

        if ($service_provider_type->save()) {

            return response_api(true, 200, trans('app.created'), $service_provider_type);

        }
        return response_api(false, 422, trans('app.not_created'));

    }

    function update(array $attributes, $id = null)
    {
        // TODO: Implement update() method.
        $service_provider_type = $this->model->find($id);
        $service_provider_type->name = $attributes['name'];

        if ($service_provider_type->save()) {

            return response_api(true, 200, trans('app.updated'), $service_provider_type);

        }
        return response_api(false, 422, trans('app.not_updated'));


    }

    function delete($id)
    {
        // TODO: Implement delete() method.
        $service_provider_type = $this->model->find($id);

        if (isset($service_provider_type) && $service_provider_type->delete())
            return response_api(true, 200, trans('app.deleted'), []);
        return response_api(false, 422, null, []);

    }
}
