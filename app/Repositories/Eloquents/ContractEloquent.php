<?php
/**
 * Created by PhpStorm.
 * UserRequest: mohammedsobhei
 * Date: 5/2/18
 * Time: 11:43 PM
 */

namespace App\Repositories\Eloquents;

use App\Contract;
use App\ContractField;
use App\ContractService;
use App\Http\Resources\OrderResource;
use App\Repositories\Interfaces\Repository;
use App\Request;
use App\RequestContractField;


class ContractEloquent implements Repository
{

    private $model, $notification;

    public function __construct(Contract $model, NotificationSystemEloquent $notification)
    {
        $this->model = $model;
        $this->notification = $notification;

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
            ->addColumn('services', function ($contract) {

                $services = $contract->Services->pluck('name')->toArray();
                $services = implode(',', $services);
                return $services;
            })->editColumn('is_completed', function ($contract) {
                if ($contract->is_completed)
                    return '<span class="label label-success">مكتمل</span>';
                return '<span class="label label-danger">غير مكتمل</span>';
            })
            ->addColumn('action', function ($contract) {
                return '<a href="' . url(admin_contract_url() . '/edit-contract/' . $contract->id) . '" class="btn btn-sm btn-success purple btn-circle btn-icon-only"
                                                                                   title="تعديل">
                                                                                    <i class="fa fa-edit"></i>
                                                                                </a><a href="' . url(admin_contract_url() . '/delete-contract/' . $contract->id) . '" class="btn btn-sm btn-danger red btn-circle btn-icon-only delete"
                                                                                   title="حذف">
                                                                                    <i class="fa fa-trash"></i>
                                                                                </a>';
            })->addIndexColumn()
            ->rawColumns(['action', 'is_completed'])->toJson();
    }

    function export()
    {

    }


    function getAll(array $attributes)
    {
        // TODO: Implement getAll() method.
        return $this->model->all();
    }

    function editContract(array $attributes)
    {
        // TODO: Implement getAll() method.

        $request = Request::find($attributes['contract']['request_id']);
        $contract = Contract::find($attributes['contract']['contract_id']);

        if (isset($request) && isset($contract)) {
            $offer = $request->Offers()->where('status', 'accept')->first();
            $contract_text = $contract->text;

            if (isset($request->contract)) {
                $contract_text = $request->contract;
            }

            foreach ($attributes['contract']['fields'] as $field) {

                // add  request contract field values
                $request_contract_field = RequestContractField::where('user_id', auth()->user()->id)->where('request_id', $request->id)->where('contract_id', $contract->id)->where('contract_field_id', $field['field_id']);
                if (!isset($request_contract_field))
                    $request_contract_field = new RequestContractField();
                $request_contract_field->user_id = auth()->user()->id;
                $request_contract_field->request_id = $request->id;
                $request_contract_field->contract_id = $contract->id;
                $request_contract_field->contract_field_id = $field['field_id'];
                $request_contract_field->value = $field['value'];
                $request_contract_field->save();


                $contract_text = str_replace($field['slug'], '<u>' . $field['value'] . '</u>', $contract_text);
            }

            $request->contract = $contract_text;
            $request->contract_status = (auth()->user()->type == 'user') ? 2 : 1;

            if ($request->save()) {

                $receiver = (auth()->user()->type == 'user') ? $offer->service_provider_id : $request->user_id;

                if (auth()->user()->type == 'user')
                    $this->notification->sendNotification(auth()->user()->id, $receiver, $request->id, 'edit_contract_client');
                else
                    $this->notification->sendNotification(auth()->user()->id, $receiver, $request->id, 'edit_contract_provider');

                return response_api(true, 422, trans('app.success'), new OrderResource($request));

            }
        }

        return response_api(false, 422, trans('app.error'), empObj());

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
            foreach ($attributes['service_ids'] as $service_id) {

                $contract_service = new ContractService();
                $contract_service->contract_id = $contract->id;
                $contract_service->service_id = $service_id;
                $contract_service->save();
            }
            return response_api(true, 200, trans('app.success'), $contract);
        }
    }

    function update(array $attributes, $id = null)
    {
        // TODO: Implement update() method.
        $contract = $this->model->find($id);
        $contract->text = $attributes['text'];
        if ($contract->save()) {

            if (count($attributes['service_ids']) > 0) {
                ContractService::where('contract_id', $contract->id)->forceDelete();
            }
            foreach ($attributes['service_ids'] as $service_id) {

                $contract_service = new ContractService();
                $contract_service->contract_id = $contract->id;
                $contract_service->service_id = $service_id;
                $contract_service->save();
            }

            return response_api(true, 200, trans('app.success'), $contract);

        }
        return response_api(false, 422, trans('app.error'));


    }

    function addField(array $attributes, $id)
    {
        if (isset($attributes['slug'])) {
            $contract_field = ContractField::where('slug', $attributes['slug'])->first();
        } else
            $contract_field = new ContractField();
        $contract_field->contract_id = $id;
        $contract_field->type = $attributes['type'];
        $contract_field->hint = $attributes['hint'];
        if ($contract_field->save()) {
            $contract_field->slug = 'FLDNM' . $contract_field->id;
            $contract_field->save();
            $this->model->where('id', $id)->update(['is_completed' => true]);

            return response_api(true, 200, trans('app.success'), $contract_field);

        }
        return response_api(false, 422, trans('app.error'));

    }

    function editField(array $attributes, $id)
    {

        $contract_field = ContractField::find($id);
        $contract_field->type = $attributes['type'];
        $contract_field->hint = $attributes['hint'];
        if ($contract_field->save()) {
            $this->model->where('id', $id)->update(['is_completed' => true]);
            return response_api(true, 200, trans('app.success'), $contract_field);

        }
        return response_api(false, 422, trans('app.error'));

    }

    function deleteField($id)
    {
        // TODO: Implement delete() method.
        $obj = ContractField::find($id);
        if (isset($obj) && $obj->delete()) {
            return response_api(true, 200, trans('app.deleted'), []);
        }
        return response_api(false, 422, null, []);

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
