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
use App\City;
use App\CompaniesRegistrationAndTrademarking;
use App\CourtAndLawsuit;
use App\DivisionOfInheritance;
use App\DraftingRegulationAndContract;
use App\Http\Resources\OrderEditResource;
use App\Http\Resources\OrderResource;
use App\MarriageOfficer;
use App\Offer;
use App\PublicProsecutionAndPolice;
use App\Repositories\Interfaces\Repository;
use App\Repositories\Uploader;
use App\Request;
use App\Service;
use App\ServiceProvider;
use App\User;


class OrderEloquent extends Uploader implements Repository
{

    private $model, $notification;

    public function __construct(Request $model, NotificationSystemEloquent $notification)
    {
        $this->model = $model;
        $this->notification = $notification;

    }

    function anyData()
    {
        $requests = $this->model->with('City', 'User', 'Service')->orderByDesc('created_at');

        return datatables()->of($requests)
            ->filter(function ($query) {

                if (request()->filled('name')) {

                    $users_id = User::where('type', 'user')->where('name', 'LIKE', '%' . request()->get('name') . '%')->pluck('id');
                    $query->whereIn('user_id', $users_id);
                }

                if (request()->filled('city')) {
                    $cities_id = City::where('name', 'LIKE', '%' . request()->get('city') . '%')->pluck('id');
                    $query->whereIn('city_id', $cities_id);
                }


                if (request()->filled('type')) {
                    $query->where('type', request()->get('type'));
                }
                if (request()->filled('service_id')) {
                    $query->where('service_id', request()->get('service_id'));
                }
                if (request()->filled('status')) {
                    $query->where('status', request()->get('status'));
                }

            })
            ->editColumn('user.name', function ($request) {
                return isset($request->User) ? $request->User->name : '-';
            })->editColumn('service.name', function ($request) {
                return isset($request->Service) ? $request->Service->name : '-';
            })->editColumn('type', function ($request) {
                if ($request->type == 'categorized')
                    return '<span class="label label-success">مصنّفة</span>';
                if ($request->type == 'uncategorized')
                    return '<span class="label label-danger">غير مصنّفة</span>';
            })->editColumn('contact_prefer', function ($request) {
                if ($request->contact_prefer == 'go_to_service_provider')
                    return 'حضور مقدم الطلب الى مزود الخدمة';
                if ($request->contact_prefer == 'go_to_user')
                    return 'حضور مزود الخدمة الى مقدم الطلب';
                if ($request->contact_prefer == 'according_agreement')
                    return 'حسب الاتفاق';
            })->editColumn('payment_prefer', function ($request) {
                if ($request->payment_prefer == 'down_payment')
                    return 'دفعة مقدمة';
                if ($request->payment_prefer == 'without_down_payment')
                    return 'بدون دفعة مقدمة';
            })
            ->editColumn('status', function ($request) {
                if ($request->status == 'new')
                    return '<span class="label label-warning">جديدة</span>';
                if ($request->status == 'completed')
                    return '<span class="label label-success">منتهية</span>';
                if ($request->status == 'canceled')
                    return '<span class="label label-danger">ملغاة</span>';
                if ($request->status == 'assigned')
                    return '<span class="label label-primary">قيد التنفيذ</span>';
            })
            ->addColumn('action', function ($request) {
                return '<a href="' . url(admin_vw() . '/requests/' . $request->id) . '" class="btn btn-sm btn-success green btn-circle"
                                                                                   title="offers">
                                                                                    <i class="fa fa-eye"></i>
                                                                                   تفاصيل
                                                                                </a>
                                                                               ';
            })->addIndexColumn()
            ->rawColumns(['status', 'type', 'contact_prefer', 'action'])->toJson();
    }

    function getAll(array $attributes)
    {
        // TODO: Implement getAll() method.
        $page_size = isset($attributes['page_size']) ? $attributes['page_size'] : max_pagination(10);
        $page_number = isset($attributes['page_number']) ? $attributes['page_number'] : 1;


        if (auth()->user()->type == 'user')
            // for client
            $collection = $this->model->where('user_id', auth()->user()->id)->where('type', $attributes['type']);
        else // for service provider
        {

            $collection = $this->model->where('type', $attributes['type']);

            if ($attributes['type'] == 'categorized') {

                $service_ids = Service::where('service_provider_type_id', auth()->user()->ServiceProvider->service_provider_type_id)->pluck('id');

                $collection = $collection->whereIn('service_id', $service_ids);
            }

            $provider_offer_orders = Offer::where('service_provider_id', auth()->user()->id)->pluck('request_id')->toArray();
            $collection = $collection->whereNotIn('id', $provider_offer_orders);

        }

        if (isset($attributes['status'])) {
            $collection = $collection->where('status', $attributes['status']);
        }
        $count = $collection->count();

        $page_count = page_count($count, $page_size);
        $page_number = $page_number - 1;
        $page_number = $page_number > $page_count ? $page_number = $page_count - 1 : $page_number;
        $object = $collection->take($page_size)->skip((int)$page_number * $page_size)->orderBy('created_at', 'desc')->get();
        if (request()->segment(1) == 'api' || request()->ajax()) {
            return response_api(true, 200, null, OrderResource::collection($object), $page_count, $page_number, $count);
        }
        return $object;
    }

    // service's client // الموكلين
    function getOrderClients(array $attributes)
    {
        // TODO: Implement getAll() method.
        $page_size = isset($attributes['page_size']) ? $attributes['page_size'] : max_pagination(10);
        $page_number = isset($attributes['page_number']) ? $attributes['page_number'] : 1;

        $collection = $this->model;

        $orders = Offer::where('service_provider_id', auth()->user()->id)->where('status', 'accepted')->pluck('request_id');
        $collection = $collection::whereIn('id', $orders)->orderByDesc('service_date');

        if (isset($attributes['status'])) {
            $collection = $collection->where('status', $attributes['status']);
        }
        $count = $collection->count();

        $page_count = page_count($count, $page_size);
        $page_number = $page_number - 1;
        $page_number = $page_number > $page_count ? $page_number = $page_count - 1 : $page_number;
        $object = $collection->take($page_size)->skip((int)$page_number * $page_size)->get();
        if (request()->segment(1) == 'api' || request()->ajax()) {
            return response_api(true, 200, null, OrderResource::collection($object), $page_count, $page_number, $count);
        }
        return $object;
    }

    function getEditOrder($id)
    {
        if (request()->segment(1) == 'api') {
            // TODO: Implement getById() method.
            $obj = $this->model->find($id);
            if (isset($obj))
                return response_api(true, 200, null, new OrderEditResource($obj));
            return response_api(false, 422, trans('app.not_data_found'), []);
        }
        return $this->model->find($id);

    }

    function getById($id)
    {
        if (request()->segment(1) == 'api') {
            // TODO: Implement getById() method.
            $obj = $this->model->find($id);
            if (isset($obj))
                return response_api(true, 200, null, new OrderResource($obj));
            return response_api(false, 422, trans('app.not_data_found'), []);
        }
        return $this->model->find($id);

    }

    function create(array $attributes)
    {
        // TODO: Implement create() method.

        $request = new Request();
        $request->city_id = $attributes['city_id'];
        $request->user_id = auth()->user()->id;
        $type = 'uncategorized';
        if (isset($attributes['service_id'])) {
            $request->service_id = $attributes['service_id'];
            $type = 'categorized';
        }
        $request->type = $type;//categorized', 'uncategorized
        if (isset($attributes['case_text']))
            $request->case_text = $attributes['case_text'];
        if (isset($attributes['evidences_text']))
            $request->evidences_text = $attributes['evidences_text'];
        if (isset($attributes['preferred_outcomes_text']))
            $request->preferred_outcomes_text = $attributes['preferred_outcomes_text'];

        $request->contact_prefer = $attributes['contact_prefer'];
        $request->payment_prefer = $attributes['payment_prefer'];
        $request->service_date = $attributes['service_date'];

        if ($request->save()) {


            $attributes['request_id'] = $request->id;

            if (isset($attributes['service_id'])) {
                //CourtAndLawsuit
                if ($attributes['service_id'] == 1) {
                    CourtAndLawsuit::create($attributes);
                }
                //PublicProsecutionAndPolice
                if ($attributes['service_id'] == 2) {
                    PublicProsecutionAndPolice::create($attributes);
                }
                //DraftingRegulationAndContract
                if ($attributes['service_id'] == 4) {
                    DraftingRegulationAndContract::create($attributes);
                }

                //DivisionOfInheritance
                if ($attributes['service_id'] == 7) {
                    DivisionOfInheritance::create($attributes);
                }
                //CompaniesRegistrationAndTrademarking
                if ($attributes['service_id'] == 8) {
                    CompaniesRegistrationAndTrademarking::create($attributes);
                }

                //Arbitration
                if ($attributes['service_id'] == 9) {
                    Arbitration::create($attributes);
                }
                //MarriageOfficer
                if ($attributes['service_id'] == 10) {
//                    MarriageOfficer::create($attributes);
                    $marriage_office = new MarriageOfficer();
                    $marriage_office->request_id = $attributes['request_id'];
                    $marriage_office->service_id = $attributes['service_id'];
                    $marriage_office->sub_service_id = $attributes['sub_service_id'];
                    $marriage_office->location = $attributes['location'];
                    $marriage_office->latitude = $attributes['latitude'];
                    $marriage_office->longitude = $attributes['longitude'];
                    $marriage_office->request_datetime = $attributes['request_datetime'];
                    $marriage_office->client_idno = $attributes['client_idno'];
                    if ($marriage_office->save()) {
                        if (isset($attributes['medical_examination'])) {
                            sleep(1);
                            $marriage_office->medical_examination = $this->upload($attributes, 'medical_examination');
                            $marriage_office->save();
                        }
                        if (isset($attributes['divorce_certificate'])) {
                            sleep(1);
                            $marriage_office->divorce_certificate = $this->upload($attributes, 'divorce_certificate');
                            $marriage_office->save();
                        }
                    }
                }
                //AssignExpert
                if ($attributes['service_id'] == 12) {
                    AssignExpert::create($attributes);
                }

                //AnnualLegalContract
                if ($attributes['service_id'] == 5) {
                    AnnualLegalContract::create($attributes);
                }
            }
            if (isset($attributes['case_file'])) {
                sleep(1);
                $request->case_file = $this->upload($attributes, 'case_file');
                $request->save();
            }
            if (isset($attributes['evidences_file'])) {
                sleep(1);
                $request->evidences_file = $this->upload($attributes, 'evidences_file');
                $request->save();
            }
            if (isset($attributes['preferred_outcomes_file'])) {
                sleep(1);
                $request->preferred_outcomes_file = $this->upload($attributes, 'preferred_outcomes_file');
                $request->save();
            }
            if (isset($attributes['case_audio'])) {
                sleep(1);
                $request->case_audio = $this->upload($attributes, 'case_audio');
                $request->save();
            }
            if (isset($attributes['evidences_audio'])) {
                sleep(1);
                $request->evidences_audio = $this->upload($attributes, 'evidences_audio');
                $request->save();
            }
            if (isset($attributes['preferred_outcomes_audio'])) {
                sleep(1);
                $request->preferred_outcomes_audio = $this->upload($attributes, 'preferred_outcomes_audio');
                $request->save();
            }

            // send notifications to all service providers
            // if order is categorized service providers according service type
            // else all service providers
            if (isset($attributes['service_id'])) {
                $service_provider_type_id = $request->Service->service_provider_type_id;

                $providers = ServiceProvider::where('service_provider_type_id', $service_provider_type_id)->whereHas('Provider', function ($query) {
                    $query->where('is_active', 1);
                })->pluck('user_id')->toArray();

                //'new_order','assigned_driver','completed_order','canceled_order'
                foreach ($providers as $provider)
                    $this->notification->sendNotification(auth()->user()->id, $provider, $request->id, 'new_order');


            } else {
                $providers = ServiceProvider::whereHas('Provider', function ($query) {
                    $query->where('is_active', 1);
                })->pluck('user_id')->toArray();

                foreach ($providers as $provider)
                    $this->notification->sendNotification(auth()->user()->id, $provider, $request->id, 'new_order');

            }


            return response_api(true, 200, 'تم انشاء الطلب بنجاح', new OrderResource($request));// . ',' . trans('app.sent_email_verification')
        }
        return response_api(false, 422, null, empObj());// . ',' . trans('app.sent_email_verification')

    }

    function update(array $attributes, $id = null)
    {
        // TODO: Implement update() method.
        $request = $this->model->where('status', 'new')->find($id);

        if (isset($request)) {
            if (isset($attributes['case_text']))
                $request->case_text = $attributes['case_text'];
            if (isset($attributes['evidences_text']))
                $request->evidences_text = $attributes['evidences_text'];
            if (isset($attributes['preferred_outcomes_text']))
                $request->preferred_outcomes_text = $attributes['preferred_outcomes_text'];

//            if (isset($attributes['contact_prefer']))
//                $request->contact_prefer = $attributes['contact_prefer'];
//            if (isset($attributes['payment_prefer']))
//                $request->payment_prefer = $attributes['payment_prefer'];
//            if (isset($attributes['service_date']))
//                $request->service_date = $attributes['service_date'];

            $request->is_edit = 1;

            if ($request->save()) {


                $attributes['request_id'] = $request->id;

                /*if (isset($request->service_id)) {
                    //CourtAndLawsuit
                    if ($request->service_id == 1) {
                        CourtAndLawsuit::where('request_id', $request->id)->update($attributes);
                    }
                    //PublicProsecutionAndPolice
                    if ($request->service_id == 2) {
                        PublicProsecutionAndPolice::where('request_id', $request->id)->update($attributes);
                    }
                    //DraftingRegulationAndContract
                    if ($request->service_id == 4) {
                        DraftingRegulationAndContract::where('request_id', $request->id)->update($attributes);
                    }

                    //DivisionOfInheritance
                    if ($request->service_id == 7) {
                        DivisionOfInheritance::where('request_id', $request->id)->update($attributes);
                    }
                    //CompaniesRegistrationAndTrademarking
                    if ($request->service_id == 8) {
                        CompaniesRegistrationAndTrademarking::where('request_id', $request->id)->update($attributes);
                    }

                    //Arbitration
                    if ($request->service_id == 9) {
                        Arbitration::where('request_id', $request->id)->update($attributes);
                    }
                    //MarriageOfficer
                    if ($request->service_id == 10) {

                        $marriage_office = MarriageOfficer::where('request_id', $request->id)->first();
                        if (!isset($marriage_office))
                            $marriage_office = new MarriageOfficer();
                        if (isset($attributes['request_id']))
                            $marriage_office->request_id = $request->id;
                        if (isset($attributes['service_id']))
                            $marriage_office->service_id = $request->service_id;
                        if (isset($attributes['sub_service_id']))
                            $marriage_office->sub_service_id = $attributes['sub_service_id'];
                        if (isset($attributes['location']))
                            $marriage_office->location = $attributes['location'];
                        if (isset($attributes['latitude']))
                            $marriage_office->latitude = $attributes['latitude'];
                        if (isset($attributes['longitude']))
                            $marriage_office->longitude = $attributes['longitude'];
                        if (isset($attributes['request_datetime']))
                            $marriage_office->request_datetime = $attributes['request_datetime'];
                        if (isset($attributes['client_idno']))
                            $marriage_office->client_idno = $attributes['client_idno'];
                        if ($marriage_office->save()) {
                            if (isset($attributes['medical_examination'])) {
                                sleep(1);
                                $marriage_office->medical_examination = $this->upload($attributes, 'medical_examination');
                                $marriage_office->save();
                            }
                            if (isset($attributes['divorce_certificate'])) {
                                sleep(1);
                                $marriage_office->divorce_certificate = $this->upload($attributes, 'divorce_certificate');
                                $marriage_office->save();
                            }
                        }
                    }
                    //AssignExpert
                    if ($request->service_id == 12) {
                        AssignExpert::where('request_id', $request->id)->update($attributes);
                    }

                    //AnnualLegalContract
                    if ($request->service_id == 5) {
                        AnnualLegalContract::where('request_id', $request->id)->update($attributes);
                    }
                }
                */

                if (isset($attributes['case_file']) && $attributes['case_file'] != 'deleted') {
                    sleep(1);
                    $request->case_file = $this->upload($attributes, 'case_file');
                } else if (isset($attributes['case_file']) && $attributes['case_file'] == 'deleted') {

                    $file = base_path('assets/upload/' . $request->getAttributes()['case_file']);
                    if (file_exists($file))
                        unlink($file);
                    $request->case_file = null;
                }
                if (isset($attributes['evidences_file']) && $attributes['evidences_file'] != 'deleted') {
                    sleep(1);
                    $request->evidences_file = $this->upload($attributes, 'evidences_file');
                } else if (isset($attributes['evidences_file']) && $attributes['evidences_file'] == 'deleted') {
                    $file = base_path('assets/upload/' . $request->getAttributes()['evidences_file']);
                    if (file_exists($file))
                        unlink($file);
                    $request->evidences_file = null;
                }
                if (isset($attributes['preferred_outcomes_file']) && $attributes['preferred_outcomes_file'] != 'deleted') {
                    sleep(1);
                    $request->preferred_outcomes_file = $this->upload($attributes, 'preferred_outcomes_file');
                } else if (isset($attributes['preferred_outcomes_file']) && $attributes['preferred_outcomes_file'] == 'deleted') {
                    $file = base_path('assets/upload/' . $request->getAttributes()['preferred_outcomes_file']);
                    if (file_exists($file))
                        unlink($file);
                    $request->preferred_outcomes_file = null;
                }
                if (isset($attributes['case_audio']) && $attributes['case_audio'] != 'deleted') {
                    sleep(1);
                    $request->case_audio = $this->upload($attributes, 'case_audio');
                } else if (isset($attributes['case_audio']) && $attributes['case_audio'] == 'deleted') {
                    $file = base_path('assets/upload/' . $request->getAttributes()['case_audio']);
                    if (file_exists($file))
                        unlink($file);
                    $request->case_audio = null;
                }
                if (isset($attributes['evidences_audio']) && $attributes['evidences_audio'] != 'deleted') {
                    sleep(1);
                    $request->evidences_audio = $this->upload($attributes, 'evidences_audio');
                } else if (isset($attributes['evidences_audio']) && $attributes['evidences_audio'] == 'deleted') {
                    $file = base_path('assets/upload/' . $request->getAttributes()['evidences_audio']);
                    if (file_exists($file))
                        unlink($file);
                    $request->evidences_audio = null;
                }
                if (isset($attributes['preferred_outcomes_audio']) && $attributes['preferred_outcomes_audio'] != 'deleted') {
                    sleep(1);
                    $request->preferred_outcomes_audio = $this->upload($attributes, 'preferred_outcomes_audio');
                } else if (isset($attributes['preferred_outcomes_audio']) && $attributes['preferred_outcomes_audio'] == 'deleted') {
                    $file = base_path('assets/upload/' . $request->getAttributes()['preferred_outcomes_audio']);
                    if (file_exists($file))
                        unlink($file);
                    $request->preferred_outcomes_audio = null;
                }
                $request->save();

                return response_api(true, 200, 'تم تعديل الطلب بنجاح', new OrderResource($request));// . ',' . trans('app.sent_email_verification')
            }
        }
        return response_api(false, 422, null, empObj());// . ',' . trans('app.sent_email_verification')

    }

    function delete($id)
    {
        // TODO: Implement delete() method.
        $obj = $this->model->where('user_id', auth()->user()->id)->find($id);
        if (isset($obj) && $obj->delete()) {
            return response_api(true, 200, trans('app.cancel_request'), []);
        }
        return response_api(false, 422, null, []);

    }

    public function changeStatus(array $attributes)
    {

        $request = $this->model->find($attributes['request_id']);
        $request->status = $attributes['status'];

        if ($request->save()) {

            if ($attributes['status'] == 'completed_order') {
                $offer = Offer::where('request_id', $attributes['request_id'])->where('status', 'accepted')->first();
                $this->notification->sendNotification(auth()->user()->id, $offer->service_provider_id, $offer->request_id, $attributes['status'] . '_order');
            }

            return response_api(true, 200, null, []);
        }
        return response_api(false, 422, null, []);

    }
}
