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

    function anyData()
    {
        $rates = $this->model->with(['Client', 'ServiceProvider', 'Order' => function ($query) {
            $query->with('Service');
        }])->orderByDesc('created_at');

        return datatables()->of($rates)
            ->filter(function ($query) {

                if (request()->filled('name')) {

                }

            })
            ->editColumn('service_provider.name', function ($rate) {
                return isset($offer->ServiceProvider) ? '<a href="' . url(admin_users_url() . '/' . $rate->service_provider_id . '/view') . '" target="_blank">' . $rate->ServiceProvider->name . '</a>' : '-';
            })->editColumn('order.service.name', function ($rate) {
                return isset($rate->Order->Service) ? $rate->Order->Service->name : '-';
            })->editColumn('order.type', function ($rate) {
                if ($rate->Order->type == 'categorized')
                    return '<span class="label label-success">مصنّفة</span>';
                if ($rate->Order->type == 'uncategorized')
                    return '<span class="label label-danger">غير مصنّفة</span>';
            })
            ->editColumn('client.name', function ($rate) {
                return isset($rate->Client) ? '<a href="' . url(admin_users_url() . '/' . $rate->user_id . '/view') . '" target="_blank">' . $rate->Client->name . '</a>' : '-';
            })->addColumn('action', function ($rate) {
                return '<a href="' . url(admin_constant_url() . '/intros/' . $rate->id . '/edit') . '" class="btn btn-sm btn-success purple btn-circle btn-icon-only edit-intro-mdl"
                                                                                   title="تعديل">
                                                                                    <i class="fa fa-edit"></i>
                                                                                </a><a href="' . url(admin_constant_url() . '/intros/' . $rate->id) . '" class="btn btn-sm btn-danger red btn-circle btn-icon-only delete"
                                                                                   title="حذف">
                                                                                    <i class="fa fa-trash"></i>
                                                                                </a>';
            })
            ->addIndexColumn()
            ->rawColumns(['client.name', 'service_provider.name', 'action'])->toJson();
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
