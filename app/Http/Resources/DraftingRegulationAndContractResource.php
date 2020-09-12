<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DraftingRegulationAndContractResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'service_id' => $this->service_id,
            'sub_service_id' => $this->sub_service_id,
            'type_service_provided' => $this->type_service_provided,
            'service' => new ServiceResource($this->Service()->first()),
            'sub_service' => new SubServiceTwoResource($this->SubService()->first()),
        ];
    }
}
