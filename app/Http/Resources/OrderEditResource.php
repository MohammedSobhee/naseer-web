<?php

namespace App\Http\Resources;

use App\SubService;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderEditResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
//        $data = null;
//        if (isset($this->service_id)) {
        if ($this->service_id == 1) {
            $subService = $this->CourtAndLawsuit()->first();
        } elseif ($this->service_id == 2) {
            $subService = $this->PublicProsecutionAndPolice()->first();
        } elseif ($this->service_id == 4) {
            $subService = $this->DraftingRegulationAndContract()->first();
        } elseif ($this->service_id == 5) {
            $subService = $this->AnnualLegalContract()->first();
        } elseif ($this->service_id == 7) {
            $subService = $this->DivisionOfInheritance()->first();
        } elseif ($this->service_id == 8) {
            $subService = $this->CompaniesRegistrationAndTrademarking()->first();
        } elseif ($this->service_id == 9) {
            $subService = $this->Arbitration()->first();
        } elseif ($this->service_id == 10) {
            $subService = $this->MarriageOfficer()->first();
        } elseif ($this->service_id == 12) {
            $subService = $this->AssignExpert()->first();
        }
//        }

        $request->request->add(['request_id' => $this->id,
            'service_id' => $this->service_id,
            'sub_service_id' => isset($subService) ? $subService->sub_service_id : 0,
            'dataRequest' => $subService]);

        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'type' => $this->type,
            'case_text' => $this->case_text,
            'case_audio' => $this->case_audio,
            'case_file' => $this->case_file,
            'evidences_text' => $this->evidences_text,
            'evidences_audio' => $this->evidences_audio,
            'evidences_file' => $this->evidences_file,
            'preferred_outcomes_text' => $this->preferred_outcomes_text,
            'preferred_outcomes_audio' => $this->preferred_outcomes_audio,
            'preferred_outcomes_file' => $this->preferred_outcomes_file,
            'contact_prefer' => $this->contact_prefer,
            'contact_prefer_lbl' => __('app.contact_prefer.' . $this->contact_prefer),
            'payment_prefer' => $this->payment_prefer,
            'payment_prefer_lbl' => __('app.payment_prefer.' . $this->payment_prefer),
            'service_date' => $this->service_date,
            'status' => $this->status,
            'is_edit' => $this->is_edit,
            'offers_num' => $this->Offers()->count(),
            'offers' => OfferSecondResource::collection($this->Offers()->orderByDesc('created_at')->get()),
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
            'city' => new CityResource($this->City()->first()),
//            'service' => new ServiceResource($this->Service()->first()),
            'client' => new ProfileResource($this->User()->first()),
            'fields_det' => SubServiceEditResource::collection(SubService::where('service_id', $this->service_id)->get())->toArray($request)
        ];
    }
}
