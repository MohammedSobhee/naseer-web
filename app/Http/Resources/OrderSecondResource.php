<?php

namespace App\Http\Resources;

use App\Contract;
use App\ContractService;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderSecondResource extends JsonResource
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
            }
        }

        $contract = null;
        $contract_service = ContractService::where('service_id', $this->service_id)->first();
        if (isset($contract_service)) {
            $service_id = $this->service_id;
            $contract = new ContractResource(Contract::whereHas('Services', function ($query) use ($service_id) {
                $query->where('service_id', $service_id);
            })->first());
        }

        if (!isset($this->service_id)) {
            $contract = new ContractResource(Contract::where('has_service', 0)->first());
        }

        $rate = $this->Rates()->where(function ($query) {
            $query->where('user_id', auth()->user()->id)->orWhere('service_provider_id', auth()->user()->id);
        })->where('action', auth()->user()->type)->first();

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
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
            'status' => $this->status,
            'is_edit' => $this->is_edit,
            'is_rate' => isset($rate),

            'offers_num' => $this->Offers()->count(),
            'city' => new CityResource($this->City()->first()),
            'service' => new ServiceResource($this->Service()->first()),
            'client' => new ProfileResource($this->User()->first()),
            'data_request' => $data,

            'contract' => $this->contract,
            'contract_status' => $this->contract_status,
            'contract_fields' => $contract
        ];
    }

}
