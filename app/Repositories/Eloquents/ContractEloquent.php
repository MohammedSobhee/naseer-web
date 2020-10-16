<?php
/**
 * Created by PhpStorm.
 * UserRequest: mohammedsobhei
 * Date: 5/2/18
 * Time: 11:43 PM
 */

namespace App\Repositories\Eloquents;

use App\Contract;
use App\ContractService;
use App\Repositories\Interfaces\Repository;


class ContractEloquent implements Repository
{

    private $model;

    public function __construct(Contract $model)
    {
        $this->model = $model;

    }

    // for cpanel
    function anyData()
    {
        $contracts = $this->model->orderByDesc('id');
        return datatables()->of($contracts)
            ->filter(function ($query) {
//                if (request()->filled('name')) {
//                    $query->where('name', 'LIKE', '%' . request()->get('name') . '%');
//                }
            })
            ->addColumn('action', function ($contract) {
//                return '<a href="' . url(admin_constant_url() . '/cities/' . $city->id . '/edit') . '" class="btn btn-sm btn-success purple btn-circle btn-icon-only edit-city-mdl"
//                                                                                   title="تعديل">
//                                                                                    <i class="fa fa-edit"></i>
//                                                                                </a><a href="' . url(admin_constant_url() . '/cities/' . $city->id) . '" class="btn btn-sm btn-danger red btn-circle btn-icon-only delete"
//                                                                                   title="حذف">
//                                                                                    <i class="fa fa-trash"></i>
//                                                                                </a>';
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

        $contract = new Contract();
        $contract->text = $attributes['text'];

        if ($contract->save()) {
            // add contract's services
            foreach ($attributes['services_id'] as $service_id) {

                $contract_service = new ContractService();
                $contract_service->contract_id = $contract->id;
                $contract_service->service_id = $service_id;
                $contract_service->save();
            }

            // add contract's fields

            return response_api(true, 200, trans('app.created'), $obj);
        }
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
