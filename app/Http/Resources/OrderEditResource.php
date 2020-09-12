<?php

namespace App\Http\Resources;

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
        $data = null;
        if (isset($this->service_id)) {
            if ($this->service_id == 1) {
                $data = new CourtAndLawsuitResource($this->CourtAndLawsuit()->first());
            } elseif ($this->service_id == 2) {
                $data = new PublicProsecutionAndPoliceResource($this->PublicProsecutionAndPolice()->first());
            }elseif ($this->service_id == 4) {
                $data = new DraftingRegulationAndContractResource($this->DraftingRegulationAndContract()->first());
            }
        }
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
            'offers_num' => $this->Offers()->count(),
            'offers' => OfferSecondResource::collection($this->Offers()->get()),
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
            'city' => new CityResource($this->City()->first()),
            'service' => new ServiceResource($this->Service()->first()),

            'client' => new ProfileResource($this->User()->first()),
            'data_request' => $data
        ];
    }
}
