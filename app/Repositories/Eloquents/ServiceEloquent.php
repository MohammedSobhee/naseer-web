<?php
/**
 * Created by PhpStorm.
 * UserRequest: mohammedsobhei
 * Date: 5/2/18
 * Time: 11:43 PM
 */

namespace App\Repositories\Eloquents;

use App\Repositories\Interfaces\Repository;
use App\Service;


class ServiceEloquent implements Repository
{

    private $model;

    public function __construct(Service $model)
    {
        $this->model = $model;

    }

    // for cpanel
    function anyData()
    {
        $services = $this->model->with('ServiceProviderType')->orderByDesc('services.id');
        return datatables()->of($services)
            ->filter(function ($query) {
                if (request()->filled('service_provider_type_id')) {
                    $query->where('service_provider_type_id', request()->get('service_provider_type_id'));
                }
                if (request()->filled('name')) {
                    $query->where('name', 'LIKE', '%' . request()->get('name') . '%');
                }
            })
            ->addColumn('service_provider_type_name', function ($service) {
                return $service->ServiceProviderType->name;
            })
            ->addColumn('action', function ($service) {
                return '<a href="' . url(admin_vw() . '/services/' . $service->id . '/edit') . '" class="btn btn-sm btn-success purple btn-circle btn-icon-only edit-service-mdl"
                                                                                   title="Edit">
                                                                                    <i class="fa fa-edit"></i>
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
    }

    function update(array $attributes, $id = null)
    {
        // TODO: Implement update() method.
        $service = $this->model->find($id);
        $service->name = $attributes['name'];
        $service->service_provider_type_id = $attributes['service_provider_type_id'];

        if ($service->save()) {

            return response_api(true, 200, trans('app.updated'), $service);

        }
        return response_api(false, 422, trans('app.not_updated'));


    }

    function delete($id)
    {
        // TODO: Implement delete() method.
    }
}
