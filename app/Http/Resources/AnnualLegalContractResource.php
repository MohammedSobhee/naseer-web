<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AnnualLegalContractResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'service_id' => $this->service_id,
            'sub_service_id' => $this->sub_service_id,
            'activity' => $this->activity,
            'contract_period' => $this->contract_period,
            'lawsuit_argument' => $this->lawsuit_argument,
            'preparation_interception' => $this->preparation_interception,
            'contract_formation' => $this->contract_formation,
            'contract_revision' => $this->contract_revision,
            'legal_consultation' => $this->legal_consultation,
            'issue_procuration' => $this->issue_procuration,
        ];
    }
}
