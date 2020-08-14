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
use App\Http\Resources\OrderResource;
use App\MarriageOfficer;
use App\PublicProsecutionAndPolice;
use App\Repositories\Interfaces\Repository;
use App\Repositories\Uploader;
use App\Request;


class OrderEloquent extends Uploader implements Repository
{

    private $model;

    public function __construct(Request $model)
    {
        $this->model = $model;

    }

    function getAll(array $attributes)
    {
        // TODO: Implement getAll() method.
        $page_size = isset($attributes['page_size']) ? $attributes['page_size'] : max_pagination(10);
        $page_number = isset($attributes['page_number']) ? $attributes['page_number'] : 1;
        $collection = $this->model->where('type', $attributes['type']);

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
                    MarriageOfficer::create($attributes);
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

            return response_api(true, 200, 'تم انشاء الطلب بنجاح', new OrderResource($request));// . ',' . trans('app.sent_email_verification')
        }
        return response_api(false, 422, null, empObj());// . ',' . trans('app.sent_email_verification')

    }

    function update(array $attributes, $id = null)
    {
        // TODO: Implement update() method.
//        $city = $this->model->find($id);
//        $city->name_ar = $attributes['name_ar'];
//        $city->name_en = $attributes['name_en'];
//
//        if ($city->save()) {
//
//            return response_api(true, 200, trans('app.updated'), $city);
//
//        }
//        return response_api(false, 422, trans('app.not_updated'));


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

        $request = $this->model->find($attributes['request_id']);
        $request->status = $attributes['status'];

        if ($request->save()) {
            return response_api(true, 200, null, []);
        }
        return response_api(false, 422, null, []);

    }
}
