<?php
/**
 * Created by PhpStorm.
 * UserRequest: mohammedsobhei
 * Date: 5/2/18
 * Time: 11:43 PM
 */

namespace App\Repositories\Eloquents;

use App\AnnualLegalContract;
use App\Arbitration;
use App\AssignExpert;
use App\CompaniesRegistrationAndTrademarking;
use App\CourtAndLawsuit;
use App\DivisionOfInheritance;
use App\DraftingRegulationAndContract;
use App\Http\Resources\OfferResource;
use App\Http\Resources\OrderResource;
use App\MarriageOfficer;
use App\Offer;
use App\PublicProsecutionAndPolice;
use App\Repositories\Interfaces\Repository;
use App\Repositories\Uploader;
use App\User;


class OfferEloquent extends Uploader implements Repository
{

    private $model;

    public function __construct(Offer $model)
    {
        $this->model = $model;

    }

    function anyData($order_id)
    {
        $offers = $this->model->with('ServiceProvider')->where('request_id', $order_id)->orderByDesc('created_at');

        return datatables()->of($offers)
            ->filter(function ($query) {

                if (request()->filled('name')) {

                    $service_providers_id = User::where('type', 'service_provider')->where('name', 'LIKE', '%' . request()->get('name') . '%')->pluck('id');
                    $query->whereIn('service_provider_id', $service_providers_id);
                }
                if (request()->filled('payment_type')) {
                    $query->where('payment_type', request()->get('payment_type'));
                }
                if (request()->filled('status')) {
                    $query->where('status', request()->get('status'));
                }

            })
            ->editColumn('service_provider.name', function ($request) {
                return isset($request->ServiceProvider) ? $request->ServiceProvider->name : '-';
            })->editColumn('payment_type', function ($request) {
                if ($request->payment_type == 'down_payment')
                    return 'دفعة مقدمة';
                if ($request->payment_type == 'late_payment')
                    return 'دفعة متأخرة';
            })
            ->editColumn('status', function ($request) {
                if ($request->status == 'pending')
                    return '<span class="label label-warning">قيد الانتظار</span>';
                if ($request->status == 'accepted')
                    return '<span class="label label-success">مقبولة</span>';
                if ($request->status == 'rejected')
                    return '<span class="label label-danger">مرفوضة</span>';
            })->addIndexColumn()
            ->rawColumns(['status'])->toJson();
    }

    function getAll(array $attributes)
    {
        // TODO: Implement getAll() method.
        $page_size = isset($attributes['page_size']) ? $attributes['page_size'] : max_pagination(10);
        $page_number = isset($attributes['page_number']) ? $attributes['page_number'] : 1;
        $collection = $this->model->where('request_id', $attributes['request_id']);

        if (isset($attributes['status'])) {
            $collection = $collection->where('status', $attributes['status']);
        }
        $count = $collection->count();

        $page_count = page_count($count, $page_size);
        $page_number = $page_number - 1;
        $page_number = $page_number > $page_count ? $page_number = $page_count - 1 : $page_number;
        $object = $collection->take($page_size)->skip((int)$page_number * $page_size)->orderBy('created_at', 'desc')->get();
        if (request()->segment(1) == 'api' || request()->ajax()) {
            return response_api(true, 200, null, OfferResource::collection($object), $page_count, $page_number, $count);
        }
        return $object;
    }

    function getById($id)
    {
        if (request()->segment(1) == 'api') {
            // TODO: Implement getById() method.
            $obj = $this->model->find($id);
            if (isset($obj))
                return response_api(true, 200, null, new OfferResource($obj));
            return response_api(false, 422, trans('app.not_data_found'), []);
        }
        return $this->model->find($id);

    }

    function create(array $attributes)
    {
        // TODO: Implement create() method.

        // check if provider has post to request
        $offer = $this->model->where('request_id', $attributes['request_id'])->where('service_provider_id', auth()->user()->id)->first();
        if (isset($offer))
            return response_api(false, 422, 'يوجد عرض مسبقاً لهذا الطلب', $offer);

        $attributes['service_provider_id'] = auth()->user()->id;
        $offer = $this->model->create($attributes);
        return response_api(true, 200, 'تم ارسال العرض', new OfferResource($offer));

    }

    function update(array $attributes, $id = null)
    {

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

    public function changeStatus(array $attributes)
    {

        $offer = $this->model->find($attributes['offer_id']);
        $offer->status = $attributes['status'];

        if ($offer->save()) {
            return response_api(true, 200, null, []);
        }
        return response_api(false, 422, null, []);

    }
}