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
use App\Request;
use App\User;

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
                    $users_id = User::where('type', 'user')->where('name', 'LIKE', '%' . request()->get('name') . '%')->pluck('id');
                    $query->whereIn('user_id', $users_id);
                }
                if (request()->filled('service_provider')) {
                    $service_provider_id = User::where('type', 'service_provider')->where('name', 'LIKE', '%' . request()->get('service_provider') . '%')->pluck('id');
                    $query->whereIn('service_provider_id', $service_provider_id);
                }
                if (request()->filled('type')) {
                    $request_id = Request::where('type', request()->get('type'))->pluck('id');
                    $query->whereIn('request_id', $request_id);

                }
                if (request()->filled('service_id')) {
                    $request_id = Request::where('service_id', request()->get('service_id'))->pluck('id');
                    $query->whereIn('request_id', $request_id);

                }
                if (request()->filled('is_approved')) {
                    $query->where('is_approved', request()->get('is_approved'));
                }

            })
            ->editColumn('service_provider.name', function ($rate) {
                return isset($rate->ServiceProvider) ? '<a href="' . url(admin_users_url() . '/' . $rate->service_provider_id . '/view') . '" target="_blank">' . $rate->ServiceProvider->name . '</a>' : '-';
            })->editColumn('action', function ($rate) {
                return ($rate->action == 'user') ? 'مقدم طلب' : 'مزود خدمة';
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
                if ($rate->is_approved)
                    return '<input type="checkbox" class="make-switch is_active" data-on-text="&nbsp;معتمد&nbsp;" data-off-text="&nbsp;مرفوض&nbsp;" name="is_approved" data-id="' . $rate->id . '" checked  data-on-color="success" data-size="mini" data-off-color="warning">';
                return '<input type="checkbox" class="make-switch is_active" data-on-text="&nbsp;معتمد&nbsp;" data-off-text="&nbsp;مرفوض&nbsp;" name="is_approved" data-id="' . $rate->id . '"  data-on-color="success" data-size="mini" data-off-color="warning">';
//                <a href="' . url(admin_rate_url() . '/' . $rate->id) . '" class="btn btn-sm btn-danger red btn-circle btn-icon-only delete"
//                                                                                   title="حذف">
//                                                                                    <i class="fa fa-trash"></i>
//                                                                                </a>
            })
            ->addIndexColumn()
            ->rawColumns(['client.name', 'service_provider.name', 'order.type', 'action'])->toJson();
    }

    function rateApproved($id)
    {

        $rate = $this->model->find($id['rate_id']);

        if (isset($rate)) {
            $rate->is_approved = !$rate->is_approved;

            if ($rate->save()) {
                return response_api(true, 200);
            }
        }
        return response_api(false, 422);

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

        $rate = Rate::where(function ($query) use ($attributes) {
            $query->where('user_id', $attributes['user_id'])->where('action', 'user')
                ->orWhere('service_provider_id', $attributes['service_provider_id'])->where('action', 'service_provider');
        })->where('request_id', $attributes['request_id'])->first();


        if (!isset($rate))
            $rate = new Rate();
        $rate->user_id = $attributes['user_id'];
        $rate->service_provider_id = $attributes['service_provider_id'];
        $rate->request_id = $attributes['request_id'];
        $rate->action = auth()->user()->type;
        $rate->rate = $attributes['rate'];
        $rate->text = $attributes['text'] ?? null;
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
