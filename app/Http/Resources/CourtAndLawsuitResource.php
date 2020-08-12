<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CourtAndLawsuitResource extends JsonResource
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
            'lawsuit_nature' => $this->lawsuit_nature,
            'lawsuit_proof' => $this->lawsuit_proof,
            'criminal_case' => $this->criminal_case,
            'court_name' => $this->court_name,
            'property_country' => $this->property_country,
            'prosecutor_defender' => $this->prosecutor_defender,
            'country' => new CountryResource($this->Country()->first()),
            'service' => new ServiceResource($this->Service()->first()),
            'sub_service' => new SubServiceTwoResource($this->SubService()->first()),
        ];
    }
}
